@extends('errors.layout')

@section('title', '404 — Page not found')

@section('message')
  Error 404 Page not found. Sorry the page you looking for doesn’t exist or has been moved
@endsection

@section('art')
  <img src="{{ asset('assets/errors/error-404.svg') }}" alt="404" title="404" width="672" height="500">
@endsection
