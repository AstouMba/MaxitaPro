<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Comptes Secondaires</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-500 min-h-screen p-4">
    <div class="w-full bg-white rounded-3xl shadow-lg p-8 min-h-[calc(100vh-2rem)]">

        <!-- Titre -->
        <h2 class="text-center text-2xl font-bold text-gray-900 mb-8">
            Liste des comptes secondaires
        </h2>

        <!-- Contenu conditionnel -->
        <div id="comptes-container">
            <!-- Message par défaut si aucun compte -->
            <div id="no-comptes" class="text-center py-8">
                <p class="text-gray-600 text-lg">Aucun compte secondaire trouvé.</p>
            </div>

            <!-- Liste des comptes (cachée par défaut) -->
            <div id="listeSecondaires" class="hidden space-y-4">
            </div>
        </div>
    </div>

    <script>
        // Structure pour afficher les comptes (sans données initiales)
        function afficherComptes(comptes) {
            const noComptesDiv = document.getElementById('no-comptes');
            const comptesListDiv = document.getElementById('comptes-list');
            
            if (comptes.length === 0) {
                noComptesDiv.classList.remove('hidden');
                comptesListDiv.classList.add('hidden');
            } else {
                noComptesDiv.classList.add('hidden');
                comptesListDiv.classList.remove('hidden');
                
                comptesListDiv.innerHTML = '';
                
                comptes.forEach(compte => {
                    const compteElement = document.createElement('div');
                    compteElement.className = 'bg-gray-50 rounded-xl p-4 border-l-4 border-orange-500';
                    compteElement.innerHTML = `
                        <div class="flex flex-wrap gap-4 text-sm">
                            <div class="font-semibold text-gray-700">
                                <span class="text-orange-600">ID:</span> ${compte.id}
                            </div>
                            <div class="text-gray-600">
                                <span class="font-medium">Créé le:</span> ${compte.datecreation}
                            </div>
                            <div class="text-gray-600">
                                <span class="font-medium">Solde:</span> ${compte.solde} FCFA
                            </div>
                            <div class="text-gray-600">
                                <span class="font-medium">Téléphone:</span> ${compte.numerotel}
                            </div>
                        </div>
                    `;
                    comptesListDiv.appendChild(compteElement);
                });
            }
        }

        // Initialisation avec tableau vide (pas de données par défaut)
        document.addEventListener('DOMContentLoaded', function() {
            afficherComptes([]);
        });

       
    </script>
</body>
</html>