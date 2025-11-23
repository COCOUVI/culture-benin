@extends('layout')

@section('title')
    Liste des Types de Contenu
@endsection

@section('content')

    <div class="container mt-5">

        <div class="card shadow-sm border-0">

            <!-- header -->
            <div class="card-header d-flex justify-content-between align-items-center"
                 style="background-color: #4da6ff; color: white;">
                <h4 class="mb-0">Liste des Types de Contenu</h4>

            </div>

            <!-- body -->
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-start">
                    <a href="{{ route('type_contenu.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Ajouter un Type de contenu
                    </a>
                </div>
                @if($typeContenus->count() === 0)

                    <!-- Aucun enregistrement -->
                    <div class="text-center py-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486748.png"
                             width="120" class="mb-3 opacity-75">
                        <h5 class="text-muted">Aucun Type de Contenu trouvé</h5>
                    </div>

                @else

                    <!-- DataTable -->
                    <div class="table-responsive">
                        <table id="type-contenu-table" class="table table-striped table-bordered">
                            <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Date création</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($typeContenus as $tc)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tc->nom }}</td>
                                    <td>{{ $tc->created_at->format('d-m-Y') }}</td>
                                    <td>

                                        <a href="{{ route('type_contenu.edit', $tc->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('type_contenu.destroy', $tc->id) }}"
                                              method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete">
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

            // Active DataTables si il y a des données
            @if($typeContenus->count() > 0)
            $('#type-contenu-table').DataTable();
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
                        if (result.isConfirmed) {
                            form.submit();
                        }
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
                background: '#00c0c0',
                color: '#fff'
            });
            @endif

        });
    </script>
@endpush
