<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\Paiement;
use App\Enums\PaiementStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configuration FedaPay
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));
    }

    /**
     * Callback après paiement FedaPay
     */
    public function callback(Request $request)
    {
        try {
            // 1. Récupérer les données envoyées
            $transactionId = $request->input('id');
            $contenuId = $request->input('contenu_id');

            // Log pour debug
            Log::info('Callback paiement reçu', [
                'transaction_id' => $transactionId,
                'contenu_id' => $contenuId,
                'all_data' => $request->all()
            ]);

            // 2. Validation des données
            if (!$transactionId || !$contenuId) {
                Log::error('Données manquantes dans le callback');
                return redirect()->route('home')
                    ->with('error', 'Données de transaction manquantes');
            }

            // 3. Vérifier si le paiement existe déjà (éviter les doublons)
            $paiementExistant = Paiement::where('transaction_id', $transactionId)->first();

            if ($paiementExistant) {
                Log::info('Paiement déjà enregistré', ['transaction_id' => $transactionId]);

                // Rediriger vers le contenu si succès
                if ($paiementExistant->statut === PaiementStatut::SUCCESS->value) {
                    return redirect()->route('contenu.detail', $contenuId)
                        ->with('info', 'Vous avez déjà accès à ce contenu');
                }
            }

            // 4.  Récupérer les détails de la transaction depuis FedaPay
            $transaction = Transaction::retrieve($transactionId);

            Log::info('Transaction récupérée', [
                'status' => $transaction->status,
                'amount' => $transaction->amount,
                'id' => $transaction->id
            ]);

            // 5. Vérifier le statut de la transaction
            if ($transaction->status === 'approved') {

                // 6. Récupérer le contenu
                $contenu = Contenu::findOrFail($contenuId);

                // 7. Créer l'enregistrement du paiement avec statut SUCCESS
                $paiement = Paiement::create([
                    'user_id' => auth()->id(),
                    'contenu_id' => $contenu->id,
                    'montant' => $transaction->amount ??  100,
                    'statut' => PaiementStatut::SUCCESS->value, // ✅ SUCCESS
                    'numero' => $transaction->customer['phone_number']['number'] ?? auth()->user()->email,
                    'paiement_methode' => $transaction->mode ?? 'mobile_money',
                    'transaction_id' => $transactionId,
                ]);

                Log::info('Paiement enregistré avec succès', [
                    'paiement_id' => $paiement->id,
                    'user_id' => auth()->id(),
                    'contenu_id' => $contenu->id,
                    'statut' => PaiementStatut::SUCCESS->value
                ]);

                // 8.  Rediriger vers le contenu avec message de succès
                return redirect()->route('contenu.detail', $contenu->id)
                    ->with('success', '🎉 Paiement réussi ! Vous avez maintenant accès au contenu.');

            } elseif ($transaction->status === 'pending') {

                // Transaction en attente - statut PENDING
                Log::warning('Transaction en attente', ['transaction_id' => $transactionId]);

                // Enregistrer avec statut PENDING
                Paiement::updateOrCreate(
                    ['transaction_id' => $transactionId],
                    [
                        'user_id' => auth()->id(),
                        'contenu_id' => $contenuId,
                        'montant' => $transaction->amount ?? 100,
                        'statut' => PaiementStatut::PENDING->value, // ✅ PENDING
                        'numero' => auth()->user()->email,
                        'paiement_methode' => $transaction->mode ?? 'mobile_money',
                    ]
                );

                return redirect()->route('home')
                    ->with('warning', '⏳ Votre paiement est en cours de traitement.  Vous recevrez une confirmation sous peu.');

            } else {

                // Transaction échouée ou refusée - statut FAILED
                Log::warning('Transaction non approuvée', [
                    'status' => $transaction->status,
                    'transaction_id' => $transactionId
                ]);

                // Enregistrer avec statut FAILED
                Paiement::updateOrCreate(
                    ['transaction_id' => $transactionId],
                    [
                        'user_id' => auth()->id(),
                        'contenu_id' => $contenuId,
                        'montant' => $transaction->amount ?? 100,
                        'statut' => PaiementStatut::FAILED->value, // ✅ FAILED
                        'numero' => auth()->user()->email,
                        'paiement_methode' => $transaction->mode ?? 'mobile_money',
                    ]
                );

                return redirect()->route('home')
                    ->with('error', '❌ Le paiement n\'a pas abouti. Veuillez réessayer.');
            }

        } catch (\FedaPay\Error\ApiConnection $e) {
            // Erreur de connexion à l'API FedaPay
            Log::error('Erreur de connexion FedaPay', [
                'message' => $e->getMessage(),
                'transaction_id' => $transactionId ??  null
            ]);

            return redirect()->route('home')
                ->with('error', 'Impossible de vérifier le paiement.  Veuillez contacter le support.');

        } catch (\FedaPay\Error\InvalidRequest $e) {
            // Requête invalide
            Log::error('Requête FedaPay invalide', [
                'message' => $e->getMessage(),
                'transaction_id' => $transactionId ?? null
            ]);

            return redirect()->route('home')
                ->with('error', 'Erreur lors de la vérification du paiement.');

        } catch (\Exception $e) {
            // Erreur générale
            Log::error('Erreur callback paiement', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('home')
                ->with('error', 'Une erreur est survenue lors du traitement du paiement.');
        }
    }
}
