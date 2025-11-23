@extends('layout')

@section('title')
    Page de modification d'un commentaire de {{ $commentaire->user->nom }} {{ $commentaire->user->prenom }}
@endsection

@section('content')

<div class="container mt-5">

    <div class="card shadow-sm" style="max-width: 700px; margin:auto;">
        <div class="card-header bg-warning text-dark d-flex align-items-center">
            <i class="bi bi-pencil-square me-2"></i>
            Modifier un commentaire
        </div>

        <div class="card-body">

            <form action="{{ route('commentaires.update', $commentaire->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- Commentaire -->
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            <i class="bi bi-chat-text-fill me-1"></i> Commentaire
                        </label>
                        <textarea name="commentaire" class="form-control @error('commentaire') is-invalid @enderror"
                                  rows="3" placeholder="Modifier le commentaire...">{{ old('commentaire', $commentaire->commentaire) }}</textarea>
                        @error('commentaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Note -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="bi bi-star-fill text-warning me-1"></i> Note
                        </label>
                        <select name="note" class="form-select @error('note') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}" {{ old('note', $commentaire->note)==$i ? 'selected' : '' }}>
                                    {{ $i }} ★
                                </option>
                            @endfor
                        </select>
                        @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Utilisateur -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="bi bi-person-fill me-1"></i> Utilisateur
                        </label>
                        <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('id_user', $commentaire->id_user)==$user->id ? 'selected' : '' }}>
                                    {{ $user->nom }} {{ $user->prenom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Contenu -->
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            <i class="bi bi-folder2-open me-1"></i> Contenu associé
                        </label>
                        <select name="id_contenu" class="form-select @error('id_contenu') is-invalid @enderror" required>
                            @foreach($contenus as $contenu)
                                <option value="{{ $contenu->id }}"
                                    {{ old('id_contenu', $commentaire->id_contenu)==$contenu->id ? 'selected' : '' }}>
                                    {{ $contenu->titre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_contenu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <!-- Boutons -->
                <div class="mt-4 text-end">
                    <a href="{{ route('commentaires.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Retour
                    </a>

                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="bi bi-save-fill"></i> Mettre à jour
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

        // Erreurs de validation
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

        // Succès
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

    });
</script>
@endpush
