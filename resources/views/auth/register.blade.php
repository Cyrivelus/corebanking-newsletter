<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50">
        
        <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-lg border border-gray-100">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">{{ __('Register') }}</h2>
                <p class="text-sm text-gray-500 mt-2">Créer un compte administrateur NewsPro</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                    <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4" x-data="{ show: false }">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />

                    <div class="relative mt-1">
                        <x-text-input id="password" 
                                        class="block w-full pr-10 border-gray-300 focus:border-slate-500 focus:ring-slate-500"
                                        ::type="show ? 'text' : 'password'"
                                        name="password"
                                        required autocomplete="new-password" />
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg x-show="!show" class="h-5 w-5 text-gray-400 hover:text-slate-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" style="display: none;" class="h-5 w-5 text-gray-400 hover:text-slate-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4" x-data="{ show: false }">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />

                    <div class="relative mt-1">
                        <x-text-input id="password_confirmation" 
                                        class="block w-full pr-10 border-gray-300 focus:border-slate-500 focus:ring-slate-500"
                                        ::type="show ? 'text' : 'password'"
                                        name="password_confirmation" required autocomplete="new-password" />
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg x-show="!show" class="h-5 w-5 text-gray-400 hover:text-slate-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" style="display: none;" class="h-5 w-5 text-gray-400 hover:text-slate-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a class="text-sm text-slate-600 hover:text-slate-900 transition" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4 bg-slate-800 hover:bg-slate-900 py-2">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-center gap-6">
                <a href="{{ route('lang.switch', 'fr') }}" class="text-xs transition {{ app()->getLocale() == 'fr' ? 'font-bold text-slate-800' : 'text-gray-400 hover:text-gray-600' }}">FRANÇAIS</a>
                <a href="{{ route('lang.switch', 'en') }}" class="text-xs transition {{ app()->getLocale() == 'en' ? 'font-bold text-slate-800' : 'text-gray-400 hover:text-gray-600' }}">ENGLISH</a>
                <a href="{{ route('lang.switch', 'es') }}" class="text-xs transition {{ app()->getLocale() == 'es' ? 'font-bold text-slate-800' : 'text-gray-400 hover:text-gray-600' }}">ESPAÑOL</a>
            </div>
        </div>
    </div>
</x-guest-layout>