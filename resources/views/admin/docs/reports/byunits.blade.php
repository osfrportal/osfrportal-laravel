@extends('osfrportal::layout')
@section('content')
    <form method="POST" action="{{ route('osfrportal.admin.docs.reports.byunits') }}">
        @csrf
        <div class="mb-3">
            <label for="js-all-sfrunits-ajax" class="form-label">Подразделения</label>
            @include('osfrportal::admin.docs.reports.select2units')
            <div class="form-text">Если не выбрано подразделение - отбор идет по всем подразделениям.</div>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="withChildUnits" name="withChildUnits"
                    value="1">
                <label class="form-check-label" for="withChildUnits">Включая подчиненные подразделения</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="withoutAppMOP" name="withoutAppMOP"
                    value="1" checked>
                <label class="form-check-label" for="withoutAppMOP">Не включать должности МОП (младший обслуживающий
                    персонал)</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="withoutDekret" name="withoutDekret"
                    value="1" checked>
                <label class="form-check-label" for="withoutDekret">Не включать работников, находящихся в декрете</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="js-all-sfrdocs-ajax" class="form-label">Документы</label>
            @include('osfrportal::admin.docs.reports.select2docs')
            <div class="form-text">Если не выбран документ - отбор идет по всем документам.</div>
        </div>

        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="withoutSigns" name="withoutSigns"
                    value="1">
                <label class="form-check-label" for="withoutSigns">Отобразить только не ознакомившихся</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Сформировать ведомость</button>
    </form>
@endsection
