<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // curl -X PUT http://boolean.test/api/categories/188 -H "Content-Type: application/json" -d '{"category_name": "UPS"}'
        $validatedData = $request->validate([
          'category_name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        // $category->update($request->all());
        $category->update($validatedData);
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        //curl -X DELETE http://boolean.test/api/categories/188 -H "Accept: application/json"
      $category = Category::findOrFail($id);

      // Delete the category
      $category->delete();

      return response()->json(null, 204);

    }
}
