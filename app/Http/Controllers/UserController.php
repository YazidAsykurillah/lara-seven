<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\User;

class UserController extends Controller
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
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_options = \App\Role::get();
        return view('user.create')
            ->with('role_options', $role_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $response=[];
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt('12345678');
            $user->save();

            //if there are submitted roles then assign user to the roles
            $roles = $request->role_name;
            if($roles){
                $user->assignRole($roles);    
            }

            $response['status'] = TRUE;
            $response['message'] = 'User has been created';
            $response['data']['url'] = url('/user/'.$user->id);
            
        } catch (Exception $e) {
            return $e;
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
        $user = User::findOrFail($id);
        return view('user.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role_options = \App\Role::get();
        return view('user.edit')
            ->with('user', $user)
            ->with('role_options', $role_options);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $response=[];
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            //if there are submitted roles then assign user to the roles
            $roles = $request->role_name;
            if($roles){
                $user->syncRoles($roles);    
            }

            $response['status'] = TRUE;
            $response['message'] = 'User has been updated';
            $response['data']['url'] = url('/user/'.$user->id);
            
        } catch (Exception $e) {
            return $e;
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
            $user = User::find($id);
            //Super Admin is NOT deletable
            if($user->hasRole('Super Admin')){
                $result = FALSe;
            }else{
                $user->delete();
                $result = TRUE;    
            }
        } catch (Exception $e) {
            $result = FALSE;
        }
        return $result;
    }

    public function delete(Request $request)
    {
        $response =[];
        if(count($request->id)){
            $counter = 0;
            foreach($request->id as $id){
                $destroy = $this->destroy($id);
                if($destroy == TRUE){
                    $counter++;
                }
            }
            $response['status'] = TRUE;
            $response['message'] = $counter.' user(s) has been deleted';
        }else{
            $response['status'] = FALSE;
            $response['message'] = 'No data supplied';
        }
        return response()->json($response);
    }
}
