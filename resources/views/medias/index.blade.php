@extends('layout')

@section('title')
    Liste des Médias
@endsection

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Liste des Médias</h5>
            </div>

            <div class="card-body">
                <table id="mediasTable" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Contenu</th>
                            <th>Type de Média</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medias as $media)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $media->contenu->titre ?? 'N/A' }}</td>
                                <td>{{ $media->type_media->nom ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('medias.show', $media->id) }}" class="btn btn-sm btn-info"
                                        title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('medias.edit', $media->id) }}" class="btn btn-sm btn-warning"
                                        title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('medias.destroy', $media->id) }}" method="POST"
                                        class="d-inline deleteMediaForm">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
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

            // DataTable
            $('#mediasTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ]
            });

            // Confirmation avant suppression
            $(document).on('submit', '.deleteMediaForm', function(e) {
                e.preventDefault(); // empêcher la soumission immédiate
                let form = this;

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // soumettre seulement après confirmation
                    }
                });
            });

            // Toast success
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            // Toast error
            @if (session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

        });
    </script>
@endpush
