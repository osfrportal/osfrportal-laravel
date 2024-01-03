@extends('osfrportal::layout')
@section('content')
    <div class="pt-0">
        <table class="table table-sm dataTable no-footer" id="table-movements">
            <thead>
                <tr>
                    <th>Дата события</th>
                    <th>Событие</th>
                    <th>Работник</th>
                    <th>Должность</th>
                    <th>Подразделение</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@push('footer-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#table-movements').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                order: [
                    [0, 'desc'],
                ],
                ajax: "{{ route('osfrportal.admin.persons.movements.all') }}",
                columns: [{
                        data: 'movementeventdate',
                        name: 'movementeventdate'
                    },
                    {
                        data: 'movementtype',
                        name: 'movementtype',
                    },
                    {
                        data: 'movementdata',
                    },
                    {
                        data: 'movementdata',
                    },
                    {
                        data: 'movementdata',
                    },
                ],
                columnDefs: [{
                        targets: 0,
                        orderable: true,
                        searchable: true,
                        className: 'dt-body-center dt-head-center',
                        render: DataTable.render.date(),
                    },
                    {
                        targets: 1,
                        orderable: true,
                        searchable: true,
                        className: 'dt-body-center dt-head-center',
                        render: function(data, type, full, meta) {
                            let arr = Object.values(data);
                            return arr[1];
                        }
                    },
                    {
                        targets: 2,
                        orderable: true,
                        searchable: true,
                        className: 'dt-body-center dt-head-center',
                        render: function(data, type, full, meta) {
                            return data.movementPersonFullFIO;
                        }
                    },
                    {
                        targets: 3,
                        orderable: true,
                        searchable: true,
                        className: 'dt-body-left dt-head-center',
                        render: function(data, type, full, meta) {
                            //let arr = Object.entries(data);
                            //console.table(arr);
                            if (data.movementType == 2) {
                                return data.movementAppointmentOld;
                            }
                            if (data.movementType == 1) {
                                return 'Старая: ' + data.movementAppointmentOld + '<br>Новая: ' +
                                    data.movementAppointmentNew;
                            }
                            return data.movementAppointmentNew;
                        }
                    },
                    {
                        targets: 4,
                        orderable: true,
                        searchable: true,
                        className: 'dt-body-left dt-head-center',
                        render: function(data, type, full, meta) {
                            //let arr = Object.entries(data);
                            //console.table(arr);
                            if (data.movementType == 2) {
                                return data.movementDepartmentOld;
                            }
                            if (data.movementType == 1) {
                                return 'Старое: ' + data.movementDepartmentOld + '<br>Новое: ' +
                                    data.movementDepartmentNew;
                            }
                            return data.movementDepartmentNew;
                        }
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    //console.table(data);
                    if (data['movementdata'].movementType == 2) {
                        $(row).addClass('table-danger');
                    }
                    if (data['movementdata'].movementType == 3) {
                        $(row).addClass('table-success');
                    }
                    if (data['movementdata'].movementType == 1) {
                        $(row).addClass('table-warning');
                    }
                    if (data['movementdata'].movementType == 4) {
                        $(row).addClass('table-info');
                    }
                }
            });
        });
    </script>
@endpush
