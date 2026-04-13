@extends('layout.site')
@section('content')

<div class="edit-container">

    <h1>Modifier le produit</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Nom :</label>
        <input type="text" name="name" value="{{ $product->name }}" required>

        <label>Description :</label>
        <input type="text" name="description" value="{{ $product->description }}" required>

        <label>Prix :</label>
        <input type="number" name="price" value="{{ $product->price }}" required>

        <label>Image :</label>
        <input type="file" name="image" accept="image/*" onchange="previewImage(event)">

        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" class="preview-img" id="oldImage">
        @endif

        <!-- PREVIEW NOUVELLE IMAGE -->
        <img id="preview" class="preview-img" style="display:none;">

        <button type="submit" class="btn-update">
            Mettre à jour
        </button>
    </form>

    <a href="{{ route('products.index') }}" class="btn-back">
        ← Retour
    </a>

</div>

<!-- JS PREVIEW IMAGE -->
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const oldImage = document.getElementById('oldImage');

    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";

            if (oldImage) {
                oldImage.style.display = "none";
            }
        }

        reader.readAsDataURL(file);
    }
}
</script>

@endsection