@extends('layout')

@section('title')
    Détail du contenu
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 700px;">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-journal-text me-2"></i> Détails du contenu
                </div>
                <div>
                    <a href="{{ route('contenus.edit', $contenu->id) }}" class="btn btn-sm btn-warning me-2">
                        <i class="bi bi-pencil-fill"></i> Modifier
                    </a>
                    <a href="{{ route('contenus.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Retour
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <!-- Titre -->
                <h2 class="mb-3 fw-bold text-primary"><i class="bi bi-card-text me-1"></i> {{ $contenu->titre }}</h2>

                <!-- Texte -->
                <div class="mb-4">
                    <h5 class="text-secondary"><i class="bi bi-pencil-square me-1"></i> Description :</h5>
                    <p class="fs-6">{{ $contenu->texte }}</p>
                </div>

                <!-- Badges / Infos -->
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge bg-info"><i
                            class="bi bi-person-fill me-1"></i> Auteur : {{ $contenu->auteur->nom ?? 'N/A' }} {{ $contenu->auteur->prenom ?? '' }}</span>
                    <span class="badge bg-secondary"><i class="bi bi-geo-alt-fill me-1"></i> Région : {{ $contenu->region->nom_region ?? 'N/A' }}</span>
                    <span class="badge bg-purple text-white "><i class="bi bi-translate me-1"></i> Langue : {{ $contenu->langue->nom_langue ?? 'N/A' }}</span>
                    <span class="badge bg-warning text-dark"><i class="bi bi-folder-fill me-1"></i> Type : {{ $contenu->type_contenu->nom ?? 'N/A' }}</span>
                    <span class="badge {{ $contenu->status_class }}">
                      <i class="bi bi-toggle-on me-1"></i> Statut : {{ ucfirst($contenu->statut) }}
                    </span>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .bg-purple {
            background-color: #6f42c1; /* violet Bootstrap-like */
            color: #fff;
        }

    </style>
@endpush
