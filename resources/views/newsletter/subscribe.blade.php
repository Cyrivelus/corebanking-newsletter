<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Le titre qui s'affiche dans l'onglet --}}
    <title>Inscription Newsletter | NewsPro</title>

    {{-- Scripts --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Favicon : C'est ici qu'on pointe vers votre propre icône --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <div class="mb-8">
            <a href="/" class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-3xl font-black tracking-tighter text-gray-900 uppercase">
                    NEWS<span class="text-indigo-600">PRO</span>
                </span>
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">

            <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Restez informé</h2>
            <p class="text-center text-gray-500 text-sm mb-8">Rejoignez notre liste de diffusion pour ne rien manquer.</p>

            @if(session('success'))
                <div class="mb-6 font-medium text-sm text-green-700 bg-green-50 p-4 rounded-xl border border-green-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 text-sm text-red-700 bg-red-50 p-4 rounded-xl border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block font-semibold text-sm text-gray-700 ml-1">Nom complet</label>
                    <input type="text" name="name"
                           class="mt-1 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all"
                           placeholder="Ex: Cyrille Tamboug"
                           value="{{ old('name') }}">
                </div>

                <div>
                    <label class="block font-semibold text-sm text-gray-700 ml-1">Adresse Email *</label>
                    <input type="email" name="email" required
                           class="mt-1 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all"
                           placeholder="votre@email.com"
                           value="{{ old('email') }}">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all duration-200 shadow-lg shadow-indigo-100">
                        S'abonner maintenant
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} NewsPro. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>
