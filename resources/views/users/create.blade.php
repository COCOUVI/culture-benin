@extends('layout')

@section('title')
    Ajout des Utilisateurs
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm custom-card mx-auto" style="max-width: 700px;">
            <!-- Header -->
            <div class="card-header text-white custom-card-header d-flex align-items-center">
                <i class="bi bi-person-plus-fill me-2"></i>
                <h4 class="mb-0">Ajouter un Utilisateur</h4>
            </div>

            <!-- Formulaire -->
            <div class="card-body p-4">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nom / Prénom -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label fw-semibold"><i class="bi bi-person"></i> Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" placeholder="Ex: Coco" value="{{ old('nom') }}">
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label fw-semibold"><i class="bi bi-person"></i> Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" placeholder="Ex: Alexandro" value="{{ old('prenom') }}">
                            @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold"><i class="bi bi-envelope"></i> Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="exemple@email.com" value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Date de naissance / Sexe -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_naissance" class="form-label fw-semibold"><i class="bi bi-calendar"></i> Date de naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}">
                            @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sexe" class="form-label fw-semibold"><i class="bi bi-gender-ambiguous"></i> Sexe</label>
                            <select name="sexe" id="sexe" class="form-select @error('sexe') is-invalid @enderror">
                                <option value="">-- Sélectionner le sexe --</option>
                                <option value="masculin" {{ old('sexe') == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                <option value="feminin" {{ old('sexe') == 'feminin' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Photo -->
                    <div class="mb-3">
                        <label for="photo" class="form-label fw-semibold"><i class="bi bi-card-image"></i> Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror">
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Rôle / Langue -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_role" class="form-label fw-semibold"><i class="bi bi-shield-fill-check"></i> Rôle</label>
                            <select name="id_role" id="id_role" class="form-select @error('id_role') is-invalid @enderror">
                                <option value="">-- Sélectionner un rôle --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('id_role') == $role->id ? 'selected' : '' }}>{{ $role->nom }}</option>
                                @endforeach
                            </select>
                            @error('id_role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_langue" class="form-label fw-semibold"><i class="bi bi-translate"></i> Langue</label>
                            <select name="id_langue" id="id_langue" class="form-select @error('id_langue') is-invalid @enderror">
                                <option value="">-- Sélectionner une langue --</option>
                                @foreach($langues as $langue)
                                    <option value="{{ $langue->id }}" {{ old('id_langue') == $langue->id ? 'selected' : '' }}>{{ $langue->nom_langue }}</option>
                                @endforeach
                            </select>
                            @error('id_langue')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Statut / Mot de passe -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label fw-semibold"><i class="bi bi-toggle-on"></i> Statut</label>
                            <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                                @foreach(\App\Enums\StatutUser::cases() as $statut)
                                    <option value="{{ $statut->value }}" {{ old('statut', \App\Enums\StatutUser::ACTIVE->value) == $statut->value ? 'selected' : '' }}>
                                        {{ ucfirst($statut->value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('statut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold"><i class="bi bi-lock-fill"></i> Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2"><i class="bi bi-x-circle"></i> Annuler</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .custom-card { border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .custom-card-header { background: linear-gradient(135deg, #1cc88a, #17a673); padding: 15px 20px; }
        .custom-card-header h4 { margin: 0; font-weight: 600; font-size: 1.25rem; }
        .form-label { color: #4e4e4e; font-size: 0.9rem; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #d1d3e2; padding: 8px 10px; transition: 0.25s; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus { border-color: #1cc88a; box-shadow: 0 0 0 0.2rem rgba(28,200,138,0.2); }
        .is-invalid { border-color: #e74a3b !important; }
        .invalid-feedback { font-size: 0.8rem; }
        .btn-success { background: linear-gradient(135deg, #1cc88a, #17a673); border: none; font-weight: 600; font-size: 0.9rem; transition: 0.2s; }
        .btn-success:hover { transform: scale(1.03); }
    </style>
@endpush
@push('scripts')
    <script>
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
                background: '#1cc88a',
                color: '#fff'
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
                background: '#e74a3b',
                color: '#fff'
            });
            @endif

        });
    </script>
@endpush
