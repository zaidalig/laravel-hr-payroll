@extends('layouts.app')@section('title','Add Employee')@section('page_title','Add Employee')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('employees.store') }}">@csrf
@include('employees._form')
<div class="mt-4"><button class="btn btn-primary">Save Employee</button> <a href="{{ route('employees.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
