<?php

namespace App\Http\Controllers;
use App\Models\AdministrativeCase;
use App\Models\AdministrativeReport;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdministrativeCaseController extends Controller
{

    public function index()
{
    $reports = AdministrativeReport::latest()->get();

    return view('admin_cases.index', compact('reports'));
}
    // 🔥 ADD THIS
    public function create()
    {
        return view('admin_cases.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'report_title' => 'required|string|max:255'
    ]);

    $report = AdministrativeReport::create([
        'report_title' => $request->report_title
    ]);

    return redirect()->route('admin-cases.show', $report->id);
}
public function show(Request $request, $id)
{
    $report = AdministrativeReport::findOrFail($id);

    $query = $report->cases();

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('station', 'like', '%' . $request->search . '%')
              ->orWhere('docket_no', 'like', '%' . $request->search . '%')
              ->orWhere('nature', 'like', '%' . $request->search . '%')
              ->orWhere('status', 'like', '%' . $request->search . '%');
        });
    }

    $cases = $query->get();

    return view('admin_cases.show', [
        'case' => $report, // para di ka mag change sa blade
        'cases' => $cases
    ]);
}
public function addRow($id)
{
    $report = AdministrativeReport::findOrFail($id);

    return view('admin_cases.add_row', compact('report'));
}
public function storeRow(Request $request, $id)
{
    $report = AdministrativeReport::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'station' => 'required|string|max:255',
        'docket_no' => 'required|string|max:255',
        'nature' => 'required|string|max:255',
        'status' => 'required|string|max:255',
    ]);

    $color = $request->color ?? null;
    $nature = $request->nature;

    if ($color && $color !== 'none') {
        $nature = $nature . '||' . $color;
    }

    $report->cases()->create([
        'name' => $request->name,
        'station' => $request->station,
        'docket_no' => $request->docket_no,
        'nature' => $nature,
        'status' => $request->status,
    ]);

    return redirect()->route('admin-cases.show', $report->id);
}
public function print($id)
{
    $report = AdministrativeReport::findOrFail($id);
    $cases = $report->cases;

    $pdf = Pdf::loadView('admin_cases.print', compact('report', 'cases'))
        ->setPaper('a4', 'landscape');

    return $pdf->stream('admin_cases.pdf');
}
public function update(Request $request, $id)
{
    $item = AdministrativeCase::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'station' => 'required|string|max:255',
        'docket_no' => 'required|string|max:255',
        'nature' => 'required|string|max:255',
        'status' => 'required|string|max:255',
    ]);

    $baseText = explode('||', $request->nature)[0];
    $color = $request->color;

    if ($color && $color !== 'none') {
        $nature = $baseText . '||' . $color;
    } else {
        $nature = $baseText;
    }

    $item->update([
        'name' => $request->name,
        'station' => $request->station,
        'docket_no' => $request->docket_no,
        'nature' => $nature,
        'status' => $request->status,
    ]);

    return redirect()->route('admin-cases.show', [
        'admin_case' => $item->report_id,
        'highlight' => $item->id
    ]);
}
public function edit($id)
{
    $item = AdministrativeCase::findOrFail($id);

    return view('admin_cases.edit', compact('item'));
}
}
