@extends('layouts.dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="mb-5">
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
    </div>

    <x-alert type="success" />
    <x-alert type="info" />

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="{{ route('dashboard.users.show', $user->id) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td></td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        @can('users.update')
                            <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('users.delete')
                            <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post">
                                @csrf
                                <!-- Form Method Spoofing -->
                                <input type="hidden" name="_method" value="delete">
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No users defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->withQueryString()->links() }}
@endsection
