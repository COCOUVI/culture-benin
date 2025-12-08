<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contenu;

class ContenuSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. Exemple de recette béninoise ---
        Contenu::create([
            'titre' => 'Recette traditionnelle du Amiwo',
            'texte' =>
            "Le *Amiwo* est un plat emblématique du Sud du Bénin, très apprécié lors des cérémonies traditionnelles.
        Il est préparé à base de pâte de maïs rouge mélangée à une sauce parfumée aux épices locales.
        
        Généralement accompagné de poulet grillé ou de poisson frit, l’Amiwo représente un symbole de convivialité
        et d’unité familiale. Sa préparation nécessite un mélange précis d’ingrédients comme le piment, la tomate,
        l’oignon, et l’huile rouge, ce qui en fait un plat riche en saveurs et en histoire culinaire.",
            'statut' => 'actif',
            'region_id' => 2,            // Ouidah
            'langue_id' => 3,            // Fongbé
            'type_contenu_id' => 1,      // Recette
            'id_auteur' => 1,
            'id_moderateur' => null,
            'parent_id' => null
        ]);

        // --- 2. Histoire traditionnelle ---
        Contenu::create([
            'titre' => 'Légende de la princesse Tassi Hangbè',
            'texte' =>
            "Tassi Hangbè est considérée comme l’une des rares reines ayant dirigé le royaume du Danxomè.
        Son histoire est entourée de mystère, mais beaucoup de récits affirment qu’elle fut une souveraine
        courageuse et visionnaire, ayant fondé l’élite militaire féminine du royaume : les fameuses
        *Amazones du Danxomè*. 
        
        Sa gouvernance est souvent décrite comme un règne de justice et de grandeur,
        marqué par la résistance et la protection du territoire contre les menaces extérieures.",
            'statut' => 'actif',
            'region_id' => 1,            // NIKKI
            'langue_id' => 1,            // Minan
            'type_contenu_id' => 2,      // Histoire
            'id_auteur' => 1,
            'id_moderateur' => null,
            'parent_id' => null
        ]);

        // --- 3. Conte béninois ---
        Contenu::create([
            'titre' => 'Le conte de Agbé et le poisson sacré',
            'texte' =>
            "Ce conte raconte l’histoire d’Agbé, un jeune pêcheur téméraire qui découvre un poisson aux écailles dorées.
        Ce poisson se révèle être un esprit de l’eau, protecteur du village. Agbé doit alors choisir entre garder
        la créature pour lui ou préserver la paix et l’harmonie de son peuple.
        
        Ce récit met en avant les valeurs de partage, de respect de la nature et de sagesse ancestrale,
        toujours transmises dans les villages béninois.",
            'statut' => 'actif',
            'region_id' => 3,          // Parakou
            'langue_id' => 2,          // Minan1
            'type_contenu_id' => 3,    // Conte
            'id_auteur' => 1,
            'id_moderateur' => null,
            'parent_id' => null
        ]);

        // --- 4. Article sur un lieu culturel ---
        Contenu::create([
            'titre' => 'La Porte du Non-Retour : un symbole historique',
            'texte' =>
            "Située à Ouidah, la Porte du Non-Retour représente l’un des lieux les plus marquants de la mémoire
        de la traite négrière. Ce monument commémore les millions d’Africains arrachés à leur terre natale.
        
        Aujourd’hui, le site est devenu un espace de recueillement, de reconnaissance historique et de
        promotion culturelle. Il attire chaque année des milliers de visiteurs venus du monde entier
        pour honorer la mémoire et mieux comprendre cette partie essentielle de l’histoire du Bénin.",
            'statut' => 'actif',
            'region_id' => 2,         // Ouidah
            'langue_id' => 3,         // Fongbé
            'type_contenu_id' => 4,   // Article
            'id_auteur' => 1,
            'id_moderateur' => null,
            'parent_id' => null
        ]);
    }
}
