<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - MAXITSA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-pattern {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/><circle cx="80" cy="30" r="1.5" fill="white" opacity="0.1"/><circle cx="60" cy="70" r="1" fill="white" opacity="0.1"/></svg>');
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-2xl">
        <!-- Header -->
        <div class="bg-orange-500 text-white text-center py-12 px-6 relative bg-pattern">
            <h1 class="text-4xl font-bold mb-3 relative z-10">MAXITSA</h1>
            <p class="text-lg opacity-90 relative z-10"></p>
        </div>

        <!-- Error Content -->
        <div class="px-8 py-12 text-center">
            <!-- Error Icon -->
            <div class="text-6xl mb-6 opacity-70"></div>
            
            <!-- Error Code -->
            <div class="text-8xl font-bold text-orange-500 mb-6 drop-shadow-sm">404</div>
            
            <!-- Error Title -->
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Page non trouvée</h2>
            
            <!-- Error Message -->
            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
                <br class="hidden sm:block">
                Vérifiez l'URL ou retournez à l'accueil.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="/" class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    Retour à l'accueil
                </a>
                <button onclick="history.back()" class="border-2 border-orange-500 text-orange-500 px-8 py-3 rounded-lg font-semibold hover:bg-orange-500 hover:text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    Page précédente
                </button>
            </div>
        </div>
    </div>
</body>
</html>