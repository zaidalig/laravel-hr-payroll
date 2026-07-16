@extends('layouts.app')@section('title','Edit Employee')@section('page_title','Edit Employee')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('employees.update',$employee) }}">@csrf @method('PUT')
@include('employees._form')
<div class="mt-4"><button class="btn btn-primary">Update</button> <a href="{{ route('employees.show',$employee) }}" class="btn btn-light">Back</a></div></form></div>@endsection
