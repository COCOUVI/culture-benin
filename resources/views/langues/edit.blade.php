@extends('layout')

@section('title')
    Modification de langue
@endsection

@section('content')

    <style>
        /* ----- Card modern ----- */
        .custom-card { border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.06); overflow: hidden; }
        .custom-card-header { background: linear-gradient(135deg, #1cc88a, #13855c); color: white; padding: 20px 20px; }
        .custom-card-header .card-title { font-size: 19px; font-weight: 600; margin: 0; }
        .form-label { font-weight: 600; color: #4e4e4e; margin-bottom: 6px; }
        .form-control { border-radius: 8px !important; border: 1px solid #d1d3e2; padding: 10px 12px; transition: 0.25s ease-in-out; }
        .form-control:focus { border-color: #1cc88a !important; box-shadow: 0 0 0 0.2rem rgba(28,200,138,0.25); }
        .is-invalid { border-color: #e74a3b !important; }
        .invalid-feedback { color: #e74a3b; font-size: 0.875rem; margin-top: 5px; }
        .btn-primary-custom { background: linear-gradient(135deg, #4e73df, #224abe); border: none; padding: 8px 18px; border-radius: 8px; font-weight: 600; transition: 0.2s ease-in-out; }
        .btn-primary-custom:hover { transform: scale(1.05); background: #224abe; }
        .btn-cancel-custom { background: #e74a3b; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 600; color: white; transition: 0.2s ease-in-out; }
        .btn-cancel-custom:hover { transform: scale(1.05); background: #c0392b; color: white; }
        .custom-footer { padding: 15px 20px; background: #f7f7f7; border-top: 1px solid #e2e2e2; }
    </style>

    <div class="card custom-card mb-4">

        <!-- HEADER -->
        <div class="custom-card-header">
            <div class="card-title">Formulaire de modification de la langue {{ $langue->nom_langue }}</div>
        </div>

        <!-- FORM -->
        <form action="{{ route('langues.update', $langue->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Code</label>
                    <input
                        type="text"
                        class="form-control @error('code_langue') is-invalid @enderror"
                        name="code_langue"
                        value="{{ old('code_langue', $langue->code_langue) }}"
                        placeholder="Ex: FR, EN, DE..."
                    >
                    @error('code_langue')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input
                        type="text"
                        class="form-control @error('nom_langue') is-invalid @enderror"
                        name="nom_langue"
                        value="{{ old('nom_langue', $langue->nom_langue) }}"
                        placeholder="Ex: Français, Anglais, Allemand..."
                    >
                    @error('nom_langue')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea
                        class="form-control @error('description') is-invalid @enderror"
                        name="description"
                        rows="3"
                        placeholder="Brève description..."
                    >{{ old('description', $langue->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- FOOTER -->
            <div class="custom-footer">
                <a href="{{ route('langues.index') }}" class="btn-cancel-custom">Annuler</a>
                <button type="submit" class="btn-primary-custom ms-2">Mettre à jour</button>
            </div>
        </form>

    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#4CAF50',
                color: '#fff'
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
                color: '#fff'
            });
            @endif
        });
    </script>
@endpush
