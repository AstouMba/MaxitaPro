<!-- Transaction Type Tabs -->
<div class="mb-8 animate-fade-in">
    <div class="flex space-x-2 bg-gray-200 p-2 rounded-xl">
        <button onclick="showTab('depot')" id="tab-depot" class="tab-btn flex-1 py-3 px-6 rounded-lg font-semibold text-center transition-all duration-300 tab-active">
            <i class="fas fa-arrow-down mr-2"></i>Dépôt
        </button>
        <button onclick="showTab('retrait')" id="tab-retrait" class="tab-btn flex-1 py-3 px-6 rounded-lg font-semibold text-center transition-all duration-300">
            <i class="fas fa-arrow-up mr-2"></i>Retrait
        </button>
        <button onclick="showTab('paiement')" id="tab-paiement" class="tab-btn flex-1 py-3 px-6 rounded-lg font-semibold text-center transition-all duration-300">
            <i class="fas fa-credit-card mr-2"></i>Paiement
        </button>
        <button onclick="showTab('annulation')" id="tab-annulation" class="tab-btn flex-1 py-3 px-6 rounded-lg font-semibold text-center transition-all duration-300">
            <i class="fas fa-times-circle mr-2"></i>Annuler
        </button>
    </div>
</div>

<!-- Transaction Forms -->
<div class="space-y-8">
    <!-- Dépôt Form -->
    <div id="depot-form" class="transaction-form">
        <div class="transaction-card p-8 bg-white rounded-2xl shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Effectuer un Dépôt</h2>
                    <p class="text-gray-600">Ajoutez de l'argent à votre compte principal ou secondaire</p>
                </div>
            </div>

            <form action="/transaction/depot" method="POST" class="space-y-6">
                <!-- Sélection du compte destinataire -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-4">Compte destinataire</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if ($compte): ?>
                        <!-- Compte Principal -->
                        <div class="account-option p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-orange-500 transition-all duration-300" 
                             onclick="selectAccount('principal', '<?= htmlspecialchars($compte['numerotel']) ?>')">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-star text-orange-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Compte Principal</p>
                                    <p class="text-sm text-gray-600"><?= htmlspecialchars($compte['numerotel']) ?></p>
                                    <p class="text-xs text-green-600 font-medium">Solde: <?= number_format($compte['solde'], 0, ',', ' ') ?> FCFA</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Comptes Secondaires -->
                        <?php if (isset($comptesSecondaires) && !empty($comptesSecondaires)): ?>
                            <?php foreach ($comptesSecondaires as $compteSecondaire): ?>
                            <div class="account-option p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-orange-500 transition-all duration-300" 
                                 onclick="selectAccount('secondaire', '<?= htmlspecialchars($compteSecondaire['numerotel']) ?>')">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-wallet text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Compte Secondaire</p>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($compteSecondaire['numerotel']) ?></p>
                                        <p class="text-xs text-green-600 font-medium">Solde: <?= number_format($compteSecondaire['solde'], 0, ',', ' ') ?> FCFA</p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <div class="p-4 border-2 border-dashed border-gray-300 rounded-xl text-center">
                            <i class="fas fa-plus-circle text-gray-400 text-2xl mb-2"></i>
                            <p class="text-gray-500 text-sm">Aucun compte secondaire</p>
                            <a href="/ajouterCompte" class="text-orange-500 text-sm hover:underline">Créer un compte</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <input type="hidden" name="compte_destinataire" id="compte-destinataire">
                <input type="hidden" name="type_compte" id="type-compte">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Montant (FCFA)</label>
                        <input type="number" name="montant" required min="100" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ex: 10000">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Code de confirmation</label>
                        <input type="password" name="code" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="****">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description (optionnelle)</label>
                    <textarea name="description" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                              placeholder="Raison du dépôt..."></textarea>
                </div>
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transform hover:-translate-y-1 transition-all duration-300 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Effectuer le Dépôt
                </button>
            </form>
        </div>
    </div>

    <!-- Retrait Form -->
    <div id="retrait-form" class="transaction-form hidden">
        <div class="transaction-card p-8 bg-white rounded-2xl shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Effectuer un Retrait</h2>
                    <p class="text-gray-600">Retirez de l'argent de votre compte</p>
                </div>
            </div>

            <form action="/transaction/retrait" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Montant (FCFA)</label>
                        <input type="number" name="montant" required min="100" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ex: 5000">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Code PIN</label>
                        <input type="password" name="pin" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="****">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Point de retrait</label>
                    <select name="point_retrait" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300">
                        <option value="">Sélectionner un point de retrait</option>
                        <option value="agence_plateau">Agence Plateau</option>
                        <option value="agence_medina">Agence Médina</option>
                        <option value="agence_parcelles">Agence Parcelles Assainies</option>
                        <option value="distributeur_auto">Distributeur automatique</option>
                    </select>
                </div>
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-4 px-6 rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transform hover:-translate-y-1 transition-all duration-300 shadow-lg">
                    <i class="fas fa-minus mr-2"></i>Effectuer le Retrait
                </button>
            </form>
        </div>
    </div>

    <!-- Paiement Form -->
    <div id="paiement-form" class="transaction-form hidden">
        <div class="transaction-card p-8 bg-white rounded-2xl shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Effectuer un Paiement</h2>
                    <p class="text-gray-600">Payez vos factures et services</p>
                </div>
            </div>

            <!-- Service Selection -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-4">Sélectionner un service</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button onclick="selectService('woyofal')" id="service-woyofal" 
                            class="service-btn p-4 border-2 border-gray-200 rounded-xl hover:border-orange-500 transition-all duration-300 text-center">
                        <i class="fas fa-lightbulb text-2xl text-yellow-500 mb-2"></i>
                        <p class="font-semibold text-sm">Woyofal</p>
                    </button>
                    <button onclick="selectService('senelec')" id="service-senelec" 
                            class="service-btn p-4 border-2 border-gray-200 rounded-xl hover:border-orange-500 transition-all duration-300 text-center">
                        <i class="fas fa-bolt text-2xl text-blue-500 mb-2"></i>
                        <p class="font-semibold text-sm">SENELEC</p>
                    </button>
                    <button onclick="selectService('sen_eau')" id="service-sen_eau" 
                            class="service-btn p-4 border-2 border-gray-200 rounded-xl hover:border-orange-500 transition-all duration-300 text-center">
                        <i class="fas fa-tint text-2xl text-cyan-500 mb-2"></i>
                        <p class="font-semibold text-sm">SEN'EAU</p>
                    </button>
                    <button onclick="selectService('orange')" id="service-orange" 
                            class="service-btn p-4 border-2 border-gray-200 rounded-xl hover:border-orange-500 transition-all duration-300 text-center">
                        <i class="fas fa-mobile-alt text-2xl text-orange-500 mb-2"></i>
                        <p class="font-semibold text-sm">Orange</p>
                    </button>
                </div>
            </div>

            <form action="/transaction/paiement" method="POST" class="space-y-6">
                <input type="hidden" name="service" id="selected-service">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Numéro de référence</label>
                        <input type="text" name="reference" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ex: 001234567890">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Montant (FCFA)</label>
                        <input type="number" name="montant" required min="100" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ex: 15000">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Code PIN</label>
                    <input type="password" name="pin" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                           placeholder="****">
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-4 px-6 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transform hover:-translate-y-1 transition-all duration-300 shadow-lg">
                    <i class="fas fa-credit-card mr-2"></i>Effectuer le Paiement
                </button>
            </form>
        </div>
    </div>

    <!-- Annulation Form -->
    <div id="annulation-form" class="transaction-form hidden">
        <div class="transaction-card p-8 bg-white rounded-2xl shadow-xl">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Annuler une Transaction</h2>
                    <p class="text-gray-600">Annulez un dépôt non encore retiré</p>
                </div>
            </div>

            <!-- Recherche de transaction -->
            <div class="mb-6">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Code de transaction</label>
                        <input type="text" id="search-transaction" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                               placeholder="Ex: TXN123456789">
                    </div>
                    <div class="flex items-end">
                        <button onclick="searchTransaction()" 
                                class="px-6 py-3 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                    </div>
                </div>
            </div>

            <!-- Résultats de recherche -->
            <div id="transaction-result" class="hidden mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-800">Transaction trouvée</h4>
                        <span id="transaction-status" class="px-3 py-1 rounded-full text-sm font-medium"></span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Code de transaction</p>
                            <p id="found-code" class="font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Montant</p>
                            <p id="found-amount" class="font-semibold text-green-600"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date</p>
                            <p id="found-date" class="font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Compte destinataire</p>
                            <p id="found-account" class="font-semibold"></p>
                        </div>
                    </div>

                    <div id="cancel-section" class="hidden">
                        <form action="/transaction/annuler" method="POST" class="space-y-4">
                            <input type="hidden" name="transaction_id" id="cancel-transaction-id">
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Raison de l'annulation</label>
                                <select name="raison" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300">
                                    <option value="">Sélectionner une raison</option>
                                    <option value="erreur_montant">Erreur de montant</option>
                                    <option value="mauvais_compte">Mauvais compte destinataire</option>
                                    <option value="transaction_duplicate">Transaction en double</option>
                                    <option value="demande_client">Demande du client</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Code PIN de confirmation</label>
                                <input type="password" name="pin" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300"
                                       placeholder="****">
                            </div>
                            
                            <div class="flex gap-4">
                                <button type="button" onclick="cancelSearch()" 
                                        class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-xl font-semibold hover:bg-gray-600 transition-all duration-300">
                                    Annuler
                                </button>
                                <button type="submit" 
                                        class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-300">
                                    <i class="fas fa-times mr-2"></i>Confirmer l'annulation
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="cannot-cancel" class="hidden">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-red-500 mt-1 mr-3"></i>
                                <div>
                                    <h5 class="font-semibold text-red-800">Impossible d'annuler</h5>
                                    <p class="text-red-700 text-sm mt-1">Cette transaction ne peut pas être annulée car elle a déjà été retirée ou traitée.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions annulables récentes -->
            <div>
                <h4 class="font-semibold text-gray-800 mb-4">Dépôts récents annulables</h4>
                <div class="space-y-3" id="recent-deposits">
                    <!-- Exemple de transaction annulable -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-arrow-down text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold">TXN202412250001</p>
                                <p class="text-sm text-gray-600">Dépôt - Aujourd'hui, 14:30</p>
                                <p class="text-xs text-orange-600 font-medium">En attente de retrait</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <p class="font-bold text-green-600">25,000 FCFA</p>
                                <p class="text-sm text-gray-600">Vers: ***2345</p>
                            </div>
                            <button onclick="quickCancel('TXN202412250001')" 
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-300 text-sm">
                                <i class="fas fa-times mr-1"></i>Annuler
                            </button>
                        </div>
                    </div>
                    
                    <!-- Message si aucune transaction -->
                    <div class="text-center py-8 text-gray-500" id="no-cancelable-transactions">
                        <i class="fas fa-check-circle text-4xl mb-3 text-gray-300"></i>
                        <p>Aucune transaction de dépôt en attente</p>
                        <p class="text-sm">Toutes vos transactions ont été traitées</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions (reste identique) -->
