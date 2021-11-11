<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;
use App\User;
class UserDatatablesController extends Controller
{
    public function index(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $users = User::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'email'
        ])
        ->with([
            'roles'=>function($query){
                return $query->select('roles.id','roles.name');
            }
        ]);
        $datatables = DataTables::of($users)
                ->addColumn('action', function($row){
                    return NULL;
                })
                ->rawColumns(['action']);

        return $datatables->make(true);
    }
}
