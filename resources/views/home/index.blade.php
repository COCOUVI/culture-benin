@extends('layouts.app1')

@section('title', 'Culture Bénin - Plateforme de promotion de la culture et des langues')

@section('content')
    <!-- Hero Carousel Section -->
    <section class="hero-carousel-section" role="banner">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <!-- Indicateurs -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>

            <div class="carousel-inner">
                <!-- Slide 1 - Culture -->
                <div class="carousel-item active">
                    <div class="hero-slide slide-1"
                         style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/img/pen.jpg');">
                        <div class="container">
                            <div class="hero-content">
                                <span class="hero-badge">🇧🇯 Culture Béninoise</span>
                                <h1 class="hero-title">Découvrez la richesse culturelle du Bénin</h1>
                                <p class="hero-description">Une plateforme participative pour préserver et promouvoir
                                    nos traditions, nos langues et notre patrimoine</p>
                                <div class="hero-actions">
                                    <a href="#contenus" class="btn btn-primary btn-lg">
                                        <i class="fas fa-book"></i>
                                        <span>Explorer les contenus</span>
                                    </a>
                                    <a href="#contribuer" class="btn btn-outline-light btn-lg">
                                        <i class="fas fa-plus"></i>
                                        <span>Contribuer</span>
                                    </a>
                                </div>
                                <div class="hero-stats">
                                    <div class="stat-item mx-3">
                                        <strong>{{ $nbr_contenus }}</strong>
                                        <span>Contenus</span>
                                    </div>
                                    <div class="stat-item mx-3">
                                        <strong>{{ $nbr_langues }}</strong>
                                        <span>Langues</span>
                                    </div>
                                    <div class="stat-item mx-3">
                                        <strong>{{ $contributeurs }}</strong>
                                        <span>Contributeurs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 - Traditions -->
                <div class="carousel-item">
                    <div class="hero-slide slide-2"
                         style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url('/img/dance.jpg');">
                        <div class="container">
                            <div class="hero-content">
                                <span class="hero-badge">🎭 Traditions Ancestrales</span>
                                <h1 class="hero-title">Préservons nos traditions millénaires</h1>
                                <p class="hero-description">Des rites sacrés aux danses traditionnelles, explorez
                                    l'héritage culturel transmis de génération en génération</p>
                                <div class="hero-actions">
                                    <a href="#traditions" class="btn btn-light btn-lg">
                                        <i class="fas fa-drum"></i>
                                        <span>Découvrir les traditions</span>
                                    </a>
                                    <a href="{{route('media.all')}}" class="btn btn-outline-light btn-lg">
                                        <i class="fas fa-play-circle"></i>
                                        <span>Voir les Medias</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 - Langues -->
                <div class="carousel-item">
                    <div class="hero-slide slide-3"
                         style="background-image: linear-gradient(rgba(255, 107, 0, 0.7), rgba(204, 85, 0, 0.7)), url('/img/Gbe_languages.png');">
                        <div class="container">
                            <div class="hero-content">
                                <span class="hero-badge">🗣️ Multilinguisme</span>
                                <h1 class="hero-title">Célébrons nos langues nationales</h1>
                                <p class="hero-description">Fon, Yoruba, Dendi, Goun... Découvrez et apprenez les
                                    langues qui font la richesse du Bénin</p>
                                <div class="hero-actions">
                                    <a href="#langues" class="btn btn-light btn-lg">
                                        <i class="fas fa-language"></i>
                                        <span>Explorer les langues</span>
                                    </a>
                                    <a href="#apprendre" class="btn btn-outline-light btn-lg">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span>Apprendre</span>
                                    </a>
                                </div>
                                <div class="hero-languages">
                                    @foreach($langues as $langue)
                                        <span class="language-tag">{{$langue->nom_langue}}</span>
                                    @endforeach
                                    <span class="language-tag">+ autres</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 - Régions -->
                <div class="carousel-item">
                    <div class="hero-slide slide-4"
                         style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/img/porte_du_non_retour.jpg');">
                        <div class="container">
                            <div class="hero-content">
                                <span class="hero-badge">🗺️ Patrimoine Régional</span>
                                <h1 class="hero-title">Voyagez à travers les 12 départements</h1>
                                <p class="hero-description">De l'Atacora au Mono, chaque région du Bénin possède ses
                                    spécificités culturelles uniques</p>
                                <div class="hero-actions">
                                    <a href="#regions" class="btn btn-light btn-lg">
                                        <i class="fas fa-map-marked-alt"></i>
                                        <span>Explorer les régions</span>
                                    </a>
                                    <a href="#carte" class="btn btn-outline-light btn-lg">
                                        <i class="fas fa-compass"></i>
                                        <span>Voir la carte</span>
                                    </a>
                                </div>
                                <div class="hero-regions">
                                    @foreach($regions as $region)
                                        <div class="region-chip">{{$region->nom_region}}</div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contrôles -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>

            <!-- Scroll down indicator -->
            <div class="scroll-indicator">
                <a href="#contenus" class="scroll-link">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Pourquoi cette plateforme ?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <article class="feature-card card">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-language"></i>
                        </div>
                        <h3 class="h5">Multilinguisme</h3>
                        <p>Créez et consultez des contenus dans les langues nationales du Bénin : Fon, Yoruba, Dendi,
                            Goun et bien d'autres.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="feature-card card">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="h5">Communauté</h3>
                        <p>Participez à la préservation de notre patrimoine en partageant vos connaissances et
                            expériences.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="feature-card card">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-photo-video"></i>
                        </div>
                        <h3 class="h5">Média riche</h3>
                        <p>Découvrez une collection riche d'images, vidéos et audios documentant la culture béninoise.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Content Carousel Section -->
    <section class="py-5 bg-light">
        <div class="container" id="contenus">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">Contenus récents</h2>

                @if(($slides ?? collect())->count() > 1)
                    <div class="carousel-controls d-none d-md-flex gap-2">
                        <button class="btn btn-outline-primary" type="button" data-bs-target="#recentContentCarousel"
                                data-bs-slide="prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-outline-primary" type="button" data-bs-target="#recentContentCarousel"
                                data-bs-slide="next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>

            @if(empty($slides) || $slides->isEmpty())
                <div class="alert alert-info">Aucun contenu récent disponible pour l'instant.</div>
            @else
                <div id="recentContentCarousel" class="carousel slide" data-bs-ride="false">
                    {{-- Indicators (render only when more than one slide) --}}
                    @if($slides->count() > 1)
                        <div class="carousel-indicators">
                            @foreach($slides as $i => $s)
                                <button type="button"
                                        data-bs-target="#recentContentCarousel"
                                        data-bs-slide-to="{{ $i }}"
                                        class="{{ $i === 0 ? 'active' : '' }}"
                                        aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                                        aria-label="Slide {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif

                    <div class="carousel-inner">
                        @foreach($slides as $index => $chunk)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row g-4">
                                    @foreach($chunk as $contenu)
                                        <div class="col-md-4">
                                            <article class="content-card card h-100">
                                                {{-- Ligne ~220 environ --}}
                                                <div class="card-img-wrapper">
                                                    @php
                                                        // ✅ Détection Cloudinary
                                                        $mediaPath = optional($contenu->media->first())->chemin;

                                                        if ($mediaPath) {
                                                            $isCloudinary = str_contains($mediaPath, 'cloudinary');
                                                            $imgSrc = $isCloudinary ?  $mediaPath : asset("storage/{$mediaPath}");
                                                        } else {
                                                            $imgSrc = "https://picsum.photos/400/250?random={$contenu->id}";
                                                        }
                                                    @endphp

                                                    <img src="{{ $imgSrc }}"
                                                         class="card-img-top"
                                                         alt="{{ $contenu->titre ?? 'Contenu culturel' }}"
                                                         loading="lazy">

                                                    <span class="badge-category">
        {{ optional($contenu->type_contenu)->nom ??  'Contenu' }}
    </span>
                                                </div>

                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="badge bg-primary me-2">
                                                            {{ optional($contenu->langue)->nom_langue ?? '—' }}
                                                        </span>
                                                        <small class="text-muted">
                                                            <i class="far fa-clock"></i>
                                                            {{ optional($contenu->created_at)->diffForHumans() ?? '' }}
                                                        </small>
                                                    </div>

                                                    <h3 class="h5 card-title">
                                                        {{ $contenu->titre ?? 'Sans titre' }}
                                                    </h3>

                                                    <p class="card-text">
                                                        {{ \Illuminate\Support\Str::limit($contenu->texte ?? '', 120) }}
                                                    </p>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-muted small">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            {{ optional($contenu->region)->nom_region ?? '—' }}
                                                        </span>


                                                        @auth
                                                            {{-- User connecté --}}
                                                            @if(auth()->user()->isAdmin() || auth()->user()->aPaye($contenu))
                                                                {{-- Admin OU a payé = Accès direct --}}
                                                                <a href="{{ route('contenu.detail', $contenu->id) }}"
                                                                   class="btn btn-sm btn-success">
                                                                    <i class="fas fa-book-open me-1"></i>
                                                                    Lire
                                                                </a>
                                                            @else
                                                                <button type="button"
                                                                        class="btn btn-sm btn-warning btn-pay-content"
                                                                        data-contenu-id="{{ $contenu->id }}"
                                                                        data-contenu-titre="{{ addslashes($contenu->titre) }}"
                                                                >
                                                                    <i class="fas fa-lock me-1"></i>
                                                                    Payer 100 F
                                                                </button>
                                                            @endif
                                                        @else
                                                            {{-- Non connecté = Bouton Connexion --}}
                                                            <a href="{{ route('login') }}"
                                                               class="btn btn-sm btn-danger">
                                                                <i class="fas fa-sign-in-alt me-1"></i>
                                                                Se connecter pour lire
                                                            </a>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Controls shown only when more than one slide --}}
                    @if($slides->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#recentContentCarousel"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#recentContentCarousel"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    @endif
                </div>
            @endif

            <div class="text-center mt-5">
                <a href="{{route('contenus.all')}}" class="btn btn-primary btn-lg">Voir tous les contenus</a>
            </div>
        </div>
    </section>

    {{-- Remplacez seulement la section Media (ligne ~370 à ~500) --}}

    <!-- Media Section -->
    <section id="medias" class="py-5">
        <div class="container">
            <h2 class="section-title">Galerie des médias</h2>
            <p class="text-center text-muted mb-5">Découvrez notre collection d'images, vidéos et audios documentant la culture béninoise</p>

            <div class="row g-4">
                @forelse($medias as $media)
                    @php
                        // ✅ Détecter si c'est Cloudinary
                        $isCloudinary = str_contains($media->chemin, 'cloudinary');

                        // ✅ URL du média (Cloudinary ou local)
                        $mediaUrl = $isCloudinary ?  $media->chemin : asset('storage/' . $media->chemin);

                        // ✅ Détecter le type
                        if ($isCloudinary) {
                            // Cloudinary encode le type dans l'URL
                            preg_match('/\/(image|video|raw)\/upload\//', $media->chemin, $matches);
                            $cloudinaryType = $matches[1] ?? 'raw';

                            $isImage = $cloudinaryType === 'image';
                            $isVideo = $cloudinaryType === 'video';

                            // Audio est stocké comme 'video' sur Cloudinary
                            $extension = strtolower($media->format ??  pathinfo($media->chemin, PATHINFO_EXTENSION));
                            $isAudio = in_array($extension, ['mp3','wav','ogg','m4a','aac','flac']);

                            if ($cloudinaryType === 'video' && ! $isAudio) {
                                $isVideo = true;
                            }
                        } else {
                            // Local : détection par extension
                            $extension = strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg','jpeg','png','gif','webp','svg']);
                            $isVideo = in_array($extension, ['mp4','mov','avi','mkv','webm']);
                            $isAudio = in_array($extension, ['mp3','wav','ogg','m4a','aac','flac']);
                        }
                    @endphp

                    <div class="col-md-4 col-lg-3">
                        <article class="media-card card h-100">
                            <div class="media-card-header">
                                @if($isImage)
                                    {{-- ✅ Image --}}
                                    <div class="media-thumbnail">
                                        <img src="{{ $mediaUrl }}"
                                             alt="{{ $media->description ?: 'Image culturelle' }}"
                                             class="img-fluid"
                                             loading="lazy">
                                        <span class="media-type-badge badge bg-success">
                                        <i class="fas fa-image"></i> Image
                                    </span>
                                    </div>

                                @elseif($isVideo)
                                    {{-- ✅ Vidéo --}}
                                    <div class="media-thumbnail video-thumbnail">
                                        <div class="video-player-wrapper">
                                            <video class="video-thumbnail-player"
                                                   preload="metadata"
                                                   muted
                                                   playsinline>
                                                <source src="{{ $mediaUrl }}" type="video/mp4">
                                                Votre navigateur ne supporte pas la lecture de vidéos.
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
                                        </div>
                                    </div>

                                @elseif($isAudio)
                                    {{-- ✅ Audio --}}
                                    <div class="media-thumbnail audio-thumbnail">
                                        <div class="audio-placeholder">
                                            <i class="fas fa-music"></i>
                                            <p>Audio</p>
                                            @if($media->duree)
                                                <small class="text-white">{{ gmdate('i:s', $media->duree) }}</small>
                                            @endif
                                        </div>
                                        <span class="media-type-badge badge bg-warning text-dark">
                                        <i class="fas fa-headphones"></i> Audio
                                    </span>
                                    </div>

                                @else
                                    {{-- ✅ Autre fichier --}}
                                    <div class="media-thumbnail">
                                        <div class="file-placeholder">
                                            <i class="fas fa-file"></i>
                                            <p>Fichier</p>
                                        </div>
                                        <span class="media-type-badge badge bg-secondary">
                                        <i class="fas fa-file-alt"></i> Document
                                    </span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <h6 class="card-title mb-2">
                                    {{ $media->contenu->titre ?? 'Média sans titre' }}
                                </h6>

                                @if($media->description)
                                    <p class="card-text small text-muted mb-2">
                                        {{ \Illuminate\Support\Str::limit($media->description, 80) }}
                                    </p>
                                @endif

                                <div class="media-meta small text-muted">
                                    <div class="mb-1">
                                        <i class="fas fa-language"></i>
                                        {{ optional($media->contenu->langue)->nom_langue ?? 'Non spécifié' }}
                                    </div>
                                    <div class="mb-1">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ optional($media->contenu->region)->nom_region ?? 'Non spécifié' }}
                                    </div>
                                    <div class="mb-1">
                                        <i class="fas fa-calendar"></i>
                                        {{ $media->created_at->format('d/m/Y') }}
                                    </div>

                                    {{-- ✅ Métadonnées Cloudinary --}}
                                    @if($media->taille)
                                        <div class="mb-1">
                                            <i class="fas fa-hdd"></i>
                                            {{ number_format($media->taille / 1048576, 2) }} MB
                                        </div>
                                    @endif

                                    @if($media->largeur && $media->hauteur && ($isImage || $isVideo))
                                        <div>
                                            <i class="fas fa-expand-arrows-alt"></i>
                                            {{ $media->largeur }}x{{ $media->hauteur }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        @if($isCloudinary)
                                            <i class="fas fa-cloud text-success"></i>
                                            {{ strtoupper($media->format ?? pathinfo($media->chemin, PATHINFO_EXTENSION)) }}
                                        @else
                                            <i class="fas fa-file-signature"></i>
                                            {{ strtoupper($media->getExtension()) }}
                                        @endif
                                    </small>
                                    <a href="{{ route('media.detail', $media->id ??  '#') }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucun média disponible pour le moment.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('media.all') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-photo-video me-2"></i>
                    Voir tous les médias
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" aria-label="Statistiques de la plateforme">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number" aria-label="{{  $nbr_contenus ?? '0' }} contenus culturels">{{  $nbr_contenus?? '0' }}+</div>
                    <p>Contenus culturels</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number" aria-label="{{ $nbr_langues ?? '0' }} langues représentées">{{ $nbr_langues ?? '0' }}</div>
                    <p>Langues représentées</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number" aria-label="{{ $totalCommentaires ?? '0' }} commentaires">{{ $totalCommentaires ?? '0' }}+</div>
                    <p>Commentaires</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number" aria-label="{{ $totalUsers ?? '0' }} utilisateurs">{{ $totalUsers ?? '0' }}+</div>
                    <p>Utilisateurs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section id="contribuer" class="py-5">
        <div class="container text-center">
            <h2 class="section-title mx-auto">Participez à la préservation de notre patrimoine</h2>
            <p class="lead mb-4 mx-auto" style="max-width: 700px;">Rejoignez notre communauté de contributeurs et
                partagez vos connaissances sur la culture béninoise</p>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <a href="#devenir-contributeur" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus" aria-hidden="true"></i>
                    <span>Devenir contributeur</span>
                </a>
                <a href="#en-savoir-plus" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <span>En savoir plus</span>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Hero Carousel Styles - AVEC PRELOAD ET TRANSITION FLUIDE */
        .hero-carousel-section {
            position: relative;
            height: 75vh;
            min-height: 500px;
            overflow: hidden;
            background: #000;
            margin: 0;
            padding: 0;
        }
        #heroCarousel,
        .carousel-inner,
        .carousel-item,
        .hero-slide {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .hero-slide {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            position: relative;

            min-height: 100%;
            width: 100%;
        }

        /* Pseudo-élément pour l'overlay - évite l'interférence */
        .hero-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit; /* Hérite du background */
            z-index: 0;
        }

        .hero-slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        /* Overlays spécifiques pour chaque slide */
        .hero-slide.slide-1::after {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
        }


        .hero-slide. slide-3::after {
            background: linear-gradient(rgba(255, 107, 0, 0.7), rgba(204, 85, 0, 0.7));
        }

        . hero-slide.slide-4::after {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6));
        }

        .hero-content {
            text-align: center;
            color: white;
            animation: fadeInUp 1s ease-out;
            max-width: 800px;
            margin: 0 auto;
            padding: 1.5rem;
            position: relative;
            z-index: 2; /* Au-dessus de l'overlay */
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badge {
            display: inline-block;
            padding: 0.625rem 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-title {
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.25rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .hero-description {
            font-size: 1.125rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .hero-actions .btn {
            padding: 0.875rem 1.75rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-actions .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-item strong {
            font-size: 2.25rem;
            font-weight: 800;
            display: block;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-item span {
            font-size: 0.875rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-languages {
            display: flex;
            justify-content: center;
            gap: 0.875rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .language-tag {
            padding: 0.5rem 1.125rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-regions {
            display: flex;
            justify-content: center;
            gap: 0.875rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .region-chip {
            padding: 0.625rem 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            font-size: 0.9375rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Carousel Controls */
        .carousel-indicators {
            bottom: 20px;
            z-index: 15;
        }

        .carousel-indicators button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .carousel-indicators button.active {
            width: 35px;
            border-radius: 10px;
            background-color: white;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 45px;
            height: 45px;
            background-color: rgba(0, 135, 81, 0.8);
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 70px;
            z-index: 3; /* Au-dessus du contenu */
        }

        . carousel-control-prev:hover . carousel-control-prev-icon,
        .carousel-control-next:hover .carousel-control-next-icon {
            background-color: rgba(0, 135, 81, 1);
            transform: scale(1.1);
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            40% {
                transform: translateX(-50%) translateY(-10px);
            }
            60% {
                transform: translateX(-50%) translateY(-5px);
            }
        }

        .scroll-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            color: white;
            font-size: 1.375rem;
            border: 2px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .scroll-link:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(5px);
        }

        /* Carousel Fade Effect - AMÉLORÉ */
        .carousel-fade .carousel-item {
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: block; /* Important pour le preload */
        }

        . carousel-fade .carousel-item. active {
            opacity: 1;
        }

        /* Preload des images - empêche le flash */
        .carousel-item:not(.active) {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Content Cards Carousel */
        .content-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .content-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .card-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        . content-card:hover .card-img-wrapper img {
            transform: scale(1.1);
        }

        .badge-category {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 135, 81, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        #recentContentCarousel .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #008751;
            opacity: 0.5;
        }

        #recentContentCarousel .carousel-indicators button.active {
            opacity: 1;
        }

        /* Media Cards Styles */
        .media-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .media-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .media-card-header {
            position: relative;
            overflow: hidden;
            height: 180px;
        }

        .media-thumbnail {
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .media-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-thumbnail {
            background: #000;
        }

        .audio-thumbnail {
            background: linear-gradient(135deg, #FCD116, #e6b800);
        }

        .video-placeholder,
        .audio-placeholder,
        .file-placeholder {
            text-align: center;
            color: white;
        }

        .video-placeholder i,
        .audio-placeholder i,
        .file-placeholder i {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .media-type-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            z-index: 2;
        }

        .media-meta {
            font-size: 0.875rem;
        }

        .media-meta i {
            width: 20px;
            margin-right: 5px;
            text-align: center;
        }

        /* Video Player Styles */
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
            background: #000;
        }

        .media-card:hover .video-thumbnail-player {
            transform: scale(1.05);
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

        .media-card:hover .video-overlay {
            background: rgba(0, 0, 0, 0.5);
        }

        .play-btn {
            background: rgba(0, 135, 81, 0.8);
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: white;
            font-size: 2rem;
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

        /* Video Modal */
        .video-modal .modal-dialog {
            max-width: 800px;
        }

        .video-modal .modal-content {
            background: #000;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .video-modal .modal-header {
            background: rgba(0, 0, 0, 0.8);
            border-bottom: 1px solid #333;
            color: white;
        }

        .video-modal .modal-body {
            padding: 0;
        }

        .video-modal video {
            width: 100%;
            max-height: 500px;
            display: block;
        }

        .video-modal .modal-footer {
            background: rgba(0, 0, 0, 0.8);
            border-top: 1px solid #333;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-carousel-section {
                height: 65vh;
            }

            .hero-title {
                font-size: 2.25rem;
            }

            . hero-description {
                font-size: 1rem;
            }

            .hero-actions .btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9375rem;
            }

            . stat-item strong {
                font-size: 1.875rem;
            }
        }

        @media (max-width: 768px) {
            .hero-carousel-section {
                height: 60vh;
                min-height: 450px;
            }

            . hero-title {
                font-size: 1.875rem;
            }

            . hero-description {
                font-size: 0.9375rem;
            }

            .hero-stats {
                gap: 1.75rem;
            }

            . stat-item strong {
                font-size: 1.625rem;
            }

            .hero-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 50px;
            }

            #recentContentCarousel .carousel-item . row {
                flex-direction: column;
            }

            #recentContentCarousel .carousel-item .col-md-4 {
                display: none;
            }

            #recentContentCarousel .carousel-item .col-md-4:first-child {
                display: block;
            }
        }
        /* Ajoutez dans  */
        .cloudinary-badge {
            position: absolute;
            top: 40px;
            right: 10px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            z-index: 3;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
        }
    </style>


@endpush

@push('scripts')
    <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @auth
            // Gérer tous les boutons de paiement
            document.querySelectorAll('.btn-pay-content').forEach(button => {
                button.addEventListener('click', function () {
                    const contenuId = this.dataset.contenuId;
                    const contenuTitre = this.dataset.contenuTitre;

                    // ✅ Initialiser le widget selon la doc (Étape 4)
                    const widget = FedaPay.init({
                        public_key: '{{ config("services.fedapay.public_key") }}',
                        transaction: {
                            amount: 100, // ✅ Prix en FCFA
                            description: `Accès: ${contenuTitre}`
                        },
                        customer: {
                            email: '{{ auth()->user()->email }}',
                            firstname: '{{ auth()->user()->nom }}',
                            lastname: '{{ auth()->user()->prenom }}'
                        },
                        // ✅ Événements de callback
                        onComplete(resp) {
                            console.log('✅ Paiement complété', resp);

                            if (resp.reason === 'CHECKOUT COMPLETE') {
                                // ✅ Soumettre au backend
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '{{route('paiement.callback')}}';

                                // CSRF
                                const csrf = document.createElement('input');
                                csrf. type = 'hidden';
                                csrf.name = '_token';
                                csrf.value = '{{ csrf_token() }}';
                                form.appendChild(csrf);

                                // Transaction ID
                                const transactionInput = document.createElement('input');
                                transactionInput.type = 'hidden';
                                transactionInput.name = 'id';
                                transactionInput. value = resp.transaction.id;
                                form.appendChild(transactionInput);

                                // Contenu ID
                                const contenuInput = document.createElement('input');
                                contenuInput. type = 'hidden';
                                contenuInput.name = 'contenu_id';
                                contenuInput.value = contenuId;
                                form. appendChild(contenuInput);

                                document.body.appendChild(form);
                                form.submit();
                            }
                        },
                        onCanceled(resp) {
                            console. log('❌ Paiement annulé', resp);
                            alert('Paiement annulé');
                        },
                        onError(error) {
                            console.error('❌ Erreur', error);
                            alert('Erreur lors du paiement.  Réessayez.');
                        }
                    });

                    // ✅ Ouvrir le popup
                    widget.open();
                });
            });
            @endauth

            // Carousel
            const recentCarouselEl = document.getElementById('recentContentCarousel');
            if (recentCarouselEl) {
                const slidesCount = recentCarouselEl.querySelectorAll('.carousel-item').length;

                if (slidesCount <= 1) {
                    recentCarouselEl.removeAttribute('data-bs-ride');
                    const indicators = recentCarouselEl.querySelector('.carousel-indicators');
                    if (indicators) indicators.style.display = 'none';
                    const prev = recentCarouselEl. querySelector('.carousel-control-prev');
                    const next = recentCarouselEl.querySelector('.carousel-control-next');
                    if (prev) prev.style. display = 'none';
                    if (next) next.style.display = 'none';
                } else {
                    const recentCarousel = new bootstrap. Carousel(recentCarouselEl, {
                        interval: 5000,
                        ride: 'carousel',
                        pause: 'hover',
                        wrap: false,
                        touch: true
                    });

                    recentCarouselEl.addEventListener('mouseenter', () => recentCarousel.pause());
                    recentCarouselEl.addEventListener('mouseleave', () => recentCarousel.cycle());
                }
            }

            // Gérer les vidéos (ligne ~660 environ)
            document.querySelectorAll('.video-thumbnail-player').forEach(video => {
                // Calculer la durée seulement si pas déjà affichée (pas de $media->duree)
                const durationEl = video.closest('.video-player-wrapper').querySelector('.video-duration');

                if (durationEl && durationEl.textContent === '--:--') {
                    video.addEventListener('loadedmetadata', function() {
                        const duration = Math. floor(video.duration);
                        const minutes = Math.floor(duration / 60);
                        const seconds = duration % 60;
                        durationEl.textContent =
                            minutes.toString().padStart(2, '0') + ':' +
                            seconds.toString().padStart(2, '0');
                    });
                }

                // Lecture automatique au survol
                const thumbnailWrapper = video.closest('.media-thumbnail');
                if (thumbnailWrapper) {
                    thumbnailWrapper.addEventListener('mouseenter', function() {
                        video. play(). catch(e => console.log('Autoplay prevented:', e));
                    });
                    thumbnailWrapper.addEventListener('mouseleave', function() {
                        video.pause();
                        video.currentTime = 0;
                    });
                }
            });
        });

        // Fonction pour ouvrir la modal vidéo
        function openVideoModal(videoUrl, videoTitle) {
            const modalHtml = `
                <div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${videoTitle}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <video controls controlsList="nodownload" style="width:100%;">
                                    <source src="${videoUrl}" type="video/mp4">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                            </div>
                            <div class="modal-footer">
                                <a href="${videoUrl}" download class="btn btn-outline-light">
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

            // Ajouter la modal au DOM
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Initialiser et afficher la modal
            const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));

            // Détruire la modal après fermeture
            document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });

            // Afficher la modal
            videoModal.show();
        }
    </script>
    <script>
        // Solution ultra simple
        setTimeout(() => {
            document.querySelectorAll('#heroCarousel a').forEach(a => {
                a.onclick = (e) => {
                    if (a.href.includes('#')) {
                        e.preventDefault();
                        document.querySelector(a.hash)?.scrollIntoView({behavior: 'smooth'});
                    }
                };
            });
        }, 500);
    </script>
@endpush
