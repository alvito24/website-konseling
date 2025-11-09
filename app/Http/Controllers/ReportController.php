<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $this->authorize('view-reports');

        $reports = [
            'overview' => $this->getOverviewStats(),
            'monthly' => $this->getMonthlyStats(),
            'categories' => $this->getCategoryStats(),
            'counselors' => $this->getCounselorStats(),
        ];

        return view('reports.index', compact('reports'));
    }

    public function show(Request $request)
    {
        $this->authorize('view-reports');

        $type = $request->type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $data = match($type) {
            'counselor' => $this->getCounselorReport($request->counselor_id, $startDate, $endDate),
            'student' => $this->getStudentReport($request->student_id, $startDate, $endDate),
            'category' => $this->getCategoryReport($request->category, $startDate, $endDate),
            default => throw new \InvalidArgumentException('Invalid report type'),
        };

        return view('reports.show', compact('data', 'type'));
    }

    private function getOverviewStats()
    {
        return [
            'total_sessions' => Konseling::count(),
            'active_sessions' => Konseling::where('status', 'in_progress')->count(),
            'completed_sessions' => Konseling::where('status', 'completed')->count(),
            'total_students' => User::where('role', 'siswa')->count(),
            'total_counselors' => User::where('role', 'guru_bk')->count(),
        ];
    }

    private function getMonthlyStats()
    {
        return Konseling::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as completed')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();
    }

    private function getCategoryStats()
    {
        return Konseling::select('jenis_konseling', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_konseling')
            ->get();
    }

    private function getCounselorStats()
    {
        return User::where('role', 'guru_bk')
            ->withCount(['counselingSessions' => function($query) {
                $query->where('status', 'completed');
            }])
            ->orderBy('counseling_sessions_count', 'desc')
            ->get();
    }

    private function getCounselorReport($counselorId, $startDate, $endDate)
    {
        return Konseling::where('guru_bk_id', $counselorId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['siswa', 'messages'])
            ->get()
            ->map(function($session) {
                return [
                    'id' => $session->id,
                    'student' => $session->siswa->name,
                    'type' => $session->jenis_konseling,
                    'topic' => $session->topik,
                    'status' => $session->status,
                    'date' => $session->created_at->format('Y-m-d'),
                    'duration' => $session->duration,
                    'messages_count' => $session->messages->count(),
                ];
            });
    }

    private function getStudentReport($studentId, $startDate, $endDate)
    {
        return Konseling::where('siswa_id', $studentId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['guru_bk', 'messages'])
            ->get()
            ->map(function($session) {
                return [
                    'id' => $session->id,
                    'counselor' => $session->guru_bk->name,
                    'type' => $session->jenis_konseling,
                    'topic' => $session->topik,
                    'status' => $session->status,
                    'date' => $session->created_at->format('Y-m-d'),
                    'follow_up' => $session->follow_up,
                ];
            });
    }

    private function getCategoryReport($category, $startDate, $endDate)
    {
        return Konseling::where('jenis_konseling', $category)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['siswa', 'guru_bk'])
            ->get()
            ->map(function($session) {
                return [
                    'id' => $session->id,
                    'student' => $session->siswa->name,
                    'counselor' => $session->guru_bk->name,
                    'topic' => $session->topik,
                    'status' => $session->status,
                    'date' => $session->created_at->format('Y-m-d'),
                    'outcome' => $session->outcome,
                ];
            });
    }

    public function export(Request $request)
    {
        $this->authorize('export-reports');

        $type = $request->type;
        $format = $request->format ?? 'pdf';
        
        $data = match($type) {
            'overview' => $this->getOverviewStats(),
            'monthly' => $this->getMonthlyStats(),
            'counselor' => $this->getCounselorReport($request->counselor_id, $request->start_date, $request->end_date),
            'student' => $this->getStudentReport($request->student_id, $request->start_date, $request->end_date),
            'category' => $this->getCategoryReport($request->category, $request->start_date, $request->end_date),
            default => throw new \InvalidArgumentException('Invalid report type'),
        };

        return match($format) {
            'pdf' => $this->generatePdfReport($data, $type),
            'excel' => $this->generateExcelReport($data, $type),
            'csv' => $this->generateCsvReport($data, $type),
            default => throw new \InvalidArgumentException('Invalid export format'),
        };
    }
}