@extends('layout.site')

@section('content')

<div class="grille-produits">
    
    <div class="carte">

        <!-- IMAGE -->
        <div>
            <img src="{{ asset('storage/' . $product->image) }}">
        </div>

        <!-- INFOS -->
        <div class="product-info">
            <h2>{{ $product->name }}</h2>

            <p>{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>

            <p>{{ $product->description }}</p>

            <div class="actions">

                <form action="{{ route('products.send', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Recevoir l'image
                    </button>
                </form>

                @php
                    $urlProduit = route('products.show', $product->slug);
                    $messageWhatsApp = urlencode("Salut ! Regarde ce produit : " . url($urlProduit));
                @endphp

                <a href="https://wa.me/?text={{ $messageWhatsApp }}" 
                   target="_blank" 
                   class="btn btn-whatsapp">
                    WhatsApp
                </a>

                <button 
                    onclick="copyLink('{{ route('products.show', $product->slug) }}')" 
                    class="btn btn-share">
                    Copier lien
                </button>

            </div>

        </div>

    </div>

</div>

<script>
function copyLink(url) {
    const fullUrl = window.location.origin + url;
    navigator.clipboard.writeText(fullUrl).then(() => {
        alert("Lien copié !");
    });
}
</script>

@endsection