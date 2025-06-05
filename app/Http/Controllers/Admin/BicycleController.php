<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bicycle;
use App\Models\BicycleTimeSlot;
use Illuminate\Http\Request;

class BicycleController extends Controller
{
    public function index()
    {
        $bicycles = Bicycle::all();
        return view('admin.bicycles.index', compact('bicycles'));
    }

    public function create()
    {
        return view('admin.bicycles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'status' => 'required|in:available,in_use,maintenance',
        ]);

        $bicycle = Bicycle::create($validated);

        // Generate today's time slots for the new bicycle
        $this->createTimeSlotsForDate($bicycle->id, now()->toDateString());

        return redirect()->route('admin.bicycles.index')->with('success', 'Bicycle created successfully with time slots.');
    }

    public function edit(Bicycle $bicycle)
    {
        return view('admin.bicycles.edit', compact('bicycle'));
    }

    public function update(Request $request, Bicycle $bicycle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'status' => 'required|in:available,in_use,maintenance',
        ]);

        $bicycle->update($validated);
        return redirect()->route('admin.bicycles.index')->with('success', 'Bicycle updated successfully');
    }

    public function destroy(Bicycle $bicycle)
    {
        $bicycle->delete();
        return redirect()->route('admin.bicycles.index')->with('success', 'Bicycle deleted successfully');
    }

    /**
     * Create time slots for a specific date (1-hour intervals from 08:00 to 18:00)
     */
    private function createTimeSlotsForDate($bicycleId, $date)
    {
        $start = new \DateTime('08:00');
        $end = new \DateTime('18:00');

        while ($start < $end) {
            $slotEnd = clone $start;
            $slotEnd->modify('+1 hour');

            BicycleTimeSlot::create([
                'bicycle_id' => $bicycleId,
                'date' => $date,
                'start_time' => $start->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'status' => 'available',
            ]);

            $start = $slotEnd;
        }
    }
}
