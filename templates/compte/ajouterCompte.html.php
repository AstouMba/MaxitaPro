<?php
$errors = $this->session->get('errors') ?? [];
$old = $this->session->get('old') ?? [];
$success = $this->session->get('success') ?? '';
?>

<body class="bg-orange-500 p-4">
    <div class="max-w-md mx-auto bg-white rounded-3xl shadow-lg p-8">


        <!-- Titre -->
        <h1 class="text-center text-2xl font-bold text-gray-900 mb-4">
            Ajouter un Compte secondaire
        </h1>

        <?php if ($success): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl text-sm">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <form method="post" action="/compte/store">
            <!-- Champ Numero de téléphone -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-3">
                    Numéro de téléphone*
                </label>
                <input 
                    type="text" 
                    name="numerotel"
                    placeholder="77XXXXXXX" 
                    value="<?= htmlspecialchars($old['numerotel'] ?? '') ?>"
                    class="w-full px-4 py-4 bg-gray-100 border-0 rounded-xl text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500"
                >
                <?php if (!empty($errors['numerotel'])): ?>
                    <p class="text-red-600 text-sm"><?= $errors['numerotel'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Champ Solde -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-3">
                    Initialiser le solde du compte*
                </label>
                <input 
                    type="number" 
                    step="0.01"
                    name="solde"
                    placeholder="ex: 10000"
                    value="<?= htmlspecialchars($old['solde'] ?? '') ?>"
                    class="w-full px-4 py-4 bg-gray-100 border-0 rounded-xl text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500"
                >
                <?php if (!empty($errors['solde'])): ?>
                    <p class="text-red-600 text-sm"><?= $errors['solde'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Boutons -->
            <div class="flex gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-orange-500 text-white font-semibold py-4 rounded-xl hover:bg-orange-600 transition-colors duration-200"
                >
                    Confirmer
                </button>
                <a 
                    href="/compte"
                    class="flex-1 bg-black text-white font-semibold py-4 rounded-xl text-center hover:bg-gray-800 transition-colors duration-200"
                >
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
