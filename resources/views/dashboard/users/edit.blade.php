@extends('layouts.dashboard')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edir User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.users._form', [
            'button_label' => 'Update',
        ])
    </form>
@endsection
