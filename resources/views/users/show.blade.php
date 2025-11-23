@extends('layout')

@section('title')
    Informations de l'utilisateur
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 700px;">
            <!-- Header -->
            <div class="card-header text-white bg-primary d-flex align-items-center">
                <i class="bi bi-person-lines-fill me-2"></i>
                <h4 class="mb-0">Information sur {{ $user->nom }} {{ $user->prenom }}</h4>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <!-- Photo utilisateur -->
                    <div class="col-md-4 text-center">
                        @if($user->photo)
                            <div class="photo-wrapper mx-auto shadow-sm rounded-circle overflow-hidden"
                                 style="width: 160px; height: 160px;">
                                <img src="{{ asset('storage/' . $user->photo) }}"
                                     alt="Photo de {{ $user->nom }}"
                                     class="img-fluid w-100 h-100 object-fit-cover"
                                     style="transition: transform 0.3s;">
                            </div>
                        @else
                            <i class="bi bi-person-circle" style="font-size: 6rem; color: #ccc;"></i>
                        @endif
                    </div>

                    <!-- Informations utilisateur -->
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nom complet:</strong> {{ $user->nom }} {{ $user->prenom }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                            <li class="list-group-item"><strong>Date de naissance:</strong> {{ optional($user->date_naissance)->format('d-m-Y') }}</li>
                            <li class="list-group-item"><strong>Sexe:</strong> {{ ucfirst($user->sexe ?? '-') }}</li>
                            <li class="list-group-item"><strong>Rôle:</strong> {{ $user->role->nom ?? '-' }}</li>
                            <li class="list-group-item"><strong>Langue:</strong> {{ $user->langue->nom_langue ?? '-' }}</li>
                            <li class="list-group-item"><strong>Statut:</strong>
                                @if($user->statut === 'actif')
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Retour
                    </a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Éditer
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .photo-wrapper img:hover {
            transform: scale(1.05);
        }
    </style>
@endpush
