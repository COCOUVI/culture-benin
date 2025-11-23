@extends('layout')

@section('title')
    Modification d'un Média
@endsection

@section('content')
    <div class="container mt-5">

        <div class="card shadow-sm mx-auto" style="max-width: 700px;">

            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-image-fill me-2"></i> Modifier un Média
                </h5>
                <a href="{{ route('medias.index') }}" class="btn btn-sm btn-light">
                    <i class="bi bi-arrow-left-circle"></i> Retour
                </a>
            </div>

            <!-- Body -->
            <div class="card-body">

                <form action="{{ route('medias.update', $media->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <!-- Aperçu actuel -->
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold">Média actuel :</label>
                        <div class="border p-2 rounded bg-light">
                            @if (in_array(pathinfo($media->chemin, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                <video controls class="w-100 rounded" style="max-height: 250px;">
                                    <source src="{{ asset('storage/' . $media->chemin) }}"
                                        type="video/{{ pathinfo($media->chemin, PATHINFO_EXTENSION) }}">
                                    Votre navigateur ne supporte pas la lecture de la vidéo.
                                </video>
                            @else
                                <img src="{{ asset('storage/media/' . $media->chemin) }}" alt="Media"
                                    class="img-fluid rounded" style="max-height: 250px;">
                            @endif
                        </div>
                    </div>


                    <!-- Upload (facultatif) -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-upload"></i> Modifier le fichier (optionnel)</label>
                        <input type="file" name="chemin" class="form-control @error('chemin') is-invalid @enderror" value="{{$media->chemin}}">
                        @error('chemin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-card-text"></i> Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $media->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contenu lié -->
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-journal-text"></i> Contenu associé</label>
                        <select name="id_contenu" class="form-select @error('id_contenu') is-invalid @enderror">
                            <option value="">-- Sélectionner --</option>
                            @foreach ($contenus as $c)
                                <option value="{{ $c->id }}" {{ $media->id_contenu == $c->id ? 'selected' : '' }}>
                                    {{ $c->titre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type de média -->
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-tags-fill"></i> Type de média</label>
                        <select name="id_type_media" class="form-select @error('id_type_media') is-invalid @enderror">
                            <option value="">-- Sélectionner --</option>
                            @foreach ($typesMedia as $t)
                                <option value="{{ $t->id }}"
                                    {{ $media->id_type_media == $t->id ? 'selected' : '' }}>
                                    {{ $t->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_type_media')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-success w-100">
                        <i class="bi bi-save"></i> Mettre à jour
                    </button>

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
                timer: 5000,
                background: '#e74a3b',
                color: '#fff'
            });
            @endif

            @if($errors->any())
            let errorMessages = '<ul class="text-start mb-0">';
            @foreach($errors->all() as $error)
                errorMessages += '<li>{{ $error }}</li>';
            @endforeach
                errorMessages += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Erreur de validation',
                html: errorMessages,
                confirmButtonText: 'OK'
            });
            @endif

        });
    </script>
@endpush