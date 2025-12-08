<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function sendTest()
    {
        try {
            Mail::to("cocouvialexandro74@gmail.com")
                ->send(new TestEmail("Ceci est un test d'envoi d'email avec Hostinger."));

            return "Email envoyé avec succès 🎉";
        } catch (\Exception $e) {
            return "Erreur lors de l'envoi : " . $e->getMessage();
        }
    }
}
