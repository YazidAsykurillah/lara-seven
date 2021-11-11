<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $response = [];
        try {
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->save();
            $response['status'] = TRUE;
            $response['message'] = 'Permission has been saved';
        } catch (Exception $e) {
            
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $response = [];
        try {
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->save();
            $response['status'] = TRUE;
            $response['message'] = 'Permission has been updated';
        } catch (Exception $e) {
            
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = FALSE;
        try {
            $permission = Permission::find($id);
            $permission->delete();
            $result = TRUE;
        } catch (Exception $e) {
            $result = FALSE;
        }
        return $result;
    }

    public function delete(Request $request){
        $response =[];
        if(count($request->id)){
            foreach($request->id as $id){
                $destroy = $this->destroy($id);
                if($destroy == TRUE){
                    $response['status'] = TRUE;
                    $response['message'] = 'Selected permission has been deleted';
                }
            }
        }else{
            $response['status'] = FALSE;
            $response['message'] = 'No data supplied';
        }
        return response()->json($response);
    }
}
