<?php

namespace Modules\Society\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $society = Society::with(['members.student', 'societyForm'])->find($id);

        $totalMembers = SocietyMembers::where('society_id', $id)->count();

        $society_forms = SocietyForms::where('society_id', $id)->get();
        $society_forms_count = SocietyForms::where('society_id', $id)->count();

        // echo "<pre>";
        // print_r($society_forms_count);
        // exit;


        $society->totalMembers = $totalMembers;
        $society->society_forms = $society_forms;
        $society->society_forms_count = $society_forms_count;

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
            'message' => "Form created Successfully."
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
        SocietyForms::where('active', true)->update(['active' => false]);

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
}
