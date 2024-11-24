<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;

class AdminController extends Controller
{
    public function profile()
    {
        // Check if the user is logged in
        if (Auth::check()) {
            // Get the authenticated user data
            $user = Auth::user(); // Fetch the authenticated user's data
// dd($user);            
            // Return the view with the user data
            return view('backend.dashboard.profile', ["data" => $user]);
        }

        // If the user is not logged in, redirect to the login page or show an error
        return redirect()->route('login')->with('error', 'You need to log in first!');
    }


    private function validateUpdateProfile(Request $request)
{
    return \Validator::make($request->all(), [
        'email' => 'required|email',
        'name' => 'required|string',
    ]);
}

public function updateProfile(Request $request)
{
    $msg_data = array();
    $validator = $this->validateUpdateProfile($request);

    // Check if validation fails
    if ($validator->fails()) {
        // Log validation errors
        \Log::error("User Approval List Validation Exception: " . implode(", ", $validator->errors()->all()));

        // You can use a custom error function here, or return the error message as needed
        errorMessage(implode("\n", $validator->errors()->all()), $msg_data);
        return back()->withErrors($validator)->withInput(); // Return back with validation errors
    }

    // Proceed to update the user's profile
    $user = Auth::user();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    // Return success message and redirect
    successMessage('Profile updated successfully', $msg_data);
}

public function updatePassword()
{
    return view('backend/dashboard/changePassword');
}


public function resetPassword(Request $request)
{
    $msg_data = array();
    
    // Validate the password reset request
    $validationErrors = $this->validatePwdRequest($request);
    if (count($validationErrors)) {
        \Log::error("Change Password Exception: " . implode(", ", $validationErrors->all()));
        errorMessage(implode("\n", $validationErrors->all()), $msg_data);
    }

    // Get the authenticated user
    $user = auth()->user();  // Use Auth::user() to get the currently authenticated user
    $id = $user->id;  // Get user ID
    $email = $user->email;  // Get user email

    // Check if the old password is correct
    if (!Hash::check($request->old_password, $user->password)) {
        errorMessage('Old password is incorrect!', $msg_data);
    }

    // Check if the new password matches the confirmation
    if ($request->new_password != $request->confirm_password) {
        errorMessage('Password not matched!', $msg_data);
    }

    // Check if the new password is the same as the old password
    if (Hash::check($request->new_password, $user->password)) {
        errorMessage(__('change_password.new_password_cannot_same_current_password'), $msg_data);
    }

    // Update the user's password
    $user->password = Hash::make($request->new_password);  // Use Hash::make to securely hash the password
    $user->save();

    // Return success message
    successMessage('Password updated successfully!', $msg_data);
}

private function validatePwdRequest(Request $request)
{
    return \Validator::make($request->all(), [
        'old_password' => 'required',
        'new_password' => 'required|min:5',
        'confirm_password' => 'required|min:5',
    ])->errors();
}
 

    public function teacher()
    {
        $data['teacher_add'] = true;
        $data['teacher_edit'] = true;
        $data['teacher_delete'] = true;
        return view('backend.teacher.index', ["data" => $data]);
    }
    

    public function addTeacher(Request $request)
    {
        return view('backend.teacher.teacher_add');
    }

    public function editTeacher($id)
    {
        $data['data'] = Teacher::find($id);   
        return view('backend.teacher.teacher_edit', ["data" => $data]);
    }

    public function saveTeacher(Request $request)
    {
        // dd($requset->all());
        $msg_data = array();
        $isEditFlow = false;
        if ($request->has('id')) {
            $validationErrors = $this->validateRequest($request);
            $isEditFlow = true;
            $Teacher = Teacher::find($request->input('id'));
        } else {
            $validationErrors = $this->validateNewRequest($request);
            $Teacher = new Teacher;
        }
        if (count($validationErrors)) {
            \Log::error("Validation Errors: " . implode(", ", $validationErrors->all()));
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }

        $Teacher->teacher_name = $request->teacher_name;
        $Teacher->save();
    
        successMessage('Data saved successfully', $msg_data);
    }


    public function teacherdata(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Query to fetch Teacher data
                $query = Teacher::query()->orderBy('updated_at', 'desc');
    
                return DataTables::of($query)

                ->filter(function ($query) use ($request) {
                    if ($request['search']['search_teacher_name'] && !is_null($request['search']['search_teacher_name'])) {
                        $query->where('teacher_name', 'like', "%" . $request['search']['search_teacher_name'] . "%");
                    }

                    $query->get();
                })
                    ->editColumn('teacher_name', function ($event) {
                        return $event->teacher_name;
                    })
                    ->editColumn('created_at', function ($event) {
                        return $event->created_at;
                    })
                    ->editColumn('action', function ($event) {
                        // Remove permission check and just display action buttons
                        $actions = '<span style="white-space:nowrap;">';
    
                        // Always show the edit button
                        $actions .= ' <a href="teacher_edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
    
                        // Always show the delete button
                        $actions .= ' <a data-url="teacher_delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="Delete"><i class="fa fa-trash"></i></a>';
    
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['teacher_name', 'created_at', 'action'])
                    ->setRowId('id')
                    ->make(true); 
            } catch (\Exception $e) {
                \Log::error("Something Went Wrong. Error: " . $e->getMessage());
                
                return response([
                    'draw'            => 0,
                    'recordsTotal'    => 0,
                    'recordsFiltered' => 0,
                    'data'            => [],
                    'error'           => 'Something went wrong',
                ]);
            }
        }
    }
        

    private function validateNewRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'teacher_name' => 'required|string',
           
        ])->errors();
    }
    
    private function validateRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'teacher_name' => 'required|string',
           
        ])->errors();
    }
    
    public function deleteTeacher($id)
    {
        $msg_data = array();
        $data = Teacher::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', $msg_data);
    }
}
