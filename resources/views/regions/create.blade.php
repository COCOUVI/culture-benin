@extends('layout')

@section('title')
    Création des Régions
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg" style="max-width: 700px; margin: auto;">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="bi bi-geo-alt-fill me-2"></i>
                <h4 class="mb-0">Créer une nouvelle Région</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('regions.store') }}" method="POST">
                    @csrf

                    {{-- Nom de la région --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-tag-fill text-primary"></i> Nom de la région
                        </label>
                        <input type="text" name="nom_region" class="form-control @error('nom_region') is-invalid @enderror"
                               placeholder="Nom de la région" value="{{ old('nom_region') }}">
                        @error('nom_region')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-text-left text-primary"></i> Description
                        </label>
                        <textarea name="description_region" rows="3"
                                  class="form-control @error('description_region') is-invalid @enderror"
                                  placeholder="Décrivez la région...">{{ old('description_region') }}</textarea>
                        @error('description_region')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Population --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-people-fill text-primary"></i> Population
                        </label>
                        <input type="number" name="population"
                               class="form-control @error('population') is-invalid @enderror"
                               placeholder="Population" value="{{ old('population') }}">
                        @error('population')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Superficie --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-bounding-box-circles text-primary"></i> Superficie (km²)
                        </label>
                        <input type="number" step="0.01" name="superficie"
                               class="form-control @error('superficie') is-invalid @enderror"
                               placeholder="Superficie en km²" value="{{ old('superficie') }}">
                        @error('superficie')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 🔵 LOCALISATION (ajout demandé) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-pin-map-fill text-primary"></i> Localisation
                        </label>
                        <input type="text" name="localisation"
                               class="form-control @error('localisation') is-invalid @enderror"
                               placeholder="Ville, département ou zone géographique"
                               value="{{ old('localisation') }}">

                        @error('localisation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Boutons --}}
                    <div class="text-end mt-4">
                        <a href="{{ route('regions.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Retour
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle-fill"></i> Enregistrer
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
                timerProgressBar: true,
                background: '#e74a3b',
                color: '#fff'
            });
            @endif
        });
    </script>
@endpush
