@extends('layouts.dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Roles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="mb-2 ml-3">
        <a href="{{ route('dashboard.roles.create') }}" class="btn btn-sm btn-primary ml-3">New</a>
        {{-- <a href="{{ route('dashboard.roles.trash') }}" class="btn btn-sm btn-dark">Trash</a> --}}
    </div>

    <x-alert type="success" />
    <x-alert type="info" />

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created_at</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td> <a href="{{ route('dashboard.roles.show', $role->id) }}"> {{ $role->name }}</a></td>
                    <td>{{ $role->created_at }}</td>
                    <td>
                        @can('roles.update')
                            <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('roles.delete')
                            <form action="{{ route('dashboard.roles.destroy', $role->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No roles defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $roles->withQueryString()->links() }}
@endsection
