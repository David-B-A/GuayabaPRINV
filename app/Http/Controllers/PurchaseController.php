<?php

namespace App\Http\Controllers;

use App\DataTables\PurchaseDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Repositories\PurchaseRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use App\Models\Product;

class PurchaseController extends AppBaseController
{
    /** @var  PurchaseRepository */
    private $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaseRepository = $purchaseRepo;
    }

    /**
     * Display a listing of the Purchase.
     *
     * @param PurchaseDataTable $purchaseDataTable
     * @return Response
     */
    public function index(PurchaseDataTable $purchaseDataTable)
    {
        return $purchaseDataTable->render('purchases.index');
    }

    /**
     * Show the form for creating a new Purchase.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::pluck('name','id')->toarray();
        $suppliers = User::pluck('name','id')->toarray();
        $products = Product::all();
        $products = $products->keyBy('id');
        return view('purchases.create', compact('users', 'suppliers', 'products'));
    }

    /**
     * Store a newly created Purchase in storage.
     *
     * @param CreatePurchaseRequest $request
     *
     * @return Response
     */
    public function store(CreatePurchaseRequest $request)
    {
        $input = $request->all();
        $input["products"] = json_encode($input["products"]);
        $purchase = $this->purchaseRepository->create($input);

        Flash::success('Purchase saved successfully.');

        return redirect(route('purchases.index'));
    }

    /**
     * Display the specified Purchase.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }
        $products = Product::all();
        $products = $products->keyBy('id');

        return view('purchases.show')->with(compact('purchase', 'products'));
    }

    /**
     * Show the form for editing the specified Purchase.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $purchase = $this->purchaseRepository->find($id);
        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }
        $users = User::pluck('name','id')->toarray();
        $suppliers = User::pluck('name','id')->toarray();
        $products = Product::all();
        $products = $products->keyBy('id');
        return view('purchases.edit')->with(compact('purchase','users', 'suppliers', 'products'));
    }

    /**
     * Update the specified Purchase in storage.
     *
     * @param  int              $id
     * @param UpdatePurchaseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePurchaseRequest $request)
    {
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }
        $input = $request->all();
        $input["products"] = json_encode($input["products"]);
        $purchase = $this->purchaseRepository->update($input, $id);

        Flash::success('Purchase updated successfully.');

        return redirect(route('purchases.index'));
    }

    /**
     * Remove the specified Purchase from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('purchases.index'));
        }

        $this->purchaseRepository->delete($id);

        Flash::success('Purchase deleted successfully.');

        return redirect(route('purchases.index'));
    }
}
