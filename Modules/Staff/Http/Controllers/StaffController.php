<?php

namespace Modules\Staff\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Modules\Staff\Entities\Staff;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users_data = Staff::get();

        return view('staff::index', ['users_data' => $users_data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('staff::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|min:3',
            'username' => 'required|unique:users,username|min:8',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
            'phone' => 'required|min:11',
            // 'user_role' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $full_name = $request->fullname;
        $username = $request->username;
        $email = $request->email;
        $phone = $request->phone;
        $password = $request->password;
        $is_active = $request->is_active;
        // $user_role = $request->user_role;

        $staff = new Staff();

        if ($request->hasFile('image_path')) {

            $file = $request->file('image_path');
            // hc_get_image_path store image in folder and return image path
            $staff->image_path = hc_store_and_get_image_path('staff', $file);
        }
        $staff->full_name = $full_name;
        $staff->username = $username;
        $staff->email = $email;
        $staff->phone_number = $phone;
        $staff->password = Hash::make($password);
        $staff->is_active = !empty($is_active) ? '1' : '0';
        // $staff->role = $user_role;

        $staff->save();

        $user = new User();

        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->staff_id = $staff->id;
        $user->role = 'staff';
        $user->is_active = !empty($is_active) ? '1' : '0';

        $user->save();

        return redirect()->route("staff.list")->withSuccess("The new staff record has been created successfully.");
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('staff::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user_data = Staff::find($id);

        return view('staff::edit', ['page_data' => $user_data]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $user = User::where('staff_id', $id)->first();

        $request->validate([
            'fullname' => 'required|min:3',
            'username' => "required|min:8|unique:users,username,$user->id",
            'email' => "required|email|unique:users,email,$user->id",
            'password' => 'nullable|min:8',
            'phone' => 'required|min:11',
            // 'user_role' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $staff = Staff::find($id);

        $staff->full_name = $request->input('fullname');
        $staff->username = $request->input('username');
        $staff->email = $request->input('email');
        $staff->phone_number = $request->input('phone');

        if ($request->filled('password')) {
            $staff->password = Hash::make($request->input('password'));
        }

        $staff->is_active = $request->has('is_active') ? '1' : '0';
        // $staff->role = $request->input('user_role');

        if ($request->hasFile('image_path')) {
            // Delete previous image
            if (!empty($staff->image_path)) {
                hc_delete_attachment_from_directory($staff->image_path, 'staff');
            }

            $file = $request->file('image_path');
            // hc_get_image_path store image in folder and return image path
            $staff->image_path = hc_store_and_get_image_path('staff', $file);
        }

        $staff->save();


        // User record edit

        if (!$user) {
            $user = new User();
            $user->role = 'staff';
        }

        $user->username = $staff->username;
        $user->email = $staff->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->staff_id = $staff->id;
        $user->is_active = $staff->is_active;
        $user->save();

        return redirect()->back()->withSuccess("The staff record has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $student = Staff::find($id);

        if (!empty($student)) {
            // Delete image from directory
            if (!empty($student->image_path)) {
                hc_delete_attachment_from_directory($student->image_path, 'staff');
            }
            $student->delete();
            return redirect()->back()->withSuccess("The staff record has been deleted successfully.");
        } else {

            return redirect()->back()->withErrors("Failed to delete the staff record. Please try again later.");
        }
    }
}