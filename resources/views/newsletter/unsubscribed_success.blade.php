<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Désabonnement confirmé</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
        <div class="text-indigo-600 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Désabonnement réussi</h1>
        <p class="text-gray-600 mb-6">
            L'adresse <span class="font-medium text-gray-900">{{ $email }}</span> a été retirée de notre liste de diffusion.
        </p>
        <a href="/" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
            Retour à l'accueil
        </a>
        <p class="mt-4 text-xs text-gray-400">Vous avez fait une erreur ? Réinscrivez-vous sur notre page d'accueil.</p>
    </div>
</body>
</html>
