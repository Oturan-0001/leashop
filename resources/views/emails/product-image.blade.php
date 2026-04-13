<x-mail::message>
<h1>Bonjour {{ auth()->user()->name }} !</h1>

<p>Vous avez demandé l'image du produit : <strong>{{ $product->name }}</strong>.</p>
<x-mail::button :url="''">
<p>Vous trouverez l'image en pièce jointe de cet email.</p>
</x-mail::button>

<p>Merci de votre confiance sur Leashop !</p>,<br>
{{ config('app.name') }}
</x-mail::message>
