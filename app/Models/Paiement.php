<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\PaiementStatut;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Paiement
 *
 * @property int $id
 * @property int $user_id
 * @property int $contenu_id
 * @property float $montant
 * @property string $statut
 * @property string $numero
 * @property string $paiement_methode
 * @property string|null $transaction_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Contenu $contenu
 * @property User $user
 *
 * @package App\Models
 */
class Paiement extends Model
{
	protected $table = 'paiements';

	protected $casts = [
		'user_id' => 'int',
		'contenu_id' => 'int',
		'montant' => 'float'
	];

	protected $fillable = [
		'user_id',
		'contenu_id',
		'montant',
		'statut',
		'numero',
		'paiement_methode',
		'transaction_id'
	];
    protected $attributes = [
        'statut' => PaiementStatut::PENDING,
    ];

	public function contenu()
	{
		return $this->belongsTo(Contenu::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
