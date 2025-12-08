@extends('layout')

@section('title')
    Page de modification de profil
@endsection

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- En-tête de la page -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-2 text-gray-800">
                            <i class="bi bi-person-circle me-2 text-primary"></i>
                            Mon Profil
                        </h1>
                        <p class="text-muted mb-0">Gérez vos informations personnelles et votre sécurité</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Carte d'informations utilisateur -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center p-4">
                        <div class="avatar-wrapper mb-3 position-relative">
                            @if(auth()->user()->photo)
                                <img src="{{auth()->user()->photo}}"
                                     alt="Photo de profil"
                                     class="avatar-image rounded-circle mx-auto d-block"
                                     style="width: 120px; height: 120px; object-fit: cover; box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);">
                            @else
                                <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 120px; height: 120px; border-radius: 50%; font-size: 48px;">
                                    {{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <h5 class="mb-1">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h5>
                        <p class="text-muted mb-2">{{ auth()->user()->email }}</p>

                        @if(auth()->user()->sexe)
                            <span class="badge bg-{{ auth()->user()->sexe === 'masculin' ? 'info' : 'danger' }}-subtle text-{{ auth()->user()->sexe === 'masculin' ? 'info' : 'danger' }} me-2 fs-5 ">
                            <i class="bi bi-gender-{{ auth()->user()->sexe === 'masculin' ? 'male' : 'female' }} me-1"></i>
                            {{ auth()->user()->sexe === 'masculin' ? 'Homme' : 'Femme' }}
                        </span>
                        @endif

                        <div class="badge bg-primary-subtle text-primary px-3 py-2 fs-5 ">
                            <i class="bi bi-shield-check me-1"></i>
                            {{ auth()->user()->role->nom ??  'Utilisateur' }}
                        </div>

                        <hr class="my-4">

                        <div class="text-start">
                            @if(auth()->user()->date_naissance)
                                <p class="text-muted mb-2 small">
                                    <i class="bi bi-cake2 me-2 text-primary"></i>
                                    <strong>Date de naissance :</strong>
                                    <br>
                                    <span class="ms-4">{{ \Carbon\Carbon::parse(auth()->user()->date_naissance)->format('d/m/Y') }}</span>
                                    <span class="badge bg-light text-dark ms-2">{{ \Carbon\Carbon::parse(auth()->user()->date_naissance)->age }} ans</span>
                                </p>
                            @endif

                            @if(auth()->user()->langue)
                                <p class="text-muted mb-2 small">
                                    <i class="bi bi-translate me-2 text-primary"></i>
                                    <strong>Langue :</strong>
                                    <br>
                                    <span class="ms-4">{{ auth()->user()->langue->nom_langue }}</span>
                                </p>
                            @endif

                            <p class="text-muted mb-2 small">
                                <i class="bi bi-calendar-plus me-2 text-primary"></i>
                                <strong>Membre depuis :</strong>
                                <br>
                                <span class="ms-4">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                            </p>
                            <p class="text-muted mb-0 small">
                                <i class="bi bi-clock-history me-2 text-primary"></i>
                                <strong>Dernière modification :</strong>
                                <br>
                                <span class="ms-4">{{ auth()->user()->updated_at->format('d/m/Y à H:i') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaires de modification -->
            <div class="col-lg-8">
                <!-- Informations personnelles -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 text-primary fw-bold">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Informations Personnelles
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <!-- Photo de profil -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="photo" class="form-label fw-semibold">
                                        <i class="bi bi-camera-fill me-2 text-primary"></i>
                                        Photo de profil
                                    </label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="preview-wrapper">
                                            @if(auth()->user()->photo)
                                                <img src="{{ auth()->user()->photo}}"
                                                     alt="Photo actuelle"
                                                     id="photo-preview"
                                                     class="rounded-circle"
                                                     style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #1976d2;">
                                            @else
                                                <div id="photo-preview" class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle"
                                                     style="width: 80px; height: 80px; font-size: 24px; border: 3px solid #6c757d;">
                                                    {{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input
                                                type="file"
                                                class="form-control @error('photo') is-invalid @enderror"
                                                id="photo"
                                                name="photo"
                                                accept="image/*"
                                                onchange="previewPhoto(event)"
                                            >
                                            <small class="text-muted">JPG, PNG ou GIF (Max.  2MB)</small>
                                            @error('photo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label fw-semibold">
                                        Nom <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-primary"></i>
                                    </span>
                                        <input
                                            type="text"
                                            class="form-control border-start-0 @error('nom') is-invalid @enderror"
                                            id="nom"
                                            name="nom"
                                            value="{{ old('nom', auth()->user()->nom) }}"
                                            required
                                            placeholder="Votre nom"
                                        >
                                        @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="prenom" class="form-label fw-semibold">
                                        Prénom <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-primary"></i>
                                    </span>
                                        <input
                                            type="text"
                                            class="form-control border-start-0 @error('prenom') is-invalid @enderror"
                                            id="prenom"
                                            name="prenom"
                                            value="{{ old('prenom', auth()->user()->prenom) }}"
                                            required
                                            placeholder="Votre prénom"
                                        >
                                        @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>
                                        <input
                                            type="email"
                                            class="form-control border-start-0 @error('email') is-invalid @enderror"
                                            id="email"
                                            name="email"
                                            value="{{ old('email', auth()->user()->email) }}"
                                            required
                                            placeholder="votre. email@exemple.com"
                                        >
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sexe" class="form-label fw-semibold">
                                        Sexe <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-gender-ambiguous text-primary"></i>
                                    </span>
                                        <select
                                            class="form-select border-start-0 @error('sexe') is-invalid @enderror"
                                            id="sexe"
                                            name="sexe"
                                            required
                                        >
                                            <option value="">Sélectionner... </option>
                                            <option value="masculin" {{ old('sexe', auth()->user()->sexe) === 'masculin' ? 'selected' : '' }}>
                                                Homme
                                            </option>
                                            <option value="feminin" {{ old('sexe', auth()->user()->sexe) === 'feminin' ? 'selected' : '' }}>
                                                Femme
                                            </option>
                                        </select>
                                        @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="date_naissance" class="form-label fw-semibold">
                                        Date de naissance <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-calendar-date text-primary"></i>
                                    </span>
                                        <input
                                            type="date"
                                            class="form-control border-start-0 @error('date_naissance') is-invalid @enderror"
                                            id="date_naissance"
                                            name="date_naissance"
                                            value="{{ old('date_naissance', optional($user->date_naissance)->format('Y-m-d') ) }}"
                                            required
                                            max="{{ date('Y-m-d') }}"
                                        >
                                        @error('date_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="id_langue" class="form-label fw-semibold">
                                        Langue préférée <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-translate text-primary"></i>
                                    </span>
                                        <select
                                            class="form-select border-start-0 @error('id_langue') is-invalid @enderror"
                                            id="id_langue"
                                            name="id_langue"
                                            required
                                        >
                                            <option value="">Sélectionner une langue... </option>
                                            @foreach($langues as $langue)
                                                <option value="{{ $langue->id }}" {{ old('id_langue', auth()->user()->id_langue) == $langue->id ? 'selected' : '' }}>
                                                    {{ $langue->nom_langue }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Cette langue sera utilisée pour l'interface</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modifier le mot de passe -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 text-primary fw-bold">
                            <i class="bi bi-shield-lock me-2"></i>
                            Sécurité du Compte
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('profile.updatePassword')}}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                                <div class="small">
                                    Pour des raisons de sécurité, vous devez saisir votre mot de passe actuel avant d'en définir un nouveau.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">
                                    Mot de passe actuel <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-primary"></i>
                                </span>
                                    <input
                                        type="password"
                                        class="form-control border-start-0 border-end-0 @error('current_password') is-invalid @enderror"
                                        id="current_password"
                                        name="current_password"
                                        required
                                        placeholder="••••••••"
                                    >
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('current_password')">
                                        <i class="bi bi-eye" id="current_password-icon"></i>
                                    </button>
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    Nouveau mot de passe <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key text-primary"></i>
                                </span>
                                    <input
                                        type="password"
                                        class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        required
                                        placeholder="••••••••"
                                        minlength="8"
                                    >
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password')">
                                        <i class="bi bi-eye" id="password-icon"></i>
                                    </button>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Le mot de passe doit contenir au moins 8 caractères</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    Confirmer le nouveau mot de passe <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key-fill text-primary"></i>
                                </span>
                                    <input
                                        type="password"
                                        class="form-control border-start-0 border-end-0"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        required
                                        placeholder="••••••••"
                                        minlength="8"
                                    >
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-warning px-4">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Modifier le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        . card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0. 5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .input-group-text {
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
        }

        . input-group:focus-within .input-group-text {
            border-color: #1976d2;
            background-color: #e3f2fd ! important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0. 4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 167, 38, 0.4);
            color: white;
        }

        . avatar-circle,
        .avatar-image {
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
            transition: all 0.3s ease;
        }

        .avatar-circle:hover,
        .avatar-image:hover {
            transform: scale(1.05);
        }

        .bg-primary-subtle {
            background-color: #e3f2fd !important;
        }

        .bg-info-subtle {
            background-color: #d1ecf1 !important;
        }

        .bg-danger-subtle {
            background-color: #f8d7da !important;
        }

        #photo-preview {
            transition: all 0.3s ease;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Preview photo before upload
        function previewPhoto(event) {
            const file = event.target. files[0];
            const preview = document.getElementById('photo-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Si c'est une div (initiales), la remplacer par une image
                    if (preview.tagName === 'DIV') {
                        const img = document.createElement('img');
                        img.id = 'photo-preview';
                        img.className = 'rounded-circle';
                        img.style.cssText = 'width: 80px; height: 80px; object-fit: cover; border: 3px solid #1976d2;';
                        img.src = e.target.result;
                        preview.parentNode.replaceChild(img, preview);
                    } else {
                        preview.src = e.target.result;
                    }
                };
                reader. readAsDataURL(file);
            }
        }

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field. type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon. classList.add('bi-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#10b981',  // 🟢 Vert moderne (Tailwind green-500)
                color: '#fff',
                iconColor: '#fff'
            });
            @endif

            @if(session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#ef4444',
                color: '#fff',
                iconColor: '#fff'
            });
            @endif
        });
    </script>
@endpush
