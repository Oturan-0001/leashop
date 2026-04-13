<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<x-app-layout>

<style>
/* ===== GLOBAL ===== */
.dashboard-wrap {
    padding: 30px;
    background: #f6f7fb;
    min-height: 100vh;
}

/* ===== HEADER BUTTON ===== */
.btn-add {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
    display: inline-block;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

/* ===== SEARCH ===== */
.search-box input {
    border-radius: 8px 0 0 8px;
}

.search-box button {
    border-radius: 0 8px 8px 0;
}

/* ===== TABLE ===== */
.table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

.table img {
    border-radius: 8px;
}

/* ===== ACTION BUTTONS ===== */
.btn-edit {
    background: #f39c12;
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    margin-right: 5px;
    transition: 0.3s;
}

.btn-edit:hover {
    background: #d68910;
    transform: scale(1.05);
}

.btn-delete {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-delete:hover {
    background: #c0392b;
    transform: scale(1.05);
}

/* EMPTY STATE */
.empty {
    text-align: center;
    padding: 20px;
    color: #888;
}
</style>

<x-slot name="header">
    <h2 class="fw-bold text-dark">
        Dashboard
    </h2>
</x-slot>

<div class="dashboard-wrap">

    <div class="container-fluid">

        <div class="card shadow-sm border-0 p-3">

            <!-- TOP BAR -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <a href="{{ route('products.create') }}" class="btn-add">
                    ➕ Ajouter un produit
                </a>

                <!-- SEARCH -->
                <form action="{{ route('products.index') }}" method="GET" class="d-flex search-box">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Chercher dans mon stock...">

                    <button class="btn btn-dark">Filtrer</button>

                    @if(request('search'))
                        <a href="{{ route('products.index') }}" class="ms-3 text-danger align-self-center">
                            Effacer
                        </a>
                    @endif
                </form>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($products as $product)

                        <tr>
                            <td>
                                <img src="{{ asset('storage/'.$product->image) }}" width="70" height="70">
                            </td>

                            <td class="fw-bold">{{ $product->name }}</td>

                            <td>{{ Str::limit($product->description, 50) }}</td>

                            <td class="text-primary fw-bold">
                                {{ number_format($product->price, 0, ',', ' ') }} FCFA
                            </td>

                            <td>

                                <a href="{{ route('products.edit', $product->id) }}" class="btn-edit">
                                    ✏️ Modifier
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        🗑️ Supprimer
                                    </button>
                                </form>

                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="empty">
                                Aucun produit trouvé.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>