@extends('layout')

@section('title')
    Détails de la langue
@endsection

@section('content')

    <style>
        /* --- Card Dashboard Style --- */
        .custom-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .custom-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }

        .custom-card-header {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            padding: 22px 25px;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-card-header i {
            font-size: 22px;
        }

        .custom-card-body {
            padding: 25px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
        }

        .lang-info {
            display: flex;
            gap: 40px;
            font-size: 16px;
            margin-bottom: 20px;
            align-items: center;
        }

        .lang-info div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lang-info i {
            color: #4e73df;
        }

        .lang-description {
            font-size: 15px;
            color: #555;
            line-height: 1.6;
            padding: 15px;
            background-color: #f1f3f6;
            border-left: 4px solid #4e73df;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .btn-back-custom {
            display: inline-block;
            background: #4e73df;
            color: white;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-back-custom:hover {
            background: #2e59d9;
            transform: scale(1.05);
            color: white;
            text-decoration: none;
        }
    </style>

    <div class="card custom-card mb-4">
        <div class="custom-card-header">
            <i class="fa-solid fa-language"></i>
            Détails de la langue
        </div>
        <div class="custom-card-body">
            <!-- Ligne code + nom avec icônes -->
            <div class="lang-info">
                <div><i class="fa-solid fa-hashtag"></i><strong>Code :</strong> {{ $langue->code_langue }}</div>
                <div><i class="fa-solid fa-font"></i><strong>Nom :</strong> {{ $langue->nom_langue }}</div>
            </div>

            <!-- Description sur la ligne suivante -->
            <div class="lang-description">
                <i class="fa-solid fa-align-left"></i> <strong>Description :</strong> {{ $langue->description ?? 'Aucune description' }}
            </div>

            <a href="{{ route('langues.index') }}" class="btn-back-custom"><i class="fa-solid fa-arrow-left"></i> Retour à la liste</a>
        </div>
    </div>

@endsection
