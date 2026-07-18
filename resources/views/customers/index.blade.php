@extends('layouts.app')

@section('title', 'Customers')

@section('content_header')
    <h1>Customers</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">

        <a href="{{ route('customers.create') }}"
           class="btn btn-primary">
            Add Customer
        </a>

        <form method="GET" action="{{ route('customers.index') }}">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search..."
                   class="form-control">
        </form>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>

                    <td>
                        <a href="{{ route('customers.edit', $customer->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('customers.destroy', $customer->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete customer?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No customers found
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>

        <div class="mt-3">
            {{ $customers->links() }}
        </div>

    </div>
</div>

@stop