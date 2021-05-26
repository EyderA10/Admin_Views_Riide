<?php

namespace App\Imports;

use App\Models\Adicional;
use App\Models\CategoriaProducto;
use App\Models\Category;
use App\Models\Producto;
use App\Models\ProductQuantity;
use App\Models\Tienda;
use App\Models\UserStore;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductoImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model(array $row)
    {
        if ($row['producto'] !== null) {
            $categories = explode(",", $row['categoria']);
            $adicionales = explode(",", $row['adicional']);
            $precio = explode(",", $row['precio']);
            $user = \Auth::user();
            if ($user->roles->id === 7) {
                $tiendas = Tienda::where('user_id', $user->id)->get();
            } elseif ($user->roles->id === 3) {
                $tiendas = UserStore::where('user_id', $user->id)->get();
            }
            $producto = Producto::create([
                'producto' => $row['producto'],
                'descripcion' => $row['descripcion'],
                'precio_a' => $row['precio_a'],
                'precio_b' => $row['precio_b'],
                'imagen' => $row['imagen'],
                'user_id' => $user->id
            ]);
            if (count($tiendas) > 0) {
                foreach ($tiendas as $tienda) {
                    if($user->roles->id === 7) {
                        $tienda_id = $tienda->id;
                    }elseif($user->roles->id === 3) {
                        $tienda_id = $tienda->tienda->id;
                    }
                    ProductQuantity::create([
                        'producto_id' => $producto->id,
                        'tienda_id' => $tienda_id,
                        'cantidad' => $row['cantidad' . '_' . $tienda_id] !== null ? $row['cantidad' . '_' . $tienda_id] : 0,
                        'inventariable' => $row['inventariable' . '_' . $tienda_id] === 'si' ? 1 : 0
                    ]);
                }
            }

            if ($row['adicional'] !== null && $row['precio'] !== null || count($adicionales) > 0) {
                foreach ($adicionales as $key => $adicional) {
                    Adicional::create([
                        'producto_id' => $producto->id,
                        'adicional' => $adicional,
                        'precio' => intval($precio[$key])
                    ]);
                }
            }
            foreach ($categories as $category) {
                $categoria = Category::where('categoria', $category)->first();
                if (isset($categoria->id)) {
                    CategoriaProducto::create([
                        'categoria_id' => $categoria->id,
                        'producto_id' => $producto->id
                    ]);
                }
            }
        }
    }

    public function batchSize(): int
    {
        //numero maximo de inserciones que se haran
        return 1000;
    }

    public function chunkSize(): int
    {
        //numero de filas maximo de lineas que leera en el archivo excel
        return 1000;
    }
}
