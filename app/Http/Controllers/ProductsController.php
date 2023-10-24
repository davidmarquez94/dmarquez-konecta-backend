<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Product;

class ProductsController extends Controller
{
    //Lista de productos
    public function index() {
        $products = Product::with('category')->get();
        if(count($products) == 0) {
            return json_encode([
                'success' => true,
                'message' => __('messages.products_empty_list')
            ]);
        } else {
            return json_encode([
                'success' => true,
                'data' => $products
            ]);
        }
    }

    //Ver detalle de producto
    public function getProduct($id){
        $product= Product::where('id', $id)->with('category')->get();
        if(count($product) > 0){
            return json_encode([
                'success' => true,
                'data' => $product
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => __('messages.product_not_found')
            ]);
        }
    }

    //Crear producto
    public function create(Request $request){
        //Definición de mensajes de error y validación de parámetros
        $messages = [
            'name.required' => __('messages.product_name_required'),
            'reference.required' => __('messages.product_reference_required'),
            'price.required' => __('messages.product_price_required'),
            'price.numeric' => __('messages.product_price_numeric'),
            'weight.required' => __('messages.product_weight_required'),
            'weight.numeric' => __('messages.product_weight_numeric'),
            'stock.required' => __('messages.product_stock_required'),
            'stock.numeric' => __('messages.product_stock_numeric'),
            'category_id.required' => __('messages.product_category_id_required'),
            'category_id.numeric' => __('messages.product_category_id_numeric'),
            'category_id.exists' => __('messages.product_category_id_exists'),
        ];

        $rules = [
            'name' => 'required',
            'reference' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|numeric|exists:categories,id'
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
        
        //Creo arreglo de datos de producto para guardar en base de datos
        $product_data = [
            'name' => $request->name,
            'reference' => $request->reference,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ];

        $product = new Product($product_data);
        if($product->save()) {
            return json_encode([
                'success' => true,
                'message' => __('messages.product_created_successfully', ['name' => $product->name])
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => __('messages.product_not_created')
            ]);
        }
    }

    public function update(Request $request) {

        //Encuentro producto para dar continuidad al método
        $product = Product::find($request->id);
        if($product == null) {
            return json_encode([
                'success' => false,
                'message' => __('messages.product_not_found')
            ]);
        }

        //Definición de mensajes de error y validación de parámetros
        $messages = [
            'name.required' => __('messages.product_name_required'),
            'reference.required' => __('messages.product_reference_required'),
            'price.required' => __('messages.product_price_required'),
            'price.numeric' => __('messages.product_price_numeric'),
            'weight.required' => __('messages.product_weight_required'),
            'weight.numeric' => __('messages.product_weight_numeric'),
            'stock.required' => __('messages.product_stock_required'),
            'stock.numeric' => __('messages.product_stock_numeric'),
            'category_id.required' => __('messages.product_category_id_required'),
            'category_id.numeric' => __('messages.product_category_id_numeric'),
            'category_id.exists' => __('messages.product_category_id_exists'),
        ];

        $rules = [
            'name' => 'required',
            'reference' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|numeric|exists:categories,id'
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
        
        //Creo arreglo de datos de producto para guardar en base de datos
        $product_data = [
            'name' => $request->name,
            'reference' => $request->reference,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ];

        $product->fill($product_data);
        if($product->save()) {
            return json_encode([
                'success' => true,
                'message' => __('messages.product_updated_successfully', ['name' => $product->name])
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => __('messages.product_not_updated')
            ]);
        }
    }

    //Elimina productos
    public function destroy($id) {
        $product = Product::find($id);
        if($product == null){
            return json_encode([
                'success' => false,
                'message' => __('messages.product_not_found')
            ]);
        }
        if($product->delete()){
            return json_encode([
                'success' => true,
                'message' => __('messages.product_deleted', ['name' => $product->name])
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => __('messages.product_not_deleted')
            ]);
        }
    }

    //Producto con mayor stock
    public function getProductWithMajorStock() {
        $product = Product::orderBy('stock', 'desc')->take(1)->get();
        if(count($product) > 0){
            return json_encode([
                'success' => true,
                'data' => $product
            ]);
        } else {
            return json_encode([
                'success' => true,
                'message' => __('messages.products_empty_list')
            ]);
        }
    }

}
