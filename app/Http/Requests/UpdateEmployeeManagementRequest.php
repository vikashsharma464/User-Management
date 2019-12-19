<?php

namespace App\Http\Requests;

use App\EmployeeManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEmployeeManagementRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('employee_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'employee_name'  => [
                'min:4',
                'max:20',
                'required',
            ],
            'employee_email' => [
                'required',
                'unique:employee_managements,employee_email,' . request()->route('employee_management')->id,
            ],
            'address'        => [
                'required',
            ],
            'gender'         => [
                'required',
            ],
            'mobile'         => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'dob'            => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'doj'            => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
