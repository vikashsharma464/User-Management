<?php

namespace App\Http\Controllers\Admin;

use App\EmployeeManagement;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeManagementRequest;
use App\Http\Requests\StoreEmployeeManagementRequest;
use App\Http\Requests\UpdateEmployeeManagementRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeManagementController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeManagements = EmployeeManagement::all();

        return view('admin.employeeManagements.index', compact('employeeManagements'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeeManagements.create');
    }

    public function store(StoreEmployeeManagementRequest $request)
    {
        $employeeManagement = EmployeeManagement::create($request->all());

        foreach ($request->input('photo', []) as $file) {
            $employeeManagement->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photo');
        }

        return redirect()->route('admin.employee-managements.index');
    }

    public function edit(EmployeeManagement $employeeManagement)
    {
        abort_if(Gate::denies('employee_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeeManagements.edit', compact('employeeManagement'));
    }

    public function update(UpdateEmployeeManagementRequest $request, EmployeeManagement $employeeManagement)
    {
        $employeeManagement->update($request->all());

        if (count($employeeManagement->photo) > 0) {
            foreach ($employeeManagement->photo as $media) {
                if (!in_array($media->file_name, $request->input('photo', []))) {
                    $media->delete();
                }
            }
        }

        $media = $employeeManagement->photo->pluck('file_name')->toArray();

        foreach ($request->input('photo', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $employeeManagement->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photo');
            }
        }

        return redirect()->route('admin.employee-managements.index');
    }

    public function show(EmployeeManagement $employeeManagement)
    {
        abort_if(Gate::denies('employee_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeeManagements.show', compact('employeeManagement'));
    }

    public function destroy(EmployeeManagement $employeeManagement)
    {
        abort_if(Gate::denies('employee_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeManagement->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeManagementRequest $request)
    {
        EmployeeManagement::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
