<?php $compte = $this->session->get('compte');
        $user=$this->session->get('user');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAX IT - Tableau de Bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans overflow-hidden">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-orange-500 text-white flex flex-col h-full">
            <!-- Logo -->
            <div class="p-6">
                <div class="bg-white text-orange-500 rounded-lg px-4 py-3 font-bold text-lg text-center">
                    MAX IT<br>
                    <span class="text-sm font-normal">SA</span>
                </div>
            </div>
            <!-- Navigation -->
            <nav class="flex-1 px-6">
                <ul class="space-y-2">
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-orange-600 bg-opacity-50">
                            <i class="fas fa-home text-lg"></i>
                            <span class="font-medium">Accueil</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-orange-600 hover:bg-opacity-50 transition-colors">
                            <i class="fas fa-exchange-alt text-lg"></i>
                            <span class="font-medium">Transactions</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-orange-600 hover:bg-opacity-50 transition-colors">
                            <i class="fas fa-wallet text-lg"></i>
                            <span class="font-medium">Mes comptes</span>
                        </a>
                    </li>
                </ul>
            </nav>
        
            <!-- Logout -->
            <div class="p-6">
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-orange-600 hover:bg-opacity-50 transition-colors">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span class="font-medium">Déconnexion</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-full">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 flex-shrink-0">
                <div class="px-8 py-4 flex items-center justify-between">
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="recherche" class="w-full pl-10 pr-4 py-2 bg-gray-100 rounded-lg border-none focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b332c1c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" 
                                 alt="User" class="w-10 h-10 rounded-full object-cover">
                            <span class="bg-orange-500 text-white px-4 py-2 rounded-lg font-medium">
                                <?= $user['prenom']; ?> <?= $user['nom'] ?>
                            </span>
                        </div>
                        <i class="fas fa-bell text-gray-400 text-xl"></i>
                    </div>
                </div>
            </header>
         
            <!-- Dashboard Content -->
          
            <main class="flex-1 p-8 overflow-y-auto">
                <!-- Account Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Main Account -->
                    <div class="bg-orange-500 text-white rounded-2xl p-6">
                        <h3 class="text-xl font-semibold mb-2">Compte Principal</h3>
                        <p class="text-lg font-medium">
                            <?= $compte['numerotel']?>
                        </p>
                    </div>
                    
                    <!-- Balance -->
                    <div class="bg-orange-500 text-white rounded-2xl p-6">
                        <h3 class="text-xl font-semibold mb-2">Solde : <?= $compte['solde']?> fcfa</h3>
                    </div>
                    
                    <!-- QR Code -->
                    <div class="bg-orange-500 text-white rounded-2xl p-6 flex items-center justify-between">
                        <div class="bg-white text-orange-500 rounded-lg px-4 py-3 font-bold text-lg">
                            MAX IT<br>
                            <span class="text-sm font-normal">SA</span>
                        </div>
                        <div class="w-20 h-20 bg-white rounded-lg flex items-center justify-center">
                            <div class="grid grid-cols-8 gap-1">
                                <!-- Placeholder QR code -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-4 mb-8">
                    <button class="flex items-center space-x-2 bg-white border border-orange-500 text-orange-500 px-6 py-3 rounded-full hover:bg-orange-50 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Créer un compte secondaire</span>
                    </button>
                    <button class="flex items-center space-x-2 bg-white border border-orange-500 text-orange-500 px-6 py-3 rounded-full hover:bg-orange-50 transition-colors">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Changer de compte</span>
                    </button>
                </div>
                <?php
                echo $ContentForLayout;
                ?>
            </main>
            <
        </div>
    </div>
</body>
</html>