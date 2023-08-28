<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Modules\Society\Entities\Discussion;
use Modules\Society\Entities\FormResponse;
use Modules\Society\Entities\Society;
use Modules\Society\Entities\SocietyForms;
use Modules\Society\Entities\SocietyMembers;
use Modules\Users\Entities\Users;

class HomeController extends Controller
{
    public function login_screen()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            if (auth()->user()->is_active == 0) {

                Session::flush();
                Auth::logout();

                return redirect()->back()->withErrors([
                    'message' => 'Your account is disabled.',
                ]);
            }

            if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
                return redirect()->route("dashboard")->withSuccess('Signed In Successfully');
            } elseif (auth()->user()->role == 'student') {
                return redirect()->route("student.dashboard")->withSuccess('Signed In Successfully');
            } else {
                return redirect()->back()->withErrors([
                    'message' => 'You have no previllages to access.',
                ]);
            }
        }

        return redirect()->back()->withErrors([
            'message' => 'Email and password is not correct.',
        ]);
    }

    public function signout()
    {

        if (Auth::check()) {

            Session::flush();
            Auth::logout();

            return Redirect()->route("login.screen");
        }
    }

    public function dashboard()
    {
        $dates = [];
        $userCounts = [];
        $percentageChange = 0;

        // Get current date
        $currentDate = date('Y-m-d');
        $dates[] = $currentDate;

        // Get previous 6 dates
        for ($i = 1; $i <= 13; $i++) {
            $previousDate = date('Y-m-d', strtotime("-$i days"));
            // $dates[] = $previousDate;
            array_unshift($dates, $previousDate);
        }

        // Get last week's dates (previous 7 days from $dates[])
        $currentWeekDates = array_slice($dates, 7);
        $lastWeekDates = array_slice($dates, 0, 7);

        // Get user counts for each date
        foreach ($currentWeekDates as $date) {
            $userCount = Users::whereDate('created_at', $date)->count();
            $userCounts[] = $userCount;
        }

        // Calculate the total number of users
        $totalUsers = array_sum($userCounts);


        // Get user counts for last week
        $userCountsLastWeek = Users::whereIn('created_at', $lastWeekDates)->count();

        // Calculate the percentage increase
        if ($userCountsLastWeek > 0) {
            $percentageChange = (($totalUsers - $userCountsLastWeek) / $userCountsLastWeek) * 100;
        }

        $societies = Society::with(['convener', 'president', 'members'])->get();

        // echo "<pre>";
        // print_r($societies->toArray());
        // exit;

        return view("admin.dashboard", [
            'dates' => $currentWeekDates,
            'userCounts' => $userCounts,
            'totalUsers' => $totalUsers,
            'percentageChange' => $percentageChange,
            'societies' => $societies,
        ]);
    }

    public function staff_dashboard()
    {
        $dates = [];
        $userCounts = [];
        $percentageChange = 0;

        // Get current date
        $currentDate = date('Y-m-d');
        $dates[] = $currentDate;

        // Get previous 6 dates
        for ($i = 1; $i <= 13; $i++) {
            $previousDate = date('Y-m-d', strtotime("-$i days"));
            // $dates[] = $previousDate;
            array_unshift($dates, $previousDate);
        }

        // Get last week's dates (previous 7 days from $dates[])
        $currentWeekDates = array_slice($dates, 7);
        $lastWeekDates = array_slice($dates, 0, 7);

        // Get user counts for each date
        foreach ($currentWeekDates as $date) {
            $userCount = Users::whereDate('created_at', $date)->count();
            $userCounts[] = $userCount;
        }

        // Calculate the total number of users
        $totalUsers = array_sum($userCounts);


        // Get user counts for last week
        $userCountsLastWeek = Users::whereIn('created_at', $lastWeekDates)->count();

        // Calculate the percentage increase
        if ($userCountsLastWeek > 0) {
            $percentageChange = (($totalUsers - $userCountsLastWeek) / $userCountsLastWeek) * 100;
        }

        $societies = Society::with(['convener', 'president', 'members'])->get();

        // echo "<pre>";
        // print_r($societies->toArray());
        // exit;

        return view("staff.dashboard", [
            'dates' => $currentWeekDates,
            'userCounts' => $userCounts,
            'totalUsers' => $totalUsers,
            'percentageChange' => $percentageChange,
            'societies' => $societies,
        ]);
    }

    public function student_dashboard()
    {
        // Fetch all society records from the database
        $societies = Society::all();
        // Calculate the total members for each society
        foreach ($societies as $society) {
            $totalMembers = SocietyMembers::where('society_id', $society->id)->count();
            $society->totalMembers = $totalMembers; // Add the totalMembers property to the $society object
        }

        return view("student.index", ['societies' => $societies]);
    }

    public function view_society($societyID)
    {
        // Fetch society record from the database
        $society = Society::with(['members.student', 'societyForm'])->find($societyID);
        $totalMembers = SocietyMembers::where('society_id', $societyID)->count();
        $society->totalMembers = $totalMembers;

        // Retrieve the active society form for the given society
        $activeSocietyForm = SocietyForms::where('society_id', $societyID)->where('active', true)->first();

        if (!empty($activeSocietyForm)) {
            // Decode and assign form_data to the society
            $activeSocietyForm->form_data = json_decode($activeSocietyForm->form_data);
            $society->society_form = $activeSocietyForm;
        }

        $hasSubmittedResponse = FormResponse::where('user_id', auth()->user()->id)->where('society_id', $societyID)->exists();
        $hasAcceptedResponse = FormResponse::where('user_id', auth()->user()->id)->where('society_id', $societyID)->where('status', 'accept')->exists();
        $society->hasSubmittedResponse = $hasSubmittedResponse;
        $society->hasAcceptedResponse = $hasAcceptedResponse;

        // Fetch discussions of the society
        $discussions = Discussion::with('users', 'society')->where('society_id', $societyID)->get();
        $society->discussions = $discussions;

        // echo "<pre>";
        // print_r($society->discussions->toArray());
        // exit;

        return view("student.view_society", ['society' => $society]);
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

            $image_path = '';
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
