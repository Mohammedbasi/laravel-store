@extends('layouts.dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Trashed Categories</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Categories</li>
                    <li class="breadcrumb-item active">Trash</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="mb-2 ml-3">
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
</div>

<x-alert type="success"/>
<x-alert type="info"/>

<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
<x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
<select name="status" class="form-control mx-2">
    <option value="">All</option>
    <option value="active" @selected(request('status') == 'active')>Active</option>
    <option value="archived" @selected(request('status') == 'archived')>Archived</option>
</select>

<button class="btn btn-dark mx-2">Filter</button>

</form>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Deleted_at</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td> <img height="60" src="{{ asset('storage/'.$category->image) }}" alt=""> </td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->deleted_at }}</td>
            <td>
            <form action="{{route('dashboard.categories.restore',$category->id)}}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                </form>
            </td>
            <td>
                <form action="{{route('dashboard.categories.force-delete',$category->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No categories defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $categories->withQueryString()->links()}}
@endsection