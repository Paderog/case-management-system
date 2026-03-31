@extends('layouts.app')

@section('title', 'Add Case')
@section('content')
    <div>
        <div class="row">
            <div class="col-md-6 offset-3">

                <h2 class="text-white m-0">Add Case</h2>
            
                @session('success')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ $value}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endsession
                <div class="card bg-dark text-white mt-4">
                    <div class="card-body border boder-light rounded">
                        <form action="{{ route('cases.store', $yearData->id) }}" method="POST">
                            <input type="hidden" name="year_id" value="{{ $yearData->id }}">
                            @csrf
                           <div class="mb-3">
                              <label class="form-label">
                                 {{ $yearData->year ?? 'Fiscal Year' }}
                                </label>
                                 <input type="text" 
                                   name="title"
                                    class="form-control form-control-lg bg-dark text-white @error('title') is-invalid @enderror"
                                     value="{{ old('title') }}">
                                      @error('title')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                            <div class="mb-3">
                                <label class="form-label">Date Filed</label>
                                <input type="date" 
                                name="date_filed"
                                class="form-control bg-dark text-white @error('date_filed') is-invalid @enderror"
                                value="{{old('date_filed')}}">
                                @error('date_filed')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ACTION TAKEN/REMARKS</label>
                                <input type="text" 
                                name="status"
                                class="form-control form-control-lg bg-dark text-white @error('status') is-invalid @enderror"
                                value="{{old('status')}}">
                                @error('status')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Latest Date of Entry</label>
                                <input type="date" 
                                name="latest_date_of_entry"
                                class="form-control bg-dark text-white @error('latest_date_of_entry') is-invalid @enderror"
                                value="{{old('latest_date_of_entry')}}">
                                @error('latest_date_of_entry')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <a href="{{ route('cases.year', $yearData->id) }}" class="btn btn-outline-warning">Back</a>
                            <button type="submit" class="btn btn-outline-success text-white">Save</button> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection