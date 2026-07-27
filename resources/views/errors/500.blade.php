@extends('errors.layout')

@section('title', '500 — Server error')

@section('message')
  Server Error 500. We apologise and are fixing the problem<br>
  Please try again at a later stage
@endsection

@section('art')
  <img src="{{ asset('assets/errors/error-500.svg') }}" alt="500" title="500" width="672" height="500">
@endsection
