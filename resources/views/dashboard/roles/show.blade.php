@extends('layouts.dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $category->name }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"> {{ $category->name }} </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Status</th>
            <th>Store</th>
            <th>Created_at</th>
        </tr>
    </thead>
    <tbody>
        @php
        $products = $category->products()->with('store')->latest()->paginate(5);
        @endphp
        @forelse($products as $product)
        <tr>
            <td> <img height="60" src="{{ asset('storage/'.$product->image) }}" alt=""> </td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->created_at }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No products defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $products->links() }}
@endsection