@extends('layout.site')
@section('content')

<div class="form-container">

    <h1>Ajouter un produit</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Nom :</label>
        <input type="text" name="name" required>

        <label>Description :</label>
        <input type="text" name="description" required>

        <label>Prix :</label>
        <input type="number" name="price" required>

        <label>Image :</label>
        <input type="file" name="image" accept="image/*" onchange="previewImage(event)">

        <!-- PREVIEW -->
        <div class="image-preview">
            <img id="preview" src="" alt="Aperçu de l'image" style="display:none;">
        </div>

        <br><br>

        <button type="submit">Ajouter</button>
    </form>

    <a href="{{ route('dashboard') }}" class="back-link">← Retour</a>

</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection