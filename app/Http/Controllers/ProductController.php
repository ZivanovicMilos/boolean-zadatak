<?php

namespace App\Http\Controllers;

use App\Http\Resources\InventoryResource;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Inventory::with([
            'product:product_number,description,regular_price,sale_price',
            'category:id,category_name',
            'manufacturer:id,manufacturer_name',
            'department:id,department_name'
        ])->select( 'product_number', 'sku', 'upc', 'category_id', 'department_id', 'manufacturer_id')
        ->get();

        return InventoryResource::collection($products);
    }

    public function productsByCategory($id) {
        $products = Inventory::where('category_id', $id)->with([
            'product:product_number,description,regular_price,sale_price',
            'category:id,category_name',
            'manufacturer:id,manufacturer_name',
            'department:id,department_name'
        ])->select( 'product_number', 'sku', 'upc', 'category_id', 'department_id', 'manufacturer_id')
            ->get();
        return InventoryResource::collection($products);
    }

    public function exportCategoryCSV($id) {
        $categoryName = Category::findOrFail($id)->category_name;
        $products = Inventory::where('category_id', $id)->with('product')->get();

        $fileName = preg_replace('/[^a-zA-Z0-9]/', '_', $categoryName) . '_' . now()->format('Y_m_d-H_i') . '.csv';
        $path = storage_path('app/public/' . $fileName);

        $handle = fopen($path, 'w+');
        fputcsv($handle, ['product_number', 'sku', 'upc', 'regular_price', 'sale_price', 'description']);

        foreach ($products as $product) {
            fputcsv($handle, [
                $product->product_number,
                $product->sku,
                $product->upc,
                $product->product->regular_price ?? 'N/A',
                $product->product->sale_price ?? 'N/A',
                $product->product->description ?? 'N/A',
            ]);
        }

        fclose($handle);

        return response()->download($path);
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
        // curl -X PUT http://boolean.test/api/products/0515C002 -H "Content-Type: application/json" -d '{"sale_price": "44.99"}'
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::where('product_number', $id)->firstOrFail();

            // Delete the product
            $product->delete();

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 405);
        }
    }
}
