@extends('layouts.app')

@section('title', 'Cases List')
@section('content')


<div class="container mt-4">
    <h2 class="mb-4 text-white">
       Cases List - {{ $yearData->year ?? 'FY2025' }}
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-3">

        {{-- LEFT SIDE --}}
        @if(isset($yearData))
            <a href="{{ route('cases.create', $yearData->id) }}" class="btn btn-outline-info">
                Add Cases
            </a>
        @endif

        {{-- RIGHT SIDE --}}
        <form method="GET" action="{{ url()->current() }}" class="d-flex">
            <input type="text"
                id="search-input"
                name="search"
                value="{{ request()->query('search', '') }}"
                class="form-control me-2"
                placeholder="Search title or status..."
                style="width: 300px;">
            <button class="btn btn-outline-info">Search</button>
        </form>

    </div>


<div class="row mb-4 text-white">

    <div class="col-md-3">
    <div class="card bg-dark border-info text-center text-white">
        <div class="card-body">
            <h6>TOTAL CASES</h6>
            <h3>{{  $totalCases }}</h3>
        </div>
    </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark border-info text-center text-white">
            <div class="card-body">
                <h6>CASES THIS MONTH</h6>
                <h3>{{ $casesThisMonth }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark border-warning text-center text-white">
            <div class="card-body">
                <h6>NO ENTRY YET</h6>
                <h3>{{ $noEntryYet }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark border-danger text-center text-white">
            <div class="card-body">
                <h6>TOTAL CASES UPDATE</h6>
                <h3>{{ $totalUpdatedCases }}</h3>
            </div>
        </div>
    </div>
 </div>

 <!-- <div class="card bg-dark text-white mb-4">
    <div class="card-body">
        <h5>Cases Per Month</h5>
        <canvas id="casesChart"></canvas>
    </div>
</div> -->

<div class="row">

    <!-- Cases Filed Chart -->
    <div class="col-md-6">
        <div class="card bg-dark text-white border-info mb-4">
            <div class="card-body text-center">
                <h6 class="mb-3">TOTAL CASES PER MONTH</h6>

                <div style="width:300px; margin:auto;">
                    <canvas id="casesChart"></canvas>
                </div>

            </div>
        </div>
    </div>

    <!-- Cases Updated Chart -->
    <div class="col-md-6">
        <div class="card bg-dark text-white border-info mb-4">
            <div class="card-body text-center">
                <h6 class="mb-3">TOTAL CASE UPDATES PER MONTH</h6>

                <div style="width:300px; margin:auto;">
                    <canvas id="updatesChart"></canvas>
                </div>

            </div>
        </div>
    </div>

</div>


        @if(session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @php
            $search = request('search');
        @endphp

        <table id="casesTable" class="table table-bordered table-dark table-striped">
            <thead>
                <tr>
                    <th class="text-center py-4 px-5" style="width:5%">#</th>
                    <th class="text-center py-4 px-5" style="width:40%">
                    {{ isset($yearData) ? $yearData->year : 'Fiscal Year' }}
                    </th>
                    <th class="text-center py-3 px-4" style="width:15%">DATE FILED</th>
                    <th class="text-center py-4 px-5" style="width:20%">ACTION TAKEN/REMARKS</th>
                    <th class="text-center py-3 px-4" style="width:15%">LATEST DATE OF ENTRY</th>
                    <th class="text-center py-4 px-5" style="width:10%">ACTIONS</th>
                </tr>
            </thead>

            <tbody>
           @forelse ($cases as $case)
                <tr id="case-{{ $case->id }}" class="{{ session('updated_id') == $case->id ? 'highlight-row' : '' }}">

                <td> {{ $cases->total() - (($cases->currentPage() - 1) * $cases->perPage() + $loop->index) }} </td>

                <td style="max-width:350px;">
                @if($search)
                    {!! str_ireplace($search, '<span class="highlight">'.$search.'</span>', $case->title) !!}
                    @else
                    {{ $case->title }}
                @endif
                </td>

                <td class="text-nowrap">
                {{ \Carbon\Carbon::parse($case->date_filed)->format('j-M-Y') }}
                </td>

                <td class="text-center">
                {{ $case->status }}
                </td>

                <td class="text-nowrap">
                {{ $case->latest_date_of_entry 
                    ? $case->latest_date_of_entry->format('j-M-Y') 
                    : 'No Entry Yet' }}
                </td>

                    <td >
                        <div class="d-flex gap-2">
                            <a href="{{ route('cases.show', ['case' => $case->id, 'page' => request()->page, 'search' => request('search')]) }}"  class="btn btn-outline-warning">Views</a>
                            <a href="{{ route('cases.edit', ['case' => $case->id, 'page' => request()->page,'search' => request('search')]) }}" class="btn btn-outline-info btn-sm">Edit</a>                           
                               <!-- <form action="{{ route('cases.destroy', $case->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Are you sure?')"
                                >Delete</button>
                            </form> -->

                        <button type="button" 
                            class="btn btn-outline-danger delete-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteCaseModal"
                            data-id="{{ $case->id }}"
                            data-url="{{ route('cases.destroy', $case->id) }}"
                            data-page="{{ request('page', 1) }}"
                            data-search="{{ request('search') }}">
                            Delete
                        </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Cases Found!</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $cases->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    @if(session('success'))
    <script>
        setTimeout(function () {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);
    </script>
    @endif

     <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search-input");

            if(searchInput){
                searchInput.addEventListener("input", function () {
                    if (this.value.trim() === "") {
                        window.location.href = "{{ route('cases.year', $yearData->id) }}";
                    }
                });
            }
        });
    </script>
 <style>
    .highlight-row {
        animation: glow 2s ease-in-out;
        background-color: rgba(0, 255, 150, 0.15) !important;
    }

    @keyframes glow {
        0% {
            box-shadow: 0 0 10px #00ff99;
        }
        50% {
            box-shadow: 0 0 20px #00ff99;
        }
        100% {
            box-shadow: none;
        }
    }

    .chart-card{
    border: 1px solid #2c2c2c;
}

.chart-container{
    width: 350px;
    height: 250px;
    margin: auto;
}

.chart-container canvas{
    width: 100% !important;
    height: 100% !important;
}

.chart-card{
    border: 2px solid #00d4ff;
    border-radius: 8px;
    padding: 10px;
}
#casesChart{
    display: block;
    margin: auto;
}

.highlight{
    background-color: yellow;
    color: black;
    font-weight: bold;
    padding: 2px 4px;
    border-radius: 3px;
}

</style>

@if(session('updated_id'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            let caseId = "{{ session('updated_id') }}";
            let row = document.getElementById("case-" + caseId);

            if(row){
                row.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }

        });
    </script>
@endif

<div class="modal fade" id="deleteCaseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">Delete Case?</h5>
                <button
                type="button"
                class="btn-close btn-close-white"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <p>You're about  to delete this case.</p>
                <p>This action cannot be reserved</p>
            </div>
            <div class="modal-footer border-0">
                <button
                type="button"
                class="btn btn-outline-light"
                data-bs-dismiss="modal"
                >
                Cancel    
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <input type="hidden" name="page" id="deletePage">
                <input type="hidden" name="search" id="deleteSearch">

                <button type="submit" class="btn btn-danger">
                    Delete Case
                </button>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')

<script id="m38dxq">
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');
    const deletePage = document.getElementById('deletePage');
    const deleteSearch = document.getElementById('deleteSearch');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const deleteUrl = this.getAttribute('data-url');
            const page = this.getAttribute('data-page');
            const search = this.getAttribute('data-search');

            deleteForm.action = deleteUrl;
            deletePage.value = page;
            deleteSearch.value = search;
        });
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(){

            let caseId = this.getAttribute('data-id');
            let page = this.getAttribute('data-page');

            deleteForm.action = `/cases/${caseId}?page=${page}`;

        });
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const ctx = document.getElementById('casesChart');

    new Chart(ctx, {
    type: 'pie',
    data: {
        labels: @json($casesPerMonth->keys()),
        datasets: [{
            data: @json($casesPerMonth->values()),
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796'
            ]
        }]
    },
    options: {
        responsive: false,
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        }
    }
});

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const table = document.getElementById("casesTable");

    if (!table) return;

    const search = "{{ request('search') }}";
    const success = "{{ session('success') }}";

    // Trigger scroll only for Add or Search
    if (search || success) {

        table.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });

    }

});
</script>

<script>

const updateCtx = document.getElementById('updatesChart');

if(updateCtx){

new Chart(updateCtx, {
    type: 'pie',
    data: {
        labels: @json($casesUpdatedPerMonth->keys()),
        datasets: [{
            data: @json($casesUpdatedPerMonth->values()),
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796'
            ],
            borderWidth: 2
        }]
    },
    options:{
        plugins:{
            legend:{
                labels:{
                    color:'white'
                }
            }
        }
    }
});

}
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const deleteButtons = document.querySelectorAll(".delete-btn");
    const deleteForm = document.getElementById("deleteCaseForm");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {

            let caseId = this.getAttribute("data-id");

            deleteForm.action = "/cases/" + caseId;

        });
    });

});
</script>

@endsection