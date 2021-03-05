<?php

namespace App\Http\Controllers;

use App\DataTables\StockMovementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateStockMovementRequest;
use App\Http\Requests\UpdateStockMovementRequest;
use App\Repositories\StockMovementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Process;
use App\Models\StockMovement;

class StockMovementController extends AppBaseController
{
    static function managePurchase(Purchase $purchase, $action, $diff_json_status = True){
        // Three posible actions: store, update, delete.
        $purchase_products = json_decode($purchase->products);
        if($action == 'delete') {
            $stockMovements = StockMovement::where('purchase',$purchase->id)->get();
            StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);
        } else if($action == 'update') {
            if ($purchase->status != 'Recibido'){
                $stockMovements = StockMovement::where('purchase',$purchase->id)->get();
                StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);
            } else if($diff_json_status) {
                $stockMovements = StockMovement::where('purchase',$purchase->id)->get();
                StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);

                //positive ammount in purchase products movements because the stock increases
                foreach($purchase_products as $purchase_product){
                    $input = ['product' => $purchase_product->producto, 'purchase' => $purchase->id, 'ammount' => $purchase_product->cantidad * $purchase_product->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($input);
                }
            }
        } else if($action == 'store'){
            if($purchase->status == 'Recibido'){
                foreach($purchase_products as $purchase_product){
                    $input = ['product' => $purchase_product->producto, 'purchase' => $purchase->id, 'ammount' => $purchase_product->cantidad * $purchase_product->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($input);
                }
            }
        }
    }
    static function manageSale(Sale $sale, $action, $diff_json_status = True){
        // Three posible actions: store, update, delete.
        $sale_products = json_decode($sale->products);
        if($action == 'delete') {
            $stockMovements = StockMovement::where('sale',$sale->id)->get();
            StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);
        } else if($action == 'update') {
            if($sale->status != 'Entregado' && $sale->status != 'En transporte'){
                $stockMovements = StockMovement::where('sale',$sale->id)->get();
                StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);
            }else if($diff_json_status) {
                $stockMovements = StockMovement::where('sale',$sale->id)->get();
                StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);

                //negative ammount in sale products movements because the stock decreases
                foreach($sale_products as $sale_product){
                    $input = ['product' => $sale_product->producto, 'sale' => $sale->id, 'ammount' => -$sale_product->cantidad * $sale_product->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($input);
                }
            }
        } else if($action == 'store'){
            if($sale->status == 'Entregado' || $sale->status == 'En transporte'){
                foreach($sale_products as $sale_product){
                    $input = ['product' => $sale_product->producto, 'sale' => $sale->id, 'ammount' => -$sale_product->cantidad * $sale_product->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($input);
                }
            }
        }
    }
    static function manageProcess(Process $process, $action, $diff_json_status = True){
        // Three posible actions: store, update, delete.
        $process_inputs = json_decode($process->inputs);
        $process_outputs = json_decode($process->outputs);
        if($action == 'delete') {
            $stockMovements = StockMovement::where('process',$process->id)->get();
            StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);
        } else if($action == 'update') {
            if($process->status != 'Realizado'){
                $stockMovements = StockMovement::where('process',$process->id)->get();
                StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);
            }else if($diff_json_status) {
                $stockMovements = StockMovement::where('process',$process->id)->get();
                StockMovementController::deleteMovementsAndUpdateProduct($stockMovements);

                //negative ammount in process inputs movements because the stock decreases
                foreach($process_inputs as $process_input){
                    $input = ['product' => $process_input->producto, 'process' => $process->id, 'ammount' => -$process_input->cantidad * $process_input->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($input);
                }
                //positive ammount in process outputs movements because the stock increases 
                foreach($process_outputs as $process_output){
                    $output = ['product' => $process_output->producto, 'process' => $process->id, 'ammount' => $process_output->cantidad * $process_output->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($output);
                }
            }
        } else if($action == 'store'){
            if($process->status == 'Realizado'){

                //negative ammount in process inputs movements because the stock decreases
                foreach($process_inputs as $process_input){
                    $input = ['product' => $process_input->producto, 'process' => $process->id, 'ammount' => -$process_input->cantidad * $process_input->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($input);
                }
                //positive ammount in process outputs movements because the stock increases 
                foreach($process_outputs as $process_output){
                    $output = ['product' => $process_output->producto, 'process' => $process->id, 'ammount' => $process_output->cantidad * $process_output->presentacion->kg];
                    StockMovementController::createMovementAndUpdateProduct($output);
                }
            }
        }
    }

    static function deleteMovementsAndUpdateProduct($stockMovements){
        foreach($stockMovements as $stockMovement) {
            $product = Product::find($stockMovement->product);
            $product->stock -= $stockMovement->ammount;
            $product->save();
            $stockMovement->delete();
        }
    }
    static function createMovementAndUpdateProduct($input){
        $stockMovement = StockMovement::create($input);
        $product = Product::find($stockMovement->product);
        $product->stock += $stockMovement->ammount;
        $product->save();
    }

    private $stockMovementRepository;

    public function __construct(StockMovementRepository $stockMovementRepo)
    {
        $this->stockMovementRepository = $stockMovementRepo;
    }

    public function index(StockMovementDataTable $stockMovementDataTable)
    {
        return $stockMovementDataTable->render('stock_movements.index');
    }

    public function store(CreateStockMovementRequest $request)
    {
        $input = $request->all();
        $input["products"] = json_encode($input["products"]);
        $stockMovement = $this->stockMovementRepository->create($input);

        return $stockMovement;
    }

    public function update($id, UpdateStockMovementRequest $request)
    {
        $stockMovement = $this->stockMovementRepository->find($id);

        if (empty($stockMovement)) {

            return False;
        }
        $input = $request->all();
        $stockMovement = $this->stockMovementRepository->update($input, $id);

        return $stockMovement;
    }

    public function destroy($id)
    {
        $stockMovement = $this->stockMovementRepository->find($id);

        if (empty($stockMovement)) {

            return False;
        }

        $this->stockMovementRepository->delete($id);

        return True;
    }
}
