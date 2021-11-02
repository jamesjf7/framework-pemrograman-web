@extends('layouts.app')

@section('content')

    <div style="padding: 12px;">
        <section>
            <h3>List All Groups</h3>
            <table border="1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Member count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->code }}</td>
                            <td>{{ $group->users->count() }}</td>
                            <td><button><a href="{{ url('/groups/' . $group->code) }}">Detail</a></button></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center">No Groups</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
        <hr>

        <section>
            <h3>Add New Group</h3>
            <form action="{{ url('/groups/store') }}" method="POST">
                @csrf
                <label for="name">Name : </label>
                <input type="text" name="name" id="name">
                <button type="submit">Add</button>
            </form>
        </section>
    </div>

@endsection
