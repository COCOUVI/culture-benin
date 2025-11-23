@extends('layout')

@section('title')
    Modification d'un Utilisateur
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm custom-card mx-auto" style="max-width: 700px;">
            <!-- Header -->
            <div class="card-header text-white custom-card-header d-flex align-items-center">
                <i class="bi bi-pencil-square me-2"></i>
                <h4 class="mb-0 text-black">Modifier {{ $user->nom }} {{ $user->prenom }}</h4>
            </div>

            <!-- Formulaire -->
            <div class="card-body p-4">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <!-- Photo -->
                        <div class="col-md-4 text-center">
                            @if($user->photo)
                                <div class="photo-wrapper mx-auto shadow-sm rounded-circle overflow-hidden"
                                     style="width: 150px; height: 150px;">
                                    <img src="{{ asset('storage/' . $user->photo) }}"
                                         alt="Photo de {{ $user->nom }}"
                                         class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                            @else
                                <i class="bi bi-person-circle" style="font-size: 6rem; color: #ccc;"></i>
                            @endif
                            <label for="photo" class="form-label fw-semibold mt-2"><i class="bi bi-card-image"></i> Changer la photo</label>
                            <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Infos utilisateur -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label fw-semibold"><i class="bi bi-person"></i> Nom</label>
                                    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror"
                                           value="{{ old('nom', $user->nom) }}">
                                    @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="prenom" class="form-label fw-semibold"><i class="bi bi-person"></i> Prénom</label>
                                    <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror"
                                           value="{{ old('prenom', $user->prenom) }}">
                                    @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold"><i class="bi bi-envelope"></i> Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_naissance" class="form-label fw-semibold"><i class="bi bi-calendar"></i> Date de naissance</label>
                                    <input type="date" name="date_naissance" id="date_naissance"
                                           class="form-control @error('date_naissance') is-invalid @enderror"
                                           value="{{ old('date_naissance', optional($user->date_naissance)->format('Y-m-d')) }}">
                                    @error('date_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sexe" class="form-label fw-semibold"><i class="bi bi-gender-ambiguous"></i> Sexe</label>
                                    <select name="sexe" id="sexe" class="form-select @error('sexe') is-invalid @enderror">
                                        <option value="">-- Sélectionner le sexe --</option>
                                        <option value="masculin" {{ old('sexe', $user->sexe) == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                        <option value="feminin" {{ old('sexe', $user->sexe) == 'feminin' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    @error('sexe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="id_role" class="form-label fw-semibold"><i class="bi bi-shield-fill-check"></i> Rôle</label>
                                    <select name="id_role" id="id_role" class="form-select @error('id_role') is-invalid @enderror">
                                        <option value="">-- Sélectionner un rôle --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('id_role', $user->id_role) == $role->id ? 'selected' : '' }}>
                                                {{ $role->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="id_langue" class="form-label fw-semibold"><i class="bi bi-translate"></i> Langue</label>
                                    <select name="id_langue" id="id_langue" class="form-select @error('id_langue') is-invalid @enderror">
                                        <option value="">-- Sélectionner une langue --</option>
                                        @foreach($langues as $langue)
                                            <option value="{{ $langue->id }}" {{ old('id_langue', $user->id_langue) == $langue->id ? 'selected' : '' }}>
                                                {{ $langue->nom_langue }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_langue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="statut" class="form-label fw-semibold"><i class="bi bi-toggle-on"></i> Statut</label>
                                    <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                                        @foreach(\App\Enums\StatutUser::cases() as $statut)
                                            <option value="{{ $statut->value }}"
                                                {{ old('statut', $user->statut) == $statut->value ? 'selected' : '' }}>
                                                {{ ucfirst($statut->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold"><i class="bi bi-lock-fill"></i> Nouveau mot de passe (optionnel)</label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-left-circle"></i> Retour
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Enregistrer
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {


            // SweetAlert Suppression
            document.querySelectorAll(".btn-delete").forEach(btn => {
                btn.addEventListener("click", function () {
                    let form = this.closest("form");
                    Swal.fire({
                        title: 'Supprimer ?',
                        text: "Cette action est irréversible !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        confirmButtonColor: '#e74a3b',
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // Toast succès
            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                background: '#1cc88a',
                color: '#fff'
            });
            @endif
        });
    </script>
@endpush
