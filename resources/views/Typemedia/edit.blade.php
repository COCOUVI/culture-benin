@extends('layout')

@section('title')
    Modification de Type de media
@endsection

@section('content')

    <div class="container mt-5">
        <div class="card shadow-sm custom-card">
            <!-- Header -->
            <div class="card-header custom-card-header text-white">
                <h4 class="mb-0">Modifier le type de média "{{ $typeMedia->nom }}"</h4>
            </div>

            <!-- Form -->
            <div class="card-body p-4">
                <form action="{{ route('type_media.update', $typeMedia->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nom" class="form-label fw-semibold">Nom du type média</label>
                        <input type="text"
                               name="nom"
                               id="nom"
                               class="form-control @error('nom') is-invalid @enderror"
                               placeholder="Ex: Vidéo, Image, Audio..."
                               value="{{ old('nom', $typeMedia->nom) }}">
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('type_media.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary btn-submit">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* Card modern */
        .custom-card { border-radius: 12px; border: none; box-shadow: 0 6px 18px rgba(0,0,0,0.08); overflow: hidden; }
        .custom-card-header { background: linear-gradient(135deg, #36b9cc, #1cc88a); padding: 20px; }
        .custom-card-header h4 { margin: 0; font-weight: 600; }

        /* Form */
        .form-label { color: #4e4e4e; }
        .form-control { border-radius: 8px; border: 1px solid #d1d3e2; padding: 10px 12px; transition: 0.25s; }
        .form-control:focus { border-color: #36b9cc; box-shadow: 0 0 0 0.2rem rgba(54,185,204,0.2); }
        .is-invalid { border-color: #e74a3b !important; }
        .invalid-feedback { font-size: 0.875rem; }

        /* Buttons */
        .btn-submit { background: linear-gradient(135deg, #36b9cc, #1cc88a); border: none; font-weight: 600; transition: 0.2s; }
        .btn-submit:hover { transform: scale(1.05); }
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
