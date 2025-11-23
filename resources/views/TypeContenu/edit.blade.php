@extends('layout')

@section('title')
    Modification du Type de Contenu
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0">

            <!-- Card Header -->
            <div class="card-header" style="background-color: #4da6ff; color: #fff;">
                <h4 class="mb-0">Modifier le Type de Contenu</h4>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <form action="{{ route('type_contenu.update', $typeContenu->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Champ NOM -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du Type de Contenu</label>
                        <input type="text"
                               name="nom"
                               id="nom"
                               class="form-control @error('nom') is-invalid @enderror"
                               value="{{ old('nom', $typeContenu->nom) }}"
                               placeholder="Modifier le nom...">

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
                           style="background-color: #e0e0e0; color: #333; margin-right: 10px;">
                            Annuler
                        </a>

                        <button type="submit"
                                class="btn"
                                style="background-color: #00c0c0; color: #fff;">
                            Mettre à jour
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
                background: '#00c0c0',
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
                background: '#ff4d4d',
                color: '#fff'
            });
            @endif

        });
    </script>
@endpush
