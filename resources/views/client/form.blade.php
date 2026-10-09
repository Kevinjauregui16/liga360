<div class="space-y-6">
    
    <div>
        <x-input-label for="name" value="Nombre"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $client?->name)" autocomplete="name" placeholder="Nombre de la liga u organización"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>
    <div>
        <x-input-label for="slug" value="Slug"/>
        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $client?->slug)" autocomplete="off" placeholder="liga-norte"/>
        <p class="mt-1 text-sm text-gray-500">Si lo dejas vacío se genera a partir del nombre.</p>
        <x-input-error class="mt-2" :messages="$errors->get('slug')"/>
    </div>
    <div>
        <x-input-label for="email" value="Correo electrónico"/>
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $client?->email)" autocomplete="email" placeholder="contacto@liga.com"/>
        <x-input-error class="mt-2" :messages="$errors->get('email')"/>
    </div>
    <div>
        <x-input-label for="phone" value="Teléfono"/>
        <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $client?->phone)" autocomplete="phone" placeholder="Teléfono"/>
        <x-input-error class="mt-2" :messages="$errors->get('phone')"/>
    </div>
    <div>
        <x-input-label for="address" value="Dirección"/>
        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $client?->address)" autocomplete="address" placeholder="Dirección"/>
        <x-input-error class="mt-2" :messages="$errors->get('address')"/>
    </div>
    <div>
        <x-input-label for="logo" value="Logo"/>
        @if ($client?->logo)
            <img src="{{ Storage::url($client->logo) }}" alt="Logo de {{ $client->name }}" class="mt-2 h-16 w-16 rounded object-cover">
        @endif
        <input id="logo" name="logo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold hover:file:bg-gray-200">
        <x-input-error class="mt-2" :messages="$errors->get('logo')"/>
    </div>
    <div>
        <x-input-label for="status" value="Estado"/>
        <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            @foreach (\App\Models\Client::STATUSES as $status => $label)
                <option value="{{ $status }}" @selected(old('status', $client?->status) === $status)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Guardar</x-primary-button>
    </div>
</div>