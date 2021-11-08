<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Role;

class RoleController extends Controller
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
        return view('role.index');
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
    public function store(StoreRoleRequest $request)
    {
        $response = [];
        try {
            $role = new Role;
            $role->code = $request->code;
            $role->name = $request->name;
            $role->save();
            $response['status'] = TRUE;
            $response['message'] = 'Role has been saved';
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
        $role = Role::findOrFail($id);
        return view('role.show')
            ->with('role', $role);
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
    public function update(UpdateRoleRequest $request, $id)
    {
        $response = [];
        try {
            $role = Role::find($id);
            $role->code = $request->code;
            $role->name = $request->name;
            $role->save();
            $response['status'] = TRUE;
            $response['message'] = 'Role has been updated';
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
            $role = Role::find($id);
            $role->delete();
            $result = TRUE;
        } catch (Exception $e) {
            $result = FALSE;
        }
        return $result;
    }

    public function delete(Request $request){
        //return $request->all();
        $response =[];
        if(count($request->id)){
            foreach($request->id as $id){
                $destroy = $this->destroy($id);
                if($destroy == TRUE){
                    $response['status'] = TRUE;
                    $response['message'] = 'Selected role has been deleted';
                }
            }
        }else{
            $response['status'] = FALSE;
            $response['message'] = 'No data supplied';
        }
        return response()->json($response);
    }
}
