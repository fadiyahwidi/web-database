<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Suppliers;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::with(['category', 'supplier'])->get();
        $suppliers = Suppliers::all();
        $categories = Categories::all();
        return view('main', compact('products', 'suppliers','categories'));
    }
    
    public function supplierList()
{
    try {
        $suppliers = Suppliers::select('_id', 'name')->get();
        return response()->json($suppliers);
    } catch (\Exception $e) {
        Log::error('Error getting suppliers: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error getting suppliers'
        ], 500);
    }
}

    public function getSupplier($id)
    {
        try {
            $supplier = Suppliers::find($id);
            if (!$supplier) {
                return response()->json(['error' => 'Supplier not found'], 404);
            }
            return response()->json($supplier);
        } catch (\Exception $e) {
            Log::error('Error fetching supplier: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching supplier'], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Products::with(['category', 'supplier'])->find($id);
            return response()->json($product);
        } catch (\Exception $e) {
            Log::error('Error finding product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error finding product'
            ], 500);
        }
    }

   // Di ProductController, update method store
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|string',
            'supplier_id' => 'required|string'  // Pastikan ini string untuk MongoDB ObjectId
        ]);

        // Verifikasi supplier exists
        $supplier = Suppliers::find($validated['supplier_id']);
        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found'
            ], 404);
        }

        // Buat produk dengan supplier_id
        $product = Products::create([
            'name' => $validated['name'],
            'price' => (float) $validated['price'],
            'stock' => (int) $validated['stock'],
            'category_id' => $validated['category_id'],
            'supplier_id' => $validated['supplier_id']  // Simpan sebagai ObjectId
        ]);

        // Load relationships
        $product->load(['category', 'supplier']);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ]);
    } catch (\Exception $e) {
        Log::error('Error creating product: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error creating product: ' . $e->getMessage()
        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        try {
            $product = Products::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Validate supplier_id exists
            if ($request->supplier_id) {
                $supplier = Suppliers::find($request->supplier_id);
                if (!$supplier) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Supplier not found'
                    ], 404);
                }
            }

            $product->update([
                'name' => $request->name,
                'price' => (float) $request->price,
                'stock' => (int) $request->stock,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating product'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Products::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product'
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->get('search');
            $products = Products::with(['category', 'supplier'])
                ->where('name', 'like', "%$search%")
                ->orWhereHas('category', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('supplier', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->get();
                    
            return response()->json([
                'success' => true,
                'data' => $products,
                'html' => view('products.table', compact('products'))->render()
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching products: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching products'
            ], 500);
        }
    }
}