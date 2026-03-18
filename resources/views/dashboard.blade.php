<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord Newsletter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Abonnés Actifs</div>
                    <div class="text-3xl font-bold text-gray-900">1</div>
                    <div class="text-xs text-green-600 mt-1">Total actuel</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Nouveaux (Mois)</div>
                    <div class="text-3xl font-bold text-gray-900">+1</div>
                    <div class="text-xs text-blue-600 mt-1">Inscription récente</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Désabonnés</div>
                    <div class="text-3xl font-bold text-gray-900">0</div>
                    <div class="text-xs text-gray-400 mt-1">Total historique</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Statut Système</div>
                    <div class="text-lg font-bold text-green-600">Opérationnel</div>
                    <div class="text-xs text-gray-400 mt-1">Serveur Vercel OK</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Actions de gestion</h3>
                    <div class="flex gap-4">
                        <a href="/admin/newsletter" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                            Voir tous les abonnés
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