<div class="mt-12 animate-fade-in" style="animation-delay: 0.3s;">
    <div class="transaction-card p-8 bg-white rounded-2xl shadow-xl">
        <h3 class="text-xl font-bold text-gray-800 mb-6">
            <i class="fas fa-history mr-2 text-orange-500"></i>Transactions Récentes
        </h3>
        <div class="space-y-4">
            <!-- Sample transactions -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-arrow-down text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Dépôt</p>
                        <p class="text-sm text-gray-600">Aujourd'hui, 14:30</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-green-600">+25,000 FCFA</p>
                    <p class="text-sm text-gray-600">Réussi</p>
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="/transaction/historique" 
                   class="text-orange-500 hover:text-orange-600 font-semibold transition-colors duration-300">
                    Voir tout l'historique →
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.tab-active {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
}

.transaction-card {
    transition: all 0.3s ease;
}

.transaction-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.account-option.selected {
    border-color: #f97316;
    background-color: #fff7ed;
}
</style>

<script>
// Tab switching functionality
function showTab(tabName) {
    document.querySelectorAll('.transaction-form').forEach(form => {
        form.classList.add('hidden');
    });
    
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('tab-active');
    });
    
    document.getElementById(tabName + '-form').classList.remove('hidden');
    document.getElementById('tab-' + tabName).classList.add('tab-active');
}

