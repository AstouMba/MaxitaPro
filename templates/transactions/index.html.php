
<main class="flex-1 p-8 overflow-y-auto">
    <!-- Account Cards -->
    <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-orange-500 text-white rounded-2xl p-6">
            <h3 class="text-xl font-semibold mb-2">Compte Principal</h3>
            <p class="text-lg font-medium">
              
                <?= $_SESSION['client'] ? htmlspecialchars($_SESSION['client']['telephone']) : '---' ?>
            </p>
        </div>

       
        <div class="bg-orange-500 text-white rounded-2xl p-6">
            <h3 class="text-xl font-semibold mb-2">
                Solde :
                <?= isset($solde) ? number_format($solde, 0, ',', ' ') . ' FCFA' : '0.00 FCFA' ?>
            </h3>
        </div>


       
        <div class="bg-orange-500 text-white rounded-2xl p-6 flex items-center justify-between">
            <div class="bg-white text-orange-500 rounded-lg px-4 py-3 font-bold text-lg">
                MAX IT<br>
                <span class="text-sm font-normal">SA</span>
            </div>
            <div class="w-20 h-20 bg-white rounded-lg flex items-center justify-center">
                <div class="grid grid-cols-8 gap-1">
               
                </div>
            </div>
        </div>
    </div> -->

    <!-- Action Buttons -->
    <!-- <div class="flex gap-4 mb-8">
        <button
            class="flex items-center space-x-2 bg-white border border-orange-500 text-orange-500 px-6 py-3 rounded-full hover:bg-orange-50 transition-colors">
            <i class="fas fa-plus"></i>
            <span>Créer un compte secondaire</span>
        </button>
        <button
            class="flex items-center space-x-2 bg-white border border-orange-500 text-orange-500 px-6 py-3 rounded-full hover:bg-orange-50 transition-colors">
            <i class="fas fa-exchange-alt"></i>
            <span>Changer de compte</span>
        </button>
    </div> -->

    <!-- Transactions Section -->
    <div class="bg-white rounded-3xl p-8 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Les 10 dernières transactions</h2>

        <!-- Exemple d'une transaction statique -->
        <div class="space-y-4">
            <?php  if(!empty($transactions)): ?>
                <?php foreach ($transactions as $t): ?>
                    <div class="flex items-center justify-between py-4 border-b border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-credit-card text-gray-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800"><?= ucfirst(htmlspecialchars($t['type'])) ?></h4>
                                <p class="text-orange-500 text-sm">
                                    <?= date('d M Y', strtotime($t['date_creation'])) ?>
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold <?= $t['type'] === 'retrait' ? 'text-red-500' : 'text-green-600' ?>">
                                <?= ($t['type'] === 'retrait' ? '-' : '+') . number_format($t['montant'], 0, ',', ' ') ?> fcfa
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">Aucune transaction trouvée.</p>
            <?php endif; ?>
        </div>
        <div class="mt-4 text-right">
            <a href="/transactions" class="text-orange-600 hover:underline font-medium">Voir plus &rarr;</a>
        </div>


    </div>
</main>