@extends('layout')

@section('title')
    Création des Commentaires
@endsection

@section('content')

<div class="container mt-5">

    <div class="card shadow-sm" style="max-width: 700px; margin:auto;">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-chat-left-dots-fill me-2"></i>
            <h5 class="mb-0">Ajouter un Commentaire</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('commentaires.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Utilisateur --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="bi bi-person-circle me-1"></i> Utilisateur
                        </label>
                        <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->nom }} {{ $user->prenom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Contenu --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="bi bi-folder2-open me-1"></i> Contenu
                        </label>
                        <select name="id_contenu" class="form-select @error('id_contenu') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($contenus as $contenu)
                                <option value="{{ $contenu->id }}" {{ old('id_contenu') == $contenu->id ? 'selected' : '' }}>
                                    {{ $contenu->titre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_contenu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Note --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            <i class="bi bi-star-fill text-warning me-1"></i> Note (1 à 5)
                        </label>
                        <select name="note" class="form-select @error('note') is-invalid @enderror" required>
                            <option value="">-- Noter --</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('note') == $i ? 'selected' : '' }}>
                                    {{ $i }} ★
                                </option>
                            @endfor
                        </select>
                        @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Commentaire --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            <i class="bi bi-pencil-square me-1"></i> Commentaire
                        </label>
                        <textarea name="commentaire" rows="4"
                            class="form-control @error('commentaire') is-invalid @enderror"
                            placeholder="Votre avis...">{{ old('commentaire') }}</textarea>
                        @error('commentaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                {{-- Boutons --}}
                <div class="mt-4 text-end">
                    <a href="{{ route('commentaires.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Retour
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill"></i> Enregistrer
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
