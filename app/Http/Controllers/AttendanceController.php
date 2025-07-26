<?php

namespace App\Http\Controllers;


use App\Models\Attendance;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function percentage()
    {
        $students = Student::all();
        $totalSessions = Attendance::count();
        $data = [];

        foreach ($students as $student) {
            $attended = StudentAttendance::where('student_id', $student->id)->count();
            $percentage = $totalSessions > 0 ? round(($attended / $totalSessions) * 100, 2) : 0;

            $data[] = [
                'name' => $student->name,
                'percentage' => $percentage,
            ];
        }

        // Sort descending by percentage
        $data = collect($data)->sortByDesc('percentage')->values();

        return view('attendances.percentage', compact('data'));
    }


    public function index()
    {
        $attendances = Attendance::withCount('students')
            ->where('teacher_id', auth()->id())
            ->latest()
            ->get();

        return view('attendances.index', compact('attendances'));
    }

    public function show(Attendance $attendance)
    {
        // Assuming Attendance belongs to a teacher and has a student group (adjust if needed)
        // Or you have a way to get the students to check attendance for.

        // For example, get all students under the teacher or related group:
        $teacherId = auth()->id();

        // Get all students for this teacher (or group)
        $students = Student::where('teacher_id', $teacherId)->get();

        // Get student attendance records keyed by student_id for this attendance
        $attendanceRecords = $attendance->studentAttendances()
            ->pluck('attend_at', 'student_id')
            ->toArray();

        return view('attendances.show', compact('attendance', 'students', 'attendanceRecords'));
    }

    public function create()
    {
        $students = Student::where('teacher_id', auth()->id())->get();
        return view('attendances.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $attendance = Attendance::create([
            'title' => $request->title,
            'teacher_id' => auth()->id(),
        ]);

        if ($request->students) {
            foreach ($request->students as $studentId) {
                $attendance->students()->attach($studentId, [
                    'attend_at' => now(),
                ]);
            }
        }

        return redirect()->route('attendances.index')
            ->with('success', 'تم تسجيل الحضور بنجاح.');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $teacherId = auth()->id();

        // Validate attendance input (optional)
        $attendanceData = $request->input('attendance', []);

        // Get all students to handle those unchecked (absent)
        $students = Student::where('teacher_id', $teacherId)->get();

        foreach ($students as $student) {
            if (isset($attendanceData[$student->id])) {
                // Mark as present: insert or update student_attendance with current timestamp
                $attendance->studentAttendances()->updateOrCreate(
                    ['student_id' => $student->id],
                    ['attend_at' => now()]
                );
            } else {
                // Mark as absent: remove student attendance record if exists
                $attendance->studentAttendances()->where('student_id', $student->id)->delete();
            }
        }

        return redirect()->route('attendances.index')
            ->with('success', 'تم تحديث حالة الحضور بنجاح');
    }

    public function attendanceAllStudent()
    {
        $students = Student::all();
        return view('students.attendance_all_student', compact('students'));
    }

    public function taskStudent($group_id)
    {

        $students = Student::where('student_group_id', $group_id)->get();

        return view('students.task_student', compact('students'));
    }
}
