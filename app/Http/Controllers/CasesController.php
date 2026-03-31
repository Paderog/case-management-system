<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\FiscalYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CasesController extends Controller
{
        public function index(Request $request)
            {
                    $query = Cases::query();

                    // SEARCH FUNCTION
                    // if ($request->filled('search')) {
                    //     $query->where(function ($q) use ($request) {
                    //         $q->where('title', 'like', '%' . $request->search . '%')
                    //           ->orWhere('status', 'like', '%' . $request->search . '%');
                    //     });
                    // }

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


                    $noEntryYet = Cases::whereNull('latest_date_of_entry')->count();

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
                        'noEntryYet',
                        'totalUpdatedCases',
                        'casesPerMonth',
                        'casesUpdatedPerMonth'
                    ));
            }
   public function create($year)
        {

            $yearData = FiscalYear::find($year);
            return view('cases.create', compact('yearData'));
        }
    public function store(Request $request)
{
    $year = FiscalYear::findOrFail($request->year_id);

    $request->validate([
    'title' => 'required|string|max:2000',
    'date_filed' => [
        'required',
        'date',
        function ($attribute, $value, $fail) use ($year) {
            try {
                $inputYear = date('Y', strtotime($value));

                $yearNumber = (int) preg_replace('/\D/', '', $year->year);

                if ($inputYear != $yearNumber) {
                    $fail("The Date Filed must be within year {$year->year}.");
                }
            } catch (\Exception $e) {
                $fail("Invalid date format.");
            }
        }
    ],

    'status' => 'required|string|max:255',
    'latest_date_of_entry' => 'nullable|date',
    'year_id' => 'required'
]);

    Cases::create([
        'title' => $request->title,
        'date_filed' => $request->date_filed,
        'status' => $request->status,
        'latest_date_of_entry' => $request->latest_date_of_entry,
        'year_id' => $request->year_id
    ]);

    return redirect()->route('cases.year', $request->year_id)
        ->with('success', 'Case added successfully!');
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
        return redirect()->route('cases.year', $case->year_id)
        ->with('success', 'Case updated successfully!')
        ->with('updated_id', $case->id);
      }
    public function destroy(Request $request, Cases $case)
        {
            $yearId = $case->year_id;
            $case->delete();

            return redirect()->route('cases.year', [
                'year' => $yearId,
                'page' => $request->page ?? 1,
                'search' => $request->search,
            ])->with('success', 'Case deleted successfully!');
        }
    public function byYear(Request $request, $year)
        {
            
            $yearData = FiscalYear::findOrFail($year);
            // ✅ START QUERY
            $query = Cases::where('year_id', $year);

            // ✅ SEARCH FUNCTION
            $search = trim($request->query('search', ''));

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }
            // ✅ FINAL CASES RESULT
            $cases = $query->orderByDesc('created_at')
                        ->paginate(20)
                        ->withQueryString();
            $totalCases = Cases::where('year_id', $year)->count();

            $casesThisMonth = Cases::where('year_id', $year)
            ->whereMonth('date_filed', now()->month)
            ->whereYear('date_filed', now()->year)
            ->count();

            $noEntryYet = Cases::where('year_id', $year)
                ->whereNull('latest_date_of_entry')
                ->count();

            $totalUpdatedCases = Cases::where('year_id', $year)
                ->whereNotNull('latest_date_of_entry')
                ->count();

            // CASES PER MONTH
            $casesPerMonth = Cases::selectRaw('MONTH(date_filed) as month, COUNT(*) as total')
                ->where('year_id', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total','month');

            $months = [
                1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',
                5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',
                9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
            ];

            $casesPerMonth = $casesPerMonth->mapWithKeys(function ($value, $key) use ($months) {
                return [$months[$key] => $value];
            });

            // UPDATED CASES PER MONTH
            $casesUpdatedPerMonth = Cases::selectRaw('MONTH(latest_date_of_entry) as month, COUNT(*) as total')
                ->where('year_id', $year)
                ->whereNotNull('latest_date_of_entry')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total','month');

            $casesUpdatedPerMonth = $casesUpdatedPerMonth->mapWithKeys(function ($value, $key) use ($months) {
                return [$months[$key] => $value];
            });

            return view('cases.index', compact(
                'cases',
                'yearData',
                'totalCases',
                'casesThisMonth',
                'noEntryYet',
                'totalUpdatedCases',
                'casesPerMonth',
                'casesUpdatedPerMonth'
            ));
        }
}
