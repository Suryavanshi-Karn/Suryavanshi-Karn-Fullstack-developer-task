<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Student;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data['total_teacher'] = Teacher::all()->count();
		$data['created_teacher'] = Teacher::where([['teachers.updated_at', '>=', date('Y-m-d')]])->count();
		$data['created_student'] = Student::where([['students.updated_at', '>=', date('Y-m-d')]])->count();
        $data['total_student'] = Student::all()->count();

        return view('backend.dashboard.admin_dashboard', ["data" => $data]);
    }

    public function studentsDashboardChart()
{
    $sample = array();

    // Initialize the last 12 months with default values.
    for ($i = 0; $i <= 11; $i++) {
        $date = date("M/y", strtotime(" -$i month"));
        $sample[$date]['month'] = $date;
        $sample[$date]['total'] = 0;
    }

    // Query to fetch student creation counts for the last 12 months.
    $data = DB::select("
    SELECT DATE_FORMAT(created_at, '%b/%y') AS month, COUNT(*) AS total
    FROM students
    WHERE created_at <= NOW()
    AND created_at >= DATE_ADD(NOW(), INTERVAL -12 MONTH)
    GROUP BY DATE_FORMAT(created_at, '%b/%y')
");


    // Update the sample array with actual data from the query.
    if (!empty($data)) {
        foreach ($data as $value) {
            if (isset($sample[$value->month])) {
                $sample[$value->month]['total'] = $value->total;
            }
        }
    }

    // Return the data in the format required by the frontend.
    return response()->json(array_values(array_reverse($sample)));
}

}
