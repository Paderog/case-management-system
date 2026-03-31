<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiscalYear;

class FiscalYearController extends Controller
{
    public function create()
    {
        return view('years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|unique:fiscal_years,year'
        ]);

        $year = FiscalYear::create([
            'year' => $request->year
        ]);

        return redirect()->route('cases.year', $year->id)
            ->with('success', 'New Fiscal Year created!');
    }
    public function destroy($id)
{
    $year = FiscalYear::findOrFail($id);
    $year->delete();

    return redirect()->back()->with('success', 'Fiscal Year deleted!');
}
}