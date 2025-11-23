@extends('layout')

@section('title')
    Détail d'un commentaire
@endsection

@section('content')

<div class="container mt-5">

    <div class="card shadow-lg border-0 rounded-4">
        
        <!-- Header -->
        <div class="card-header bg-info text-white d-flex align-items-center rounded-top-4">
            <i class="bi bi-chat-left-text fs-4 me-2"></i>
            <h5 class="mb-0">Détails du Commentaire</h5>
        </div>

        <!-- Body -->
        <div class="card-body p-4">

            <!-- Info User -->
            <div class="mb-4 d-flex align-items-center">
                <div class="me-3">
                    <i class="bi bi-person-circle fs-2 text-primary"></i>
                </div>
                <div>
                    <h6 class="mb-1 text-secondary">Utilisateur</h6>
                    <p class="fw-bold mb-0">
                        {{ $commentaire->user->nom }} {{ $commentaire->user->prenom }}
                    </p>
                </div>
            </div>

            <!-- Commentaire -->
            <div class="mb-4">
                <h6 class="text-secondary"><i class="bi bi-chat-dots me-2"></i>Commentaire</h6>
                <div class="p-3 bg-light rounded-3 border">
                    {{ $commentaire->commentaire ?? 'Aucun texte fourni.' }}
                </div>
            </div>

            <!-- Note -->
            <div class="mb-4">
                <h6 class="text-secondary"><i class="bi bi-star-fill text-warning me-1"></i>Note</h6>

                <div class="d-flex">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $commentaire->note)
                            <i class="bi bi-star-fill text-warning fs-5"></i>
                        @else
                            <i class="bi bi-star text-warning fs-5"></i>
                        @endif
                    @endfor
                </div>
            </div>

            <!-- Contenu associé -->
            <div class="mb-4">
                <h6 class="text-secondary"><i class="bi bi-folder2-open me-2"></i>Contenu associé</h6>
                <p class="fw-semibold">{{ $commentaire->contenu->titre }}</p>
            </div>

            <!-- Dates -->
            <div class="mb-4">
                <h6 class="text-secondary"><i class="bi bi-clock-history me-2"></i>Informations temporelles</h6>
                <p class="mb-1"><strong>Créé le :</strong> {{ $commentaire->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Mis à jour le :</strong> {{ $commentaire->updated_at->format('d/m/Y H:i') }}</p>
            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer bg-white d-flex justify-content-between py-3">

            <a href="{{ route('commentaires.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Retour
            </a>

            <div>
                <a href="{{ route('commentaires.edit', $commentaire->id) }}" class="btn btn-warning text-dark me-2">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>

                <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
