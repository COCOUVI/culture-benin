@extends('layout')

@section('title')
    Détail d'un Média
@endsection

@extends('layout')

@section('title')
    Détail d'un Média
@endsection

@section('content')
    <div class="card custom-card mb-4">
        <!-- Header -->
        <div class="custom-card-header">
            <div class="card-title">
                <i class="bi bi-image-fill me-2"></i>
                Détails du média
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="row g-4">
                <!-- Aperçu du média -->
                <div class="col-lg-5">
                    <div class="media-preview-card">
                        <h6 class="section-title mb-3">
                            <i class="bi bi-camera-reels me-2"></i>Aperçu
                        </h6>

                        @php
                            // ✅ Détecter le type depuis l'URL Cloudinary ou l'extension
                            $isCloudinary = str_contains($media->chemin, 'cloudinary');

                            if ($isCloudinary) {
                                // Extraire le type depuis l'URL Cloudinary
                                preg_match('/\/(image|video|raw)\/upload\//', $media->chemin, $matches);
                                $cloudinaryType = $matches[1] ?? 'raw';

                                $isImage = $cloudinaryType === 'image';
                                $isVideo = $cloudinaryType === 'video';

                                // Pour audio, c'est stocké comme 'video' sur Cloudinary
                                // On vérifie l'extension
                                $extension = strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
                                $isAudio = in_array($extension, ['mp3','wav','ogg','m4a','aac','flac']);

                                // Si c'est video mais pas audio, c'est une vraie vidéo
                                if ($cloudinaryType === 'video' && !$isAudio) {
                                    $isVideo = true;
                                }
                            } else {
                                // Fallback : détection par extension
                                $extension = strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg','jpeg','png','gif','webp','svg']);
                                $isVideo = in_array($extension, ['mp4','mov','avi','mkv','webm']);
                                $isAudio = in_array($extension, ['mp3','wav','ogg','m4a','aac','flac']);
                            }

                            // Extension pour affichage
                            $extension = $media->format ?? strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
                        @endphp

                        <div class="media-wrapper">
                            @if($isImage)
                                {{-- ✅ Image : URL directe (Cloudinary ou local) --}}
                                <img src="{{ $isCloudinary ? $media->chemin : asset('storage/'.$media->chemin) }}"
                                     alt="{{ $media->titre ??  'Media' }}"
                                     class="img-fluid rounded-3 shadow-lg media-image"
                                     loading="lazy">

                            @elseif($isVideo)
                                {{-- ✅ Vidéo : URL directe --}}
                                <video controls
                                       class="w-100 rounded-3 shadow-lg"
                                       controlsList="nodownload"
                                       preload="metadata">
                                    <source src="{{ $isCloudinary ? $media->chemin : asset('storage/'.$media->chemin) }}"
                                            type="video/{{ $extension }}">
                                    Votre navigateur ne supporte pas la lecture vidéo.
                                </video>

                            @elseif($isAudio)
                                {{-- ✅ Audio : Player avec visualisation --}}
                                <div class="audio-player-wrapper">
                                    <div class="audio-visual-icon">
                                        <i class="bi bi-music-note-beamed audio-icon"></i>
                                    </div>
                                    <p class="audio-filename mt-3 mb-3">
                                        {{ $media->titre ?? basename($media->chemin) }}
                                    </p>
                                    <audio controls
                                           class="w-100 custom-audio-player"
                                           controlsList="nodownload"
                                           preload="metadata">
                                        <source src="{{ $isCloudinary ? $media->chemin : asset('storage/'.$media->chemin) }}"
                                                type="audio/{{ $extension }}">
                                        Votre navigateur ne supporte pas la lecture audio.
                                    </audio>
                                </div>

                            @else
                                {{-- ✅ Autre fichier : Placeholder avec lien de téléchargement --}}
                                <div class="file-placeholder">
                                    <i class="bi bi-file-earmark-text file-icon"></i>
                                    <p class="mt-3 mb-2 text-muted">{{ basename($media->chemin) }}</p>
                                    <a href="{{ $isCloudinary ? $media->chemin : asset('storage/'.$media->chemin) }}"
                                       class="btn btn-sm btn-primary mt-2"
                                       download
                                       target="_blank">
                                        <i class="bi bi-download me-1"></i> Télécharger
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Metadata rapide -->
                        <div class="metadata-quick mt-3">
                            <div class="metadata-item">
                                @if($isImage)
                                    <i class="bi bi-file-earmark-image text-primary"></i>
                                    <span>📷 {{ strtoupper($extension) }}</span>
                                @elseif($isVideo)
                                    <i class="bi bi-file-earmark-play text-danger"></i>
                                    <span>🎥 {{ strtoupper($extension) }}</span>
                                @elseif($isAudio)
                                    <i class="bi bi-file-earmark-music text-warning"></i>
                                    <span>🎵 {{ strtoupper($extension) }}</span>
                                @else
                                    <i class="bi bi-file-earmark text-secondary"></i>
                                    <span>📄 {{ strtoupper($extension) }}</span>
                                @endif
                            </div>

                            <div class="metadata-item">
                                <i class="bi bi-calendar3 text-primary"></i>
                                <span>{{ $media->created_at->format('d/m/Y') }}</span>
                            </div>

                            {{-- ✅ Taille depuis la colonne 'taille' ou calcul local --}}
                            @if($media->taille)
                                <div class="metadata-item">
                                    <i class="bi bi-hdd text-success"></i>
                                    <span>{{ number_format($media->taille / 1048576, 2) }} MB</span>
                                </div>
                            @elseif(! $isCloudinary && file_exists(storage_path('app/public/'.$media->chemin)))
                                <div class="metadata-item">
                                    <i class="bi bi-hdd text-success"></i>
                                    <span>{{ number_format(filesize(storage_path('app/public/'.$media->chemin)) / 1048576, 2) }} MB</span>
                                </div>
                            @endif

                            {{-- ✅ Durée pour vidéo/audio --}}
                            @if($media->duree)
                                <div class="metadata-item">
                                    <i class="bi bi-clock text-info"></i>
                                    <span>{{ gmdate('i:s', $media->duree) }}</span>
                                </div>
                            @endif

                            {{-- ✅ Dimensions pour images/vidéos --}}
                            @if($media->largeur && $media->hauteur)
                                <div class="metadata-item">
                                    <i class="bi bi-aspect-ratio text-secondary"></i>
                                    <span>{{ $media->largeur }}x{{ $media->hauteur }}</span>
                                </div>
                            @endif

                            {{-- ✅ Badge Cloudinary --}}
                            @if($isCloudinary)
                                <div class="metadata-item metadata-cloudinary">
                                    <i class="bi bi-cloud-check-fill text-success"></i>
                                    <span>☁️ Cloudinary</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informations détaillées -->
                <div class="col-lg-7">
                    <!-- Section Informations générales -->
                    <div class="info-section mb-4">
                        <h6 class="section-title">
                            <i class="bi bi-info-circle me-2"></i>Informations générales
                        </h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-item-modern">
                                    <div class="info-icon">
                                        <i class="bi bi-file-text-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label-small">Contenu lié</span>
                                        <span class="info-value-large">{{ $media->contenu->titre ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item-modern">
                                    <div class="info-icon">
                                        <i class="bi bi-tag-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label-small">Type de média</span>
                                        <span class="badge-type mt-1">{{ $media->type_media->nom ??  ucfirst($extension) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item-modern">
                                    <div class="info-icon">
                                        <i class="bi bi-folder-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label-small">Source</span>
                                        <span class="info-value-large text-truncate" title="{{ $media->chemin }}">
                                            @if($isCloudinary)
                                                <i class="bi bi-cloud-check me-1 text-success"></i>
                                                Cloudinary CDN
                                            @else
                                                <i class="bi bi-hdd me-1 text-primary"></i>
                                                {{ Str::limit(basename($media->chemin), 25) }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="info-item-modern">
                                    <div class="info-icon">
                                        <i class="bi bi-chat-left-text-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label-small">Description:</span>
                                        <span class="info-value-large">{{ $media->description ?? 'Aucune description' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Dates -->
                    <div class="info-section">
                        <h6 class="section-title">
                            <i class="bi bi-clock-history me-2"></i>Historique
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item-modern">
                                    <div class="info-icon">
                                        <i class="bi bi-calendar-plus-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label-small">Date d'ajout</span>
                                        <span class="info-value-large">{{ $media->created_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item-modern">
                                    <div class="info-icon">
                                        <i class="bi bi-calendar-check-fill"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label-small">Dernière modification</span>
                                        <span class="info-value-large">{{ $media->updated_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer avec actions -->
        <div class="custom-footer">
            <a href="{{ route('medias.index') }}" class="btn-cancel-custom">
                <i class="bi bi-arrow-left-circle"></i> Retour
            </a>

            <div class="d-flex gap-2">
                <a href="{{ route('medias.edit', $media->id) }}" class="btn-warning-custom">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>

                <form action="{{ route('medias.destroy', $media->id) }}"
                      method="POST"
                      class="deleteMediaForm d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-custom">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Card modern */
        .custom-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
            width: 100%;
            max-width: 100%;
        }

        .custom-card-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 20px 20px;
        }

        .custom-card-header .card-title {
            font-size: 19px;
            font-weight: 600;
            margin: 0;
        }

        /* Media Preview Card */
        .media-preview-card {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            height: 100%;
        }

        .media-wrapper {
            position: relative;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .media-image {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        . media-image:hover {
            transform: scale(1.05);
        }

        /* Audio Player Enhanced */
        .audio-player-wrapper {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            padding: 40px 30px;
            border-radius: 12px;
            text-align: center;
            width: 100%;
        }

        .audio-visual-icon {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        . audio-icon {
            font-size: 5rem;
            color: #f59e0b;
            filter: drop-shadow(0 4px 8px rgba(245, 158, 11, 0.3));
        }

        .audio-filename {
            font-size: 0.95rem;
            font-weight: 600;
            color: #78350f;
            word-break: break-word;
        }

        .custom-audio-player {
            border-radius: 50px;
            background: #ffffff;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .custom-audio-player::-webkit-media-controls-panel {
            background: #ffffff;
        }

        /* Video styling */
        video {
            max-height: 400px;
            background: #000;
        }

        /* File Placeholder */
        .file-placeholder {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            padding: 60px 20px;
            border-radius: 12px;
            text-align: center;
        }

        . file-icon {
            font-size: 5rem;
            color: #6b7280;
        }

        /* Metadata Quick */
        .metadata-quick {
            display: flex;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            flex-wrap: wrap;
        }

        .metadata-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            font-weight: 600;
            color: #4b5563;
            white-space: nowrap;
        }

        /* Section Title */
        .section-title {
            color: #1e40af;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
        }

        /* Info Item Modern */
        .info-item-modern {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            height: 100%;
        }

        .info-item-modern:hover {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
        }

        .info-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 1.2rem;
        }

        . info-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-label-small {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        . info-value-large {
            font-size: 1rem;
            color: #1f2937;
            font-weight: 600;
            word-break: break-word;
        }

        /* Badge Type */
        .badge-type {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        /* Buttons */
        .btn-cancel-custom {
            background: #6c757d;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            color: white;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cancel-custom:hover {
            transform: translateY(-2px);
            background: #5a6268;
            color: white;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            color: white;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-warning-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
            color: white;
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            color: white;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0. 3);
        }

        . btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        /* Footer */
        .custom-footer {
            padding: 20px 25px;
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .media-preview-card {
                margin-bottom: 1. 5rem;
            }

            .media-wrapper {
                min-height: 250px;
            }
        }

        @media (max-width: 768px) {
            .custom-footer {
                flex-direction: column;
                gap: 12px;
            }

            . custom-footer > * {
                width: 100%;
            }

            .btn-cancel-custom,
            .btn-warning-custom,
            .btn-danger-custom {
                width: 100%;
                justify-content: center;
            }

            .metadata-quick {
                flex-direction: column;
            }

            .metadata-item {
                width: 100%;
                justify-content: center;
            }

            .audio-icon {
                font-size: 3.5rem;
            }

            .audio-player-wrapper {
                padding: 30px 20px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Confirmation suppression
        $('. deleteMediaForm').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal. fire({
                title: 'Êtes-vous sûr ? ',
                text: "Le média sera définitivement supprimé de Cloudinary et de la base de données.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result. isConfirmed) form.submit();
            });
        });
    </script>
@endpush
