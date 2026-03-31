@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card bg-dark text-white shadow mx-auto" style="max-width: 700px;">

        <div class="card-body">

            <h4 class="mb-4 text-center">
                Edit Administrative Case
            </h4>

            @php
                $parts = explode('||', $item->nature);
                $text = $parts[0];
                $color = $parts[1] ?? null;
            @endphp

            <form action="{{ route('admin-cases.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $item->name }}">
                </div>

                <div class="mb-3">
                    <label>Station</label>
                    <input type="text" name="station" class="form-control" value="{{ $item->station }}">
                </div>

                <div class="mb-3">
                    <label>Docket No.</label>
                    <input type="text" name="docket_no" class="form-control" value="{{ $item->docket_no }}">
                </div>

                <div class="mb-3">
                    <label>Nature</label>
                    <textarea name="nature" class="form-control" rows="3">{{ explode('||', $item->nature)[0] }}</textarea>  
                </div>
                <div class="mb-3">
                    <label>Highlight</label><br>

                    <input type="radio" name="color" value="none" {{ $color == null ? 'checked' : '' }}>  None

                    <input type="radio" name="color" value="yellow"
                        {{ $color == 'yellow' ? 'table-warning' : '' }}> 🟡 Yellow

                    <input type="radio" name="color" value="green"
                        {{ $color == 'green' ? 'checked' : '' }} class="ms-3"> 🟢 Green

                    <input type="radio" name="color" value="red"
                        {{ $color == 'red' ? 'checked' : '' }} class="ms-3"> 🔴 Red
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" value="{{ $item->status }}">
                </div>

                <!-- 🔥 BUTTONS -->
                <div class="d-flex justify-content-between mt-4">

                    <!-- BACK -->
                    <a href="{{ route('admin-cases.show', $item->report_id) }}" class="btn btn-secondary">
                        Back
                    </a>

                    <!-- UPDATE -->
                    <button type="submit" class="btn btn-success px-4">
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection