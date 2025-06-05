<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'weekly');
        $date = $request->input('date', now()->format('Y-m-d'));

        $startDate = Carbon::parse($date);
        if ($period === 'monthly') {
            $startDate = $startDate->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        } else {
            $startDate = $startDate->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();
        }

        $bookings = Booking::with(['user', 'bicycle'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        return view('admin.reports.bookings', compact('bookings', 'period', 'date', 'startDate', 'endDate'));
    }

    public function print(Request $request)
    {
        $period = $request->input('period', 'weekly');
        $date = $request->input('date', now()->format('Y-m-d'));

        $startDate = Carbon::parse($date);
        if ($period === 'monthly') {
            $startDate = $startDate->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        } else {
            $startDate = $startDate->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();
        }

        $bookings = Booking::with(['user', 'bicycle'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        return view('admin.reports.bookings-print', compact('bookings', 'period', 'startDate', 'endDate'));
    }
}