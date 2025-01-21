<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    public function index()
    {
        try {
            $suppliers = Suppliers::all();
            return response()->json([
                'success' => true,
                'data' => $suppliers
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting suppliers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting suppliers'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'address' => 'required|string'
            ]);

            $supplier = Suppliers::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Supplier created successfully',
                'data' => $supplier
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating supplier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating supplier'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $supplier = Suppliers::find($id);
            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }
            return response()->json($supplier);
        } catch (\Exception $e) {
            Log::error('Error getting supplier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting supplier'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $supplier = Suppliers::find($id);
            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'address' => 'required|string'
            ]);

            $supplier->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Supplier updated successfully',
                'data' => $supplier
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating supplier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating supplier'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = Suppliers::find($id);
            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }

            $supplier->delete();
            return response()->json([
                'success' => true,
                'message' => 'Supplier deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting supplier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting supplier'
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->get('search');
            $suppliers = Suppliers::where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->get();

            return response()->json([
                'success' => true,
                'data' => $suppliers,
                'html' => view('suppliers.table', compact('suppliers'))->render()
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching suppliers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching suppliers'
            ], 500);
        }
    }

    public function getSuppliersList()
    {
        try {
            $suppliers = Suppliers::all();
            
            // Add logging for debugging
            Log::info('Suppliers list retrieved:', ['count' => $suppliers->count()]);
            
            $formattedSuppliers = $suppliers->map(function($supplier) {
                return [
                    '_id' => (string)$supplier->_id,  // Ensure _id is cast to string
                    'name' => $supplier->name
                ];
            });
            
            // Log the formatted response
            Log::info('Formatted suppliers:', ['suppliers' => $formattedSuppliers]);
            
            return response()->json($formattedSuppliers);
        } catch (\Exception $e) {
            Log::error('Error getting suppliers list: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting suppliers list'
            ], 500);
        }
    }
}