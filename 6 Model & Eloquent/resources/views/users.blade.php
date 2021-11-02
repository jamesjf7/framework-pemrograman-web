@extends('layouts.app')

@section('content')

    <div style="padding: 12px;">
        <section>
            <h3>List All Users</h3>
            <ul>
                @forelse ($users as $user)
                    <li>
                        <a href="{{ url('/users/' . $user->id) }}">{{ $user->username }}</a>
                    </li>
                @empty
            </ul>
            No Users...
            @endforelse
        </section>

        <hr>

        <section>
            <h3>Add New User</h3>

            <form action="{{ url('/users/store') }}" method="POST">
                @csrf
                <label for="username">Username : </label>
                <input type="text" name="username" id="username"><br>

                <label for="password">Password : </label>
                <input type="password" name="password" id="password"><br>

                <label for="password_confirmation">Password Confirmation : </label>
                <input type="password" name="password_confirmation" id="password_confirmation"><br>

                <button type="submit" class="btn btn-primary">Add User</button>
        </section>
    </div>

@endsection
