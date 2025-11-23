<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{ asset('adminlte/img/benin.png') }}"
                alt="Logo"
                class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">CULTURE BENIN</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
            >
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Users -->
                <li class="nav-item {{ request()->routeIs('users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Users
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <!-- CREATE -->
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}"
                               class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>

                        <!-- INDEX -->
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                               class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <!-- Type Media -->
                <li class="nav-item {{ request()->routeIs('type_media.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-collection-fill"></i>
                        <p>
                            Type Media
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('type_media.create')}}"
                               class="nav-link  {{ request()->routeIs('type_media.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('type_media.index')}}"
                               class="nav-link {{ request()->routeIs('type_media.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Type Contenu -->
                <li class="nav-item {{ request()->routeIs('type_contenu.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-folder-fill"></i>
                        <p>
                            Type Contenu
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('type_contenu.create') }}"
                               class="nav-link {{ request()->routeIs('type_contenu.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('type_contenu.index') }}"
                               class="nav-link {{ request()->routeIs('type_contenu.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Media -->
                <li class="nav-item  {{ request()->routeIs('medias.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-camera-video-fill"></i>
                        <p>
                            Media
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{route('medias.create')}}" class="nav-link {{ request()->routeIs('medias.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('medias.index')}}" class="nav-link {{ request()->routeIs('medias.index') ? 'active' : '' }}">
                                <i class="nav-icon  bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Contenu -->
                <li class="nav-item {{ request()->routeIs('contenus.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text-fill"></i>
                        <p>
                            Contenu
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('contenus.create')}}" class="nav-link {{ request()->routeIs('contenus.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('contenus.index')}}" class="nav-link {{ request()->routeIs('contenus.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Langues -->
                <li class="nav-item {{ request()->routeIs('langues.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-translate"></i>
                        <p>
                            Langues
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item ">
                            <a href="{{ route('langues.create') }}"
                               class="nav-link {{ request()->routeIs('langues.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle "></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('langues.index') }}"
                               class="nav-link  {{ request()->routeIs('langues.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Région -->
                <li class="nav-item {{ request()->routeIs('regions.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-geo-alt-fill"></i>
                        <p>
                            Région
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('regions.create')}}" class="nav-link {{ request()->routeIs('regions.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('regions.index')}}" class="nav-link {{ request()->routeIs('regions.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Commentaire -->
                <li class="nav-item {{ request()->routeIs('commentaires.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-chat-left-text-fill"></i>
                        <p>
                            Commentaire
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('commentaires.create')}}" class="nav-link {{ request()->routeIs('commentaires.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('commentaires.index')}}" class="nav-link {{ request()->routeIs('commentaires.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Role -->
                <li class="nav-item {{ request()->routeIs('roles.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shield-fill-check"></i>
                        <p>
                            Rôle
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('roles.create')}}"
                               class="nav-link  {{ request()->routeIs('roles.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Créer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}"
                               class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Liste</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Section séparateur -->


                <!-- Profil -->


                <!-- Déconnexion -->

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
