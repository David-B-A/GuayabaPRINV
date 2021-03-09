<?php

namespace App\Http\Controllers;

use App\DataTables\ProcessDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProcessRequest;
use App\Http\Requests\UpdateProcessRequest;
use App\Repositories\ProcessRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use App\Models\Product;
use App\Models\ProcessTemplate;
use Auth;

class ProcessController extends AppBaseController
{
    /** @var  ProcessRepository */
    private $processRepository;

    public function __construct(ProcessRepository $processRepo)
    {
        $this->processRepository = $processRepo;
    }

    /**
     * Display a listing of the Process.
     *
     * @param ProcessDataTable $processDataTable
     * @return Response
     */
    public function index(ProcessDataTable $processDataTable)
    {
        return $processDataTable->render('processes.index');
    }

    /**
     * Show the form for creating a new Process.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::pluck('name','id')->toarray();

        $responsibles = User::whereHas(
            'roles', function($q){
                $q->whereIn('name', ['Admin','Responsable de producción']);
            })->pluck('name','id')->toarray();

        $products = Product::all();
        $products = $products->keyBy('id');
        $process_templates = ProcessTemplate::all();
        $process_templates = $process_templates->keyBy('id');
        return view('processes.create', compact('users', 'responsibles', 'products', 'process_templates'));
    }

    /**
     * Store a newly created Process in storage.
     *
     * @param CreateProcessRequest $request
     *
     * @return Response
     */
    public function store(CreateProcessRequest $request)
    {
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);
        $input["user"] = Auth::user()->id;
        $process = $this->processRepository->create($input);
        StockMovementController::manageProcess($process, 'store');

        Flash::success('Proceso guardado con éxito.');

        return redirect(route('processes.index'));
    }

    /**
     * Display the specified Process.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $process = $this->processRepository->find($id);

        if (empty($process)) {
            Flash::error('Proceso no encontrado');

            return redirect(route('processes.index'));
        }

        return view('processes.show')->with('process', $process);
    }

    /**
     * Show the form for editing the specified Process.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $process = $this->processRepository->find($id);

        if (empty($process)) {
            Flash::error('Proceso no encontrado');

            return redirect(route('processes.index'));
        }

        $users = User::pluck('name','id')->toarray();
        $responsibles = User::pluck('name','id')->toarray();
        $products = Product::all();
        $products = $products->keyBy('id');
        $process_templates = ProcessTemplate::all();
        $process_templates = $process_templates->keyBy('id');
        return view('processes.edit')->with(compact('process','users', 'responsibles', 'products', 'process_templates'));
    }

    /**
     * Update the specified Process in storage.
     *
     * @param  int              $id
     * @param UpdateProcessRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProcessRequest $request)
    {
        $process = $this->processRepository->find($id);

        if (empty($process)) {
            Flash::error('Proceso no encontrado');

            return redirect(route('processes.index'));
        }
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);
        $input["user"] = Auth::user()->id;

        $diff_json_status = $process->inputs != $input["inputs"] || $process->outputs != $input["outputs"] || $process->status != $input["status"];

        $process = $this->processRepository->update($input, $id);
        StockMovementController::manageProcess($process, 'update', $diff_json_status);

        Flash::success('Proceso actualizado con éxito.');

        return redirect(route('processes.index'));
    }

    /**
     * Remove the specified Process from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $process = $this->processRepository->find($id);

        if (empty($process)) {
            Flash::error('Proceso no encontrado');

            return redirect(route('processes.index'));
        }
        StockMovementController::manageProcess($process, 'delete');

        $this->processRepository->delete($id);

        Flash::success('Proceso eliminado con éxito.');

        return redirect(route('processes.index'));
    }
}
