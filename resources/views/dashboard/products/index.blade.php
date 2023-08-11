@extends('layouts.dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Products</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">products</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="mb-2 ml-3">
    <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-primary ml-3">New</a>
    {{--<a href="{{ route('dashboard.products.trash') }}" class="btn btn-sm btn-dark">Trash</a>--}}
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
            <th>Category</th>
            <th>Store</th>
            <th>Created_at</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td> <img height="60" src="{{ asset('storage/'.$product->image) }}" alt=""> </td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9">No products defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $products->withQueryString()->links()}}
@endsection