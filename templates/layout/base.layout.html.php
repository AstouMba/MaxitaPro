<?php
$compte = $this->session->get('compte');
$user = $this->session->get('user');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAX IT - Tableau de Bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .animate-slide-in {
            animation: slideIn 0.6s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .gradient-card {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            box-shadow: 0 20px 40px rgba(249, 115, 22, 0.3);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(249, 115, 22, 0.4);
        }

        .sidebar-item {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-item:hover::before {
            left: 100%;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .pulse-ring {
            animation: pulse-ring 2s infinite;
        }



        .search-focus {
            transition: all 0.3s ease;
        }

        .search-focus:focus {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.2);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans overflow-hidden">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-orange-500 to-orange-600 text-white flex flex-col h-full shadow-2xl">
            <!-- Logo -->
            <div class="p-6 animate-slide-in">
                <div
                    class="bg-white text-orange-500 rounded-xl px-4 py-3 font-bold text-lg text-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                    MAX IT<br>
                    <span class="text-sm font-normal">SA</span>
                </div>
            </div>

            <?php
// Fonction pour ajouter les classes si le lien correspond à la page actuelle
function isActive(string $path): string {
    $currentUrl = strtok($_SERVER['REQUEST_URI'], '?'); // Enlève les éventuels paramètres GET
    return $currentUrl === $path
        ? 'bg-gradient-to-r from-orange-600 to-orange-700 shadow-lg'
        : 'hover:bg-gradient-to-r from-orange-600 to-orange-700 hover:shadow-lg transition-all duration-300';
}
?>

<!-- Navigation -->
<nav class="flex-1 px-6">
    <ul class="space-y-3">
        <li class="animate-slide-in" style="animation-delay: 0.1s;">
            <a href="/transaction"
               class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl <?= isActive('/transaction') ?>">
                <i class="fas fa-home text-lg"></i>
                <span class="font-medium">Accueil</span>
            </a>
        </li>

        <li class="animate-slide-in" style="animation-delay: 0.2s;">
            <a href="/transaction-mode"
               class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl">
                <i class="fas fa-exchange-alt text-lg"></i>
                <span class="font-medium">Transactions</span>
            </a>
        </li>

        <li class="animate-slide-in" style="animation-delay: 0.3s;">
            <a href="/compte/listeCompte"
               class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl <?= isActive('/compte/listeCompte') ?>">
                <i class="fas fa-wallet text-lg"></i>
                <span class="font-medium">Mes comptes</span>
            </a>
        </li>
    </ul>
</nav>


            <!-- Logout -->
            <div class="p-6 animate-slide-in" style="animation-delay: 0.4s;">
                <a href="/logout"
                    class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-xl hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span class="font-medium">Déconnexion</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-full">
            <!-- Header -->
            <header class="bg-white shadow-xl border-b border-gray-200 flex-shrink-0 animate-fade-in">
                <div class="px-8 py-6 flex items-center justify-between">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <div class="text-xl font-semibold text-gray-700  py-3 px-4 rounded-xl shadow-sm">
                                Bienvenue sur <span class="text-orange-500 font-bold">MAXIT SA</span>
                            </div>
                        </div>
                    </div>


                    <!-- User Info -->
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-4">

                            <div
                                class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-xl font-medium shadow-lg">
                                <?= htmlspecialchars($user->getPrenom() ?? '') ?>
                                <?= htmlspecialchars($user->getNom() ?? '') ?>
                            </div>
                        </div>
                        <div class="relative">
                            <i
                                class="fas fa-bell text-gray-400 text-xl hover:text-orange-500 transition-colors cursor-pointer"></i>
                            <span
                                class="absolute -top-2 -right-2 w-5 h-5 text-white text-xs flex items-center justify-center"></span>
                        </div>
                    </div>
                </div>

                <!-- Account Cards -->
                <?php if ($compte): ?>
                    <div class="px-8 pb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                            <!-- Main Account -->
                            <div class="gradient-card hover-lift text-white rounded-2xl p-6 animate-fade-in"
                                style="animation-delay: 0.1s;">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-semibold">Compte Principal</h3>
                                    <i class="fas fa-user-circle text-2xl opacity-70"></i>
                                </div>
                                <p class="text-lg font-medium opacity-90">
                                    <?= htmlspecialchars($compte['numerotel']) ?>
                                </p>
                            </div>

                            <!-- Balance -->
                            <div class="gradient-card hover-lift text-white rounded-2xl p-6 animate-fade-in"
                                style="animation-delay: 0.2s;">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-semibold">Solde Actuel</h3>
                                    <button id="toggleSolde" class="focus:outline-none">
                                        <i class="fas fa-eye text-2xl opacity-70"></i>
                                    </button>
                                </div>
                                <p id="solde" class="text-2xl font-bold">
                                    <?= number_format($compte['solde'], 0, ',', ' ') ?> <span
                                        class="text-sm font-normal">FCFA</span>
                                </p>
                            </div>


                            <!-- QR Code -->
                            <div class="gradient-card hover-lift text-white rounded-2xl p-6 flex items-center justify-between animate-fade-in"
                                style="animation-delay: 0.3s;">
                                <div class="bg-white text-orange-500 rounded-xl px-4 py-3 font-bold text-lg shadow-lg">
                                    MAX IT<br>
                                    <span class="text-sm font-normal">SA</span>
                                </div>
                                <div
                                    class="w-20 h-20 bg-white rounded-xl flex items-center justify-center text-orange-500 font-bold text-lg shadow-lg hover:scale-105 transition-transform duration-300 cursor-pointer">
                                    <i class="fas fa-qrcode text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 animate-fade-in" style="animation-delay: 0.4s;">
                            <a href="/ajouterCompte"
                                class="flex items-center space-x-2 bg-white border-2 border-orange-500 text-orange-500 px-6 py-3 rounded-full hover:bg-orange-500 hover:text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-plus"></i>
                                <span class="font-medium">Créer un compte secondaire</span>
                            </a>


                            <button
                                class="flex items-center space-x-2 bg-white border-2 border-orange-500 text-orange-500 px-6 py-3 rounded-full hover:bg-orange-500 hover:text-white hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-exchange-alt"></i>
                                <span class="font-medium">Changer de compte</span>
                            </button>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="px-8 pb-6">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                <p class="text-red-700 font-medium">Aucun compte disponible.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 p-8 overflow-y-auto">
                <div class="animate-fade-in" style="animation-delay: 0.5s;">
                    <?php echo $ContentForLayout; ?>
                </div>
            </main>

        </div>
    </div>
    <script>
        const solde = <?= json_encode(number_format($compte['solde'], 0, ',', ' ')) ?>;
        const soldeEl = document.getElementById('solde');
        const toggleSoldeBtn = document.getElementById('toggleSolde');
        let soldeVisible = true;

        toggleSoldeBtn.addEventListener('click', () => {
            soldeVisible = !soldeVisible;
            soldeEl.textContent = soldeVisible ? `${solde} FCFA` : '** FCFA';
            toggleSoldeBtn.innerHTML = `<i class="fas fa-eye${soldeVisible ? '' : '-slash'} text-2xl opacity-70"></i>`;
        });
    </script>

</body>

</html>