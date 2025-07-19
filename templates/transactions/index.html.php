<main class="flex-1 p-8 overflow-y-auto">
    
    <!-- Transactions Section -->
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl p-8 shadow-xl border border-gray-100">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-8">
            Les 10 dernières transactions
        </h2>

        <!-- En-tête du tableau -->
        <div class="grid grid-cols-3 font-bold text-gray-700 border-b-2 border-gray-200 pb-4 mb-6">
            <div class="flex items-center gap-2">
                <span class="text-lg"></span>
                <span>Date</span>
            </div>
            <div class="text-center flex items-center justify-center gap-2">
                <span class="text-lg"></span>
                <span>Montant</span>
            </div>
            <div class="text-right flex items-center justify-end gap-2">
                <span>Type</span>
                <span class="text-lg"></span>
            </div>
        </div>

        <div class="space-y-3">
            <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $index => $t): ?>
                    <div class="grid grid-cols-3 items-center py-4 px-4 rounded-xl border border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 hover:border-blue-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-200 animate-fade-in-up" style="animation-delay: <?= $index * 0.1 ?>s;">
                        <!-- Date -->
                        <div class="text-gray-600 font-medium">
                            <?= date('d M Y', strtotime($t['date'])) ?>
                        </div>

                        <!-- Montant -->
                        <div class="text-center">
                            <span class="inline-block bg-gradient-to-r from-gray-800 to-gray-600 text-white px-4 py-2 rounded-xl font-semibold shadow-md">
                                <?= number_format($t['montant'], 0, ',', ' ') ?> FCFA
                            </span>
                        </div>

                        <!-- Type -->
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold uppercase tracking-wide
                                <?php
                                echo match ($t['typetransaction']) {
                                    'paiement' => 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-300',
                                    'retrait' => 'bg-gradient-to-r from-red-100 to-red-200 text-red-700 border border-red-300',
                                    'depot' => 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 border border-green-300',
                                    default => 'bg-gray-100 text-gray-500'
                                };
                                ?>">
                                <?= ucfirst(htmlspecialchars($t['typetransaction'])) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">💳</div>
                    <p class="text-gray-500 text-lg">Aucune transaction trouvée.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-8 text-right">
            <a href="/transactions" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:translate-x-1 transition-all duration-200">
                Voir plus →
            </a>
        </div>
    </div>

</main>

<style>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
    opacity: 0;
}
</style>