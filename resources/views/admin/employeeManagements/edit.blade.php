@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employeeManagement.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-managements.update", [$employeeManagement->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_name">{{ trans('cruds.employeeManagement.fields.employee_name') }}</label>
                <input class="form-control {{ $errors->has('employee_name') ? 'is-invalid' : '' }}" type="text" name="employee_name" id="employee_name" value="{{ old('employee_name', $employeeManagement->employee_name) }}" required>
                @if($errors->has('employee_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.employee_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="employee_email">{{ trans('cruds.employeeManagement.fields.employee_email') }}</label>
                <input class="form-control {{ $errors->has('employee_email') ? 'is-invalid' : '' }}" type="text" name="employee_email" id="employee_email" value="{{ old('employee_email', $employeeManagement->employee_email) }}" required>
                @if($errors->has('employee_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.employee_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.employeeManagement.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $employeeManagement->address) }}" required>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.employeeManagement.fields.gender') }}</label>
                @foreach(App\EmployeeManagement::GENDER_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="gender_{{ $key }}" name="gender" value="{{ $key }}" {{ old('gender', $employeeManagement->gender) === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="gender_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('gender'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="photo">{{ trans('cruds.employeeManagement.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mobile">{{ trans('cruds.employeeManagement.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="number" name="mobile" id="mobile" value="{{ old('mobile', $employeeManagement->mobile) }}" step="1" required>
                @if($errors->has('mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mobile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="dob">{{ trans('cruds.employeeManagement.fields.dob') }}</label>
                <input class="form-control date {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="text" name="dob" id="dob" value="{{ old('dob', $employeeManagement->dob) }}" required>
                @if($errors->has('dob'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dob') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.dob_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="doj">{{ trans('cruds.employeeManagement.fields.doj') }}</label>
                <input class="form-control date {{ $errors->has('doj') ? 'is-invalid' : '' }}" type="text" name="doj" id="doj" value="{{ old('doj', $employeeManagement->doj) }}" required>
                @if($errors->has('doj'))
                    <div class="invalid-feedback">
                        {{ $errors->first('doj') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeManagement.fields.doj_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    var uploadedPhotoMap = {}
Dropzone.options.photoDropzone = {
    url: '{{ route('admin.employee-managements.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photo[]" value="' + response.name + '">')
      uploadedPhotoMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotoMap[file.name]
      }
      $('form').find('input[name="photo[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($employeeManagement) && $employeeManagement->photo)
      var files =
        {!! json_encode($employeeManagement->photo) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photo[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection