@extends('layout')

@section('title')
    Modification d'une Région
@endsection

@section('content')

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-edit me-2"></i> Modifier la Région : {{ $region->nom_region }}
                </h4>
            </div>

            <div class="card-body">

                <form action="{{ route('regions.update', $region->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nom région -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-map-marked-alt me-1"></i> Nom de la région
                        </label>
                        <input type="text" name="nom_region" class="form-control @error('nom_region') is-invalid @enderror"
                               value="{{ old('nom_region', $region->nom_region) }}" required>

                        @error('nom_region')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-align-left me-1"></i> Description
                        </label>
                        <textarea name="description_region" rows="3"
                                  class="form-control @error('description_region') is-invalid @enderror"
                        >{{ old('description_region', $region->description_region) }}</textarea>

                        @error('description_region')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Population -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-users me-1"></i> Population
                        </label>
                        <input type="number" name="population" min="0"
                               class="form-control @error('population') is-invalid @enderror"
                               value="{{ old('population', $region->population) }}" required>

                        @error('population')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Superficie -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-ruler-combined me-1"></i> Superficie (km²)
                        </label>
                        <input type="number" step="0.01" name="superficie" min="0"
                               class="form-control @error('superficie') is-invalid @enderror"
                               value="{{ old('superficie', $region->superficie) }}" required>

                        @error('superficie')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-geo-alt-fill me-1"></i> Localisation
                        </label>
                        <input type="text" name="localisation"
                               class="form-control @error('localisation') is-invalid @enderror"
                               placeholder="Ville, département ou zone géographique"
                               value="{{ old('localisation', $region->localisation) }}">

                        @error('localisation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('regions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Annuler
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Mettre à jour
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

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
                background: '#4CAF50', // vert
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
                background: '#e74a3b', // rouge
                color: '#fff'
            });
            @endif
        });
    </script>
@endpush
