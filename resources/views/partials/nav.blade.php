<nav class="navbar navbar-expand-lg navbar-dark sticky-top" role="navigation" aria-label="Navigation principale">
    <div class="container">
        <a class="navbar-brand" href="{{ route('accueil') }}" aria-label="Culture Bénin - Accueil">
            <!-- Logo CBJ avec masque africain -->
            <div class="logo-wrapper">
                <img src="{{ asset('img/logo1.png') }}" alt="Logo Culture Bénin" class="navbar-logo">
            </div>
            <div class="brand-text">
                <span class="brand-name">Culture Bénin</span>
                <span class="brand-tagline">Patrimoine & Traditions</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}"
                       href="{{ route('accueil') }}"
                       aria-current="{{ request()->routeIs('accueil') ? 'page' : 'false' }}">
                       Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contes">Contes & Histoires</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#cuisine">Cuisine</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#traditions">Traditions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#medias">Medias</a>
                </li>
            </ul>
            <div class="d-flex align-items-center flex-wrap gap-2">
                @auth
                    <span class="navbar-text text-light me-3 d-none d-sm-block">
                        <i class="fas fa-user-circle me-1"></i>
                        Bonjour, {{ Auth::user()->nom }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<style>
/* Logo CBJ - Taille augmentée */
.navbar-brand {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0. 5rem 0;
}

. logo-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
}

.navbar-logo {
    height: 70px;  /* Augmenté de 50px à 70px */
    width: auto;   /* Auto pour garder les proportions */
    display: block;
    filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0. 25));
}

/* Texte de marque */
.brand-text {
    display: flex;
    flex-direction: column;
    gap: 0. 15rem;
}

.brand-name {
    font-weight: 700;
    font-size: 1.4rem;
    letter-spacing: 0.3px;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    line-height: 1.2;
}

. brand-tagline {
    font-size: 0.75rem;
    font-weight: 500;
    color: rgba(255, 215, 0, 0.95);
    text-transform: uppercase;
    letter-spacing: 1.2px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

/* Responsive Desktop Large */
@media (min-width: 1200px) {
    .navbar-logo {
        height: 75px;  /* Encore plus grand sur grands écrans */
    }

    .brand-name {
        font-size: 1. 5rem;
    }

    .brand-tagline {
        font-size: 0.8rem;
    }
}

/* Responsive Tablet */
@media (max-width: 992px) {
    .navbar-logo {
        height: 65px;
    }

    .brand-name {
        font-size: 1.3rem;
    }

    .brand-tagline {
        font-size: 0. 7rem;
    }
}

/* Responsive Mobile Large */
@media (max-width: 768px) {
    .navbar-brand {
        gap: 0.85rem;
    }

    .navbar-logo {
        height: 58px;
    }

    .brand-name {
        font-size: 1.2rem;
    }

    .brand-tagline {
        font-size: 0. 65rem;
    }
}

/* Responsive Mobile */
@media (max-width: 576px) {
    .navbar-brand {
        gap: 0. 75rem;
    }

    .navbar-logo {
        height: 52px;
    }

    .brand-name {
        font-size: 1. 1rem;
    }

    .brand-tagline {
        display: none;
    }
}

/* Responsive Mobile Small */
@media (max-width: 400px) {
    .navbar-logo {
        height: 48px;
    }

    .brand-name {
        font-size: 1rem;
    }
}
</style>
