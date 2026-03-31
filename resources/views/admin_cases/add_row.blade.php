@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card bg-white text-black shadow mx-auto" style="max-width: 700px;">
        
        <div class="card-body">

            <h4 class="mb-4 text-center">
                {{ $report->report_title }} - <br> <br>
                 ADD ADMINISTRATIVE CASE
            </h4>

            <form action="{{ route('admin-cases.store-row', $report->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="station" class="form-control" placeholder="Station" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="docket_no" class="form-control" placeholder="Docket No." required>
                </div>

                <div class="mb-3">
                    <label>Nature</label>
                    <textarea name="nature" class="form-control" placeholder="Nature" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Highlight</label><br>

                    <input type="radio" name="color" value="yellow"> 🟡 Yellow
                    <input type="radio" name="color" value="green" class="ms-3"> 🟢 Green
                    <input type="radio" name="color" value="red" class="ms-3"> 🔴 Red
                </div>

                <div class="mb-3">
                    <input type="text" name="status" class="form-control" placeholder="Status" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">Save</button>
                    <a href="{{ route('admin-cases.show', $report->id) }}" class="btn btn-secondary px-4">Back</a>
                </div>

            </form>

        </div>

    </div>

</div>
<style>
    .card{
        border-radius: 12px;
    }
    .form-control{
        height: 60px;
    }
</style>
<script>
function setColor(color) {
    document.getElementById('colorInput').value = color;
}
</script>

@endsection