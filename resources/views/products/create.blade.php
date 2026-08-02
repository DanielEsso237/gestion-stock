<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un produit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nom" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="sku" value="SKU" />
                        <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" :value="old('sku')" required />
                        <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category_id" value="Catégorie" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">— Aucune —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="price" value="Prix (€)" />
                            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="quantity" value="Quantité" />
                            <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full" :value="old('quantity', 0)" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="alert_threshold" value="Seuil d'alerte" />
                            <x-text-input id="alert_threshold" name="alert_threshold" type="number" min="0" class="mt-1 block w-full" :value="old('alert_threshold', 5)" required />
                            <x-input-error :messages="$errors->get('alert_threshold')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
                        <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>