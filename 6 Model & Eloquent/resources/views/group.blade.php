@extends('layouts.app')

@section('content')

    <div style="padding: 12px;">
        <h2>Detail Group</h2>
        Name : {{ $group->name }}
        <br>
        Code : {{ $group->code }}
        <br>
        Created At : {{ $group->created_at }}

        <h3>List All Member</h3>
        Total Members : {{ $group->users->count() }}
        <table border="1">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Joined At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($group->users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        {{-- Akses data di Intermediate table menggunakan keyword pivot --}}
                        <td>{{ $user->pivot->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center">No Members</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
