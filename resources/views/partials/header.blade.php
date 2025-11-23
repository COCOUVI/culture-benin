<nav class="app-header navbar navbar-expand" style="background: #0b3d2e; color: #fff;">
    <div class="container-fluid">

        <!-- Menu burger + Logo -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list fs-4"></i>
                </a>
            </li>

            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link text-white fw-bold">
                    <i class="bi bi-house-door me-1"></i> Accueil Culturel
                </a>
            </li>

            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-geo-alt me-1 text-warning"></i> Sites Culturels
                </a>
            </li>
        </ul>

        <!-- Éléments de droite -->
        <ul class="navbar-nav ms-auto">

            <!-- Search -->
            <li class="nav-item">
                <a class="nav-link text-white" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- Messages : Ex : nouveaux commentaires sur un contenu culturel -->
            <li class="nav-item dropdown">
                <a class="nav-link text-white" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-chat-text"></i>
                    <span class="navbar-badge badge text-bg-danger">3</span>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">

                    <span class="dropdown-item dropdown-header bg-success text-white">
                        Nouveaux Messages & Avis
                    </span>

                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <img src="{{asset('adminlte/img/user1-128x128.jpg')}}"
                                 class="img-size-50 rounded-circle me-3" alt="">
                            <div>
                                <h6 class="dropdown-item-title text-success fw-bold">
                                    Aïcha HOUENOU
                                </h6>
                                <p class="fs-7">“Superbe exposition sur l’art Gèlèdé !”</p>
                                <p class="fs-7 text-secondary"><i class="bi bi-clock"></i> Il y a 2h</p>
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item dropdown-footer text-center text-success fw-bold">
                        Voir tous les messages
                    </a>
                </div>
            </li>

            <!-- Notifications : ex : nouveaux contenus ajoutés -->
            <li class="nav-item dropdown">
                <a class="nav-link text-white" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">5</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header bg-warning text-dark fw-bold">
                        Notifications Culturelles
                    </span>

                    <a href="#" class="dropdown-item">
                        <i class="bi bi-image me-2"></i> Nouveau média ajouté
                        <span class="float-end text-secondary fs-7">15 min</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item">
                        <i class="bi bi-people-fill me-2"></i> Nouvel artisan inscrit
                        <span class="float-end text-secondary fs-7">1 h</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="#" class="dropdown-item dropdown-footer text-center text-warning fw-bold">
                        Voir toutes les notifications
                    </a>
                </div>
            </li>

          

            <!-- User -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                    <img src="{{asset('adminlte/img/user2-160x160.jpg')}}"
                         class="user-image rounded-circle shadow" alt="">
                    <span class="d-none d-md-inline fw-bold">Agent Culturel</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-success">
                        <img src="{{asset('adminlte/img/user2-160x160.jpg')}}"
                             class="rounded-circle shadow" alt="">
                        <p>
                            Agent Culturel — Ministère du Tourisme & Culture
                            <small>Membre depuis 2024</small>
                        </p>
                    </li>

                    <li class="user-body text-center">
                        <a href="#" class="btn btn-outline-success btn-sm">Profil</a>
                        <a href="#" class="btn btn-outline-danger btn-sm float-end">Déconnexion</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>
