<?php

namespace App\Http\Controllers;

use App\DataTables\SaleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Repositories\SaleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use App\Models\Product;

class SaleController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sale.
     *
     * @param SaleDataTable $saleDataTable
     * @return Response
     */
    public function index(SaleDataTable $saleDataTable)
    {
        return $saleDataTable->render('sales.index');
    }

    /**
     * Show the form for creating a new Sale.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::pluck('name','id')->toarray();
        $customers = User::pluck('name','id')->toarray();
        $products = Product::all();
        $products = $products->keyBy('id');
        return view('sales.create', compact('users', 'customers', 'products'));
    }

    /**
     * Store a newly created Sale in storage.
     *
     * @param CreateSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleRequest $request)
    {
        $input = $request->all();
        $input["products"] = json_encode($input["products"]);
        $sale = $this->saleRepository->create($input);

        Flash::success('Venta guardada con éxito.');

        return redirect(route('sales.index'));
    }

    /**
     * Display the specified Sale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }
        $products = Product::all();
        $products = $products->keyBy('id');

        return view('sales.show')->with(compact('sale', 'products'));
    }

    /**
     * Show the form for editing the specified Sale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }
        $users = User::pluck('name','id')->toarray();
        $customers = User::pluck('name','id')->toarray();
        $products = Product::all();
        $products = $products->keyBy('id');
        return view('sales.edit')->with(compact('sale','users', 'customers', 'products'));
    }

    /**
     * Update the specified Sale in storage.
     *
     * @param  int              $id
     * @param UpdateSaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleRequest $request)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }
        $input = $request->all();
        $input["products"] = json_encode($input["products"]);
        $sale = $this->saleRepository->update($input, $id);

        Flash::success('Venta actualizada con éxito.');

        return redirect(route('sales.index'));
    }

    /**
     * Remove the specified Sale from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Venta no encontrada');

            return redirect(route('sales.index'));
        }

        $this->saleRepository->delete($id);

        Flash::success('Venta eliminada con éxito.');

        return redirect(route('sales.index'));
    }
}
