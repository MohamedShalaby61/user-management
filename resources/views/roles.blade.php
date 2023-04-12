@extends('layouts.app')

@section('title')
    Roles
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Edit Roles Permissions') }}</div>
                    <div class="card-body">
                        @foreach ($roles as $role)
                            <form action="{{ route('roles.update', $role) }}" method="post">
                                @csrf
                                @method('PUT')
                                <h4>{{ $role->name }}</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Permission</th>
                                            <th>Add/Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->name }}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            {{ $role->hasPermission($permission->slug) ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
