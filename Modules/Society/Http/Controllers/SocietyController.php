<?php

namespace Modules\Society\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Society\Entities\Discussion;
use Modules\Society\Entities\FormResponse;
use Modules\Society\Entities\SocietyMembers;
use Modules\Society\Entities\Society;
use Modules\Society\Entities\SocietyForms;
use Modules\Staff\Entities\Staff;
use Modules\Students\Entities\Students;

class SocietyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // Fetch all society records from the database
        $societies = Society::all();
        // Calculate the total members for each society
        foreach ($societies as $society) {
            $totalMembers = SocietyMembers::where('society_id', $society->id)->count();
            $society->totalMembers = $totalMembers; // Add the totalMembers property to the $society object
        }

        return view('society::index', ['societies' => $societies]);
    }

    public function view_societies()
    {
        // Fetch all society records from the database
        $societies = Society::all();

        // Calculate the total members for each society
        foreach ($societies as $society) {
            $totalMembers = SocietyMembers::where('society_id', $society->id)->count();
            $society->totalMembers = $totalMembers; // Add the totalMembers property to the $society object
        }

        return view('society::view_societies', ['societies' => $societies]);
    }

    public function view_society($id)
    {
        // Fetch all society records from the database
        $society = Society::with(['members.user', 'societyForm'])->find($id);

        $totalMembers = SocietyMembers::where('society_id', $id)->count();

        $society_forms = SocietyForms::where('society_id', $id)->get();
        $society_forms_count = SocietyForms::where('society_id', $id)->count();

        $society_form_responses = FormResponse::with(['forms', 'users', 'users.student', 'users.staff'])
            ->where('society_id', $id)
            ->whereHas('forms', function ($query) {
                $query->where('active', true);
            })
            ->get();

        $society_form_responses_count = FormResponse::where('society_id', $id)->count();

        $society->totalMembers = $totalMembers;
        $society->society_forms = $society_forms;
        $society->society_forms_count = $society_forms_count;
        $society->society_form_responses = $society_form_responses;
        $society->society_form_responses_count = $society_form_responses_count;

        // echo "<pre>";
        // print_r($society_form_responses->toArray());
        // exit;

        return view('society::view_society', ['society' => $society]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // Get all staff members
        $staffMembers = Staff::all();
        // Get all students
        $students = Students::all();

        // Pass the staff members to the view
        return view('society::create', ['staffMembers' => $staffMembers, 'students' => $students]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|min:3',
        ]);

        // Create a new society record in the database
        $society = new Society();

        $society->name = $request->name;
        $society->convener_id = $request->convener;
        $society->president_id = $request->president;
        $society->border_color = $request->border_color;

        if ($request->hasFile('image_path')) {

            $file = $request->file('image_path');
            // hc_get_image_path store image in folder and return image path
            $society->image_path = hc_store_and_get_society_image_path('societies', $request->name, $file);
        }

        $society->save();

        // Redirect to a success page or show a success message
        return redirect()->route("society.list")->withSuccess("The new society record has been created successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // Find the society with the given ID
        $society = Society::find($id);

        // Fetch all staff members and students for the dropdowns
        $staffMembers = Staff::all();
        $students = Students::all();

        // Pass the retrieved data to the view
        return view('society::edit', [
            'society' => $society,
            'staffMembers' => $staffMembers,
            'students' => $students,
        ]);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Find the society with the given ID
        $society = Society::find($id);

        if (!$society) {
            // If society with the given ID is not found, redirect back with a message
            return redirect()->back()->with('error', 'Society not found.');
        }

        // Update the society data
        $society->name = $request->input('name');
        $society->convener_id = $request->input('convener');
        $society->president_id = $request->input('president');
        $society->border_color = $request->input('border_color');

        // Handle image upload (if a new image is provided)
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists
            // Delete previous image
            if (!empty($society->image_path)) {
                hc_delete_attachment_from_directory($society->image_path, 'societies');
            }

            $file = $request->file('image_path');
            // hc_get_image_path store image in folder and return image path
            $society->image_path = hc_store_and_get_society_image_path('societies', $society->name, $file);
        }

        // Save the updated data
        $society->save();

        // Redirect back to the edit page with a success message
        return redirect()->back()->withSuccess("The society record has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $society = Society::find($id);

        if (!empty($society)) {
            // Delete image from directory if it exists
            if (!empty($society->image_path)) {
                hc_delete_attachment_from_directory($society->image_path, 'societies');
            }

            // Delete the society record
            $society->delete();

            return redirect()->back()->withSuccess("The society record has been deleted successfully.");
        } else {
            return redirect()->back()->withErrors("Failed to delete the society record. Please try again later.");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function member_destroy($sid, $mid)
    {
        $member = SocietyMembers::find($mid);

        if (!empty($member)) {

            // Delete the member record
            $member->delete();

            return redirect()->back()->withSuccess("The member record has been deleted successfully.");
        } else {
            return redirect()->back()->withErrors("Failed to delete the member record. Please try again later.");
        }
    }

    /**
     * create form.
     * @param int $id
     * @return Renderable
     */
    public function createform($id)
    {
        $society = Society::find($id);
        return view('society::createform', ['society' => $society]);
    }

    public function storeformdata(Request $request)
    {
        if (empty(json_decode($request->formData))) {
            return json_encode(array(
                'success' => false,
                'message' => "Form is empty."
            ));
            die();
        }

        $society_form = new SocietyForms();
        $society_form->society_id = $request->societyId;
        $society_form->form_title = $request->form_title;
        $society_form->form_data = $request->formData;
        $society_form->save();

        return json_encode(array(
            'success' => true,
            'message' => "Form created Successfully.",
            'redirect' => route('society.view', $request->societyId)
        ));

        die();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function form_destroy($sid, $fid)
    {
        $form = SocietyForms::find($fid);

        if (!empty($form)) {

            // Delete the form record
            $form->delete();

            return redirect()->back()->withSuccess("The form has been deleted successfully.");
        } else {
            return redirect()->back()->withErrors("Failed to delete the form. Please try again later.");
        }
    }

    /**
     * Show the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function view_society_form($sid, $fid)
    {
        $society = Society::find($sid);
        $society_form = SocietyForms::find($fid);

        if (!empty($society_form)) {
            $society_form->form_data = json_decode($society_form->form_data);
            $society->society_form = $society_form;

            return view('society::view_society_form', ['society' => $society]);
        } else {
            return redirect()->back()->withErrors("Failed to open form. Please try again later.");
        }
    }

    /**
     * Show the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function form_active(Request $request, $sid, $fid)
    {
        // Update all records in SocietyForms table
        SocietyForms::where('society_id', $sid)->where('active', true)->update(['active' => false]);

        $society_form = SocietyForms::find($fid);

        $form_active_checkbox = $request->form_active_checkbox == 'on' ? true : false;

        if (!empty($society_form)) {
            $society_form->active = $form_active_checkbox;
            $society_form->save();

            if ($form_active_checkbox == true) {
                return redirect()->back()->withSuccess("Form is activated");
            } else {
                return redirect()->back()->withSuccess("Form is deactivated");
            }
        } else {
            return redirect()->back()->withErrors("Form not found.");
        }
    }

    /**
     * Show the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function submit_form_data(Request $request)
    {
        if (empty(json_decode($request->formData))) {
            return json_encode(array(
                'success' => false,
                'message' => "Form is empty."
            ));
            die();
        }

        if ($request->formActive) {
            $society_form_response = new FormResponse();
            $society_form_response->society_id = $request->societyId;
            $society_form_response->user_id = Auth::id();
            $society_form_response->form_id = $request->formId;
            $society_form_response->form_title = $request->form_title;
            $society_form_response->form_data = $request->formData;
            $society_form_response->save();

            if (auth()->user()->role == 'student') {
                return json_encode(array(
                    'success' => true,
                    'message' => "Form submited Successfully.",
                    'redirect' => route('student.view.society', $request->societyId)
                ));
            }

            return json_encode(array(
                'success' => true,
                'message' => "Form submited Successfully.",
                'redirect' => route('society.view', $request->societyId)
            ));
        } else {
            if (auth()->user()->role == 'student') {
                return json_encode(array(
                    'success' => 'not_active',
                    'message' => "Form is not active.",
                    'redirect' => route('student.view.society', $request->societyId)
                ));
            }

            return json_encode(array(
                'success' => 'not_active',
                'message' => "Form is not active.",
                'redirect' => route('society.view', $request->societyId)
            ));
        }

        die();
    }

    /**
     * Show the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function view_society_registrationforms(Request $request)
    {
        $society_forms = SocietyForms::with('society')->get();

        $society_forms_count = SocietyForms::all()->count();
        return view('society::view_registration_form', ['society_forms' => $society_forms, 'society_forms_count' => $society_forms_count]);
    }

    /**
     * Show the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function view_society_form_response(Request $request, $sid, $fid)
    {
        $society_form = FormResponse::with(['society', 'users', 'users.student', 'users.staff'])->find($fid);
        $society_form->form_data = json_decode($society_form->form_data);

        return view('society::view_society_form_response', ['society_form' => $society_form]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function form_response_destroy($sid, $fid)
    {
        $form = FormResponse::find($fid);

        if (!empty($form)) {

            // Delete the form record
            $form->delete();

            return redirect()->back()->withSuccess("The form Response has been deleted successfully.");
        } else {
            return redirect()->back()->withErrors("Failed to delete the form Response. Please try again later.");
        }
    }

    /**
     * Add members.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add_member_to_society(Request $request)
    {
        $response = FormResponse::where('id', $request->responseID)
            ->where('society_id', $request->societyId)
            ->where('user_id', $request->userID)
            ->first();

        if ($response) {
            $isChecked = $request->accepted;
            $status = $isChecked == 'true' ? 'accept' : 'pending';

            $response->update(['status' => $status]);

            if ($status == 'accept') {
                // Check if the member record already exists
                $existingMember = SocietyMembers::where('user_id', $request->userID)
                    ->where('society_id', $request->societyId)
                    ->first();

                if (!$existingMember) {
                    $member = new SocietyMembers();
                    $member->user_id = $request->userID;
                    $member->society_id = $request->societyId;
                    $member->save();
                }
            } elseif ($status == 'pending') {
                SocietyMembers::where('user_id', $request->userID)
                    ->where('society_id', $request->societyId)
                    ->delete();
            }

            return response()->json([
                'success' => true,
                'message' => "Response Status Updated.",
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Form response not found.'
        ]);
    }

    public function societies_discussions() {
        // Fetch all society records from the database
        $societies = Society::all();
        // Calculate the total members for each society
        foreach ($societies as $society) {
            $totalMembers = SocietyMembers::where('society_id', $society->id)->count();
            $society->totalMembers = $totalMembers; // Add the totalMembers property to the $society object
        }

        return view("society::socities_discussion", ['societies' => $societies]);
    }

    public function society_discussions($societyID) {
        // Fetch society record from the database
        $society = Society::with(['members.student', 'societyForm'])->find($societyID);
        $totalMembers = SocietyMembers::where('society_id', $societyID)->count();
        $society->totalMembers = $totalMembers;

        // Fetch discussions of the society
        $discussions = Discussion::with('users.staff', 'society')->where('society_id', $societyID)->get();
        $society->discussions = $discussions;

        // echo "<pre>";
        // print_r($society->discussions->toArray());
        // exit;

        return view("society::society_discussion", ['society' => $society]);
    }

    public function fetchDiscussions(Request $request)
    {
        // Fetch discussions of the society
        $discussions = Discussion::with('users', 'society')->where('society_id', $request->societyId)->get();

        $formattedDiscussions = [];

        foreach ($discussions as $discussion) {
            $isMine = $discussion->user_id === auth()->user()->id;
            $usernameAlignmentClass = $isMine ? 'right' : 'left';
            $timeAlignmentClass = $isMine ? 'left' : 'right';

            if($discussion->users->role == 'admin' || $discussion->users->role == 'staff') {
                $image_path = isset($discussion->users->staff->image_path) && $discussion->users->staff->image_path ? 'uploads/staff/uploads/' . $discussion->users->staff->image_path : 'images/user-thumb.jpg';
            } else {
                $image_path = isset($discussion->users->student->image_path) && $discussion->users->student->image_path ? 'uploads/students/uploads/' . $discussion->users->student->image_path : 'images/user-thumb.jpg';
            }

            $formattedDiscussion = [
                'user_name' => $discussion->users->username,
                'user_avatar' => asset($image_path),
                'message' => $discussion->message,
                'created_at' => $discussion->created_at->format('d M h:i a'),
                'is_mine' => $discussion->user_id === auth()->user()->id,
                'username_alignment_class' => $usernameAlignmentClass,
                'time_alignment_class' => $timeAlignmentClass,
            ];

            $formattedDiscussions[] = $formattedDiscussion;
        }

        return response()->json($formattedDiscussions);
    }

    public function saveDiscussions(Request $request)
    {
        // Validate input, if needed
        // print_r($request->all());
        // exit;

        $discussion = new Discussion();
        $discussion->society_id = $request->societyId;
        $discussion->user_id = auth()->user()->id;
        $discussion->message = $request->message;
        $discussion->save();

        return response()->json(['success' => true]);
    }
}
