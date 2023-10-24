<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index() {
        $sales = Sale::all();
        if(count($sales) > 0){
            return json_encode([
                'success' => true,
                'data' => $sales
            ]);
        } else {
            return json_encode([
                'success' => true,
                'messages' => __('messages.sales_list_empty')
            ]);
        }
    }

    public function create(Request $request) {
        //Definición de mensajes de error y validación de parámetros
        $messages = [
            'employee_id.required' =>__('messages.employee_id_required'),
            'employee_id.numeric' =>__('messages.employee_id_numeric'),
            'employee_id.exists' =>__('messages.employee_id_exists'),
            'product_id.required' =>__('messages.product_id_required'),
            'product_id.numeric' =>__('messages.product_id_numeric'),
            'product_id.exists' => __('messages.product_not_found'),
            'quantity.required' => __('messages.product_quantity_required'),
            'quantity.numeric' => __('messages.product_quantity_numeric'),
        ];

        $rules = [
            'employee_id' => 'required|numeric|exists:employees,id',
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        //Devuelve errores
        if($validator->fails()){
            $errors = "";
            foreach($validator->errors()->messages() as $message){
                foreach($message as $error){
                    $errors .= "" . $error . "  //  ";
                }
            }
            return json_encode([
                'status' => 'error',
                'message' => json_encode($errors)
            ]);
        }

        //Valida el stock disponible
        $stock = $this->getProductStock($request->product_id);
        if($stock > $request->quantity) {
            //Creo arreglo de datos para registro de venta
            $sale_data = [
                'employee_id' => $request->employee_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ];
            $sale = new Sale($sale_data);
            
            $product = Product::find($request->product_id);
            
            //Calcula nuevo stock, actualiza producto y registra venta
            $new_stock = $this->substractStock($product, $request->quantity);
            $product_data = [
                'stock' => $new_stock
            ];
            $product->fill($product_data);
            if($product->save()){
                $sale->save();
                return json_encode([
                    'success' => true,
                    'message' => __('messages.sale_registered')
                ]);
            } else {
                return json_encode([
                    'success' => false,
                    'messages' => __('messages.sale_not_registered')
                ]);
            }
        } else {
            return json_encode([
                'success' => false,
                'message' => __('messages.stock_not_available')
            ]);
        }
    }

    //Obtiene el stock disponible
    public function getProductStock($product_id) {
        $product = Product::find($product_id);
        return $product->stock;
    }

    //Resta stock para la venta
    public function substractStock($product, $quantity){
        $stock = $product->stock;
        $new_stock = $stock - $quantity;
        return $new_stock;
    }

    //Producto más vendido
    public function getMostSoldProduct() {
        $sales = DB::table('sales')
                ->leftJoin('products', 'product_id', '=', 'products.id')
                ->orderBy('quantity', 'desc')
                ->take(1)
                ->get();
        
        return json_encode([
            'success' => true,
            'data' =>$sales 
        ]);
    }
}
