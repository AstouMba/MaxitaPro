<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Comptes Secondaires</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 min-h-screen p-4">
    <div class="w-full h-full">
        <!-- Header avec logo Maxitsa -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
            </div>
        </div>
        <div class="text-white/90">
            <i class="fas fa-user-circle text-lg mr-2"></i>
            <span class="text-sm">Mon Compte</span>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[calc(100vh-8rem)] flex flex-col">
        <!-- En-tête stylisé -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-8">
            <h2 class="text-white text-3xl font-bold flex items-center">
                <i class="fas fa-list-ul mr-4 text-2xl"></i>
                Mes Comptes
            </h2>
            <p class="text-orange-100 mt-2 text-lg">Gestion de vos comptes associés</p>
        </div>

        <!-- Contenu principal -->
        <div class="p-8 flex-1">
            <!-- Table stylisée -->
            <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-inner">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="px-8 py-5 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-phone mr-3 text-orange-400"></i>Téléphone
                                </th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-money-bill-wave mr-3 text-orange-400"></i>Solde
                                </th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-3 text-orange-400"></i>État
                                </th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-star mr-3 text-orange-400"></i>Principal
                                </th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-3 text-orange-400"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($comptes as $compte): ?>
                                <?php if (count($compte) > 0): ?>
                                    <tr class="hover:bg-orange-50 transition-all duration-300 hover:shadow-md">
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-4 shadow-sm">
                                                    <i class="fas fa-mobile-alt text-orange-600 text-lg"></i>
                                                </div>
                                                <span
                                                    class="text-gray-900 font-semibold text-lg"><?= $compte['numerotel'] ?></span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span
                                                    class="text-2xl font-bold text-green-600 mr-2"><?= $compte['solde'] ?></span>
                                                <span class="text-green-500 font-medium">FCFA</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 shadow-sm">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                <?= $compte['typecompte'] ?>
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <?php if ($compte['principal'] ?? false): ?>
                                                <span
                                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 shadow-sm">
                                                    <i class="fas fa-crown mr-2"></i>
                                                    Principal
                                                </span>
                                            <?php else: ?>
                                                <span class="text-gray-400 font-medium">
                                                    <i class="fas fa-minus mr-2"></i>
                                                    Secondaire
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <?php if (!($compte['principal'] ?? false)): ?>
                                                <?php if (!($compte['principal'] ?? false)): ?>
                                                    <a href="/compte/switchCompte?id=<?= $compte['id'] ?>"
                                                        class="bg-orange-500 hover:bg-orange-600 text-white px-2 py-2 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center text-sm">
                                                        <i class="fas fa-exchange-alt mr-2"></i>
                                                        Basculer en Principal </a>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-sm font-medium">
                                                        <i class="fas fa-check mr-2"></i>
                                                        Compte Principal
                                                    </span>
                                                <?php endif; ?>

                                            <?php else: ?>
                                                <span class="text-gray-400 text-sm font-medium">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Compte Principal
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Message si aucun compte (optionnel) -->
            <div id="no-comptes" class="hidden text-center py-16">
                <div
                    class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-inbox text-orange-500 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucun compte trouvé</h3>
                <p class="text-gray-600 text-lg">Vous n'avez pas encore de comptes secondaires.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 px-8 py-6 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-gray-600 flex items-center">
                    <i class="fas fa-clock mr-2 text-orange-500"></i>
                    Dernière mise à jour: <?= date('d/m/Y à H:i') ?>
                </p>
                <button
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-refresh mr-2"></i>
                    Actualiser
                </button>
            </div>
        </div>
    </div>
    </div>
</body>

</html>