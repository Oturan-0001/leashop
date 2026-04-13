<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductImageMail; // On devra créer ce Mailable

class ProductController extends Controller
{
    /** PAGE D'ACCUEIL PUBLIQUE (Front-Office) */
    public function welcome(Request $request)
    {
        // On commence à préparer la requête (sans l'exécuter tout de suite)
        $query = Product::query();

        // Si le paramètre 'search' existe dans l'URL (ex: ?search=chaussure)
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            
            // On cherche dans le nom OU la description
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        }

        // On exécute la requête avec get()
        $products = $query->latest()->get(); 
        
        return view('welcome', compact('products'));
    }


    /** 1. LISTE DES PRODUITS (Admin ) */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        }

        // Pour l'admin, on garde la pagination (ex: 10 par page)
        // On ajoute appends() pour que la pagination n'oublie pas le mot recherché quand on change de page
        $products = $query->latest()->paginate(10)->appends($request->all());
        
        return view('products.index', compact('products'));
    }

    /** 2. FORMULAIRE DE CRÉATION (Admin) */
    public function create()
    {
        return view('products.create');
    }

    /** 3. ENREGISTREMENT EN BASE (Admin) */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Stockage de l'image dans storage/app/public/products
        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $path,
            // Le slug est géré automatiquement par le modèle !
        ]);

        return redirect()->route('products.index')->with('success', 'Produit ajouté !');
    }

    /** 4. VOIR UN PRODUIT (Détail avec Slug) */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    /** 5. FORMULAIRE D'ÉDITION (Admin) */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /** 6. MISE À JOUR (Admin) */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        // Si une nouvelle image est téléchargée
        if ($request->hasFile('image')) {
            // On supprime l'ancienne image physiquement
            Storage::disk('public')->delete($product->image);
            // On enregistre la nouvelle
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->except('image'));
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produit mis à jour !');
    }

    /** 7. SUPPRESSION (Admin) */
    public function destroy(Product $product)
    {
        // Supprimer l'image du stockage
        Storage::disk('public')->delete($product->image);
        // Supprimer l'entrée en base
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé !');
    }

    /** 8. ENVOI PAR EMAIL (Client connecté) */
    public function sendByEmail($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        // Envoi du mail (On créera la classe ProductImageMail juste après)
        Mail::to($user->email)->send(new ProductImageMail($product));

        return back()->with('success', 'L\'image a été envoyée à votre adresse email !');
    }

    public function search(Request $request)
    {
        $query = $request->input('search'); // Récupère le texte tapé

        $products = Product::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->paginate(10);

        // On retourne la vue index (ou une vue spéciale recherche) avec les résultats
        return view('products.index', compact('products', 'query'));
    }
}
