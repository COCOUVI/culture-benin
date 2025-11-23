@extends('layout')

@section('title')
    Information sur une région
@endsection

@section('content')
    <div class="container mt-5">

        <div class="card shadow-sm mx-auto" style="max-width: 750px;">

            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="bi bi-geo-alt-fill me-2"></i>
                <h4 class="mb-0">Détails de la Région : {{ $region->nom_region }}</h4>
            </div>

            <div class="card-body">

                <div class="row">
                    <!-- Photo / Icon -->
                    <div class="col-md-4 text-center border-end">
                        <img src="https://cdn-icons-png.flaticon.com/512/854/854878.png"
                             class="img-fluid rounded-circle shadow-sm mb-3"
                             style="max-width: 140px;">
                        <h5 class="text-primary">{{ $region->nom_region }}</h5>
                    </div>

                    <!-- Informations -->
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">
                                <i class="bi bi-tag-fill text-primary me-1"></i>
                                <strong>Nom :</strong> {{ $region->nom_region }}
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-text-left text-primary me-1"></i>
                                <strong>Description :</strong><br>
                                <span class="text-muted">
                                    {{ $region->description_region ?? 'Aucune description' }}
                                </span>
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-people-fill text-primary me-1"></i>
                                <strong>Population :</strong> {{ number_format($region->population) }}
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-bounding-box-circles text-primary me-1"></i>
                                <strong>Superficie :</strong> {{ number_format($region->superficie, 2) }} km²
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-geo-alt text-primary me-1"></i>
                                <strong>Localisation :</strong> {{ $region->localisation ?? '-' }}
                            </li>



                        </ul>
                    </div>
                </div>

                <!-- Actions -->
                <div class="text-end mt-4">
                    <a href="{{ route('regions.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Retour
                    </a>
                    <a href="{{ route('regions.edit', $region->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i> Modifier
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection
