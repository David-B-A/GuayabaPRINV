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

class StockMovementController extends AppBaseController
{
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
