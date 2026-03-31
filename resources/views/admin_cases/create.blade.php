@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card bg-dark text-white shadow mx-auto" style="max-width: 700px;">

        <div class="card-body">

            <h4 class="mb-4 text-center">
                Add Administrative Report
            </h4>

            <form action="{{ route('admin-cases.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Report Title</label>
                    <input type="text" name="report_title" class="form-control" placeholder="Enter full title..." required>
                </div>

                <!-- 🔥 BUTTONS -->
                <div class="d-flex justify-content-between mt-4">

                    <a href="{{ route('admin-cases.index') }}" class="btn btn-secondary px-4">
                         Back
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        Create
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection