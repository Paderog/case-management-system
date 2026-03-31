<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiscalYear;
use App\Models\Cases;

class HomeController extends Controller
{
    public function index()
    {
        $years = FiscalYear::orderByDesc('year')->get();

        foreach ($years as $year) {

            $year->totalCases = Cases::where('year_id', $year->id)->count();

            $year->casesThisMonth = Cases::where('year_id', $year->id)
                ->whereMonth('date_filed', now()->month)
                ->whereYear('date_filed', now()->year)
                ->count();

            $year->noEntryYet = Cases::where('year_id', $year->id)
                ->whereNull('latest_date_of_entry')
                ->count();

            $year->totalUpdatedCases = Cases::where('year_id', $year->id)
                ->whereNotNull('latest_date_of_entry')
                ->count();

            $months = [
                1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',
                5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',
                9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
            ];

            // ✅ FIX: NO whereYear
            $cases = Cases::selectRaw('MONTH(date_filed) as month, COUNT(*) as total')
                ->where('year_id', $year->id)
                ->whereNotNull('date_filed')
                ->groupBy('month')
                ->pluck('total', 'month');

            $casesPerMonth = [];

            foreach ($cases as $m => $total) {
                if (isset($months[$m])) {
                    $casesPerMonth[$months[$m]] = $total;
                }
            }

            $year->casesPerMonth = $casesPerMonth;


            // ✅ FIX: NO whereYear
            $updates = Cases::selectRaw('MONTH(latest_date_of_entry) as month, COUNT(*) as total')
                ->where('year_id', $year->id)
                ->whereNotNull('latest_date_of_entry')
                ->groupBy('month')
                ->pluck('total', 'month');

            $casesUpdatedPerMonth = [];

            foreach ($updates as $m => $total) {
                if (isset($months[$m])) {
                    $casesUpdatedPerMonth[$months[$m]] = $total;
                }
            }

            $year->casesUpdatedPerMonth = $casesUpdatedPerMonth;
        }

        return view('dashboard', compact('years'));
    }
}