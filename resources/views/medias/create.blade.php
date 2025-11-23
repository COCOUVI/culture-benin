@extends('layout')

@section('title', 'Création de Media pour les contenus')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Ajouter un Média</h5>
            </div>

            <div class="card-body">

                <form id="mediaForm" action="{{ route('medias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Contenu associé --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contenu associé</label>
                        <select name="id_contenu" class="form-select @error('id_contenu') is-invalid @enderror" required>
                            <option value="">-- Sélectionnez --</option>
                            @foreach($contenus as $contenu)
                                <option value="{{ $contenu->id }}" {{ old('id_contenu') == $contenu->id ? 'selected' : '' }}>
                                    {{ $contenu->titre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Type de média --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Type de média</label>
                        <select name="id_type_media" class="form-select @error('id_type_media') is-invalid @enderror" required>
                            <option value="">-- Sélectionnez --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('id_type_media') == $type->id ? 'selected' : '' }}>
                                    {{ $type->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_type_media')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Drag and Drop Zone --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fichier média</label>
                        <div id="dropZone"
                             class="border border-2 border-secondary p-5 text-center rounded @error('chemin') border-danger @enderror"
                             style="cursor: pointer; background: #f8f9fa; transition: all 0.3s;">
                            <i class="bi bi-cloud-arrow-up-fill fs-1 text-primary"></i>
                            <p class="mt-2 mb-1">Glissez un fichier ici ou cliquez pour sélectionner</p>
                            <small class="text-muted">Formats acceptés : JPG, PNG, GIF, MP4, MOV, AVI (Max: 20MB)</small>
                        </div>
                        @error('chemin')
                        <div class="text-danger mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ✅ Input file EN DEHORS de la dropZone --}}
                    <input type="file"
                           name="chemin"
                           id="fileInput"
                           class="d-none"
                           accept="image/jpeg,image/jpg,image/png,image/gif,video/mp4,video/quicktime,video/x-msvideo">

                    {{-- Aperçu du fichier sélectionné --}}
                    <div id="filePreview" class="alert alert-info d-none mb-3">
                        <i class="bi bi-file-earmark-check me-2"></i>
                        <strong>Fichier sélectionné :</strong> <span id="fileName"></span>
                        <span class="badge bg-primary ms-2" id="fileSize"></span>
                    </div>

                    {{-- ProgressBar --}}
                    <div class="progress mb-3 d-none" id="progressContainer" style="height: 25px;">
                        <div id="progressBar"
                             class="progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style="width: 0%">0%</div>
                    </div>

                    {{-- Boutons --}}
                    <div class="d-flex gap-2">
                        <button type="submit" id="submitBtn" class="btn btn-success" disabled>
                            <i class="bi bi-check-circle me-1"></i> Enregistrer le média
                        </button>
                        <button type="button" id="resetBtn" class="btn btn-secondary d-none">
                            <i class="bi bi-arrow-clockwise me-1"></i> Réinitialiser
                        </button>
                        <a href="{{ route('medias.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Éléments DOM
        const dropZone = document.getElementById("dropZone");
        const fileInput = document.getElementById("fileInput");
        const progressBar = document.getElementById("progressBar");
        const progressContainer = document.getElementById("progressContainer");
        const submitBtn = document.getElementById("submitBtn");
        const resetBtn = document.getElementById("resetBtn");
        const mediaForm = document.getElementById("mediaForm");
        const filePreview = document.getElementById("filePreview");
        const fileName = document.getElementById("fileName");
        const fileSize = document.getElementById("fileSize");

        let isUploadReady = false;

        // ✅ Clic sur la zone
        dropZone.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            fileInput.click();
            console.log("🖱️ Clic sur dropZone - Ouverture du sélecteur");
        });

        // ✅ Drag over
        dropZone.addEventListener("dragover", (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add("bg-light", "border-primary");
            dropZone.style.transform = "scale(1.02)";
        });

        // ✅ Drag leave
        dropZone.addEventListener("dragleave", (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove("bg-light", "border-primary");
            dropZone.style.transform = "scale(1)";
        });

        // ✅ DROP du fichier
        dropZone.addEventListener("drop", (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove("bg-light", "border-primary");
            dropZone.style.transform = "scale(1)";

            console.log("📥 DROP EVENT déclenché");

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                console.log("📁 Fichier détecté:", files[0].name, "Taille:", files[0].size);

                // ✅ Créer un DataTransfer pour assigner le fichier
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                fileInput.files = dt.files;

                console.log("✅ Fichier assigné à fileInput:", fileInput.files[0]?.name);

                // Déclencher manuellement l'événement change
                const changeEvent = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(changeEvent);
            } else {
                console.warn("⚠️ Aucun fichier dans le drop");
            }
        });

        // ✅ Changement de fichier (drag OU sélecteur)
        fileInput.addEventListener("change", (e) => {
            console.log("🔄 CHANGE EVENT déclenché");

            if (e.target.files && e.target.files.length > 0) {
                const file = e.target.files[0];
                console.log("📦 Fichier dans input:", file.name, file.size, "bytes");

                // Vérifier la taille (20MB max)
                const maxSize = 20 * 1024 * 1024; // 20MB
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Fichier trop volumineux',
                        text: 'Le fichier ne doit pas dépasser 20MB',
                        confirmButtonText: 'OK'
                    });
                    fileInput.value = "";
                    return;
                }

                // Afficher les infos et lancer la progression
                displayFileInfo(file);
                simulateProgress();
            } else {
                console.warn("⚠️ Aucun fichier dans l'input");
            }
        });

        // ✅ Afficher les infos du fichier
        function displayFileInfo(file) {
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);

            // Mettre à jour l'aperçu
            fileName.textContent = file.name;
            fileSize.textContent = sizeInMB + ' MB';
            filePreview.classList.remove("d-none");

            // Mettre à jour la dropZone
            dropZone.innerHTML = `
                <i class="bi bi-file-earmark-check fs-1 text-success"></i>
                <p class="mt-2 mb-1"><strong>${file.name}</strong></p>
                <p class="text-muted small mb-0">${sizeInMB} MB</p>
                <p class="text-primary small mb-0"><i class="bi bi-cursor me-1"></i>Cliquez pour changer</p>
            `;

            resetBtn.classList.remove("d-none");
        }

        // ✅ Simulation de la progression
        function simulateProgress() {
            console.log("⏳ Démarrage de la simulation de progression");

            isUploadReady = false;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Préparation...';
            progressContainer.classList.remove("d-none");
            progressBar.style.width = "0%";
            progressBar.textContent = "0%";
            progressBar.classList.remove("bg-success");
            progressBar.classList.add("bg-info");

            let percent = 0;
            const interval = setInterval(() => {
                percent += Math.floor(Math.random() * 8) + 5;
                if (percent > 100) percent = 100;

                progressBar.style.width = percent + "%";
                progressBar.textContent = percent + "%";

                if (percent >= 100) {
                    clearInterval(interval);
                    console.log("✅ Progression terminée - Activation du bouton");

                    progressBar.classList.remove("bg-info");
                    progressBar.classList.add("bg-success");

                    setTimeout(() => {
                        isUploadReady = true;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Enregistrer le média';
                        console.log("🟢 Bouton activé - Prêt à envoyer");
                    }, 500);
                }
            }, 180);
        }

        // ✅ Réinitialiser le formulaire
        resetBtn.addEventListener("click", () => {
            console.log("🔄 Réinitialisation du formulaire");

            fileInput.value = "";
            dropZone.innerHTML = `
                <i class="bi bi-cloud-arrow-up-fill fs-1 text-primary"></i>
                <p class="mt-2 mb-1">Glissez un fichier ici ou cliquez pour sélectionner</p>
                <small class="text-muted">Formats acceptés : JPG, PNG, GIF, MP4, MOV, AVI (Max: 20MB)</small>
            `;
            filePreview.classList.add("d-none");
            progressContainer.classList.add("d-none");
            progressBar.style.width = "0%";
            resetBtn.classList.add("d-none");
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Enregistrer le média';
            isUploadReady = false;
        });

        // ✅ Validation avant soumission
        mediaForm.addEventListener("submit", function(e) {
            console.log("🚀 TENTATIVE DE SOUMISSION");
            console.log("📋 FileInput files:", fileInput.files);
            console.log("📊 Nombre de fichiers:", fileInput.files.length);

            // Vérifier qu'un fichier est présent
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                console.error("❌ ERREUR : Aucun fichier sélectionné");

                Swal.fire({
                    icon: 'warning',
                    title: 'Fichier manquant',
                    text: 'Veuillez sélectionner un fichier avant de soumettre',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            console.log("✅ Fichier présent:", fileInput.files[0].name);
            console.log("📤 Envoi du formulaire au serveur...");

            // Désactiver le bouton pendant l'envoi
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Envoi en cours...';

            // Le formulaire sera envoyé normalement
            return true;
        });

        // ✅ Log initial
        console.log("✅ Script drag & drop initialisé");
        console.log("📝 Form enctype:", mediaForm.getAttribute('enctype'));
    </script>

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
                timer: 5000,
                background: '#e74a3b',
                color: '#fff'
            });
            @endif

            @if($errors->any())
            let errorMessages = '<ul class="text-start mb-0">';
            @foreach($errors->all() as $error)
                errorMessages += '<li>{{ $error }}</li>';
            @endforeach
                errorMessages += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Erreur de validation',
                html: errorMessages,
                confirmButtonText: 'OK'
            });
            @endif

        });
    </script>
@endpush
