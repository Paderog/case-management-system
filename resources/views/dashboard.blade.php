@extends('layouts.app')

@section('content')

@foreach($years as $year)

<div class="card bg-dark text-white border-info mb-4 p-4">

    <h3 class="mb-4">{{ $year->year }}</h3>

    <!-- <pre>{{ json_encode($year->casesPerMonth) }}</pre>
    <pre>{{ json_encode($year->casesUpdatedPerMonth) }}</pre> -->

    <!-- CARDS -->
    <div class="row text-center mb-4">

        <div class="col-md-3">
            <div class="card bg-dark text-white border-info">
                <div class="card-body">
                    <h6>TOTAL CASES</h6>
                    <h3>{{ $year->totalCases }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white border-info">
                <div class="card-body">
                    <h6>CASES THIS MONTH</h6>
                    <h3>{{ $year->casesThisMonth }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white border-warning">
                <div class="card-body">
                    <h6>NO ENTRY YET</h6>
                    <h3>{{ $year->noEntryYet }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark text-white border-danger">
                <div class="card-body">
                    <h6>TOTAL CASES UPDATE</h6>
                    <h3>{{ $year->totalUpdatedCases }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- CHARTS -->
    <div class="row">

        <div class="col-md-6">
            <div class="card bg-dark text-white border-info p-3">
                <h6 class="text-center">TOTAL CASES PER MONTH</h6>
                <div style="height:300px; display:flex; justify-content:center; align-items:center;">
                    <canvas id="casesChart{{ $year->id }}"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-dark text-white border-info p-3">
                <h6 class="text-center">TOTAL CASE UPDATES PER MONTH</h6>
                <div style="height:300px; display:flex; justify-content:center; align-items:center;">
                    <canvas id="updatesChart{{ $year->id }}"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

@endforeach

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const monthColors = {
    'Jan': '#4e73df',
    'Feb': '#1cc88a',
    'Mar': '#36b9cc',
    'Apr': '#f6c23e',
    'May': '#e74a3b',
    'Jun': '#858796',
    'Jul': '#fd7e14',
    'Aug': '#20c997',
    'Sep': '#6610f2',
    'Oct': '#d63384',
    'Nov': '#6f42c1',
    'Dec': '#0dcaf0'
};

@foreach($years as $year)

let casesData{{ $year->id }} = {!! json_encode($year->casesPerMonth ?? []) !!};
let updatesData{{ $year->id }} = {!! json_encode($year->casesUpdatedPerMonth ?? []) !!};

let casesCanvas{{ $year->id }} = document.getElementById('casesChart{{ $year->id }}');

if (casesCanvas{{ $year->id }}) {
    new Chart(casesCanvas{{ $year->id }}, {
        type: 'pie',
        data: {
            labels: Object.keys(casesData{{ $year->id }}),
            datasets: [{
                data: Object.values(casesData{{ $year->id }}),
                backgroundColor: Object.keys(casesData{{ $year->id }}).map(month => monthColors[month])
            }]
        },
          options: {
        plugins: {
            legend: {
                labels: {
                    color: '#ffffff' // 🔥 HERE NA FIX
                }
            }
        }
    }
    });
}

let updatesCanvas{{ $year->id }} = document.getElementById('updatesChart{{ $year->id }}');

if (updatesCanvas{{ $year->id }}) {
    new Chart(updatesCanvas{{ $year->id }}, {
        type: 'pie',
        data: {
            labels: Object.keys(updatesData{{ $year->id }}),
            datasets: [{
                data: Object.values(updatesData{{ $year->id }}),
                backgroundColor: Object.keys(updatesData{{ $year->id }}).map(month => monthColors[month])
            }]
        },
          options: {
        plugins: {
            legend: {
                labels: {
                    color: '#ffffff' // 🔥 HERE NA FIX
                }
            }
        }
    }
    });
}

@endforeach

});
</script>

@endsection