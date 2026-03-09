<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CasesController extends Controller
{
  public function index(Request $request)
{
    $query = Cases::query();

    // SEARCH FUNCTION
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('status', 'like', '%' . $request->search . '%');
        });
    }

    $cases = $query->orderByDesc('created_at')
                   ->paginate(20)
                   ->withQueryString();

    $totalUpdatedCases = Cases::whereNotNull('latest_date_of_entry')->count();

    $casesUpdatedPerMonth = Cases::selectRaw('MONTH(latest_date_of_entry) as month, COUNT(*) as total')
    ->whereNotNull('latest_date_of_entry')
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total','month');

    $months = [
    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
    5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
];

$casesUpdatedPerMonth = $casesUpdatedPerMonth->mapWithKeys(function ($value, $key) use ($months) {
    return [$months[$key] => $value];
});    


    // DASHBOARD STATISTICS
    $totalCases = Cases::count();

    $casesThisMonth = Cases::whereMonth('date_filed', now()->month)
        ->whereYear('date_filed', now()->year)
        ->count();


    $noEntry = Cases::whereNull('latest_date_of_entry')->count();

    $casesPerMonth = Cases::selectRaw('MONTH(date_filed) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total','month');

        $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
];

$casesPerMonth = $casesPerMonth->mapWithKeys(function ($value, $key) use ($months) {
    return [$months[$key] => $value];
});

    return view('cases.index', compact(
        'cases',
        'totalCases',
        'casesThisMonth',
        'noEntry',
        'totalUpdatedCases',
        'casesPerMonth',
        'casesUpdatedPerMonth'
    ));
}
    public function create()
    {
        return view('cases.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|min:2|max:2000',
            'date_filed' => 'required|date',
            'status' => 'required|string|max:255',
            'latest_date_of_entry' => 'nullable|date',

        ]);

        // dd('ok');

        Cases::create($request->all());
        return redirect()->route('cases.index')->with('success', 'Case added Successfully!!!');
    }
    public function show($id)
    {
         $case = Cases::findOrFail($id);
        // dd($case);
        return view('cases.show', compact('case'));
    }
    public function edit(Cases $case)
    {

        return view('cases.edit', compact('case'));
    }
   public function update(Request $request, Cases $case)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:2000',
            'date_filed' => 'required|date',
            'status' => 'required|string|max:255',
            'latest_date_of_entry' => 'required|date',
        ]);

        $case->update([
            'title' => $request->title,
            'status' => $request->status,
            'latest_date_of_entry' => $request->latest_date_of_entry
        ]);
       return redirect()->route('cases.index', [
        'page' => $request->page,
        'search' => $request->search
        ])
        ->with('success', 'Case updated successfully!')
        ->with('updated_id', $case->id);
    }
   public function destroy(Request $request, $id)
{
    $case = Cases::findOrFail($id);
    $case->delete();

    return redirect()->route('cases.index', ['page' => $request->page])
        ->with('success', 'Case deleted successfully!');
}

}
