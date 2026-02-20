<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Inscription Newsletter') }} | NewsPro</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .custom-focus:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            outline: none;
        }
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
                    <span class="text-3xl font-extrabold tracking-tight text-slate-900 leading-none">
                        NEWS<span class="text-indigo-600">PRO</span>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-400 mt-1">Newsletter Solutions</span>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-[440px] px-8 py-12 bg-white shadow-[0_20px_50px_rgba(79,70,229,0.05)] overflow-hidden sm:rounded-[2.5rem] border border-indigo-100/50 relative">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 opacity-50"></div>

            <div class="relative text-center mb-10">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('Restez informé') }}</h2>
                <p class="text-slate-500 mt-3 leading-relaxed">
                    {{ __('Rejoignez notre liste de diffusion pour ne rien manquer.') }}
                </p>
            </div>

            @if(session('success'))
                <div class="mb-8 font-semibold text-sm text-emerald-700 bg-emerald-50 p-5 rounded-2xl border border-emerald-100 flex items-center animate-bounce">
                    <div class="bg-emerald-500 p-1 rounded-full mr-3">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 text-sm text-rose-700 bg-rose-50 p-5 rounded-2xl border border-rose-100">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center">
                                <span class="w-1.5 h-1.5 bg-rose-400 rounded-full mr-2"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-6 relative">
                @csrf
                <div class="group">
                    <label class="block font-bold text-xs uppercase tracking-widest text-slate-400 mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">{{ __('Nom complet') }}</label>
                    <input type="text" name="name"
                           class="block w-full px-5 py-4 bg-slate-50 border-transparent focus:bg-white border-2 focus:border-indigo-500 rounded-2xl transition-all duration-300 custom-focus text-slate-800 placeholder-slate-300"
                           placeholder="Cyrille Tamboug"
                           value="{{ old('name') }}">
                </div>

                <div class="group">
                    <label class="block font-bold text-xs uppercase tracking-widest text-slate-400 mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">{{ __('Adresse Email') }} *</label>
                    <input type="email" name="email" required
                           class="block w-full px-5 py-4 bg-slate-50 border-transparent focus:bg-white border-2 focus:border-indigo-500 rounded-2xl transition-all duration-300 custom-focus text-slate-800 placeholder-slate-300"
                           placeholder="votre@email.com"
                           value="{{ old('email') }}">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center items-center px-6 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm uppercase tracking-[0.15em] transition-all duration-300 shadow-xl shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-1 active:scale-[0.98]">
                        {{ __("S'abonner maintenant") }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-8 border-t border-slate-50 flex justify-center gap-8">
                <a href="{{ route('lang.switch', 'fr') }}" class="text-[11px] font-bold tracking-widest transition-all {{ app()->getLocale() == 'fr' ? 'text-indigo-600' : 'text-slate-300 hover:text-slate-500' }}">FRANÇAIS</a>
                <a href="{{ route('lang.switch', 'en') }}" class="text-[11px] font-bold tracking-widest transition-all {{ app()->getLocale() == 'en' ? 'text-indigo-600' : 'text-slate-300 hover:text-slate-500' }}">ENGLISH</a>
                <a href="{{ route('lang.switch', 'es') }}" class="text-[11px] font-bold tracking-widest transition-all {{ app()->getLocale() == 'es' ? 'text-indigo-600' : 'text-slate-300 hover:text-slate-500' }}">ESPAÑOL</a>
            </div>

            <p class="mt-10 text-center text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">
                {{ __('© 2026 NewsPro NewsLetter .') }}
            </p>
        </div>
    </div>
</body>
</html>