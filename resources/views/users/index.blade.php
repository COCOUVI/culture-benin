@extends('layout')

@section('title')
    Liste des Utilisateurs
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Liste des Utilisateurs</h4>
            </div>

            <div class="card-body">
                @if($users->count() === 0)
                    <div class="text-center py-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486748.png" width="120"
                             class="mb-3 opacity-75">
                        <h5 class="text-muted">Aucun utilisateur trouvé</h5>
                    </div>
                @else
                    <!-- Bouton Ajouter en haut de la table -->
                    <div class="mb-3 text-start">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Ajouter un utilisateur
                        </a>
                    </div>
                    <div class="table-responsive">

                        <table id="users-table" class="table table-striped table-bordered">
                            <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Date de naissance</th>
                                <th>Sexe</th>
                                <th>Rôle</th>
                                <th>Langue</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->nom }} {{ $user->prenom }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ optional($user->date_naissance)->format('d-m-Y') }}</td>
                                    <td>{{ ucfirst($user->sexe ?? '-') }}</td>
                                    <td>{{ $user->role->nom ?? '-' }}</td>
                                    <td>{{ $user->langue->nom_langue ?? '-' }}</td>
                                    <td>{{ ucfirst($user->statut) }}</td>
                                    <td>
                                        <!-- Voir -->
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info"
                                           title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Éditer -->
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning"
                                           title="Éditer">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Supprimer -->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if($users->count() > 0)
            $('#users-table').DataTable();
            @endif

            // SweetAlert Suppression
            document.querySelectorAll(".btn-delete").forEach(btn => {
                btn.addEventListener("click", function () {
                    let form = this.closest("form");
                    Swal.fire({
                        title: 'Supprimer ?',
                        text: "Cette action est irréversible !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        confirmButtonColor: '#e74a3b',
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
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
                background: '#f6c23e', // jaune
                color: '#000', // texte noir pour contraste
            });
            @endif
        });
    </script>
@endpush