// Account selection for deposits
function selectAccount(type, numero) {
    document.querySelectorAll('.account-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    event.currentTarget.classList.add('selected');
    document.getElementById('compte-destinataire').value = numero;
    document.getElementById('type-compte').value = type;
}

// Service selection functionality
function selectService(serviceName) {
    document.querySelectorAll('.service-btn').forEach(btn => {
        btn.classList.remove('border-orange-500', 'bg-orange-50');
    });
    
    const selectedBtn = document.getElementById('service-' + serviceName);
    selectedBtn.classList.add('border-orange-500', 'bg-orange-50');
    
    document.getElementById('selected-service').value = serviceName;
}

// Transaction search functionality
function searchTransaction() {
    const code = document.getElementById('search-transaction').value;
    if (!code) {
        alert('Veuillez saisir un code de transaction');
        return;
    }
    
    // Simuler une recherche - remplacer par un appel AJAX réel
    setTimeout(() => {
        // Exemple de transaction trouvée
        const mockTransaction = {
            code: code,
            amount: '25000',
            date: 'Aujourd\'hui, 14:30',
            account: '***2345',
            status: 'en_attente',
            canCancel: true
        };
        
        displayTransactionResult(mockTransaction);
    }, 1000);
}

function displayTransactionResult(transaction) {
    const resultDiv = document.getElementById('transaction-result');
    const statusSpan = document.getElementById('transaction-status');
    const cancelSection = document.getElementById('cancel-section');
    const cannotCancel = document.getElementById('cannot-cancel');
    
    // Remplir les informations
    document.getElementById('found-code').textContent = transaction.code;
    document.getElementById('found-amount').textContent = transaction.amount + ' FCFA';
    document.getElementById('found-date').textContent = transaction.date;
    document.getElementById('found-account').textContent = transaction.account;
    document.getElementById('cancel-transaction-id').value = transaction.code;
    
    // Définir le statut
    if (transaction.status === 'en_attente') {
        statusSpan.textContent = 'En attente';
        statusSpan.className = 'px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800';
        cancelSection.classList.remove('hidden');
        cannotCancel.classList.add('hidden');
    } else {
        statusSpan.textContent = 'Déjà traitée';
        statusSpan.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
        cancelSection.classList.add('hidden');
        cannotCancel.classList.remove('hidden');
    }
    
    resultDiv.classList.remove('hidden');
}

function cancelSearch() {
    document.getElementById('transaction-result').classList.add('hidden');
    document.getElementById('search-transaction').value = '';
}

function quickCancel(transactionCode) {
    if (confirm('Êtes-vous sûr de vouloir annuler cette transaction ?')) {
        // Simuler l'annulation rapide
        alert('Transaction ' + transactionCode + ' annulée avec succès');
        // Recharger la liste ou masquer l'élément
        event.target.closest('.flex').remove();
    }
}

// Form validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const inputs = form.querySelectorAll('input[required], select[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        // Validation spéciale pour le dépôt
        if (form.action.includes('/depot')) {
            const compteDestinataire = document.getElementById('compte-destinataire').value;
            if (!compteDestinataire) {
                isValid = false;
                alert('Veuillez sélectionner un compte destinataire');
            }
        }
        
        // Validation spéciale pour le paiement
        if (form.action.includes('/paiement')) {
            const service = document.getElementById('selected-service').value;
            if (!service) {
                isValid = false;
                alert('Veuillez sélectionner un service');
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    });
});

