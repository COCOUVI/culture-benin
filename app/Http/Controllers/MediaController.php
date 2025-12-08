<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Models\Contenu;
use App\Models\Media;
use App\Models\TypeMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $medias = Media::with(['contenu', 'type_media'])->get();
        return view('medias.index',compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $contenus = Contenu::all();
        $types = TypeMedia::all();
        return view('medias.create',compact('contenus','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request)
    {
        $data = $request->validated();
        $cloudinaryUrl = null;
        $cloudinaryPublicId = null;

        try {
            // ✅ Upload du fichier vers CLOUDINARY
            if ($request->hasFile('chemin')) {
                $file = $request->file('chemin');
                $mimeType = $file->getMimeType();

                // Déterminer le type de ressource et le dossier
                $resourceType = 'auto'; // Cloudinary détecte automatiquement
                $folder = 'medias/';

                if (str_starts_with($mimeType, 'image/')) {
                    $folder .= 'images';
                    $resourceType = 'image';
                } elseif (str_starts_with($mimeType, 'video/')) {
                    $folder .= 'videos';
                    $resourceType = 'video';
                } elseif (str_starts_with($mimeType, 'audio/')) {
                    $folder .= 'audios';
                    $resourceType = 'video'; // Cloudinary utilise 'video' pour audio aussi
                } else {
                    $folder .= 'autres';
                    $resourceType = 'raw'; // Pour les fichiers non-média
                }

                Log::info('Upload média vers Cloudinary', [
                    'mime_type' => $mimeType,
                    'folder' => $folder,
                    'resource_type' => $resourceType,
                    'size' => $file->getSize(),
                ]);

                // Générer un nom unique
                $publicId = $folder . '/' . time() . '_' . uniqid();

                // ✅ Upload vers Cloudinary
                $cloudinary = new \Cloudinary\Cloudinary();

                $uploadOptions = [
                    'folder' => $folder,
                    'public_id' => time() . '_' . uniqid(),
                    'resource_type' => $resourceType,
                ];

                // Transformations spécifiques selon le type
                if ($resourceType === 'image') {
                    $uploadOptions['transformation'] = [
                        'quality' => 'auto',
                        'fetch_format' => 'auto',
                    ];
                } elseif ($resourceType === 'video') {
                    $uploadOptions['transformation'] = [
                        'quality' => 'auto',
                    ];
                }

                $result = $cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    $uploadOptions
                );

                $cloudinaryUrl = $result['secure_url'];
                $cloudinaryPublicId = $result['public_id'];
                $data['chemin'] = $cloudinaryUrl;

                // ✅ Informations supplémentaires depuis Cloudinary
                $data['taille'] = $result['bytes'] ??  $file->getSize();
                $data['format'] = $result['format'] ??  $file->getClientOriginalExtension();

                // Pour les vidéos et audio, Cloudinary fournit la durée
                if (isset($result['duration'])) {
                    $data['duree'] = $result['duration']; // en secondes
                }

                // Pour les images, dimensions
                if (isset($result['width']) && isset($result['height'])) {
                    $data['largeur'] = $result['width'];
                    $data['hauteur'] = $result['height'];
                }

                Log::info('Média uploadé sur Cloudinary avec succès', [
                    'url' => $cloudinaryUrl,
                    'public_id' => $cloudinaryPublicId,
                    'type' => $resourceType,
                    'format' => $data['format'],
                ]);
            }

            // ✅ Créer l'enregistrement dans la base de données
            $media = Media::create($data);

            Log::info('Média créé en base de données', [
                'media_id' => $media->id,
                'type' => $resourceType ??  'unknown',
            ]);

            return redirect()->back()
                ->with('success', 'Média ajouté avec succès !');

        } catch (\Exception $e) {
            // ✅ En cas d'erreur, supprimer le fichier de Cloudinary
            if ($cloudinaryPublicId) {
                try {
                    $cloudinary = new \Cloudinary\Cloudinary();
                    $cloudinary->uploadApi()->destroy($cloudinaryPublicId, [
                        'resource_type' => $resourceType ??  'auto'
                    ]);

                    Log::info('Média supprimé de Cloudinary après erreur', [
                        'public_id' => $cloudinaryPublicId,
                    ]);
                } catch (\Exception $deleteException) {
                    Log::error('Échec suppression média Cloudinary', [
                        'public_id' => $cloudinaryPublicId,
                        'error' => $deleteException->getMessage(),
                    ]);
                }
            }

            Log::error('Erreur lors de l\'ajout du média', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'ajout du média : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
        return view('medias.show',compact('media'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
        $contenus = Contenu::all();
        $typesMedia = TypeMedia::all();
        return view('medias.edit',compact('media','contenus','typesMedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMediaRequest $request, Media $media)
    {
        $data = $request->validated();
        $newCloudinaryUrl = null;
        $newCloudinaryPublicId = null;
        $oldCloudinaryPublicId = null;
        $resourceType = 'auto';

        try {
            // ✅ Vérifier si un nouveau fichier a été uploadé
            if ($request->hasFile('chemin')) {
                $file = $request->file('chemin');
                $mimeType = $file->getMimeType();

                // Déterminer le type de ressource et le dossier
                $folder = 'medias/';

                if (str_starts_with($mimeType, 'image/')) {
                    $folder .= 'images';
                $resourceType = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                    $folder .= 'videos';
                    $resourceType = 'video';
                } elseif (str_starts_with($mimeType, 'audio/')) {
                    $folder .= 'audios';
                    $resourceType = 'video'; // Cloudinary utilise 'video' pour audio
                } else {
                    $folder .= 'autres';
                    $resourceType = 'raw';
                }

                Log::info('Mise à jour média - Upload vers Cloudinary', [
                    'media_id' => $media->id,
                    'mime_type' => $mimeType,
                    'folder' => $folder,
                    'resource_type' => $resourceType,
                ]);

                try {
                    // ✅ Extraire le public_id de l'ancien média Cloudinary
                    if ($media->chemin && str_contains($media->chemin, 'cloudinary')) {
                        // Format URL Cloudinary: . ../image/upload/v123456/medias/images/123_abc. jpg
                        preg_match('/\/(image|video|raw)\/upload\/v\d+\/(. +)\. ([a-z0-9]+)$/i', $media->chemin, $matches);

                        if (isset($matches[2])) {
                            $oldCloudinaryPublicId = $matches[2];
                            $oldResourceType = $matches[1] ?? 'auto';

                            Log::info('Ancien média Cloudinary identifié', [
                                'public_id' => $oldCloudinaryPublicId,
                                'resource_type' => $oldResourceType,
                            ]);
                        }
                    }

                    // ✅ Upload le nouveau fichier vers Cloudinary
                    $cloudinary = new \Cloudinary\Cloudinary();

                    $uploadOptions = [
                        'folder' => $folder,
                        'public_id' => time() .  '_' . uniqid(),
                        'resource_type' => $resourceType,
                    ];

                    // Transformations selon le type
                    if ($resourceType === 'image') {
                        $uploadOptions['transformation'] = [
                            'quality' => 'auto',
                            'fetch_format' => 'auto',
                        ];
                    } elseif ($resourceType === 'video') {
                        $uploadOptions['transformation'] = [
                            'quality' => 'auto',
                        ];
                    }

                    $result = $cloudinary->uploadApi()->upload(
                        $file->getRealPath(),
                        $uploadOptions
                    );

                    $newCloudinaryUrl = $result['secure_url'];
                    $newCloudinaryPublicId = $result['public_id'];
                    $data['chemin'] = $newCloudinaryUrl;

                    // ✅ Mettre à jour les métadonnées
                    $data['taille'] = $result['bytes'] ?? $file->getSize();
                    $data['format'] = $result['format'] ??  $file->getClientOriginalExtension();

                    if (isset($result['duration'])) {
                        $data['duree'] = $result['duration'];
                    }

                    if (isset($result['width']) && isset($result['height'])) {
                        $data['largeur'] = $result['width'];
                        $data['hauteur'] = $result['height'];
                    }

                    Log::info('Nouveau média uploadé sur Cloudinary', [
                        'media_id' => $media->id,
                        'url' => $newCloudinaryUrl,
                        'public_id' => $newCloudinaryPublicId,
                    ]);

                    // ✅ Supprimer l'ancien fichier de Cloudinary APRÈS l'upload réussi
                    if ($oldCloudinaryPublicId) {
                        try {
                            $cloudinary->uploadApi()->destroy($oldCloudinaryPublicId, [
                                'resource_type' => $oldResourceType ??  'auto'
                            ]);

                            Log::info('Ancien média supprimé de Cloudinary', [
                                'public_id' => $oldCloudinaryPublicId,
                            ]);
                        } catch (\Exception $deleteException) {
                            // Ne pas bloquer si la suppression échoue
                            Log::warning('Échec suppression ancien média Cloudinary', [
                                'public_id' => $oldCloudinaryPublicId,
                                'error' => $deleteException->getMessage(),
                            ]);
                        }
                    }

                } catch (\Exception $uploadException) {
                    Log::error('Erreur upload Cloudinary lors de la mise à jour', [
                        'media_id' => $media->id,
                        'error' => $uploadException->getMessage(),
                    ]);

                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Erreur lors de l\'upload du nouveau fichier : ' . $uploadException->getMessage());
                }
            } else {
                // ✅ Si aucun nouveau fichier, ne pas modifier le champ 'chemin'
                unset($data['chemin']);

                Log::info('Mise à jour média sans changement de fichier', [
                    'media_id' => $media->id,
                    'updated_fields' => array_keys($data),
                ]);
            }

            // ✅ Mettre à jour le média dans la base de données
            $media->update($data);

            Log::info('Média mis à jour en base de données', [
                'media_id' => $media->id,
            ]);

            return redirect()->route('medias. index')
                ->with('success', 'Le média a été mis à jour avec succès !');

        } catch (\Exception $e) {
            // ✅ Rollback : supprimer le nouveau fichier Cloudinary en cas d'erreur
            if ($newCloudinaryPublicId) {
                try {
                    $cloudinary = new \Cloudinary\Cloudinary();
                    $cloudinary->uploadApi()->destroy($newCloudinaryPublicId, [
                        'resource_type' => $resourceType
                    ]);

                    Log::info('Nouveau média supprimé après erreur de mise à jour', [
                        'public_id' => $newCloudinaryPublicId,
                    ]);
                } catch (\Exception $deleteException) {
                    Log::error('Échec suppression nouveau média après erreur', [
                        'public_id' => $newCloudinaryPublicId,
                        'error' => $deleteException->getMessage(),
                    ]);
                }
            }

            Log::error('Erreur lors de la mise à jour du média', [
                'media_id' => $media->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du média. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
        $media->delete();
        return redirect()->back()->with('success', 'Le média a été  supprimée avec succès !');
    }
}
