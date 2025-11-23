@extends('layout')

@section('title')
    Liste des Régions
@endsection

@section('content')
    <div class="container mt-5">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Liste des Régions</h4>

            </div>

            <div class="card-body">

                @if($regions->count() === 0)
                    <div class="text-center py-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/6356/6356656.png" width="120" class="opacity-75 mb-3">
                        <h5 class="text-muted">Aucune région trouvée</h5>
                    </div>
                @else

                    <div class="mb-3 text-start">
                        <a href="{{ route('regions.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Ajouter une région
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table id="regions-table" class="table table-bordered table-striped">
                            <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Population</th>
                                <th>Superficie (km²)</th>
                                <th>Localisation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($regions as $region)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $region->nom_region }}</td>
                                    <td>{{ number_format($region->population) }}</td>
                                    <td>{{ number_format($region->superficie, 2) }}</td>
                                    <td>{{ $region->localisation ?? '-' }}</td>
                                    <td>
                                        <!-- Voir -->
                                        <a href="{{ route('regions.show', $region->id) }}" class="btn btn-info btn-sm" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Modifier -->
                                        <a href="{{ route('regions.edit', $region->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Supprimer -->
                                        <form action="{{ route('regions.destroy', $region->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" title="Supprimer">
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
        document.addEventListener('DOMContentLoaded', function() {

            // Initialisation DataTable
            @if($regions->count() > 0)
            $('#regions-table').DataTable();
            @endif

            // 🔥 SweetAlert - Confirmation suppression
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    let form = this.closest('form');

                    Swal.fire({
                        title: 'Supprimer ?',
                        text: "Cette action est irréversible !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        confirmButtonColor: '#f1c40f',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 🟢 Toast succès
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

            // 🟡 Toast suppression
            @if(session('deleted'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: "{{ session('deleted') }}",
                showConfirmButton: false,
                timer: 3000,
                background: '#f1c40f',
                color: '#000'
            });
            @endif

            // 🔴 Toast erreur
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
