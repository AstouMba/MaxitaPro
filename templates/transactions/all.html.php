<!-- Transactions Section -->
<div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl p-8 shadow-xl border border-gray-100">

    <!-- Titre -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
            Toutes les transactions
        </h2>
    </div>

    <div class="filter-section mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
            <h3 class="text-lg font-semibold text-gray-700">Filtres</h3>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!--  Filtre par date -->
            <div class="space-y-2">
                <label for="filter-date" class="block text-sm font-medium text-gray-700">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Filtrer par date
                    </span>
                </label>
                <input type="text" id="filter-date"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-200" />
            </div>

            <!--  Filtre par type -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Type de transaction
                    </span>
                </label>
                <div class="flex flex-wrap gap-2">
                    <button class="btn-filter active" data-type="">Tous</button>
                    <button class="btn-filter" data-type="depot">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            Dépôt
                        </span>
                    </button>
                    <button class="btn-filter" data-type="retrait">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            Retrait
                        </span>
                    </button>
                    <button class="btn-filter" data-type="paiement">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
                            Paiement
                        </span>
                    </button>
                </div>
            </div>

            <!--  Actions -->
            <div class="space-y-2">
                <div>
                    <button id="reset-filters"
                        class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-4 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- En-tête -->
    <div class="grid grid-cols-3 font-bold text-gray-700 border-b-2 border-gray-200 pb-4 mb-6">
        <div>Date</div>
        <div class="text-center">Montant</div>
        <div class="text-right">Type</div>
    </div>

    <!-- Liste transactions -->
    <div class="space-y-3">
        <?php if (!empty($alltransactions)): ?>
            <?php foreach ($alltransactions as $index => $t): ?>
                <div class="transaction-item grid grid-cols-3 items-center py-4 px-4 rounded-xl border border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 hover:border-blue-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-200 animate-fade-in-up"
                    style="animation-delay: <?= $index * 0.1 ?>s;"
                    data-date="<?= date('Y-m-d', strtotime($t['date'])) ?>"
                    data-type="<?= strtolower($t['typetransaction']) ?>">

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

    <!-- Bouton retour -->
    <div class="mt-8 text-right">
        <a href="/transaction"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-x-1 transition-all duration-200">
            ← Retour
        </a>
    </div>
</div>

<!-- Animation -->
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
/* Boutons filtre stylés */
.btn-filter {
    @apply px-4 py-2 rounded-xl text-sm font-medium shadow border transition hover:bg-orange-100 hover:border-orange-300;
    background-color: white;
    border-color: #ddd;
}
.btn-filter.active {
    @apply bg-orange-500 text-white border-orange-600 shadow-md;
}
</style>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('filter-date');
    const filterButtons = document.querySelectorAll('.btn-filter');
    const resetButton = document.getElementById('reset-filters');
    const transactionItems = document.querySelectorAll('.transaction-item');

    let selectedType = '';

    function filterTransactions() {
        const selectedDate = dateInput.value;

        transactionItems.forEach(item => {
            const itemDate = item.dataset.date;
            const itemType = item.dataset.type;

            const matchDate = !selectedDate || itemDate === selectedDate;
            const matchType = !selectedType || itemType === selectedType;

            item.style.display = (matchDate && matchType) ? '' : 'none';
        });
    }

    // Gestion des boutons type
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            selectedType = button.dataset.type;
            filterTransactions();
        });
    });

    dateInput.addEventListener('change', filterTransactions);

    resetButton.addEventListener('click', () => {
        dateInput.value = '';
        selectedType = '';
        filterButtons.forEach(btn => btn.classList.remove('active'));
        filterButtons[0].classList.add('active'); // "Tous"
        filterTransactions();
    });
});
</script>
