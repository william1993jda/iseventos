<?php

namespace App\Services\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!empty($row['categoria'])) {
            $category = Category::firstOrCreate(['name' => $row['categoria'], 'active' => 1]);

            $price = '0.00';

            if (!empty($row['valor_is_atual'])) {
                $price = preg_replace('/\D/', '', $row['valor_is_atual']);
            }

            $product = Product::where('category_id', $category->id)
                ->where('name', $row['equipamento'])
                ->first();

            if (empty($product)) {
                $product = Product::firstOrCreate([
                    "category_id" => $category->id,
                    "name" => $row['equipamento'],
                    "price" => $price,
                    "customization" => 0,
                    "active" => 1
                ]);
            }
        }
    }
}
