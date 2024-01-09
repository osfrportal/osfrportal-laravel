<?php

namespace Osfrportal\OsfrportalLaravel\Http\Controllers\Admin;

use Carbon\Carbon;
use Yajra\DataTables\DataTables;

use Osfrportal\OsfrportalLaravel\Enums\StorageTypesEnum;
use Osfrportal\OsfrportalLaravel\Enums\StorageCategoryTypesEnum;

use Osfrportal\OsfrportalLaravel\Models\SfrStorage;
use Illuminate\Http\Request;
use Osfrportal\OsfrportalLaravel\Http\Requests\StorageAddNewRequest;
class SFRStorageController extends Controller
{

    private $permissionManage = 'flash-manage';

    public function index(Request $request)
    {
        $this->authorize($this->permissionManage);
        if ($request->ajax()) {
            $model = SfrStorage::with(['person', 'journalcheck'])->select('sfrstorage.*');

            return Datatables::of($model)
                ->setRowId('storuuid')
                ->make(true);
        } else {
            return view('osfrportal::admin.storage.index');
        }
    }

    public function create()
    {
        $this->authorize($this->permissionManage);
        $StorageTypes = StorageTypesEnum::toArray();
        $StorageCategoryTypes = StorageCategoryTypesEnum::toArray();
        return view('osfrportal::admin.storage.create', ['StorageTypes' => $StorageTypes, 'StorageCategoryTypes' => $StorageCategoryTypes]);
    }

    public function store(StorageAddNewRequest $request)
    {
        //dump($request->all());
        //dump($request->validated());
        $this->flasher_interface->addSuccess('Устройство хранения успешно добавлено');
        return redirect()->route('osfrportal.admin.storage.index');
    }
}
