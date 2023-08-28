<?php

namespace Modules\Students\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Modules\Students\Entities\Students;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users_data = Students::get();

        return view('students::index', ['users_data' => $users_data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('students::create');
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
            'registration_number' => 'required|unique:students,reg_number',
            'password' => 'required|min:8',
            'phone' => 'required|min:11',
            // 'user_role' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $full_name = $request->fullname;
        $username = $request->username;
        $reg_number = $request->registration_number;
        $email = $request->email;
        $phone = $request->phone;
        $password = $request->password;
        $is_active = $request->is_active;
        // $user_role = $request->user_role;

        
        $student = new Students();
        
        if ($request->hasFile('image_path')) {

            $file = $request->file('image_path');
            // hc_get_image_path store image in folder and return image path
            $student->image_path = hc_store_and_get_image_path('students', $file);
        }
        $student->full_name = $full_name;
        $student->username = $username;
        $student->reg_number = isset($reg_number) && !empty($reg_number) ? $reg_number : '';
        $student->email = $email;
        $student->phone_number = $phone;
        $student->password = Hash::make($password);
        $student->is_active = !empty($is_active) ? '1' : '0';
        // $student->role = $user_role;

        $student->save();

        $user = new User();

        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->student_id = $student->id;
        $user->role = 'student';
        $user->is_active = !empty($is_active) ? '1' : '0';

        $user->save();

        return redirect()->route("students.list")->withSuccess("The new student record has been created successfully.");
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('students::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user_data = Students::find($id);

        return view('students::edit', ['page_data' => $user_data]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $user = User::where('student_id', $id)->first();

        $request->validate([
            'fullname' => 'required|min:3',
            'username' => "required|min:8|unique:users,username,$user->id",
            'email' => "required|email|unique:users,email,$user->id",
            'registration_number' => "required|unique:students,reg_number,$id",
            'password' => 'nullable|min:8',
            'phone' => 'required|min:11',
            // 'user_role' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $student = Students::find($id);

        $student->full_name = $request->input('fullname');
        $student->username = $request->input('username');
        $student->reg_number = $request->input('registration_number');
        $student->email = $request->input('email');
        $student->phone_number = $request->input('phone');

        if ($request->filled('password')) {
            $student->password = Hash::make($request->input('password'));
        }

        $student->is_active = $request->has('is_active') ? '1' : '0';
        // $student->role = $request->input('user_role');

        if ($request->hasFile('image_path')) {
            // Delete previous image
            if (!empty($student->image_path)) {
                hc_delete_attachment_from_directory($student->image_path, 'students');
            }

            $file = $request->file('image_path');
            // hc_get_image_path store image in folder and return image path
            $student->image_path = hc_store_and_get_image_path('students', $file);
        }

        $student->save();


        // User record edit

        if (!$user) {
            $user = new User();
            $user->role = 'student';
        }

        $user->username = $student->username;
        $user->email = $student->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->student_id = $student->id;
        $user->is_active = $student->is_active;
        $user->save();

        return redirect()->back()->withSuccess("The student record has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $student = Students::find($id);

        if (!empty($student)) {
            // Delete image from directory
            if (!empty($student->image_path)) {
                hc_delete_attachment_from_directory($student->image_path, 'students');
            }
            $student->delete();
            return redirect()->back()->withSuccess("The student record has been deleted successfully.");
        } else {

            return redirect()->back()->withErrors("Failed to delete the student record. Please try again later.");
        }
    }
}