// Animation des cartes au chargement
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.transaction-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.classList.add('fade-in');
    });
    
    // Charger les transactions annulables (à remplacer par un appel AJAX)
    loadCancelableTransactions();
});

function loadCancelableTransactions() {
    // Simuler le chargement des transactions annulables
    // En production, faire un appel AJAX vers /transaction/annulables
    const mockTransactions = [
        {
            code: 'TXN202412250001',
            amount: '25000',
            date: 'Aujourd\'hui, 14:30',
            account: '***2345',
            status: 'en_attente'
        },
        {
            code: 'TXN202412240015',
            amount: '15000',
            date: 'Hier, 16:45',
            account: '***6789',
            status: 'en_attente'
        }
    ];
    
    const container = document.getElementById('recent-deposits');
    const noTransactionsMsg = document.getElementById('no-cancelable-transactions');
    
    if (mockTransactions.length === 0) {
        noTransactionsMsg.classList.remove('hidden');
        return;
    }
    
    noTransactionsMsg.classList.add('hidden');
    
    // Effacer le contenu existant sauf le message "aucune transaction"
    const existingTransactions = container.querySelectorAll('.flex');
    existingTransactions.forEach(tx => tx.remove());
    
    mockTransactions.forEach(transaction => {
        const transactionElement = document.createElement('div');
        transactionElement.className = 'flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300';
        transactionElement.innerHTML = `
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-arrow-down text-green-600"></i>
                </div>
                <div>
                    <p class="font-semibold">${transaction.code}</p>
                    <p class="text-sm text-gray-600">Dépôt - ${transaction.date}</p>
                    <p class="text-xs text-orange-600 font-medium">En attente de retrait</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="font-bold text-green-600">${transaction.amount} FCFA</p>
                    <p class="text-sm text-gray-600">Vers: ${transaction.account}</p>
                </div>
                <button onclick="quickCancel('${transaction.code}')" 
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-300 text-sm">
                    <i class="fas fa-times mr-1"></i>Annuler
                </button>
            </div>
        `;
        container.insertBefore(transactionElement, noTransactionsMsg);
    });
}

// Actualiser la liste des transactions annulables toutes les 30 secondes
setInterval(loadCancelableTransactions, 30000);
</script>