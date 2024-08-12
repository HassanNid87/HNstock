@extends('base')
@section('title', ($isUpdate ? 'Update' : 'Create') . ' Category')

@php
    $route = route('categories.store');
    if ($isUpdate) {
        $route = route('categories.update', $category);
    }
@endphp

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">@yield('title')</h5>
        </div>
        <div class="card-body">
            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($isUpdate)
                    @method('PUT')
                @endif


                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-sm" value="{{ $isUpdate ? 'Edit' : 'Create' }}">
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
