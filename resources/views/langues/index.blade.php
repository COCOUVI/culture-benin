@extends('layout')

@section('title')
    Liste des langues
@endsection

@section('content')

    {{-- FontAwesome (si non chargé) --}}

    <style>
        /* --- Card Modern --- */
        .custom-card {
            border-radius: 12px;
            overflow: hidden;
            border: none !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .custom-card-header {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            padding: 18px 20px;
        }

        .custom-card-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 20px;
        }

        /* --- Table --- */
        #languesTable thead {
            background: #f1f2f6;
            font-weight: bold;
        }

        #languesTable tbody tr:hover {
            background: #f8f9fc !important;
            transition: 0.2s;
        }

        /* --- Icon Buttons Modern --- */
        .icon-btn {
            border: none;
            color: white;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s ease-in-out;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            font-size: 15px;
        }

        .btn-edit {
            background: #f6c23e;
        }

        .btn-edit:hover {
            background: #dda20a;
            transform: scale(1.1);
        }

        .btn-delete {
            background: #e74a3b;
        }

        .btn-delete:hover {
            background: #c0392b;
            transform: scale(1.1);
        }

        /* Datatable */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 6px;
            border: 1px solid #d1d3e2;
            padding: 5px 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4e73df !important;
            color: white !important;
        }

        .no-link-style {
            text-decoration: none; /* supprime le souligné */
            color: inherit; /* garde la couleur du bouton */
            display: inline-flex; /* pour centrer l’icône */
            align-items: center;
            justify-content: center;
        }
        .btn-info {
            background: #36b9cc; /* bleu clair */
            color: white;
        }

        .btn-info:hover {
            background: #2c9faf;
            transform: scale(1.1);
        }


    </style>


    <div class="card custom-card mb-4">
        <div class="card-header custom-card-header">
            <h3 class="card-title">Langues disponibles</h3>
        </div>

        <div class="card-body">
            <table id="languesTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($langues as $langue)
                    <tr>
                        <td>{{ $langue->code_langue }}</td>
                        <td>{{ $langue->nom_langue }}</td>
                        <td class="text-center">
                            <a href="{{ route('langues.show', $langue->id) }}"
                               class="icon-btn btn-info mx-1 no-link-style"
                               title="Voir les détails">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('langues.edit', $langue->id) }}"
                               class="icon-btn btn-edit mx-1 no-link-style">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <!-- Bouton Supprimer avec icône -->
                            <button type="button" class="icon-btn btn-delete mx-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $langue->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal{{ $langue->id }}" tabindex="-1"
                         aria-labelledby="deleteModalLabel{{ $langue->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $langue->id }}">Confirmation</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer la langue
                                    <strong>{{ $langue->nom_langue }}</strong> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler
                                    </button>
                                    <form action="{{ route('langues.destroy', $langue->id) }}" method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="3" class="text-center">Aucune langue trouvée</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#languesTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success', // tu peux garder l'icône “success” ou mettre “info”
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#f6c23e', // jaune
                color: '#000', // texte noir pour contraste
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            @endif

            @if(session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#e74a3b',
                color: '#fff',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            @endif
        });
    </script>

@endpush
