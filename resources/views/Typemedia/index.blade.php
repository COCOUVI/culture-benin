@extends('layout')

@section('title')
    Liste des types de médias
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <!-- Header -->
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Liste des types de médias</h4>
            </div>

            <!-- Table + Bouton Ajouter -->
            <div class="card-body p-3">

                <!-- Bouton Ajouter placé au-dessus de la table -->
                <div class="mb-3 d-flex justify-content-start">
                    <a href="{{ route('type_media.create') }}"
                       class="btn btn-primary d-flex align-items-center shadow-sm"
                       style="border-radius: 8px; padding: 8px 16px; font-weight: 600; transition: 0.2s;">
                        <i class="fa-solid fa-plus me-2"></i> Ajouter un type
                    </a>
                </div>

                @if($mediaTypes->count())
                    <table id="media-types-table" class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mediaTypes as $mediaType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mediaType->nom }}</td>
                                <td class="text-center">
                                    <a href="{{ route('type_media.edit', $mediaType->id) }}" class="btn btn-warning btn-sm me-1" title="Modifier">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <!-- Bouton Supprimer -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $mediaType->id }}" title="Supprimer">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    <!-- Modal de confirmation -->
                                    <div class="modal fade" id="deleteModal{{ $mediaType->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $mediaType->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $mediaType->id }}">Confirmation</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer le type de média "<strong>{{ $mediaType->nom }}</strong>" ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('type_media.destroy', $mediaType->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning text-center mb-0" role="alert" style="width: 100%;">
                        Aucun type de média trouvé
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            @if($mediaTypes->count())
            $('#media-types-table').DataTable({
                language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
                columnDefs: [ { orderable: false, targets: 2 } ],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                responsive: true
            });
            @endif
        });
    </script>

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
                background: '#f6c23e',
                color: '#000',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            @endif
        });
    </script>
@endpush
