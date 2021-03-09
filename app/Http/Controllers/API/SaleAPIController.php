<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSaleAPIRequest;
use App\Http\Requests\API\UpdateSaleAPIRequest;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

/**
 * Class SaleController
 * @package App\Http\Controllers\API
 */

class SaleAPIController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sale.
     * GET|HEAD /sales
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sales = $this->saleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($sales->toArray(), 'Sales retrieved successfully');
    }

    /**
     * Store a newly created Sale in storage.
     * POST /sales
     *
     * @param CreateSaleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleAPIRequest $request)
    {
        $input = $request->all();
        $input["products"] = json_encode($input["products"]);
        $input["user"] = Auth::user()->id;
        $sale = $this->saleRepository->create($input);

        return $this->sendResponse($sale->toArray(), 'Sale saved successfully');
    }

    /**
     * Display the specified Sale.
     * GET|HEAD /sales/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        return $this->sendResponse($sale->toArray(), 'Sale retrieved successfully');
    }

    /**
     * Update the specified Sale in storage.
     * PUT/PATCH /sales/{id}
     *
     * @param int $id
     * @param UpdateSaleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleAPIRequest $request)
    {
        $input = $request->all();

        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }
        $input["products"] = json_encode($input["products"]);
        $input["user"] = Auth::user()->id;
        $sale = $this->saleRepository->update($input, $id);

        return $this->sendResponse($sale->toArray(), 'Sale updated successfully');
    }

    /**
     * Remove the specified Sale from storage.
     * DELETE /sales/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        $sale->delete();

        return $this->sendSuccess('Sale deleted successfully');
    }
}
