<div>
    <x-input-label for="name" value="Nom" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name ?? '')" required
        autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="sku" value="SKU" />
    <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" :value="old('sku', $product->sku ?? '')" required />
    <x-input-error :messages="$errors->get('sku')" class="mt-2" />
</div>

<div>
    <x-input-label for="category_id" value="Catégorie" />
    <select id="category_id" name="category_id"
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">— Aucune —</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? null) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

<div class="grid grid-cols-3 gap-4">
    <div>
        <x-input-label for="price" value="Prix (€)" />
        <x-text-input id="price" name="price" type="number" step="0.01" min="0"
            class="mt-1 block w-full" :value="old('price', $product->price ?? '')" required />
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="quantity" value="Quantité" />
        <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full"
            :value="old('quantity', $product->quantity ?? 0)" required />
        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="alert_threshold" value="Seuil d'alerte" />
        <x-text-input id="alert_threshold" name="alert_threshold" type="number" min="0"
            class="mt-1 block w-full" :value="old('alert_threshold', $product->alert_threshold ?? 5)" required />
        <x-input-error :messages="$errors->get('alert_threshold')" class="mt-2" />
    </div>
</div>
