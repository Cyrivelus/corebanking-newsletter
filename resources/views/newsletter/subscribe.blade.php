<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Inscription Newsletter') }} | NewsPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-indigo-50/30 font-sans antialiased text-slate-900">
    <div class="min-h-screen flex flex-col justify-center items-center p-6">

        <div class="mb-10 text-center">
            <a href="/" class="group flex flex-col items-center gap-3">
                <div class="bg-indigo-600 p-4 rounded-2xl shadow-lg shadow-indigo-200 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold tracking-tight text-slate-900">NEWS<span class="text-indigo-600">PRO</span></span>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-[440px] px-8 py-12 bg-white shadow-xl rounded-[2.5rem] border border-indigo-100 relative overflow-hidden">

            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-slate-900">{{ __('Restez informé') }}</h2>
                <p class="text-slate-500 mt-3">{{ __('Rejoignez notre liste de diffusion.') }}</p>
            </div>

            @if(session('success'))
                <div class="mb-8 p-5 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 font-semibold animate-pulse">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 p-5 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 text-sm">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block font-bold text-xs uppercase text-slate-400 mb-2 ml-1">{{ __('Nom complet') }}</label>
                    <input type="text" name="name" class="block w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl outline-none transition-all" placeholder="Cyrille Tamboug" value="{{ old('name') }}">
                </div>

                <div>
                    <label class="block font-bold text-xs uppercase text-slate-400 mb-2 ml-1">{{ __('Adresse Email') }} *</label>
                    <input type="email" name="email" required class="block w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 rounded-2xl outline-none transition-all" placeholder="votre@email.com" value="{{ old('email') }}">
                </div>

                <button type="submit" class="w-full flex justify-center items-center px-6 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold uppercase tracking-widest shadow-lg transition-all hover:-translate-y-1">
                    {{ __("S'abonner maintenant") }}
                </button>
            </form>

            <div class="mt-12 pt-8 border-t border-slate-50 flex justify-center gap-8">
                <a href="{{ route('lang.switch', 'fr') }}" class="text-[11px] font-bold {{ app()->getLocale() == 'fr' ? 'text-indigo-600' : 'text-slate-300' }}">FR</a>
                <a href="{{ route('lang.switch', 'en') }}" class="text-[11px] font-bold {{ app()->getLocale() == 'en' ? 'text-indigo-600' : 'text-slate-300' }}">EN</a>
                <a href="{{ route('lang.switch', 'es') }}" class="text-[11px] font-bold {{ app()->getLocale() == 'es' ? 'text-indigo-600' : 'text-slate-300' }}">ES</a>
            </div>
        </div>
    </div>
</body>
</html>
