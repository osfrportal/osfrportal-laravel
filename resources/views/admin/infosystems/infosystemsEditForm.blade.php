@extends('osfrportal::layout')
@section('content')
    <form method="POST" action="{{ route('osfrportal.admin.infosystems.save') }}">
        <input type="hidden" id="isysid" name="isysid" value="{{ old('isysid', !is_null($infoSystemData) ? $infoSystemData->isysid : Str::uuid()) }}">
        <div class="mb-3 row">
            <label for="isys_name" class="col-sm-2 col-form-label">Название</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('isys_name') is-invalid @enderror" id="isys_name"
                    name="isys_name" value="{{ old('isys_name', !is_null($infoSystemData) ? $infoSystemData->isys_name : '') }}">
                @error('isys_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <label for="parent_isysid" class="col-sm-2 col-form-label">Родительская ИС</label>
            <div class="col-sm-10">
                 <select class="form-select @error('parent_isysid') is-invalid @enderror" id="parent_isysid" name="parent_isysid">
                                <option>-</option>
                                @foreach ($infoSystemsRoot as $rootInfosystem)

                                        <option value="{{ $rootInfosystem->isysid }}" @selected(old('parent_isysid') == $rootInfosystem->isysid)>{{ $rootInfosystem->isys_name }}
                                        </option>

                                @endforeach
                            </select>
                @error('parent_isysid')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <a class="btn btn-primary" href="{{ route('osfrportal.admin.infosystems.index') }}" role="button">Назад</a>
        <input class="btn btn-primary" type="submit" value="Сохранить">
    </form>
@endsection
