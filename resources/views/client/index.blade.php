<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Clientes</h1>
                            <p class="mt-2 text-sm text-gray-700">Listado de todos los clientes.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('clients.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Agregar cliente</a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mt-4 rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
                    @endif

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">#</th>
                                        
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nombre</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Slug</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Correo electrónico</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Teléfono</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Dirección</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Logo</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Estado</th>

                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($clients as $client)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                            
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $client->name }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $client->slug }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $client->email }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $client->phone }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $client->address }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">@if ($client->logo)<img src="{{ Storage::url($client->logo) }}" alt="" class="h-10 w-10 rounded object-cover">@endif</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $client->status_label }}</td>

                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                                    <a href="{{ route('clients.show', $client->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">Ver</a>
                                                    <a href="{{ route('clients.edit', $client->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">Editar</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('clients.destroy', $client->id) }}" class="text-red-600 font-bold hover:text-red-900" onclick="event.preventDefault(); confirm('¿Seguro que deseas eliminar este cliente?') ? this.closest('form').submit() : false;">Eliminar</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $clients->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>