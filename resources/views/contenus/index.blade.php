@extends('layout')

@section('title')
    Liste des contenus
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="bi bi-journal-text me-2"></i> Liste des contenus
            </div>
            <div class="card-body">
                <table id="contenusTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Région</th>
                        <th>Langue</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contenus as $contenu)
                        <tr>
                            <td>{{ $contenu->titre }}</td>
                            <td>{{ $contenu->auteur->nom ?? 'N/A' }} {{ $contenu->auteur->prenom ?? '' }}</td>
                            <td>{{ $contenu->region->nom_region ?? 'N/A' }}</td>
                            <td>{{ $contenu->langue->nom_langue ?? 'N/A' }}</td>
                            <td>{{ $contenu->type_contenu->nom ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('contenus.show', $contenu->id) }}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye-fill"></i> Voir</a>
                                <a href="{{ route('contenus.edit', $contenu->id) }}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-fill"></i> Modifier</a>
                                <form action="{{ route('contenus.destroy', $contenu->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1">
                                        <i class="bi bi-trash-fill"></i> Supprimer
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
    <!-- DataTables JS & SweetAlert2 -->
    <script>
        $(document).ready(function() {
            // Initialisation du datatable
            $('#contenusTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                }
            });

            // Gestion de la suppression avec toast
            $('.delete-form').on('submit', function(e){
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if(result.isConfirmed){
                        form.submit();
                    }
                });
            });

            // Toast après suppression
            @if(session('success'))

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                background: '#ffc107',   // JAUNE BOOTSTRAP
                color: '#212529'         // TEXTE FONCÉ, hyper lisible
            });

            @endif

    });
    </script>
@endpush
