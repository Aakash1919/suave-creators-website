@extends('errors.layout')

@section('title', '403 — Forbidden')

@section('message')
  Error 403 Access denied. Sorry, you don’t have permission to view this page
@endsection

@section('art')
  <img src="{{ asset('assets/errors/error-403.svg') }}" alt="403" title="403" width="672" height="500">
@endsection
