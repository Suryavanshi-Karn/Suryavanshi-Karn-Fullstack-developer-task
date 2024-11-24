<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Models\Teacher;
use App\Models\Student;

class StudentController extends Controller
{
    public function student(){

        $data['student_add'] = true;
        $data['student_edit'] = true;
        $data['student_delete'] = true;
      
        return view('backend.student.index', ["data" => $data]);
    
    }

    public function studentdata(Request $request)
    {
        if ($request->ajax()) {
            try {
                
                $query = Student::with('teacher')->orderBy('updated_at', 'desc');
                return DataTables::of($query)

                ->filter(function ($query) use ($request) {
                    if ($request['search']['search_student_name'] && !is_null($request['search']['search_student_name'])) {
                        $query->where('student_name', 'like', "%" . $request['search']['search_student_name'] . "%");
                    }
                    if ($request['search']['search_class'] && !is_null($request['search']['search_class'])) {
                        $query->where('class', 'like', "%" . $request['search']['search_class'] . "%");
                    }
                    if ($request['search']['search_yearly_fees'] && !is_null($request['search']['search_yearly_fees'])) {
                        $query->where('yearly_fees', 'like', "%" . $request['search']['search_yearly_fees'] . "%");
                    }

                    $query->get();
                })
                    ->editColumn('student_name', function ($event) {
                        return $event->student_name;
                    })
                    ->editColumn('class_teacher_id', function ($event) {
                        return $event->teacher->teacher_name ?? 'N/A'; // Fallback if no teacher is assigned
                    })
                    ->editColumn('class', function ($event) {
                        return $event->class;
                    })
                    ->editColumn('admission_date', function ($event) {
                        return $event->admission_date;
                    })
                    ->editColumn('yearly_fees', function ($event) {
                        return $event->yearly_fees;
                    })
                    ->editColumn('action', function ($event) {
                        // Remove permission check and just display action buttons
                        $actions = '<span style="white-space:nowrap;">';
    
                        // Always show the edit button
                        $actions .= ' <a href="student_edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
    
                        // Always show the delete button
                        $actions .= ' <a data-url="student_delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="Delete"><i class="fa fa-trash"></i></a>';
    
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

    public function addStudent(Request $request)
    {
        $data['teacher'] = Teacher::all();
        
        return view('backend.student.student_add', ["data" => $data]);
    }

    public function editStudent($id)
    {
        $data['data'] = Student::find($id);
        $data['teacher'] = Teacher::all();

        return view('backend.student.student_edit', ["data" => $data]);
    }


        public function saveStudent(Request $request)
        {
            // dd($requset->all());
            $msg_data = array();
            $isEditFlow = false;
            if ($request->has('id')) {
                $validationErrors = $this->validateRequest($request);
                $isEditFlow = true;
                $student = Student::find($request->input('id'));
            } else {
                $validationErrors = $this->validateNewRequest($request);
                $student = new Student;
            }
            if (count($validationErrors)) {
                \Log::error("Validation Errors: " . implode(", ", $validationErrors->all()));
                errorMessage(implode("\n", $validationErrors->all()), $msg_data);
            }

            $student->student_name = $request->student_name;
            $student->class_teacher_id = $request->class_teacher_id;
            $student->class = $request->class;
            $student->admission_date = $request->admission_date;
            $student->yearly_fees = $request->yearly_fees;
            $student->save();
        
            successMessage('Data saved successfully', $msg_data);
        }

        private function validateNewRequest(Request $request)
        {
            return \Validator::make($request->all(), [
                'student_name' => 'required|string',
                'class_teacher_id' => 'required|integer',
                'class' => 'required|string',
                'admission_date' => 'required|date',
                'yearly_fees' => 'required|string',
               
            ])->errors();
        }
        
        private function validateRequest(Request $request)
        {
            return \Validator::make($request->all(), [
                'student_name' => 'required|string',
                'class_teacher_id' => 'required|integer',
                'class' => 'required|string',
                'admission_date' => 'required|date',
                'yearly_fees' => 'required|string',
               
            ])->errors();
        }

        public function deleteStudent($id)
        {
            $msg_data = array();
            $data = Student::find($id);
            $data->delete();
            successMessage('Data Deleted successfully', $msg_data);
        }
}
