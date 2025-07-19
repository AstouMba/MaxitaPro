<?php
$errors = $this->session->get('errors') ?? [];
$old = $this->session->get('old') ?? [];
$this->session->unset('errors');
$this->session->unset('old');
?>

<div class="flex w-full max-w-6xl mx-auto">
    <!-- Formulaire de connexion -->
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md">
            <!-- Logo/Titre -->
            <div class="text-center mb-8">
                <div class="inline-block bg-gray-100 rounded-2xl px-6 py-3">
                    <h1 class="text-xl font-bold text-gray-800">MAX IT</h1>
                    <p class="text-orange-500 text-sm font-medium">SA</p>
                </div>
            </div>

            <!-- Formulaire -->
            <form class="space-y-6" action="/auth" method="post">
               <!-- Erreur globale -->
<?php if (!empty($errors['global'])): ?>
    <div class="mb-4 text-red-600 font-semibold text-center">
        <?= htmlspecialchars($errors['global']) ?>
    </div>
<?php endif; ?>

<div>
    <label class="block text-gray-700 text-sm font-medium mb-2">Login*</label>
    <input type="text" name="login"
           value="<?= htmlspecialchars($old['login'] ?? '') ?>"
           placeholder="Entrez votre login"
           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 <?= !empty($errors['login']) ? 'border-red-500' : 'border-gray-300' ?>">
    <?php if (!empty($errors['login'])): ?>
        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['login']) ?></p>
    <?php endif; ?>
</div>

<div class="mt-4">
    <label class="block text-gray-700 text-sm font-medium mb-2">Mot de passe*</label>
    <input type="password" name="password"
           placeholder="Entrez votre mot de passe"
           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 <?= !empty($errors['password']) ? 'border-red-500' : 'border-gray-300' ?>">
    <?php if (!empty($errors['password'])): ?>
        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['password']) ?></p>
    <?php endif; ?>
</div>



                <div class="text-left">
                    <a href="#" class="text-gray-600 text-sm hover:text-orange-500 transition-colors">
                        Mot de passe oublié?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-orange-500 text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition-colors">
                    Connexion
                </button>

                <div class="text-center text-sm text-gray-600">
                    vous n'avez pas de compte ?
                    <a href="/inscription"
                        class="text-orange-500 hover:text-orange-600 transition-colors">s'inscrire</a>
                </div>
            </form>

        </div>
    </div>


</div>