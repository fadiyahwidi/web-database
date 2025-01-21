<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        try {
            $categories = Categories::select('_id', 'name')
                ->orderBy('name')
                ->get();
                
            $categories = $categories->map(function ($category) {
                return [
                    '_id' => (string) $category->_id,
                    'name' => $category->name
                ];
            });
            
            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('Error getting categories: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    public function show($id)
    {
        try {
            $category = Categories::find($id);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }
            return response()->json($category);
        } catch (\Exception $e) {
            Log::error('Error fetching category: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching category'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $category = Categories::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating category'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Categories::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating category'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Categories::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting category'
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->get('search');
            $categories = Categories::where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->get();
                    
            return response()->json([
                'success' => true,
                'data' => $categories,
                'html' => view('categories.table', compact('categories'))->render()
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching categories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching categories'
            ], 500);
        }
    }
}