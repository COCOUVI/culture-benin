@extends('layouts.app1')

@section('title', 'Contenus Culturels - Culture Bénin')

@section('content')
    <!-- Hero Header Section -->
    <section class="hero-header">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-header__title">
                        <i class="fas fa-book-open me-3"></i>
                        Découvrez Notre Patrimoine Culturel
                    </h1>
                    <p class="hero-header__subtitle">
                        Explorez {{ $contents->total() }} contenus authentiques sur la richesse culturelle du Bénin
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters & Search Section -->
    <section class="filters-section">
        <div class="container">
            <div class="filters-card">
                <form method="GET" action="{{ route('contenus.all') }}" class="filters-form">
                    <div class="row g-3 align-items-end">
                        <!-- Search -->
                        <div class="col-lg-4 col-md-6">
                            <label for="search" class="form-label">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </label>
                            <input
                                type="text"
                                name="q"
                                id="search"
                                value="{{ request('q') }}"
                                class="form-control"
                                placeholder="Titre, description..."
                            >
                        </div>

                        <!-- Language Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="langue" class="form-label">
                                <i class="fas fa-language me-2"></i>Langue
                            </label>
                            <select name="langue_id" id="langue" class="form-select">
                                <option value="">Toutes les langues</option>
                                @foreach($langues as $langue)
                                    <option value="{{ $langue->id }}" {{ request('langue_id') == $langue->id ?  'selected' : '' }}>
                                        {{ $langue->nom_langue }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Region Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="region" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Région
                            </label>
                            <select name="region_id" id="region" class="form-select">
                                <option value="">Toutes les régions</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->nom_region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="col-lg-2 col-md-6">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filtrer
                            </button>
                        </div>
                    </div>

                    @if(request()->hasAny(['q', 'langue_id', 'region_id']))
                        <div class="mt-3">
                            <a href="{{ route('contenus.all') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Réinitialiser les filtres
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </section>

    <!-- Content Grid Section -->
    <section class="content-grid-section">
        <div class="container">
            <!-- Results Info -->
            <div class="results-info mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h2 class="results-info__title">
                        <span class="results-count">{{ $contents->total() }}</span>
                        {{ Str::plural('contenu', $contents->total()) }}
                        {{ request('q') ? 'trouvé(s)' : 'disponible(s)' }}
                    </h2>

                    <div class="results-info__pagination">
                        Page {{ $contents->currentPage() }} sur {{ $contents->lastPage() }}
                    </div>
                </div>
            </div>

            <!-- Content Cards Grid -->
            @if($contents->isEmpty())
                <div class="empty-state">
                    <div class="empty-state__icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-state__title">Aucun contenu trouvé</h3>
                    <p class="empty-state__text">
                        Essayez de modifier vos critères de recherche ou
                        <a href="{{ route('contenus.all') }}">explorez tous les contenus</a>
                    </p>
                </div>
            @else
                <div class="row g-4 content-grid">
                    @foreach($contents as $contenu)
                        <div class="col-lg-4 col-md-6">
                            <article class="content-card">
                                <!-- Card Image -->
                                <div class="content-card__image">
                                    @php
                                        $media = optional($contenu->media->first())->chemin;
                                        $imgSrc = $media ? asset("storage/{$media}") : "https://images.unsplash.com/photo-1569165003085-e8a1066f1cb8?w=600&h=400&fit=crop";
                                    @endphp
                                    <img src="{{ $imgSrc }}" alt="{{ $contenu->titre ??  'Contenu culturel' }}">

                                    <!-- Category Badge -->
                                    <div class="content-card__category">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ optional($contenu->type_contenu)->nom ??  'Contenu' }}
                                    </div>

                                    <!-- Favorite Button -->
                                    <button class="content-card__favorite" aria-label="Ajouter aux favoris">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>

                                <!-- Card Body -->
                                <div class="content-card__body">
                                    <!-- Meta Info -->
                                    <div class="content-card__meta">
                                        <span class="badge-langue">
                                            <i class="fas fa-language me-1"></i>
                                            {{ optional($contenu->langue)->nom_langue ?? '—' }}
                                        </span>
                                        <span class="content-card__date">
                                            <i class="far fa-clock me-1"></i>
                                            {{ optional($contenu->created_at)->diffForHumans() ??  '' }}
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="content-card__title">
                                        <a href="{{ route('contenu.detail', $contenu->id) }}">
                                            {{ $contenu->titre ?? 'Sans titre' }}
                                        </a>
                                    </h3>

                                    <!-- Excerpt -->
                                    <p class="content-card__excerpt">
                                        {{ \Illuminate\Support\Str::limit($contenu->texte ??  'Aucune description disponible. ', 140) }}
                                    </p>

                                    <!-- Footer -->
                                    <div class="content-card__footer">
                                        <div class="content-card__location">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ optional($contenu->region)->nom_region ?? '—' }}
                                        </div>

                                        {{-- Boutons conditionnels avec paiement --}}
                                        @auth
                                            @if(auth()->user()->isAdmin() || auth()->user()->aPaye($contenu))
                                                <a href="{{ route('contenu.detail', $contenu->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-book-open me-1"></i>Lire
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-sm btn-warning btn-pay-content"
                                                        data-contenu-id="{{ $contenu->id }}"
                                                        data-contenu-titre="{{ addslashes($contenu->titre) }}">
                                                    <i class="fas fa-lock me-1"></i>Payer 100 F
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-sign-in-alt me-1"></i>Se connecter
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $contents->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h2 class="cta-card__title">
                            <i class="fas fa-plus-circle me-3"></i>
                            Contribuez à notre patrimoine
                        </h2>
                        <p class="cta-card__text">
                            Partagez vos connaissances et participez à la préservation de notre culture
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('contenus.create') }}" class="btn btn-cta">
                            <i class="fas fa-pen me-2"></i>
                            Créer un contenu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* ========================================
           VARIABLES & BASE
        ======================================== */
        :root {
            --benin-green: #008751;
            --benin-green-dark: #006b40;
            --benin-yellow: #FCD116;
            --benin-red: #E8112D;

            --color-text: #1a202c;
            --color-text-light: #4a5568;
            --color-border: #e2e8f0;
            --color-bg-light: #f7fafc;
            --color-white: #ffffff;

            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);

            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ========================================
           HERO HEADER - CONSERVÉ
        ======================================== */
        .hero-header {
            background: linear-gradient(135deg, var(--benin-green) 0%, var(--benin-green-dark) 100%);
            padding: 5rem 0 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0. 05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }

        .hero-header__title {
            color: var(--color-white);
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .hero-header__subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: clamp(1rem, 2vw, 1.25rem);
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }

        /* ========================================
           FILTERS SECTION
        ======================================== */
        .filters-section {
            padding: 2rem 0;
            background: var(--color-bg-light);
            margin-top: -2rem;
            position: relative;
            z-index: 10;
        }

        .filters-card {
            background: var(--color-white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--color-border);
        }

        .filters-form . form-label {
            font-weight: 600;
            color: var(--color-text);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .filters-form . form-control,
        .filters-form .form-select {
            border: 2px solid var(--color-border);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            transition: var(--transition);
        }

        .filters-form .form-control:focus,
        .filters-form . form-select:focus {
            border-color: var(--benin-green);
            box-shadow: 0 0 0 4px rgba(0, 135, 81, 0.1);
        }

        .filters-form .btn-primary {
            background: linear-gradient(135deg, var(--benin-green), var(--benin-green-dark));
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        . filters-form .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* ========================================
           CONTENT GRID SECTION
        ======================================== */
        .content-grid-section {
            padding: 3rem 0 4rem;
        }

        . results-info {
            padding: 1.5rem;
            background: var(--color-bg-light);
            border-radius: 12px;
            border-left: 4px solid var(--benin-green);
        }

        .results-info__title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-text);
            margin: 0;
        }

        .results-count {
            color: var(--benin-green);
            font-weight: 800;
        }

        .results-info__pagination {
            color: var(--color-text-light);
            font-size: 0.9375rem;
            font-weight: 600;
        }

        /* ========================================
           CONTENT CARD
        ======================================== */
        .content-card {
            background: var(--color-white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--color-border);
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--benin-green);
        }

        .content-card__image {
            position: relative;
            height: 240px;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .content-card__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .content-card:hover .content-card__image img {
            transform: scale(1.1);
        }

        .content-card__category {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(0, 135, 81, 0.95);
            color: var(--color-white);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .content-card__favorite {
            position: absolute;
            top: 16px;
            left: 16px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .content-card__favorite:hover {
            background: var(--benin-red);
            color: var(--color-white);
            transform: scale(1.1);
        }

        . content-card__favorite i {
            font-size: 1.125rem;
        }

        .content-card__body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .content-card__meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        /* Badge Langue - Couleur complète avec texte clair */
        .badge-langue {
            background: var(--benin-yellow);
            color: #1a1a1a;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(252, 209, 22, 0.3);
        }

        .badge-langue i {
            color: #1a1a1a;
        }

        .content-card__date {
            color: var(--color-text-light);
            font-size: 0.8125rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .content-card__title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .content-card__title a {
            color: var(--color-text);
            text-decoration: none;
            transition: var(--transition);
        }

        .content-card__title a:hover {
            color: var(--benin-green);
        }

        .content-card__excerpt {
            color: var(--color-text-light);
            font-size: 0.9375rem;
            line-height: 1.7;
            margin-bottom: 1.25rem;
            flex: 1;
        }

        .content-card__footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--color-border);
            gap: 1rem;
        }

        .content-card__location {
            color: var(--color-text-light);
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .content-card__location i {
            color: var(--benin-green);
        }

        /* Bouton "Lire plus" - Simple */
        .btn-read-more {
            color: var(--benin-green);
            font-weight: 700;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-read-more:hover {
            color: var(--benin-green-dark);
            text-decoration: underline;
        }

        /* ========================================
           EMPTY STATE
        ======================================== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--color-bg-light);
            border-radius: 16px;
            border: 2px dashed var(--color-border);
        }

        .empty-state__icon {
            font-size: 4rem;
            color: var(--color-text-light);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state__title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 0.75rem;
        }

        . empty-state__text {
            color: var(--color-text-light);
            font-size: 1.0625rem;
        }

        .empty-state__text a {
            color: var(--benin-green);
            font-weight: 600;
            text-decoration: none;
        }

        .empty-state__text a:hover {
            text-decoration: underline;
        }

        /* ========================================
           PAGINATION
        ======================================== */
        .pagination-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper . pagination {
            gap: 0.5rem;
        }

        .pagination-wrapper . page-link {
            border: 2px solid var(--color-border);
            border-radius: 10px;
            color: var(--color-text);
            font-weight: 600;
            padding: 0.75rem 1.125rem;
            transition: var(--transition);
        }

        .pagination-wrapper .page-link:hover {
            background: var(--benin-green);
            border-color: var(--benin-green);
            color: var(--color-white);
            transform: translateY(-2px);
        }

        . pagination-wrapper .page-item.active .page-link {
            background: var(--benin-green);
            border-color: var(--benin-green);
            box-shadow: 0 4px 12px rgba(0, 135, 81, 0.3);
        }

        .pagination-wrapper .page-item.disabled .page-link {
            opacity: 0.5;
        }

        /* ========================================
           CTA SECTION
        ======================================== */
        .cta-section {
            padding: 3rem 0;
            background: var(--color-bg-light);
        }

        .cta-card {
            background: linear-gradient(135deg, var(--benin-green), var(--benin-green-dark));
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: var(--benin-yellow);
            opacity: 0.1;
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        . cta-card__title {
            color: var(--color-white);
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            position: relative;
        }

        .cta-card__text {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.125rem;
            margin-bottom: 0;
            position: relative;
        }

        .btn-cta {
            background: var(--color-white);
            color: var(--benin-green);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.0625rem;
            border: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            transition: var(--transition);
            position: relative;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            color: var(--benin-green-dark);
        }

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 992px) {
            .hero-header {
                padding: 4rem 0 2rem;
            }

            .filters-card {
                padding: 1.5rem;
            }

            .content-card__image {
                height: 200px;
            }
        }

        @media (max-width: 768px) {
            .hero-header {
                padding: 3rem 0 1.5rem;
            }

            .filters-section {
                margin-top: 0;
            }

            .filters-card {
                padding: 1.25rem;
            }

            . results-info {
                flex-direction: column;
                text-align: center;
            }

            .results-info__title {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .content-card__image {
                height: 220px;
            }

            .cta-card {
                padding: 2rem 1.5rem;
                text-align: center;
            }

            .cta-card__title {
                font-size: 1.5rem;
            }

            .btn-cta {
                width: 100%;
                margin-top: 1rem;
            }
        }

        /* ✅ AJOUT : Styles pour les boutons de paiement */
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #008751, #006b40);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 135, 81, 0.3);
        }

        .btn-warning {
            background: #FCD116;
            border-color: #e6b800;
            color: #1a1a1a;
        }

        .btn-warning:hover {
            background: #e6b800;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(252, 209, 22, 0.4);
            color: #1a1a1a;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }
    </style>
@endpush

@push('scripts')
    {{-- ✅ Script FedaPay pour le paiement --}}
    <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @auth
            // Gérer tous les boutons de paiement
            document.querySelectorAll('.btn-pay-content').forEach(button => {
                button.addEventListener('click', function () {
                    const contenuId = this.dataset.contenuId;
                    const contenuTitre = this.dataset.contenuTitre;

                    // Initialiser le widget FedaPay
                    const widget = FedaPay.init({
                        public_key: '{{ config("services.fedapay.public_key") }}',
                        transaction: {
                            amount: 100,
                            description: `Accès: ${contenuTitre}`
                        },
                        customer: {
                            email: '{{ auth()->user()->email }}',
                            firstname: '{{ auth()->user()->nom }}',
                            lastname: '{{ auth()->user()->prenom }}'
                        },
                        onComplete(resp) {
                            console.log('✅ Paiement complété', resp);

                            if (resp.reason === 'CHECKOUT COMPLETE') {
                                // Soumettre au backend
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '{{ route('paiement.callback') }}';

                                // CSRF
                                const csrf = document.createElement('input');
                                csrf.type = 'hidden';
                                csrf.name = '_token';
                                csrf.value = '{{ csrf_token() }}';
                                form.appendChild(csrf);

                                // Transaction ID
                                const transactionInput = document.createElement('input');
                                transactionInput.type = 'hidden';
                                transactionInput.name = 'id';
                                transactionInput.value = resp.transaction.id;
                                form.appendChild(transactionInput);

                                // Contenu ID
                                const contenuInput = document.createElement('input');
                                contenuInput.type = 'hidden';
                                contenuInput.name = 'contenu_id';
                                contenuInput.value = contenuId;
                                form.appendChild(contenuInput);

                                document.body.appendChild(form);
                                form.submit();
                            }
                        },
                        onCanceled(resp) {
                            console.log('❌ Paiement annulé', resp);
                            alert('Paiement annulé');
                        },
                        onError(error) {
                            console.error('❌ Erreur', error);
                            alert('Erreur lors du paiement.  Réessayez.');
                        }
                    });

                    // Ouvrir le popup
                    widget.open();
                });
            });
            @endauth

            // Favorite button interaction
            document.querySelectorAll('.content-card__favorite').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const icon = this.querySelector('i');
                    icon.classList.toggle('far');
                    icon.classList.toggle('fas');
                });
            });

            // Smooth scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({behavior: 'smooth', block: 'start'});
                    }
                });
            });
        });
    </script>
@endpush
