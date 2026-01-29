        // Définition des étapes
        const totalSteps = 5;
        let currentStep = 1;

        // Initialisation de la date
        const today = new Date().toISOString().split("T")[0];
        document.getElementById("date_debut").setAttribute("min", today);
        document.getElementById("date_fin").setAttribute('min', today);

        // Mise à jour de la date fin lorsque date début change
        document.getElementById("date_debut").addEventListener('change', function() {
            const startDate = this.value;
            document.getElementById("date_fin").setAttribute('min', startDate);
        });

        // Fonction pour passer à l'étape suivante
        function nextStep(step) {
            // Validation basique
            if (step === 1) {
                if (!document.getElementById('marque').value) {
                    alert('Veuillez sélectionner une marque');
                    return;
                }
                if (!document.getElementById('type_marque').value) {
                    alert('Veuillez saisir le modèle');
                    return;
                }
            }

            if (step === 4) {
                if (!document.getElementById('matricule').value) {
                    alert('Veuillez saisir le matricule');
                    return;
                }
                if (!document.getElementById('prix_location').value) {
                    alert('Veuillez saisir le prix de location');
                    return;
                }
            }

            // Désactiver l'étape actuelle
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
            document.getElementById(`step-${currentStep}`).classList.remove('active');

            // Activer la nouvelle étape
            currentStep = step + 1;
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
            document.getElementById(`step-${currentStep}`).classList.add('active');

            // Mettre à jour la barre de progression
            updateProgress();
        }

        // Fonction pour revenir à l'étape précédente
        function prevStep(step) {
            // Désactiver l'étape actuelle
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
            document.getElementById(`step-${currentStep}`).classList.remove('active');
            // Activer la nouvelle étape
            currentStep = step - 1;
            document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
            document.getElementById(`step-${currentStep}`).classList.add('active');

            // Mettre à jour la barre de progression
            updateProgress();
        }
        // Mettre à jour la barre de progression
        function updateProgress() {
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            document.getElementById('progress-fill').style.height = `${progress}%`;
        }

        // Permet de cliquer sur les étapes pour naviguer
        document.querySelectorAll('.step').forEach(step => {
            step.addEventListener('click', function() {
                const stepNum = parseInt(this.getAttribute('data-step'));

                // Désactiver toutes les étapes
                document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
                document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));

                // Activer l'étape sélectionnée
                this.classList.add('active');
                document.getElementById(`step-${stepNum}`).classList.add('active');
                currentStep = stepNum;

                // Mettre à jour la barre de progression
                updateProgress();
            });
        });

        // Initialiser la barre de progression
        updateProgress();