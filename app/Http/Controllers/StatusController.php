<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Models\Status;
use App\Services\StatusService;

class StatusController extends Controller
{
    protected $service;

    public function __construct(StatusService $service)
    {
        $this->service = $service;
    }

    /**
     * @lrd:start
     * Show all status
     * @lrd:end
     */
    public function index()
    {
        return $this->service->getAllStatus();
    }

    /**
     * @lrd:start
     * Create a status
     * @lrd:end
     */
    public function store(StatusRequest $request)
    {
        $this->authorize('create', Status::class);

        $status = $this->service->createStatus($request);

        return ['message' => "Status {$status->name} criado com sucesso"];
    }

    /**
     * @lrd:start
     * Update a status
     * @lrd:end
     */
    public function update(StatusRequest $request, Status $status)
    {
        $this->authorize('update', $status);

        $this->service->updateStatus($status, $request);

        return ['message' => 'Status atualizado com sucesso'];
    }

    /**
     * @lrd:start
     * Delete a status
     * @lrd:end
     */
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);

        $this->service->destroyStatus($status);

        return ['message' => 'Status removido com sucesso'];
    }
}
