@extends('layout')

@section('title')
    Liste des Commentaires
@endsection

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-chat-dots-fill me-2"></i> Liste des Commentaires
        </div>

        <div class="card-body">
            <table id="commentairesTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Utilisateur</th>
                        <th>Contenu</th>
                        <th>Commentaire</th>
                        <th>Note</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($commentaires as $commentaire)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <i class="bi bi-person-circle text-primary"></i>
                            {{ $commentaire->user->nom ?? 'Utilisateur inconnu' }}
                        </td>

                        <td>
                            <i class="bi bi-file-text-fill text-secondary"></i>
                            {{ $commentaire->contenu->titre ?? 'N/A' }}
                        </td>

                        <td>{{ Str::limit($commentaire->commentaire, 40) }}</td>

                        <td>
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $commentaire->note ? '-fill text-warning' : '' }}"></i>
                            @endfor
                        </td>

                        <td>{{ $commentaire->created_at->format('d/m/Y') }}</td>

                        <td>
                            <a href="{{ route('commentaires.show', $commentaire->id) }}"
                               class="btn btn-sm btn-info" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('commentaires.edit', $commentaire->id) }}"
                               class="btn btn-sm btn-warning" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('commentaires.destroy', $commentaire->id) }}"
                                  method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {

    // Initialisation datatable
    $('#commentairesTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        }
    });

    // Confirmation suppression
    $('.delete-form').on('submit', function(e){
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Ce commentaire sera définitivement supprimé.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });

    // Toast succès
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
