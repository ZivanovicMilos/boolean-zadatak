<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Department;
use App\Models\Inventory;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-inventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import inventory from CSV file';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle()
    {
        $data = array_map('str_getcsv', file(database_path('static-data/product_categories.csv')));
        $data = array_slice($data, 1); // Preskoci header line

        DB::transaction(function () use ($data) {
            foreach ($data as $row) {
                if (!isset($row[1]) || empty($row)) {
                    continue;
                }
                    // Unesi kategoriju, odeljenje i proizvođača samo ako ne postoje
                $category = Category::firstOrCreate(['category_name' => $row[1]]);
                $department = Department::firstOrCreate(['department_name' => $row[2]]);
                $manufacturer = Manufacturer::firstOrCreate(['manufacturer_name' => $row[3]]);

                // Unesi proizvod
                Product::updateOrCreate(
                    ['product_number' => $row[0]],
                    [
                        'description' => $row[8],
                        'regular_price' => $row[6],
                        'sale_price' => $row[7]
                    ]
                );

                // Unesi inventar
                Inventory::updateOrCreate(
                    ['sku' => $row[5]],
                    [
                        'upc' => $row[4],
                        'product_number' => $row[0],
                        'category_id' => $category->id,
                        'department_id' => $department->id,
                        'manufacturer_id' => $manufacturer->id
                    ]
                );
            }
        });

        $this->info('CSV data has been successfully imported.');
    }
}
