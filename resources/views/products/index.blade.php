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

                <div id="products-results">
                    @include('products._results')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>