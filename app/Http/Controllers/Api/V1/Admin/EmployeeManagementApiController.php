<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\EmployeeManagement;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEmployeeManagementRequest;
use App\Http\Requests\UpdateEmployeeManagementRequest;
use App\Http\Resources\Admin\EmployeeManagementResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeManagementApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeManagementResource(EmployeeManagement::all());
    }

    public function store(StoreEmployeeManagementRequest $request)
    {
        $employeeManagement = EmployeeManagement::create($request->all());

        if ($request->input('photo', false)) {
            $employeeManagement->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        return (new EmployeeManagementResource($employeeManagement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeManagement $employeeManagement)
    {
        abort_if(Gate::denies('employee_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeManagementResource($employeeManagement);
    }

    public function update(UpdateEmployeeManagementRequest $request, EmployeeManagement $employeeManagement)
    {
        $employeeManagement->update($request->all());

        if ($request->input('photo', false)) {
            if (!$employeeManagement->photo || $request->input('photo') !== $employeeManagement->photo->file_name) {
                $employeeManagement->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
        } elseif ($employeeManagement->photo) {
            $employeeManagement->photo->delete();
        }

        return (new EmployeeManagementResource($employeeManagement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeManagement $employeeManagement)
    {
        abort_if(Gate::denies('employee_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeManagement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
