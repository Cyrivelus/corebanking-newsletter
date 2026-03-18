<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion de la Newsletter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Tableau de bord Newsletter</h1>
                <div class="space-x-4">
                   <a href="{{ route('admin.newsletter.campaign') }}"
   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-blue-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 hover:border-blue-700 shadow-sm transition">

    <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
    </svg>

    Nouvelle campagne
</a>
                    <a href="{{ route('admin.newsletter.export') }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 shadow-sm transition">
                        Exporter CSV
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Abonnés Actifs</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalActive }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Nouveaux (ce mois)</p>
                    <p class="text-2xl font-semibold text-gray-800">+{{ $newThisMonth }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total Désabonnés</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalUnsubscribed }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-orange-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Départs (ce mois)</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $unsubsThisMonth }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($subscribers as $subscriber)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subscriber->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subscriber->name ?: '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($subscriber->is_subscribed)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Désinscrit
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $subscriber->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                    <form action="{{ route('admin.newsletter.destroy', $subscriber) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Attention : Cette action est irréversible. Supprimer définitivement cet abonné ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-4 font-bold">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p>Aucun inscrit pour le moment.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $subscribers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
