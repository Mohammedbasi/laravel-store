@extends('layouts.dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Import Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                        <li class="breadcrumb-item active">Import Products</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <form action="{{ route('dashboard.products.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-form.input label="Products Count" class="form-control-lg" role="input" name="count" />
        </div>
        <button type="submit" class="btn btn-primary">Start importing...</button>
    </form>
@endsection
