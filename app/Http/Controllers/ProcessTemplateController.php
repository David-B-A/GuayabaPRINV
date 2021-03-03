<?php

namespace App\Http\Controllers;

use App\DataTables\ProcessTemplateDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProcessTemplateRequest;
use App\Http\Requests\UpdateProcessTemplateRequest;
use App\Repositories\ProcessTemplateRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Product;

class ProcessTemplateController extends AppBaseController
{
    /** @var  ProcessTemplateRepository */
    private $processTemplateRepository;

    public function __construct(ProcessTemplateRepository $processTemplateRepo)
    {
        $this->processTemplateRepository = $processTemplateRepo;
    }

    /**
     * Display a listing of the ProcessTemplate.
     *
     * @param ProcessTemplateDataTable $processTemplateDataTable
     * @return Response
     */
    public function index(ProcessTemplateDataTable $processTemplateDataTable)
    {
        return $processTemplateDataTable->render('process_templates.index');
    }

    /**
     * Show the form for creating a new ProcessTemplate.
     *
     * @return Response
     */
    public function create()
    {
        $products = Product::all();
        $products = $products->keyBy('id');
        return view('process_templates.create',compact('products'));
    }

    /**
     * Store a newly created ProcessTemplate in storage.
     *
     * @param CreateProcessTemplateRequest $request
     *
     * @return Response
     */
    public function store(CreateProcessTemplateRequest $request)
    {
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);
        $processTemplate = $this->processTemplateRepository->create($input);

        Flash::success('Proceso Estándar guardado con éxito.');

        return redirect(route('processTemplates.index'));
    }

    /**
     * Display the specified ProcessTemplate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $processTemplate = $this->processTemplateRepository->find($id);

        if (empty($processTemplate)) {
            Flash::error('Proceso Estándar no encontrado');

            return redirect(route('processTemplates.index'));
        }
        $products = Product::all();
        $products = $products->keyBy('id');

        return view('process_templates.show')->with(compact('processTemplate', 'products'));
    }

    /**
     * Show the form for editing the specified ProcessTemplate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $processTemplate = $this->processTemplateRepository->find($id);

        if (empty($processTemplate)) {
            Flash::error('Proceso Estándar no encontrado');

            return redirect(route('processTemplates.index'));
        }

        $products = Product::all();
        $products = $products->keyBy('id');
        return view('process_templates.edit')->with(compact('processTemplate', 'products'));
    }

    /**
     * Update the specified ProcessTemplate in storage.
     *
     * @param  int              $id
     * @param UpdateProcessTemplateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProcessTemplateRequest $request)
    {
        $processTemplate = $this->processTemplateRepository->find($id);

        if (empty($processTemplate)) {
            Flash::error('Proceso Estándar no encontrado');

            return redirect(route('processTemplates.index'));
        }
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);

        $processTemplate = $this->processTemplateRepository->update($input, $id);

        Flash::success('Proceso Estándar actualizado con éxito.');

        return redirect(route('processTemplates.index'));
    }

    /**
     * Remove the specified ProcessTemplate from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $processTemplate = $this->processTemplateRepository->find($id);

        if (empty($processTemplate)) {
            Flash::error('Proceso Estándar no encontrado');

            return redirect(route('processTemplates.index'));
        }

        $this->processTemplateRepository->delete($id);

        Flash::success('Proceso Estándar eliminado con éxito.');

        return redirect(route('processTemplates.index'));
    }
}
