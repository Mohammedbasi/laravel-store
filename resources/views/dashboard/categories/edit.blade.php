@extends('layouts.dashboard')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Category</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Category</a></li>
                    <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<form action="{{ route('dashboard.categories.update',$category->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    @include('dashboard.categories._form',[
        'button_label'=>'Update'
        ])
</form>

@endsection