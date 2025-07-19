<?php
$errors = $this->session->get('errors') ?? [];
$old = $this->session->get('old') ?? [];
$this->session->unset('errors');
$this->session->unset('old');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Formulaire d'Inscription</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-400 min-h-screen flex items-center justify-center p-4">
  <div class="flex flex-col lg:flex-row bg-white rounded-3xl shadow-lg overflow-hidden w-full max-w-5xl">
    <!-- Formulaire -->
    <div class="w-full lg:w-1/2 p-6 sm:p-8">
      <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Inscription</h1>

      <form action="/inscription" method="post" enctype="multipart/form-data" class="space-y-6">
        <!-- Nom et Prénom -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
            <input id="nom" name="nom" type="text"
              value="<?= htmlspecialchars($old['nom'] ?? '') ?>"
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-400 <?= !empty($errors['nom']) ? 'border-red-500' : '' ?>">
            <?php if (!empty($errors['nom'])): ?>
              <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['nom']) ?></p>
            <?php endif; ?>
          </div>
          <div>
            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom*</label>
            <input id="prenom" name="prenom" type="text"
              value="<?= htmlspecialchars($old['prenom'] ?? '') ?>"
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-400 <?= !empty($errors['prenom']) ? 'border-red-500' : '' ?>">
            <?php if (!empty($errors['prenom'])): ?>
              <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['prenom']) ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Adresse -->
        <div>
          <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse*</label>
          <input id="adresse" name="adresse" type="text"
            value="<?= htmlspecialchars($old['adresse'] ?? '') ?>"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-400 <?= !empty($errors['adresse']) ? 'border-red-500' : '' ?>">
          <?php if (!empty($errors['adresse'])): ?>
            <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['adresse']) ?></p>
          <?php endif; ?>
        </div>

        <!-- Téléphone -->
        <div>
          <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
          <input id="telephone" name="telephone" type="tel"
            value="<?= htmlspecialchars($old['telephone'] ?? '') ?>"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-400 <?= !empty($errors['telephone']) ? 'border-red-500' : '' ?>">
          <?php if (!empty($errors['telephone'])): ?>
            <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['telephone']) ?></p>
          <?php endif; ?>
        </div>

        <!-- CNI -->
        <div>
          <label for="cni" class="block text-sm font-medium text-gray-700 mb-1">Numéro de CNI*</label>
          <input id="cni" name="cni" type="text"
            value="<?= htmlspecialchars($old['cni'] ?? '') ?>"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-400 <?= !empty($errors['cni']) ? 'border-red-500' : '' ?>">
          <?php if (!empty($errors['cni'])): ?>
            <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['cni']) ?></p>
          <?php endif; ?>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe*</label>
          <input id="password" name="password" type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-400 <?= !empty($errors['password']) ? 'border-red-500' : '' ?>">
          <?php if (!empty($errors['password'])): ?>
            <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['password']) ?></p>
          <?php endif; ?>
        </div>

        <!-- Photo CNI -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Télécharger Photo CNI*</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div onclick="document.getElementById('photo-recto').click()" class="cursor-pointer border-2 border-dashed rounded-xl p-4 text-center hover:border-orange-400 transition-colors <?= !empty($errors['photo_recto']) ? 'border-red-500' : 'border-gray-300' ?>">
              <svg class="w-6 h-6 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <span id="label-recto" class="text-sm text-gray-600"><?= htmlspecialchars($old['photo_recto_name'] ?? 'Recto') ?></span>
              <input id="photo-recto" name="photo_recto" type="file" class="hidden" accept="image/*">
              <?php if (!empty($errors['photo_recto'])): ?>
                <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['photo_recto']) ?></p>
              <?php endif; ?>
            </div>

            <div onclick="document.getElementById('photo-verso').click()" class="cursor-pointer border-2 border-dashed rounded-xl p-4 text-center hover:border-orange-400 transition-colors <?= !empty($errors['photo_verso']) ? 'border-red-500' : 'border-gray-300' ?>">
              <svg class="w-6 h-6 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <span id="label-verso" class="text-sm text-gray-600"><?= htmlspecialchars($old['photo_verso_name'] ?? 'Verso') ?></span>
              <input id="photo-verso" name="photo_verso" type="file" class="hidden" accept="image/*">
              <?php if (!empty($errors['photo_verso'])): ?>
                <p class="mt-1 text-red-600 text-sm"><?= htmlspecialchars($errors['photo_verso']) ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Bouton -->
        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition">
          Créer un compte
        </button>

        <p class="text-center text-sm text-gray-600">Vous avez déjà un compte ? 
          <a href="/" class="text-orange-500 hover:text-orange-600">Se connecter</a>
        </p>
      </form>
    </div>

    <!-- Image illustrée -->
    <div class="hidden lg:flex lg:w-1/2 bg-orange-400 items-center justify-center p-6">
      <img src="images/assets/Banknote-rafiki.png" alt="Illustration" class="max-w-full h-auto object-contain">
    </div>
  </div>

  <script>
    document.getElementById('photo-recto').addEventListener('change', function (e) {
      const label = document.getElementById('label-recto');
      const file = e.target.files[0];
      if (file) {
        label.textContent = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;
      }
    });

    document.getElementById('photo-verso').addEventListener('change', function (e) {
      const label = document.getElementById('label-verso');
      const file = e.target.files[0];
      if (file) {
        label.textContent = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;
      }
    });
  </script>
</body>
</html>
