@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card bg-dark text-white shadow mx-auto" style="max-width: 700px;">

        <div class="card-body">

            <h4 class="mb-4 text-center">
                Add New Fiscal Year
            </h4>

            <form action="{{ route('years.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Year</label>
                    <input type="text" name="year" class="form-control" placeholder="e.g. FY2028" required>
                </div>

                <!-- 🔥 BUTTONS -->
                <div class="d-flex justify-content-between mt-4">

                    <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">
                        Back
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection