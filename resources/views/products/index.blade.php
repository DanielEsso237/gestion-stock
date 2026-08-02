<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produits') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold rounded-md">
                        + Ajouter un produit
                    </a>
                </div>

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
                                <td class="py-2 text-right">
                                    <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:underline">Modifier</a>
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