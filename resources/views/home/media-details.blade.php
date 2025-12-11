
@extends('layouts.app1')

@section('title', $media->contenu->titre ?? 'Détails du média - Culture Bénin')

@section('content')
    @php
        // ✅ Détection Cloudinary au début
        $isCloudinary = str_contains($media->chemin, 'cloudinary');
        $mediaUrl = $isCloudinary ?  $media->chemin : asset('storage/' . $media->chemin);

        // Type de média
        if ($isCloudinary) {
            preg_match('/\/(image|video|raw)\/upload\//', $media->chemin, $matches);
            $cloudinaryType = $matches[1] ?? 'raw';
            $extension = strtolower($media->format ??  pathinfo($media->chemin, PATHINFO_EXTENSION));
        } else {
            $extension = strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
        }
    @endphp

        <!-- Hero Section - Style Medium -->
    <section class="media-detail-hero py-5 mb-5" style="background: linear-gradient(135deg, #008751 0%, #00532b 100%);">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-white opacity-75 hover-opacity-100 transition">
                            <i class="fas fa-home me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('media.all') }}" class="text-white opacity-75 hover-opacity-100 transition">
                            <i class="fas fa-photo-video me-1"></i> Galerie
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">
                        {{ \Illuminate\Support\Str::limit($media->contenu->titre ??   'Détails', 40) }}
                    </li>
                </ol>
            </nav>

            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold text-white mb-4" style="font-size: 2.5rem; line-height: 1.2;">
                        {{ $media->contenu->titre ?? 'Média culturel' }}
                    </h1>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @if($media->type_media)
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                                <i class="fas {{ $media->isImage() ? 'fa-image' : ($media->isVideo() ? 'fa-video' : ($media->isAudio() ? 'fa-headphones' : 'fa-file')) }} me-1"></i>
                                {{ $media->type_media->nom }}
                            </span>
                        @endif

                        {{-- ✅ Badge Cloudinary --}}
                        @if($isCloudinary)
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(16, 185, 129, 0.9); color: white; border: 1px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-cloud me-1"></i>
                                CDN Cloudinary
                            </span>
                        @endif

                        @if($media->contenu && $media->contenu->langue)
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0. 3);">
                                <i class="fas fa-language me-1"></i>
                                {{ $media->contenu->langue->nom_langue }}
                            </span>
                        @endif

                        @if($media->contenu && $media->contenu->region)
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0. 3);">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $media->contenu->region->nom_region }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
                        <button class="btn btn-sm px-3 py-2" onclick="shareMedia()"
                                style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.3);">
                            <i class="fas fa-share-alt me-1"></i>
                            <span>Partager</span>
                        </button>
                        {{-- ✅ Téléchargement adapté --}}
                        <a href="{{ $mediaUrl }}"
                           download
                           target="_blank"
                           class="btn btn-sm px-3 py-2"
                           style="background: #f8f9fa; color: #008751; border: none;">
                            <i class="fas fa-download me-1"></i>
                            <span>Télécharger</span>
                        </a>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('medias.edit', $media->id) }}"
                                   class="btn btn-sm px-3 py-2"
                                   style="background: #ffc107; color: #212529; border: none;">
                                    <i class="fas fa-edit me-1"></i>
                                    <span>Modifier</span>
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <!-- Media Container -->
                    <div class="card border-0 shadow-sm mb-5" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-body p-0">
                            @if($media->isImage())
                                {{-- ✅ Image --}}
                                <div class="image-preview text-center p-4" style="background: #f8f9fa;">
                                    <img src="{{ $mediaUrl }}"
                                         alt="{{ $media->description ?: 'Image culturelle' }}"
                                         class="img-fluid rounded"
                                         id="mediaImage"
                                         style="max-height: 70vh; object-fit: contain;"
                                         loading="eager">
                                </div>

                            @elseif($media->isVideo())
                                {{-- ✅ Vidéo --}}
                                <div class="video-preview">
                                    <div class="video-player-container bg-dark">
                                        <video controls
                                               controlsList="nodownload"
                                               class="w-100"
                                               style="min-height: 400px;"
                                               preload="metadata"
                                               id="mediaVideo">
                                            <source src="{{ $mediaUrl }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    </div>
                                </div>

                            @elseif($media->isAudio())
                                {{-- ✅ Audio --}}
                                <div class="audio-preview bg-light p-5 text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-music fa-4x mb-3" style="color: #008751;"></i>
                                        <h4 class="mb-2">Écouter l'audio</h4>
                                        <p class="text-muted mb-0">
                                            {{ $media->contenu->titre ??  'Fichier audio culturel' }}
                                        </p>
                                        @if($media->duree)
                                            <p class="text-muted small mt-2">
                                                <i class="fas fa-clock me-1"></i>
                                                Durée: {{ gmdate('i:s', $media->duree) }}
                                            </p>
                                        @endif
                                    </div>

                                    <audio controls
                                           controlsList="nodownload"
                                           class="w-100 mt-4"
                                           id="mediaAudio"
                                           preload="metadata"
                                           style="max-width: 600px; margin: 0 auto;">
                                        <source src="{{ $mediaUrl }}" type="audio/{{ $extension }}">
                                        Votre navigateur ne supporte pas la lecture audio.
                                    </audio>
                                </div>

                            @else
                                {{-- ✅ Autre fichier --}}
                                <div class="document-preview bg-light p-5 text-center">
                                    <i class="fas fa-file-alt fa-5x mb-4" style="color: #6c757d;"></i>
                                    <h4 class="mb-3">Document à consulter</h4>
                                    <p class="text-muted mb-4">
                                        <i class="fas fa-file-signature me-1"></i>
                                        Format: {{ strtoupper($extension) }}
                                    </p>
                                    <a href="{{ $mediaUrl }}"
                                       target="_blank"
                                       class="btn px-4 py-2"
                                       style="background: #008751; color: white;">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        Ouvrir le document
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Media Actions -->
                        @if($media->isImage())
                            <div class="card-footer bg-white border-top py-3">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-outline-secondary btn-sm px-3" onclick="zoomImage(1. 2)">
                                        <i class="fas fa-search-plus me-1"></i> Zoom
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm px-3" onclick="zoomImage(1)">
                                        <i class="fas fa-search-minus me-1"></i> Réinitialiser
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm px-3" onclick="rotateImage()">
                                        <i class="fas fa-redo me-1"></i> Rotation
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Description Section -->
                    @if($media->description || $media->contenu)
                        <div class="mb-5">
                            <h3 class="mb-4 pb-2" style="border-bottom: 2px solid #f0f0f0; font-weight: 600;">
                                À propos de ce média
                            </h3>

                            @if($media->description)
                                <div class="mb-4">
                                    <p class="mb-3" style="font-size: 1.1rem; line-height: 1.7; color: #404040;">
                                        {{ $media->description }}
                                    </p>
                                </div>
                            @endif

                            @if($media->contenu)
                                <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #008751;">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3" style="color: #008751;">
                                            <i class="fas fa-book me-2"></i>
                                            Contenu associé
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong>Titre:</strong> {{ $media->contenu->titre }}</p>
                                                @if($media->contenu->introduction)
                                                    <p class="mb-0"><strong>Introduction:</strong> {{ \Illuminate\Support\Str::limit($media->contenu->introduction, 150) }}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                @if($media->contenu->type_contenu)
                                                    <p class="mb-2"><strong>Type:</strong> {{ $media->contenu->type_contenu->nom }}</p>
                                                @endif
                                                @if($media->contenu->auteur)
                                                    <p class="mb-0"><strong>Auteur:</strong> {{ $media->contenu->auteur->prenom }} {{ $media->contenu->auteur->nom }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('contenu.detail', $media->contenu->id) }}"
                                               class="btn btn-sm px-3 py-2"
                                               style="background: #008751; color: white;">
                                                <i class="fas fa-book-open me-2"></i>
                                                Lire le contenu complet
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Metadata Section -->
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body">
                            <h6 class="mb-4 text-muted text-uppercase small">Informations techniques</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Type de fichier</small>
                                        <span class="fw-medium">{{ $media->type_media->nom ??  'Non spécifié' }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Format</small>
                                        <span class="fw-medium">{{ strtoupper($extension) }}</span>
                                    </div>
                                    {{-- ✅ Dimensions (images/vidéos) --}}
                                    @if($media->largeur && $media->hauteur)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Dimensions</small>
                                            <span class="fw-medium">{{ $media->largeur }}x{{ $media->hauteur }}px</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Date d'ajout</small>
                                        <span>{{ $media->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    {{-- ✅ Taille depuis DB ou calcul --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Taille du fichier</small>
                                        @if($media->taille)
                                            <span>{{ number_format($media->taille / 1048576, 2) }} Mo</span>
                                        @else
                                            <span id="fileSize">Calcul... </span>
                                        @endif
                                    </div>
                                    {{-- ✅ Durée (vidéo/audio) --}}
                                    @if($media->duree)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Durée</small>
                                            <span class="fw-medium">{{ gmdate('i:s', $media->duree) }}</span>
                                        </div>
                                    @endif
                                    {{-- ✅ Source --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Hébergement</small>
                                        <span class="fw-medium">
                                            @if($isCloudinary)
                                                <i class="fas fa-cloud text-success me-1"></i> Cloudinary CDN
                                            @else
                                                <i class="fas fa-hdd text-primary me-1"></i> Serveur local
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Media -->
                    @if($media->contenu && $media->contenu->media->count() > 1)
                        <div class="mb-5">
                            <h3 class="mb-4 pb-2" style="border-bottom: 2px solid #f0f0f0; font-weight: 600;">
                                Autres médias de ce contenu
                            </h3>
                            <div class="row g-4">
                                @foreach($media->contenu->media->where('id', '!=', $media->id)->take(3) as $relatedMedia)
                                    @php
                                        $relatedIsCloudinary = str_contains($relatedMedia->chemin, 'cloudinary');
                                        $relatedUrl = $relatedIsCloudinary ? $relatedMedia->chemin : asset('storage/' . $relatedMedia->chemin);
                                    @endphp
                                    <div class="col-md-4">
                                        <a href="{{ route('media.detail', $relatedMedia->id) }}"
                                           class="text-decoration-none text-dark">
                                            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                                                <div class="card-body p-0" style="border-radius: 8px; overflow: hidden;">
                                                    @if($relatedMedia->isImage())
                                                        <img src="{{ $relatedUrl }}"
                                                             alt="{{ $relatedMedia->description }}"
                                                             class="w-100"
                                                             style="height: 180px; object-fit: cover;"
                                                             loading="lazy">
                                                    @elseif($relatedMedia->isVideo())
                                                        <div class="position-relative video-card-thumb" style="height: 180px;">
                                                            <video class="w-100 h-100"
                                                                   preload="metadata"
                                                                   muted
                                                                   playsinline
                                                                   style="object-fit: cover; pointer-events: none;">
                                                                <source src="{{ $relatedUrl }}" type="video/mp4">
                                                            </video>
                                                            <i class="fas fa-play-circle play-icon"></i>
                                                        </div>
                                                    @elseif($relatedMedia->isAudio())
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                             style="height: 180px;">
                                                            <i class="fas fa-headphones fa-3x" style="color: #008751;"></i>
                                                        </div>
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                             style="height: 180px;">
                                                            <i class="fas fa-file-alt fa-3x" style="color: #6c757d;"></i>
                                                        </div>
                                                    @endif
                                                    <div class="p-3">
                                                        <small class="text-muted d-block mb-1">
                                                            {{ $relatedMedia->type_media->nom ?? 'Média' }}
                                                        </small>
                                                        <p class="mb-0" style="font-size: 0.9rem; line-height: 1.4;">
                                                            {{ \Illuminate\Support\Str::limit($relatedMedia->description, 60) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Section -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="mb-3 text-muted text-uppercase small">Partager ce média</h6>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-sm px-3 py-2" onclick="shareToFacebook()"
                                        style="background: #1877f2; color: white;">
                                    <i class="fab fa-facebook-f me-1"></i> Facebook
                                </button>
                                <button class="btn btn-sm px-3 py-2" onclick="shareToTwitter()"
                                        style="background: #1da1f2; color: white;">
                                    <i class="fab fa-twitter me-1"></i> Twitter
                                </button>
                                <button class="btn btn-sm px-3 py-2" onclick="shareToWhatsApp()"
                                        style="background: #25d366; color: white;">
                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                </button>
                                <button class="btn btn-sm px-3 py-2" onclick="shareToLinkedIn()"
                                        style="background: #0a66c2; color: white;">
                                    <i class="fab fa-linkedin-in me-1"></i> LinkedIn
                                </button>
                                <button class="btn btn-outline-secondary btn-sm px-3 py-2" onclick="copyLink()">
                                    <i class="fas fa-link me-1"></i> Copier le lien
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Navigation Footer -->
    <section class="py-5 border-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('media.all') }}" class="text-decoration-none text-dark hover-text-primary transition">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span>Retour à la galerie</span>
                </a>

                @if($media->contenu)
                    <a href="{{ route('contenu.detail', $media->contenu->id) }}"
                       class="btn px-4 py-2"
                       style="background: #008751; color: white;">
                        <i class="fas fa-book-open me-2"></i>
                        Voir le contenu associé
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Variables de couleurs */
        :root {
            --benin-primary: #008751;
            --benin-primary-dark: #00532b;
            --benin-light: #e8f5f0;
        }

        /* Styles généraux */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #404040;
        }

        /* Transitions */
        .transition {
            transition: all 0.3s ease;
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
        }

        .hover-text-primary:hover {
            color: var(--benin-primary) !important;
        }

        .hover-shadow:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        /* Typographie */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            color: #212529;
        }

        /* Boutons */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* Badges */
        .badge {
            font-weight: 500;
            font-size: 0.85rem;
        }

        /* Cards */
        .card {
            border-radius: 12px;
            border: none;
        }

        /* Media queries */
        @media (max-width: 768px) {
            .media-detail-hero h1 {
                font-size: 1.8rem !important;
            }

            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        /* Personnalisation du player audio */
        audio::-webkit-media-controls-panel {
            background-color: #f8f9fa;
        }

        audio::-webkit-media-controls-play-button {
            background-color: var(--benin-primary);
            border-radius: 50%;
        }

        /* Personnalisation du player vidéo */
        video {
            border-radius: 8px;
        }
        /* ✅ Ajouter pour l'icône play des vidéos miniatures */
        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 32px;
            text-shadow: 0 2px 12px rgba(0,0,0,0.6);
            z-index: 3;
            pointer-events: none;
        }
    </style>
@endpush♠

@push('scripts')
    <script>
        // ✅ Variables Blade correctes
        const mediaUrl = "{{ $mediaUrl }}";
        const isCloudinary = {{ $isCloudinary ?  'true' : 'false' }};
        const mediaTaille = {{ $media->taille ??  'null' }};

        document.addEventListener('DOMContentLoaded', function() {
            // Calculer la taille du fichier si pas déjà en DB
            if (!mediaTaille && document.getElementById('fileSize')) {
                async function getFileSize() {
                    try {
                        const response = await fetch(mediaUrl, { method: 'HEAD' });
                        const size = response.headers.get('content-length');

                        if (size) {
                            const sizeInMB = (size / 1048576).toFixed(2);
                            document.getElementById('fileSize').textContent = sizeInMB + ' Mo';
                        } else {
                            document.getElementById('fileSize'). textContent = 'Inconnue';
                        }
                    } catch (error) {
                        document.getElementById('fileSize').textContent = 'Inconnue';
                    }
                }
                getFileSize();
            }
        });

        // Fonctions d'image (inchangées)
        let currentZoom = 1;
        let currentRotation = 0;

        function zoomImage(factor) {
            const img = document.getElementById('mediaImage');
            if (img) {
                currentZoom = factor;
                img.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
                img.style. transition = 'transform 0.3s ease';
            }
        }

        function rotateImage() {
            const img = document.getElementById('mediaImage');
            if (img) {
                currentRotation += 90;
                img.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
                img.style.transition = 'transform 0.3s ease';
            }
        }

        // Fonctions de partage
        const pageUrl = window.location.href;
        const mediaTitle = '{{ addslashes($media->contenu->titre ??  'Média culturel du Bénin') }}';
        const mediaDescription = '{{ addslashes($media->description ?: 'Découvrez ce média culturel sur Culture Bénin') }}';

        function shareMedia() {
            if (navigator.share) {
                navigator.share({
                    title: mediaTitle,
                    text: mediaDescription,
                    url: pageUrl
                }).catch(err => console. log('Share cancelled'));
            } else {
                copyLink();
            }
        }

        function shareToFacebook() {
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}`, '_blank');
        }

        function shareToTwitter() {
            window.open(`https://twitter.com/intent/tweet? url=${encodeURIComponent(pageUrl)}&text=${encodeURIComponent(mediaTitle)}`, '_blank');
        }

        function shareToWhatsApp() {
            window.open(`https://wa.me/?text=${encodeURIComponent(mediaTitle + ' - ' + pageUrl)}`, '_blank');
        }

        function shareToLinkedIn() {
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(pageUrl)}`, '_blank');
        }

        function copyLink() {
            navigator.clipboard.writeText(pageUrl). then(() => {
                const toast = document.createElement('div');
                toast.innerHTML = `
                    <div style="position: fixed; bottom: 20px; right: 20px; background: #008751; color: white; padding: 12px 20px; border-radius: 6px; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease;">
                        <i class="fas fa-check-circle me-2"></i>
                        Lien copié dans le presse-papier
                    </div>
                `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }).catch(err => {
                alert('Erreur lors de la copie du lien');
            });
        }
    </script>
@endpush
