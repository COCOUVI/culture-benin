@extends('layout')

@section('title')
    Détail d'un Média
@endsection

@section('content')
<div class="container mt-5">

    <div class="card shadow-sm" style="max-width: 750px; margin: auto;">
        <div class="card-header bg-info text-white d-flex align-items-center">
            <i class="bi bi-image-fill me-2"></i> Détails du média
        </div>

        <div class="card-body">

            <!-- Aperçu du média -->
            <div class="text-center mb-4">
                @php
                    $extension = strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
                @endphp

                @if(in_array($extension, ['jpg','jpeg','png','gif']))
                    <img src="{{ asset('storage/'.$media->chemin) }}" 
                         alt="Media" class="img-fluid rounded shadow" 
                         style="max-height: 350px;">
                @elseif(in_array($extension, ['mp4','mov','avi','mkv']))
                    <video controls class="w-100 rounded shadow">
                        <source src="{{ asset('storage/'.$media->chemin) }}">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                @else
                    <div class="alert alert-secondary">
                        Fichier: {{ $media->chemin }}
                    </div>
                @endif
            </div>

            <hr>

            <!-- Informations -->
            <h5 class="fw-bold">Informations du média</h5>

            <table class="table table-bordered mt-3">
                <tr>
                    <th>Contenu lié</th>
                    <td>{{ $media->contenu->titre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Type de média</th>
                    <td>{{ $media->type_media->nom ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $media->description ?? 'Aucune description' }}</td>
                </tr>
                <tr>
                    <th>Date d'ajout</th>
                    <td>{{ $media->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Dernière modification</th>
                    <td>{{ $media->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            <!-- Actions -->
            <div class="text-end mt-4">
                <a href="{{ route('medias.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>

                <a href="{{ route('medias.edit', $media->id) }}" class="btn btn-warning text-dark">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>

                <form action="{{ route('medias.destroy', $media->id) }}" 
                      method="POST" style="display:inline-block;" 
                      class="deleteMediaForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Confirmation suppression
    $('.deleteMediaForm').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Le média sera définitivement supprimé.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@endpush
