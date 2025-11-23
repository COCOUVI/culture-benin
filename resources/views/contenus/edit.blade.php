@extends('layout')

@section('title')
    Page de modification d'un contenu
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm" style="max-width: 700px; margin:auto;">
            <div class="card-header bg-warning text-dark d-flex align-items-center">
                <i class="bi bi-pencil-square me-2"></i> Modifier le contenu
            </div>

            <div class="card-body">
                <form action="{{ route('contenus.update', $contenu->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Titre -->
                        <div class="col-12">
                            <label class="form-label fw-bold"><i class="bi bi-card-text me-1"></i> Titre</label>
                            <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                                   placeholder="Titre du contenu" value="{{ old('titre', $contenu->titre) }}" required>
                            @error('titre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Texte -->
                        <div class="col-12">
                            <label class="form-label fw-bold"><i class="bi bi-pencil-fill me-1"></i> Texte</label>
                            <textarea name="texte" rows="3" class="form-control @error('texte') is-invalid @enderror"
                                      placeholder="Votre texte...">{{ old('texte', $contenu->texte) }}</textarea>
                            @error('texte') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Statut & Auteur -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-toggle-on me-1"></i> Statut</label>
                            <select name="statut" class="form-select @error('statut') is-invalid @enderror" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="actif" {{ old('statut', $contenu->statut)=='actif' ? 'selected' : '' }}>Actif</option>
                                <option value="inactif" {{ old('statut', $contenu->statut)=='inactif' ? 'selected' : '' }}>Inactif</option>
                            </select>
                            @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-person-fill me-1"></i> Auteur</label>
                            <select name="id_auteur" class="form-select @error('id_auteur') is-invalid @enderror" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('id_auteur', $contenu->id_auteur)==$user->id ? 'selected' : '' }}>
                                        {{ $user->nom }} {{ $user->prenom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_auteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Région & Langue -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-geo-alt-fill me-1"></i> Région</label>
                            <select name="region_id" class="form-select @error('region_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id', $contenu->region_id)==$region->id ? 'selected' : '' }}>
                                        {{ $region->nom_region }}
                                    </option>
                                @endforeach
                            </select>
                            @error('region_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-translate me-1"></i> Langue</label>
                            <select name="langue_id" class="form-select @error('langue_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($langues as $langue)
                                    <option value="{{ $langue->id }}" {{ old('langue_id', $contenu->langue_id)==$langue->id ? 'selected' : '' }}>
                                        {{ $langue->nom_langue }}
                                    </option>
                                @endforeach
                            </select>
                            @error('langue_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Type de contenu -->
                        <div class="col-12">
                            <label class="form-label fw-bold"><i class="bi bi-folder-fill me-1"></i> Type de contenu</label>
                            <select name="type_contenu_id" class="form-select @error('type_contenu_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_contenu_id', $contenu->type_contenu_id)==$type->id ? 'selected' : '' }}>
                                        {{ $type->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_contenu_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="mt-4 text-end">
                        <a href="{{ route('contenus.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Retour</a>
                        <button type="submit" class="btn btn-warning text-dark"><i class="bi bi-save-fill"></i> Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toasts validation
            @if($errors->any())
            @foreach($errors->all() as $error)
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ $error }}",
                showConfirmButton: false,
                timer: 3000,
                background: '#e74a3b',
                color: '#fff'
            });
            @endforeach
            @endif

            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                background: '#4CAF50',
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
                background: '#e74a3b',
                color: '#fff'
            });
            @endif
        });
    </script>
@endpush
