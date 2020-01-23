<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Compound;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware ('auth:api', ['except'=>'login']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            ['data' => User::orderBy('id','DESC')->get(), 'success' => true]
        );
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $message = '';
        try {
            $User = new User();
            $postData = $request->except('id', '_method');
            $postData['password'] = Hash::make($postData['password'] ?? 'password');
            $User->fill($postData);
            $success = $User->save();
            $data = $User;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = true;
        }
        return compact('data', 'message', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [];
        $message = '';

        try {

            $data = User::findOrFail($id);
            $success = true;

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = true;
        }
        return compact('data', 'message', 'id');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [];
        $message = '';

        try {

            $User = User::findOrFail($id);
            $success = true;
            $postData = $request->except('id');
            $postData['password'] = Hash::make($postData['password'] ?? 'password');
            $success = $User->update($postData);
            $data = $User;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = true;
        }
        return compact('data', 'message', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = [];
        $message = 'User deleted';
        $success = true;
        try {

            $User = User::findOrFail($id);
            $data = $User;
            $success = $User->delete();
        } catch (\Exception $e){
            $success = false;
            $message = 'User not found';
        }
        return compact('data', 'message', 'success');
     }
}
