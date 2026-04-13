<!-- 

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{route('products.create')}}" class="btn btn-secondary">Ajouter un produit</a><br><br>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Prix</th>
                            </tr>
                        </thead>

                        @foreach($products as product)

                        
                        <tr>
                            <td><img src="{{ asset('storage/'.$product->image) }}" width="100"></td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->price}}</td>
                            <td>
                                <a href="{{ route('products.edit',$product->id)}}">Modifier</a>

                                <form action="{{route('products.destroy',$product->id)}}">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        

                        @enforeach
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
