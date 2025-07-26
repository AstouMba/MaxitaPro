document.addEventListener('DOMContentLoaded', function() {
    const formIdentite = document.getElementById('form_identite');
    const formInscription = document.getElementById('form_inscription');
    const numeroIdentiteInput = document.querySelector('#form_identite input[name="numero_cni"]');
    const errorMessage = document.querySelector('#form_identite .error-message');

    // Fonction pour afficher le spinner
    function showSpinner() {
        const button = document.getElementById('search-button');
        const searchIcon = document.getElementById('search-icon');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('button-text');
        
        button.disabled = true;
        searchIcon.classList.add('hidden');
        spinner.classList.remove('hidden');
        buttonText.textContent = 'Recherche en cours...';
    }

    // Fonction pour masquer le spinner
    function hideSpinner() {
        const button = document.getElementById('search-button');
        const searchIcon = document.getElementById('search-icon');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('button-text');
        
        button.disabled = false;
        searchIcon.classList.remove('hidden');
        spinner.classList.add('hidden');
        buttonText.textContent = 'Rechercher';
    }
    
    // Validation du format CNI
    function validateCNI(cni) {
        return /^1\d{12}$/.test(cni);
    }
    
    // Affichage des messages d'erreur
    function showError(message) {
        errorMessage.style.display = 'flex';
        errorMessage.querySelector('p').textContent = message;
    }
    
    function hideError() {
        errorMessage.style.display = 'none';
    }
    
    // Fonction pour remplir le formulaire d'inscription avec les données
    function remplirFormulaireInscription(data) {
        // Remplir les champs du formulaire d'inscription
        document.querySelector('#form_inscription input[name="nom"]').value = data.nom || '';
        document.querySelector('#form_inscription input[name="prenom"]').value = data.prenom || '';
        document.querySelector('#form_inscription input[name="telephone"]').value = data.telephone || '';
        document.querySelector('#form_inscription input[name="numero_identite"]').value = data.numero_identite || '';
        
        // Note: Les champs login et password restent vides pour que l'utilisateur les saisisse
    }
    
    // Fonction pour basculer entre les formulaires
    function basculerVersInscription() {
        formIdentite.classList.add('hidden');
        formInscription.classList.remove('hidden');
        
        // Afficher le message de succès
        // const successMessage = document.getElementById('success-message');
        // if (successMessage) {
        //     successMessage.classList.remove('hidden');
        // }
    }
    
    // Fonction de recherche de citoyen (appelée par oninput)
    window.chercherCitoyen = async function() {
        const cni = numeroIdentiteInput.value.trim();
        
        // Masquer l'erreur précédente
        hideError();
        
        // Vérifier si le CNI a au moins 5 caractères avant de faire la recherche
        // if (cni.length < 5) {
        //     return;
        // }
        
        // Valider le format CNI complet si saisi entièrement
        if (cni.length === 13 && !validateCNI(cni)) {
            showError('Format CNI invalide. Le numéro doit commencer par 1 et contenir 13 chiffres.');
            return;
        }
        
        // Faire la recherche si CNI complet
        if (cni.length === 13) {
            showSpinner();
            // alert(`Recherche en cours pour le CNI: ${cni}`);
            try {
                // Remplacez cette URL par votre endpoint réel
                const response = await fetch(`https://appdaf-g15c.onrender.com/api/citoyen/${cni}`);
                const data = await response.json();
                
                if (data.statut === 'success') {
                    // Remplir le formulaire d'inscription avec les données trouvées
                    remplirFormulaireInscription(data.data);
                    
                    // Passer au formulaire d'inscription
                    basculerVersInscription();
                    
                } else {
                    showError(data.message || 'Aucun citoyen trouvé avec ce numéro de CNI');
                }
            } catch (error) {
                showError('Erreur de connexion au serveur');
                console.error('Erreur:', error);
            } finally{
                hideSpinner();
            }
        }
    };
    
    // Gestion du formulaire de recherche CNI
    const formRecherche = document.querySelector('#form_identite form');
    if (formRecherche) {
        formRecherche.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const cni = numeroIdentiteInput.value.trim();
            
            if (!validateCNI(cni)) {
                showError('Format CNI invalide. Le numéro doit commencer par 1 et contenir 13 chiffres.');
                return;
            }
            
            // Déclencher la recherche
            await chercherCitoyen();
        });
    }
    
    // Gestion du retour vers le formulaire de recherche (optionnel)
    window.retourRecherche = function() {
        formInscription.classList.add('hidden');
        formIdentite.classList.remove('hidden');
        
        // Réinitialiser le champ de recherche
        numeroIdentiteInput.value = '';
        hideError();
    };
    
    // Gestion du formulaire d'inscription
    const formInscriptionElement = document.querySelector('#form_inscription form');
    if (formInscriptionElement) {
        formInscriptionElement.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Ici vous pouvez ajouter la logique de soumission du formulaire d'inscription
            // Par exemple, validation des champs, envoi des données au serveur, etc.
            
            console.log('Formulaire d\'inscription soumis');
            
            // Exemple de validation simple
            const login = document.querySelector('#form_inscription input[name="login"]').value.trim();
            const password = document.querySelector('#form_inscription input[name="password"]').value.trim();
            
            // if (!login || !password) {
            //     alert('Veuillez remplir tous les champs obligatoires');
            //     return;
            // }
            
            // Soumettre le formulaire (remplacez par votre logique)
            // this.submit();
        });
    }
    
    // Fonction utilitaire pour afficher/masquer les messages d'erreur sur les champs
    window.toggleFieldError = function(fieldName, show, message = '') {
        const field = document.querySelector(`input[name="${fieldName}"]`);
        if (field) {
            const errorDiv = field.closest('.space-y-2').querySelector('.error-message');
            if (errorDiv) {
                if (show) {
                    errorDiv.classList.remove('hidden');
                    if (message) {
                        errorDiv.querySelector('p').textContent = message;
                    }
                } else {
                    errorDiv.classList.add('hidden');
                }
            }
        }
    };
});