@extends('layout')

@section('title')
    Liste des rôles
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <!-- Header -->
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Liste des rôles</h4>
            </div>

            <!-- Table + Bouton Ajouter -->
            <div class="card-body p-3">
                <div class="mb-3 d-flex justify-content-start">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Ajouter un rôle
                    </a>
                </div>

                <table id="roles-table" class="table table-striped table-hover table-bordered mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nom du rôle</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->nom }}</td>
                            <td class="text-center">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm me-1" title="Modifier">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <!-- Bouton pour ouvrir le modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}" title="Supprimer">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <!-- Modal Bootstrap -->
                                <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $role->id }}">Confirmation</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer le rôle <strong>{{ $role->nom }}</strong> ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
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
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Aucun rôle trouvé</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#roles-table').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
                },
                columnDefs: [
                    { orderable: false, targets: 2 } // Actions non triables
                ],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                responsive: true
            });
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
