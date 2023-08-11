@extends('layouts.dashboard')

@section('content')

<x-alert type="success" />
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Profile</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name="first_name" label="First Name" :value="$user->profile->first_name" />
        </div>
        <div class="col-md-6">
            <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name" />
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name="birthday" label="Birthday" type="date" :value="$user->profile->birthday" />
        </div>
        <div class="col-md-6">
            <x-form.radio name="gender" label="Gender" :options="['male'=>'Male','female'=>'Female']" :checked="$user->profile->gender" />
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="street_address" label="Street Address" :value="$user->profile->street_address" />
        </div>
        <div class="col-md-4">
            <x-form.input name="city" label="City" :value="$user->profile->city" />
        </div>
        <div class="col-md-4">
            <x-form.input name="state" label="State" :value="$user->profile->state" />
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code" />
        </div>
        <div class="col-md-4">
            <x-form.select name="country" label="Country" :options="$countries" :selected="$user->profile->country" />
        </div>
        <div class="col-md-4">
            <x-form.select name="local" label="Local" :options="$locales" :selected="$user->profile->local" />
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>

</form>

@endsection