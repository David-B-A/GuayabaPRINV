<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProcessTemplateAPIRequest;
use App\Http\Requests\API\UpdateProcessTemplateAPIRequest;
use App\Models\ProcessTemplate;
use App\Repositories\ProcessTemplateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProcessTemplateController
 * @package App\Http\Controllers\API
 */

class ProcessTemplateAPIController extends AppBaseController
{
    /** @var  ProcessTemplateRepository */
    private $processTemplateRepository;

    public function __construct(ProcessTemplateRepository $processTemplateRepo)
    {
        $this->processTemplateRepository = $processTemplateRepo;
    }

    /**
     * Display a listing of the ProcessTemplate.
     * GET|HEAD /processTemplates
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $processTemplates = $this->processTemplateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($processTemplates->toArray(), 'Process Templates retrieved successfully');
    }

    /**
     * Store a newly created ProcessTemplate in storage.
     * POST /processTemplates
     *
     * @param CreateProcessTemplateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProcessTemplateAPIRequest $request)
    {
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);

        $processTemplate = $this->processTemplateRepository->create($input);

        return $this->sendResponse($processTemplate->toArray(), 'Process Template saved successfully');
    }

    /**
     * Display the specified ProcessTemplate.
     * GET|HEAD /processTemplates/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ProcessTemplate $processTemplate */
        $processTemplate = $this->processTemplateRepository->find($id);

        if (empty($processTemplate)) {
            return $this->sendError('Process Template not found');
        }

        return $this->sendResponse($processTemplate->toArray(), 'Process Template retrieved successfully');
    }

    /**
     * Update the specified ProcessTemplate in storage.
     * PUT/PATCH /processTemplates/{id}
     *
     * @param int $id
     * @param UpdateProcessTemplateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProcessTemplateAPIRequest $request)
    {
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);

        /** @var ProcessTemplate $processTemplate */
        $processTemplate = $this->processTemplateRepository->find($id);

        if (empty($processTemplate)) {
            return $this->sendError('Process Template not found');
        }

        $processTemplate = $this->processTemplateRepository->update($input, $id);

        return $this->sendResponse($processTemplate->toArray(), 'ProcessTemplate updated successfully');
    }

    /**
     * Remove the specified ProcessTemplate from storage.
     * DELETE /processTemplates/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ProcessTemplate $processTemplate */
        $processTemplate = $this->processTemplateRepository->find($id);

        if (empty($processTemplate)) {
            return $this->sendError('Process Template not found');
        }

        $processTemplate->delete();

        return $this->sendSuccess('Process Template deleted successfully');
    }
}
