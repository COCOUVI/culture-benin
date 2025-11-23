@extends('layout')

@section('title')
    Dashboard Culture Bénin
@endsection

@section('content')
    <div class="row">
        <!-- Statistiques clés -->
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $totalContenus }}</h3>
                    <p>Contenus culturels</p>
                </div>
                <i class="bi bi-journal-bookmark small-box-icon"></i>
                <a href="{{ route('contenus.index') }}" class="small-box-footer">
                    Voir plus <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $totalLangues }}</h3>
                    <p>Langues disponibles</p>
                </div>
                <i class="bi bi-translate small-box-icon"></i>
                <a href="{{ route('contenus.index') }}" class="small-box-footer">
                    Voir plus <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $totalCommentaires }}</h3>
                    <p>Commentaires</p>
                </div>
                <i class="bi bi-chat-left-text small-box-icon"></i>
                <a href="{{ route('commentaires.index') }}" class="small-box-footer">
                    Voir plus <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Utilisateurs</p>
                </div>
                <i class="bi bi-people small-box-icon"></i>
                <a href="{{ route('users.index') }}" class="small-box-footer">
                    Voir plus <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <!-- Graphiques -->
    <!-- Graphiques -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3>Contenus par langue</h3>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height: 300px;">
                    <canvas id="contenusLangueChart" style="max-height: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3>Commentaires par contenu</h3>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="height: 300px;">
                    <canvas id="commentairesChart" style="max-height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Données envoyées depuis le controller
        const languesLabels = @json($contenusParLangue->keys());
        const languesValues = @json($contenusParLangue->values());

        const commentairesLabels = @json($commentairesParContenu->keys());
        const commentairesValues = @json($commentairesParContenu->values());

        // Diagramme en bâtons : contenus par langue
        new Chart(document.getElementById('contenusLangueChart'), {
            type: 'bar',
            data: {
                labels: languesLabels,
                datasets: [{
                    label: 'Nombre de contenus',
                    data: languesValues,
                    backgroundColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Contenus par langue'
                    }
                }
            }
        });

        // Diagramme semi-circulaire : commentaires par contenu
        new Chart(document.getElementById('commentairesChart'), {
            type: 'doughnut',
            data: {
                labels: commentairesLabels,
                datasets: [{
                    data: commentairesValues,
                    backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Commentaires par contenu'
                    }
                }
            }
        });
    </script>
@endpush
