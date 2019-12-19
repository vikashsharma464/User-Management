@extends('layouts.admin')
@section('content')
@can('employee_management_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.employee-managements.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeManagement.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeManagement.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeManagement">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.employee_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.employee_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.dob') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.doj') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeManagement.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeManagements as $key => $employeeManagement)
                        <tr data-entry-id="{{ $employeeManagement->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeManagement->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeManagement->employee_name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeManagement->employee_email ?? '' }}
                            </td>
                            <td>
                                {{ $employeeManagement->address ?? '' }}
                            </td>
                            <td>
                                {{ App\EmployeeManagement::GENDER_RADIO[$employeeManagement->gender] ?? '' }}
                            </td>
                            <td>
                                @foreach($employeeManagement->photo as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        <img src="{{ $media->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $employeeManagement->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $employeeManagement->dob ?? '' }}
                            </td>
                            <td>
                                {{ $employeeManagement->doj ?? '' }}
                            </td>
                            <td>
                                {{ $employeeManagement->created_at ?? '' }}
                            </td>
                            <td>
                                @can('employee_management_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-managements.show', $employeeManagement->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_management_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-managements.edit', $employeeManagement->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_management_delete')
                                    <form action="{{ route('admin.employee-managements.destroy', $employeeManagement->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('employee_management_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-managements.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-EmployeeManagement:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection