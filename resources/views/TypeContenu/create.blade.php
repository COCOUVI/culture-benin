@extends('layout')

@section('title')
    Ajout d'un Type de Contenu
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <!-- Card Header -->
            <div class="card-header" style="background-color: #4da6ff; color: #fff;">
                <h4 class="mb-0">Ajouter un Type de Contenu</h4>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <form action="{{ route('type_contenu.store') }}" method="POST">
                    @csrf

                    <!-- Champ Nom -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du Type de Contenu</label>
                        <input type="text"
                               name="nom"
                               id="nom"
                               class="form-control @error('nom') is-invalid @enderror"
                               placeholder="Ex: Article"
                               value="{{ old('nom') }}">

                        <!-- Message d'erreur -->
                        @error('nom')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('type_contenu.index') }}"
                           class="btn"
                           style="background-color: #e0e0e0; color: #333; font-weight: 500; margin-right: 10px;">
                            Annuler
                        </a>
                        <button type="submit"
                                class="btn"
                                style="background-color: #00c0c0; color: #fff; font-weight: 600;">
                            Créer
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
            @if(session('success') && session('toast_id'))
            const toastId = "{{ session('toast_id') }}";

            // Vérifier si ce toast a déjà été affiché
            if (!sessionStorage.getItem('toast_' + toastId)) {
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

                // Marquer comme affiché
                sessionStorage.setItem('toast_' + toastId, 'shown');
            }
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
                background: '#ff4d4d',
                color: '#fff'
            });
            @endif

        });
    </script>
@endpush
