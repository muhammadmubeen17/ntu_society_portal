<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Entities\Users;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users_data = Users::get();

        return view('users::index', ['users_data' => $users_data]);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  * @return Renderable
    //  */
    // public function create()
    // {
    //     return view('users::create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  * @param Request $request
    //  * @return Renderable
    //  */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'fullname'      => 'required|min:2|max:12',
    //         'username'      => 'required|unique:users,username|min:8',
    //         'email'         => 'required|unique:users,email|email',
    //         'password'      => 'required|min:8',
    //         'phone'         => 'required|min:11',
    //     ]);

    //     $full_name          = $request->fullname;
    //     $username           = $request->username;
    //     $reg_number         = $request->registration_number;
    //     $email              = $request->email;
    //     $phone              = $request->phone;
    //     $password           = $request->password;
    //     $is_active          = $request->is_active;
    //     $user_role          = $request->user_role;

    //     if ($request->file('image_path')) {
    //         $picture       = !empty($request->file('image_path')) ? $request->file('image_path')->getClientOriginalName() : '';
    //         $request->file('image_path')->move(public_path('uploads/users/uploads/'), $picture);
    //     }

    //     $users = new Users();

    //     $users->full_name       = $full_name;
    //     $users->username        = $username;
    //     $users->reg_number      = isset($reg_number) && !empty($reg_number) ? $reg_number : '';
    //     $users->email           = $email;
    //     $users->phone_number    = $phone;
    //     $users->password        = Hash::make($password);
    //     $users->is_active       = !empty($is_active) ? '1' : '0';
    //     $users->role            = $user_role;
    //     $users->image_path      = isset($picture) && !empty($picture) ? $picture : '';

    //     $users->save();

    //     return redirect()->route("users.list")->withSuccess("User created successfully");
    // }

    // /**
    //  * Show the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function show($id)
    // {
    //     return view('users::show');
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function edit($id)
    // {
    //     $user_data = Users::find($id);

    //     return view('users::edit', ['page_data' => $user_data]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  * @param Request $request
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'firstname'     => 'required|min:2|max:12',
    //         'username'      => "required|min:8|unique:users,username,$id",
    //         'email'         => "required|email|unique:users,email,$id"
    //     ]);

    //     $first_name         = $request->firstname;
    //     $last_name          = $request->lastname;
    //     $username           = $request->username;
    //     $email              = $request->email;
    //     $password           = $request->password;
    //     $is_active          = $request->is_active;
    //     $user_role          = $request->user_role;

    //     if ($request->file('image_path')) {
    //         $picture       = !empty($request->file('image_path')) ? $request->file('image_path')->getClientOriginalName() : '';
    //         $request->file('image_path')->move(public_path('uploads/users/uploads/'), $picture);
    //     }

    //     $users = Users::find($id);

    //     if (!empty($first_name)) {

    //         $users->first_name      = $first_name;
    //     }

    //     $users->last_name       = $last_name;

    //     if (!empty($username)) {

    //         $users->username        = $username;
    //     }

    //     if (!empty($email)) {

    //         $users->email           = $email;
    //     }

    //     if (!empty($password)) {
    //         $request->validate([
    //             'password'      => 'required|min:8',
    //         ]);
    //         $users->password        = Hash::make($password);
    //     }

    //     $users->is_active       = !empty($is_active) ? '1' : '0';

    //     if (!empty($user_role)) {

    //         $users->role       = $user_role;
    //     }

    //     if (!empty($request->file('image_path'))) {
    //         $users->image_path      = isset($picture) && !empty($picture) ? $picture : '';
    //     }

    //     $users->save();

    //     return redirect()->back()->withSuccess("User updated successfully");
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function destroy($id)
    // {
    //     $user = Users::find($id);

    //     if (!empty($user)) {

    //         $user->delete();
    //         return redirect()->back()->withSuccess("User deleted successfully");
    //     } else {

    //         return redirect()->back()->withErrors("Something went wrong");
    //     }
    // }
}
