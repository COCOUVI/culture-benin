@extends('layout')

@section('title')
    Modification de rôle
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <!-- Header -->
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Modifier le rôle : {{ $role->nom }}</h4>
            </div>

            <!-- Formulaire -->
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nom" class="form-label fw-bold">Nom du rôle</label>
                        <input type="text"
                               id="nom"
                               name="nom"
                               class="form-control @error('nom') is-invalid @enderror"
                               placeholder="Ex: Administrateur"
                               value="{{ old('nom', $role->nom) }}">
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
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
        });
    </script>
@endpush
