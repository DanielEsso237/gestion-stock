<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produits') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">
                        @switch(session('status'))
                            @case('product-created') Produit ajouté avec succès. @break
                            @case('product-updated') Produit mis à jour. @break
                            @case('product-deleted') Produit supprimé. @break
                            @case('stock-in-recorded') Stock mis à jour. @break
                            @case('stock-out-recorded') Sortie de stock enregistrée. @break
                        @endswitch
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 text-red-700 text-sm rounded-md">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold rounded-md">
                        + Ajouter un produit
                    </a>
                </div>

                <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="search" value="Rechercher" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full"
                            value="{{ request('search') }}" placeholder="Nom ou SKU..." />
                    </div>

                    <div class="min-w-[200px]">
                        <x-input-label for="category_id" value="Catégorie" />
                        <select id="category_id" name="category_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2 pb-2">
                        <input type="checkbox" id="low_stock" name="low_stock" value="1"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            @checked(request()->boolean('low_stock')) />
                        <label for="low_stock" class="text-sm text-gray-700">Stock bas uniquement</label>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold rounded-md">
                            Filtrer
                        </button>
                        @if (request()->anyFilled(['search', 'category_id', 'low_stock']))
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-xs font-semibold rounded-md">
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                </form>

                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase border-b">
                        <tr>
                            <th class="py-2">Nom</th>
                            <th class="py-2">SKU</th>
                            <th class="py-2">Catégorie</th>
                            <th class="py-2">Prix</th>
                            <th class="py-2">Quantité</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-b">
                                <td class="py-2">{{ $product->name }}</td>
                                <td class="py-2">{{ $product->sku }}</td>
                                <td class="py-2">{{ $product->category?->name ?? '—' }}</td>
                                <td class="py-2">{{ number_format($product->price, 2) }} €</td>
                                <td class="py-2 {{ $product->quantity <= $product->alert_threshold ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $product->quantity }}
                                </td>
                                <td class="py-2 text-right space-x-2">
                                    <button type="button" class="text-green-600 hover:underline" x-data @click="$dispatch('open-modal', 'stock-in-{{ $product->id }}')">
                                        + Stock
                                    </button>
                                    <button type="button" class="text-orange-600 hover:underline" x-data @click="$dispatch('open-modal', 'stock-out-{{ $product->id }}')">
                                        − Stock
                                    </button>
                                    <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Supprimer ce produit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                    </form>

                                    <x-modal :name="'stock-in-'.$product->id" focusable>
                                        <form method="POST" action="{{ route('products.stock-in', $product) }}" class="p-6">
                                            @csrf
                                            <h2 class="text-lg font-medium text-gray-900">Réception — {{ $product->name }}</h2>

                                            <div class="mt-4">
                                                <x-input-label for="quantity_{{ $product->id }}" value="Quantité reçue" />
                                                <x-text-input id="quantity_{{ $product->id }}" name="quantity" type="number" min="1" class="mt-1 block w-full" required />
                                            </div>

                                            <div class="mt-4">
                                                <x-input-label for="reason_{{ $product->id }}" value="Motif (optionnel)" />
                                                <x-text-input id="reason_{{ $product->id }}" name="reason" type="text" class="mt-1 block w-full" placeholder="Ex: Réception fournisseur X" />
                                            </div>

                                            <div class="mt-6 flex justify-end gap-3">
                                                <x-secondary-button x-on:click="$dispatch('close')">Annuler</x-secondary-button>
                                                <x-primary-button>Enregistrer</x-primary-button>
                                            </div>
                                        </form>
                                    </x-modal>

                                    <x-modal :name="'stock-out-'.$product->id" focusable>
                                        <form method="POST" action="{{ route('products.stock-out', $product) }}" class="p-6">
                                            @csrf
                                            <h2 class="text-lg font-medium text-gray-900">Sortie — {{ $product->name }}</h2>
                                            <p class="mt-1 text-sm text-gray-500">Stock actuel : {{ $product->quantity }}</p>

                                            <div class="mt-4">
                                                <x-input-label for="out_quantity_{{ $product->id }}" value="Quantité sortie" />
                                                <x-text-input id="out_quantity_{{ $product->id }}" name="quantity" type="number" min="1" max="{{ $product->quantity }}" class="mt-1 block w-full" required />
                                            </div>

                                            <div class="mt-4">
                                                <x-input-label for="out_reason_{{ $product->id }}" value="Motif (optionnel)" />
                                                <x-text-input id="out_reason_{{ $product->id }}" name="reason" type="text" class="mt-1 block w-full" placeholder="Ex: Vente, casse, perte" />
                                            </div>

                                            <div class="mt-6 flex justify-end gap-3">
                                                <x-secondary-button x-on:click="$dispatch('close')">Annuler</x-secondary-button>
                                                <x-primary-button>Enregistrer</x-primary-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">Aucun produit pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>