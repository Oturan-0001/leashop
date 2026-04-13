@extends('layout.site')
@section('content')

<h1>Bienvenue sur Leashop</h1>

<p>Trouvez tout ce dont vous avez besoin</p>

<div class="search-box">
    <form action="{{ route('home') }}" method="GET" style="display:flex; width:100%;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un article...">
        <button type="submit">Chercher</button>
    </form>
</div>

<p>
    Ici nous vous offrons tout ce dont vous avez besoin pour le travail, la cuisine ou votre quotidien.
</p>

<div class="products">

@forelse($products as $product)

    <div class="product-card">
        
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        
        <div class="product-content">
            <div class="product-title">{{ $product->name }}</div>
            
            <div class="product-price">
                {{ number_format($product->price, 0, ',', ' ') }} FCFA
            </div>

            <div class="product-actions">
                <a href="{{ route('products.show', $product->slug) }}" class="btn-detail">
                    Détails
                </a>
                <a href="https://wa.me/57209375?text=Bonjour" class="btn-whatsapp">
                    WhatsApp
                </a>
            </div>
        </div>

    </div>

@empty
    <div class="empty">
        Aucun produit disponible pour le moment.
    </div>
@endforelse

</div>

@endsection