@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeManagement->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.employee_name') }}
                        </th>
                        <td>
                            {{ $employeeManagement->employee_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.employee_email') }}
                        </th>
                        <td>
                            {{ $employeeManagement->employee_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.address') }}
                        </th>
                        <td>
                            {{ $employeeManagement->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.gender') }}
                        </th>
                        <td>
                            {{ App\EmployeeManagement::GENDER_RADIO[$employeeManagement->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.photo') }}
                        </th>
                        <td>
                            @foreach($employeeManagement->photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.mobile') }}
                        </th>
                        <td>
                            {{ $employeeManagement->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.dob') }}
                        </th>
                        <td>
                            {{ $employeeManagement->dob }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.doj') }}
                        </th>
                        <td>
                            {{ $employeeManagement->doj }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-managements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection