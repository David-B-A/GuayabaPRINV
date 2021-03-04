<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProcessAPIRequest;
use App\Http\Requests\API\UpdateProcessAPIRequest;
use App\Models\Process;
use App\Repositories\ProcessRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProcessController
 * @package App\Http\Controllers\API
 */

class ProcessAPIController extends AppBaseController
{
    /** @var  ProcessRepository */
    private $processRepository;

    public function __construct(ProcessRepository $processRepo)
    {
        $this->processRepository = $processRepo;
    }

    /**
     * Display a listing of the Process.
     * GET|HEAD /processes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $processes = $this->processRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($processes->toArray(), 'Processes retrieved successfully');
    }

    /**
     * Store a newly created Process in storage.
     * POST /processes
     *
     * @param CreateProcessAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProcessAPIRequest $request)
    {
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);

        $process = $this->processRepository->create($input);

        return $this->sendResponse($process->toArray(), 'Process saved successfully');
    }

    /**
     * Display the specified Process.
     * GET|HEAD /processes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Process $process */
        $process = $this->processRepository->find($id);

        if (empty($process)) {
            return $this->sendError('Process not found');
        }

        return $this->sendResponse($process->toArray(), 'Process retrieved successfully');
    }

    /**
     * Update the specified Process in storage.
     * PUT/PATCH /processes/{id}
     *
     * @param int $id
     * @param UpdateProcessAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProcessAPIRequest $request)
    {
        $input = $request->all();
        $input["inputs"] = json_encode($input["inputs"]);
        $input["outputs"] = json_encode($input["outputs"]);
        $input["metadata"] = json_encode($input["metadata"]);

        /** @var Process $process */
        $process = $this->processRepository->find($id);

        if (empty($process)) {
            return $this->sendError('Process not found');
        }

        $process = $this->processRepository->update($input, $id);

        return $this->sendResponse($process->toArray(), 'Process updated successfully');
    }

    /**
     * Remove the specified Process from storage.
     * DELETE /processes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Process $process */
        $process = $this->processRepository->find($id);

        if (empty($process)) {
            return $this->sendError('Process not found');
        }

        $process->delete();

        return $this->sendSuccess('Process deleted successfully');
    }
}
