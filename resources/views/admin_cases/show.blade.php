@extends('layouts.app')

@section('content')

<div class="container text-white">

    <h2 class="mb-4">Administrative Cases</h2>

            <div class="d-flex justify-content-between align-items-center mb-3">

                <a href="{{ route('admin-cases.add-row', $case->id) }}" class="btn btn-success">
                    ➕ Add Administrative Case
                </a>

                   <form method="GET" class="mx-auto" style="width: 700px;">
                        <input type="text" id="searchInput" name="search" class="form-control text-center"
                        placeholder="Search..." value="{{ request('search') }}">
                  </form>

                <a href="{{ route('admin-cases.print', $case->id) }}" 
                    class="btn btn-info" 
                    target="_blank">
                        🖨 Download
                </a>

            </div>

    <h4 class="text-center">{{ $case->report_title }}</h4>

    <table class="table" style="background-color: white; color: black;">
        
        <thead>
            <tr>
                <th>Name</th>
                <th>Station</th>
                <th>Docket No.</th>
                <th>Nature</th>
                <th>Status</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>

        <tbody> 

            @forelse($cases as $item)
                <tr class="{{ request()->get('highlight') == $item->id ? 'highlight-row' : '' }}">
                    <td style="position: relative; padding-right: 25px;">
                        <!-- <div style="font-size:10px; color:yellow;">
                            ID: {{ $item->id }} | H: {{ request('highlight') }}
                        </div> -->
                        {{ $loop->iteration }}. {{ $item->name }}
                        <!-- ✏️ EDIT ICON (INSIDE CELL TOP RIGHT) -->
                        <a href="{{ route('admin-cases.edit', $item->id) }}"
                            style="
                                position: absolute;
                                top: 5px;
                                right: 5px;
                                font-size: 13px;
                                color: #ccc;
                                text-decoration: none;
                            ">
                                   ✏️
                        </a>
                    </td>
                    <td>{{ $item->station }}</td>
                    <td>{{ $item->docket_no }}</td>
                    @php
                        $parts = explode('||', $item->nature);
                        $text = $parts[0];

                        $color = isset($parts[1]) && $parts[1] !== 'none' ? trim($parts[1]) : null;

                        $bgColor = match($color) {
                            'yellow' => '#FFD700',
                            'green' => '#28a745',
                            'red' => '#dc3545',
                            default => '#ffffff'
                        };

                        $textColor = 'black';
                    @endphp

                    <td style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                        {{ $text }}
                    </td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No data yet</td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>
<style>
    .edit-btn {
    opacity: 0;
    transition: 0.2s;
    }

    tr:hover .edit-btn {
        opacity: 1;
    }
    .highlight-row {
    background-color: yellow !important;
    animation: glowPulse 6s ease-in-out 2;
    }

    @keyframes glowPulse {
        0% { background-color: rgba(0,255,0,0.2); }
        50% { background-color: rgba(0,255,0,0.6); }
        100% { background-color: rgba(0,255,0,0.2); }
    }
</style>
<script>
window.onload = function () {
    let highlighted = document.querySelector('.highlight-row');
    if (highlighted) {
        highlighted.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
};
</script>
<script>
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function () {
        if (this.value === '') {
            window.location.href = window.location.pathname;
        }
    });
</script>
@endsection