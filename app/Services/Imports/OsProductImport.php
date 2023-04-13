<?php

namespace App\Services\Imports;

use App\Models\OsCategory;
use App\Models\OsProduct;
use App\Models\OsProductStock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OsProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!empty($row['tipo'])) {
            $category = OsCategory::firstOrCreate(['name' => $row['tipo'], 'active' => 1]);

            $price = '0.00';

            if (!empty($row['valor'])) {
                $price = preg_replace('/\D/', '', $row['valor']);

                if (!empty($price)) {
                    $price = substr($price, 0, -2) . ',' . substr($price, -2);
                } else {
                    $price = '0,00';
                }
            }

            $product = OsProduct::where('os_category_id', $category->id)
                ->where('name', $row['equipamentos_os'])
                ->first();

            if (empty($product)) {
                $product = OsProduct::firstOrCreate([
                    "os_category_id" => $category->id,
                    "name" => $row['equipamentos_os'],
                    "brand" => $row['marca'],
                    "model" => $row['modelo'],
                    "serie" => $row['no_serie'],
                    "weight" => $row['peso'],
                    "dimensions" => $row['medidas'],
                    "price" => $price,
                    "customization" => 0,
                    "active" => 1
                ]);
            }

            OsProductStock::firstOrCreate([
                'os_product_id' => $product->id,
                'sku' => $row['patrimonio'],
                "active" => 1,
                'accessories' => $row['acessorios']
            ]);
        }
    }
}
