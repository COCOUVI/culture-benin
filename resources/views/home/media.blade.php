@extends('layouts.app1')

@section('title', 'Galerie des Médias - Culture Bénin')

@section('content')
    <!-- Hero Section -->
    <section class="media-hero py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold text-white mb-3">
                        <i class="fas fa-photo-video me-3"></i>
                        Galerie des Médias Culturels
                    </h1>
                    <p class="lead text-white-50 mb-4">
                        Découvrez notre collection riche d'images, vidéos et audios documentant
                        la diversité culturelle du Bénin. Une mémoire vivante de nos traditions.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $stats['total'] ??  0 }}</span>
                            <span class="stat-label">Médias</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $stats['images'] ?? 0 }}</span>
                            <span class="stat-label">Images</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $stats['videos'] ?? 0 }}</span>
                            <span class="stat-label">Vidéos</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $stats['audios'] ?? 0 }}</span>
                            <span class="stat-label">Audios</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-filter me-2"></i>
                        Filtres
                    </h5>
                </div>
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('media.all') }}"
                           class="btn btn-outline-primary {{ ! request()->has('type') ?  'active' : '' }}">
                            <i class="fas fa-layer-group me-1"></i>
                            Tous les médias
                        </a>
                        @foreach($typesMedia as $type)
                            <a href="{{ route('media.all', ['type' => $type->id]) }}"
                               class="btn btn-outline-primary {{ request('type') == $type->id ?  'active' : '' }}">
                                <i class="{{ $type->icon ??  'fas fa-file' }} me-1"></i>
                                {{ $type->nom }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Media Grid Section -->
    <section class="py-5">
        <div class="container">
            @if($medias->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-photo-video fa-4x text-muted mb-4"></i>
                        <h3 class="h4 text-muted">Aucun média disponible</h3>
                        <p class="text-muted mb-4">Aucun média n'a été uploadé pour le moment.</p>
                        @auth
                            @if(auth()->user()->isAdmin() || auth()->user()->isAuteur())
                                <a href="{{ route('contenus.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Créer un contenu
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($medias as $media)
                        @php
                            // ✅ Détection Cloudinary
                            $isCloudinary = str_contains($media->chemin, 'cloudinary');
                            $mediaUrl = $isCloudinary ? $media->chemin : asset('storage/' . $media->chemin);

                            // Type
                            if ($isCloudinary) {
                                preg_match('/\/(image|video|raw)\/upload\//', $media->chemin, $matches);
                                $cloudinaryType = $matches[1] ?? 'raw';
                                $extension = strtolower($media->format ??  pathinfo($media->chemin, PATHINFO_EXTENSION));
                            } else {
                                $extension = strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
                            }
                        @endphp

                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="media-grid-card card h-100 border-0 shadow-sm">
                                <!-- Media Header -->
                                <div class="media-card-header position-relative">
                                    @if($media->isImage())
                                        {{-- ✅ Image --}}
                                        <div class="media-thumbnail">
                                            <img src="{{ $mediaUrl }}"
                                                 alt="{{ $media->description ?: 'Image culturelle' }}"
                                                 class="img-fluid w-100"
                                                 loading="lazy">
                                            <span class="media-type-badge badge bg-success">
                                                <i class="fas fa-image"></i> Image
                                            </span>
                                            @if($isCloudinary)
                                                <span class="cloudinary-badge">
                                                    <i class="fas fa-cloud"></i>
                                                </span>
                                            @endif
                                        </div>

                                    @elseif($media->isVideo())
                                        {{-- ✅ Vidéo --}}
                                        <div class="media-thumbnail video-thumbnail">
                                            <div class="video-player-wrapper">
                                                <video class="video-thumbnail-player"
                                                       preload="metadata"
                                                       muted
                                                       playsinline>
                                                    <source src="{{ $mediaUrl }}" type="video/mp4">
                                                </video>
                                                <div class="video-overlay">
                                                    <button class="play-btn"
                                                            onclick="openVideoModal('{{ $mediaUrl }}', '{{ addslashes($media->contenu->titre ??  'Vidéo culturelle') }}')">
                                                        <i class="fas fa-play-circle"></i>
                                                    </button>
                                                    @if($media->duree)
                                                        <p class="video-duration">{{ gmdate('i:s', $media->duree) }}</p>
                                                    @else
                                                        <p class="video-duration" id="duration-{{ $media->id }}">--:--</p>
                                                    @endif
                                                </div>
                                                <span class="media-type-badge badge bg-primary">
                                                    <i class="fas fa-video"></i> Vidéo
                                                </span>
                                                @if($isCloudinary)
                                                    <span class="cloudinary-badge">
                                                        <i class="fas fa-cloud"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                    @elseif($media->isAudio())
                                        {{-- ✅ Audio --}}
                                        <div class="media-thumbnail audio-thumbnail">
                                            <div class="audio-placeholder">
                                                <i class="fas fa-music fa-3x text-warning"></i>
                                                <p class="mt-2 mb-0 fw-bold">Fichier Audio</p>
                                                @if($media->duree)
                                                    <small class="text-dark">{{ gmdate('i:s', $media->duree) }}</small>
                                                @endif
                                            </div>
                                            <span class="media-type-badge badge bg-warning text-dark">
                                                <i class="fas fa-headphones"></i> Audio
                                            </span>
                                            @if($isCloudinary)
                                                <span class="cloudinary-badge">
                                                    <i class="fas fa-cloud"></i>
                                                </span>
                                            @endif
                                        </div>

                                    @else
                                        {{-- ✅ Autre fichier --}}
                                        <div class="media-thumbnail">
                                            <div class="file-placeholder">
                                                <i class="fas fa-file fa-3x text-secondary"></i>
                                                <p class="mt-2 mb-0 fw-bold">Document</p>
                                            </div>
                                            <span class="media-type-badge badge bg-secondary">
                                                <i class="fas fa-file-alt"></i> Document
                                            </span>
                                            @if($isCloudinary)
                                                <span class="cloudinary-badge">
                                                    <i class="fas fa-cloud"></i>
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Quick Actions -->
                                    <div class="media-actions">
                                        <button class="btn-action btn-action-sm"
                                                title="Partager"
                                                data-media-url="{{ $mediaUrl }}"
                                                data-media-title="{{ $media->contenu->titre ?? 'Média culturel' }}">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                        <a href="{{ $mediaUrl }}"
                                           download
                                           target="_blank"
                                           class="btn-action btn-action-sm"
                                           title="Télécharger">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Media Body -->
                                <div class="card-body">
                                    <h6 class="card-title fw-bold mb-2">
                                        <a href="{{ route('contenu.detail', $media->contenu->id ??  '#') }}"
                                           class="text-decoration-none text-dark">
                                            {{ $media->contenu->titre ??  'Média sans titre' }}
                                        </a>
                                    </h6>

                                    @if($media->description)
                                        <p class="card-text small text-muted mb-3">
                                            {{ \Illuminate\Support\Str::limit($media->description, 100) }}
                                        </p>
                                    @endif

                                    <!-- Media Meta -->
                                    <div class="media-meta small">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-tag me-2 text-primary"></i>
                                            <span class="text-muted">{{ $media->type_media->nom ?? 'Non spécifié' }}</span>
                                        </div>
                                        @if($media->contenu)
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-language me-2 text-primary"></i>
                                                <span class="text-muted">
                                                    {{ optional($media->contenu->langue)->nom_langue ?? 'Non spécifié' }}
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                                <span class="text-muted">
                                                    {{ optional($media->contenu->region)->nom_region ?? 'Non spécifié' }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar me-2 text-primary"></i>
                                            <span class="text-muted">{{ $media->created_at->format('d/m/Y') }}</span>
                                        </div>

                                        {{-- ✅ Métadonnées supplémentaires --}}
                                        @if($media->taille)
                                            <div class="d-flex align-items-center mt-2">
                                                <i class="fas fa-hdd me-2 text-primary"></i>
                                                <span class="text-muted">{{ number_format($media->taille / 1048576, 2) }} Mo</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Media Footer -->
                                <div class="card-footer bg-transparent border-top-0 pt-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            @if($isCloudinary)
                                                <i class="fas fa-cloud text-success me-1"></i>
                                            @else
                                                <i class="fas fa-file-signature me-1"></i>
                                            @endif
                                            {{ strtoupper($extension) }}
                                        </small>
                                        <div class="btn-group">
                                            <a href="{{ $mediaUrl }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary mx-1"
                                               title="Voir en grand">
                                                <i class="fas fa-expand"></i>
                                            </a>
                                            <a href="{{ route('media.detail', $media->id) }}"
                                               class="btn btn-sm btn-primary"
                                               title="Voir le contenu">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $medias->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Hero Section */
        .media-hero {
            background: linear-gradient(135deg, var(--benin-green), var(--benin-green-dark));
            position: relative;
            overflow: hidden;
        }

        .media-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23008751' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .hero-stats {
            display: flex;
            gap: 1.5rem;
            justify-content: flex-end;
        }

        .stat-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem;
            border-radius: 10px;
            min-width: 80px;
        }

        .stat-number {
            display: block;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--benin-yellow);
        }

        .stat-label {
            display: block;
            font-size: 0.875rem;
            color: white;
            opacity: 0.9;
        }

        /* Media Grid Card */
        .media-grid-card {
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .media-grid-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            border-color: var(--benin-green);
        }

        .media-card-header {
            height: 200px;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
        }

        .media-thumbnail {
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            position: relative;
        }

        .media-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .media-grid-card:hover .media-thumbnail img {
            transform: scale(1.05);
        }

        .video-thumbnail {
            background: #000;
        }

        .audio-thumbnail {
            background: linear-gradient(135deg, #fff9db, #ffe066);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-placeholder {
            text-align: center;
            color: #6c757d;
        }

        .media-type-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            z-index: 2;
        }

        .media-actions {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 0.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .media-grid-card:hover .media-actions {
            opacity: 1;
        }

        .btn-action-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--benin-green);
            transition: all 0.3s ease;
        }

        .btn-action-sm:hover {
            background: var(--benin-green);
            color: white;
            transform: scale(1.1);
        }

        /* Video Styles */
        .video-player-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .video-thumbnail-player {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .play-btn {
            background: rgba(0, 135, 81, 0.8);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .play-btn:hover {
            background: rgba(0, 135, 81, 1);
            transform: scale(1.1);
        }

        .video-duration {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 1;
        }

        /* Media Meta */
        .media-meta i {
            width: 16px;
            text-align: center;
        }

        /* Filter Buttons */
        .btn-outline-primary.active {
            background-color: var(--benin-green);
            border-color: var(--benin-green);
            color: white;
        }

        /* Empty State */
        .empty-state {
            max-width: 400px;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-stats {
                justify-content: flex-start;
                margin-top: 2rem;
            }

            .stat-item {
                min-width: 70px;
                padding: 0.75rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-stats {
                flex-wrap: wrap;
            }

            .media-card-header {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .hero-stats {
                gap: 1rem;
            }

            .stat-item {
                min-width: 60px;
                padding: 0.5rem;
            }

            .stat-number {
                font-size: 1.25rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }
        }
        /* ✅ Badge Cloudinary */
        .cloudinary-badge {
            position: absolute;
            top: 40px;
            right: 10px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
        }

        . cloudinary-badge i {
            font-size: 0.65rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gérer les vidéos
            document.querySelectorAll('. video-thumbnail-player').forEach(video => {
                const durationEl = video.closest('.video-player-wrapper').querySelector('.video-duration');

                // Calculer la durée seulement si pas déjà affichée
                if (durationEl && durationEl.textContent === '--:--') {
                    video.addEventListener('loadedmetadata', function() {
                        const duration = Math.floor(video.duration);
                        const minutes = Math.floor(duration / 60);
                        const seconds = duration % 60;
                        durationEl.textContent =
                            minutes.toString().padStart(2, '0') + ':' +
                            seconds.toString().padStart(2, '0');
                    });
                }

                // Lecture automatique au survol
                const thumbnailWrapper = video.closest('. media-thumbnail');
                if (thumbnailWrapper) {
                    thumbnailWrapper.addEventListener('mouseenter', function() {
                        video.play(). catch(e => console.log('Autoplay prevented'));
                    });
                    thumbnailWrapper.addEventListener('mouseleave', function() {
                        video.pause();
                        video. currentTime = 0;
                    });
                }
            });

            // Boutons d'action Partager
            document.querySelectorAll('.media-actions .btn-action-sm[title="Partager"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const mediaUrl = this.dataset.mediaUrl;
                    const mediaTitle = this.dataset.mediaTitle;

                    if (navigator.share) {
                        navigator.share({
                            title: mediaTitle,
                            text: 'Découvrez ce média culturel du Bénin',
                            url: window.location.href
                        }). catch(err => console.log('Share cancelled'));
                    } else {
                        // Copier le lien
                        navigator.clipboard.writeText(window. location.href). then(() => {
                            showToast('Lien copié dans le presse-papier');
                        });
                    }
                });
            });
        });

        // Fonction pour ouvrir la modal vidéo
        function openVideoModal(videoUrl, videoTitle) {
            const modalHtml = `
                <div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title">${videoTitle}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <video controls controlsList="nodownload" style="width:100%; max-height:70vh;" autoplay>
                                    <source src="${videoUrl}" type="video/mp4">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                            </div>
                            <div class="modal-footer bg-dark">
                                <a href="${videoUrl}" download target="_blank" class="btn btn-outline-light">
                                    <i class="fas fa-download me-2"></i>
                                    Télécharger
                                </a>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));

            document.getElementById('videoModal').addEventListener('hidden. bs.modal', function() {
                this.remove();
            });

            videoModal.show();
        }

        // Toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.innerHTML = `
                <div style="position: fixed; bottom: 20px; right: 20px; background: #008751; color: white; padding: 12px 20px; border-radius: 6px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease;">
                    <i class="fas fa-check-circle me-2"></i>
                    ${message}
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
@endpush
