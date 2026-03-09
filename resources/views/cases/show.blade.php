@extends('layouts.app')

@section('title', 'Cases Details')
@section('content')
<div class="container mt-4">
    <div class="row">
            <div class="col-md-6 offset-3">
     <h1 class="mb-4 text-white">Cases Details</h1>
            <div class="card bg-dark text-white mt-4">
                <div class="card-body border border-success rounded">
                    <h5 class="card-title"><strong>FY2026:</strong> {{ $case->title}} </h5>
                    <p class="card-date"><strong>Date Filed:</strong> {{ $case->date_filed->format('j-M-Y')}} </p>
                    <p class="card-text"><strong>Status:</strong> {{ $case->status}} </p>
                    <p class="card-date"><strong>Latest Date of Entry:</strong> {{ $case->latest_date_of_entry ? $case->latest_date_of_entry->format('j-M-Y') : 'No Entry Yet' }}</p>
                    <a href="{{ route('cases.index', ['page' => request('page')]) }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection