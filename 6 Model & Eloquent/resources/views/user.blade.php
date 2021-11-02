@extends('layouts.app')

@section('content')
    <div>
        <h2>Tutor Model & Eloquent (Relationship)</h2>

        <section>
            <h3>One To One (User - Profile)</h3>
            {{-- Form update user's profile --}}
            <form action="{{ url('/users/update') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                Username : <input type="text" name="username" id="" value="{{ $user->username }}"><br>
                Instagram : <input type="text" name="instagram" id="" value="{{ $user->profile->instagram }}"><br>
                Github : <input type="text" name="github" id="" value="{{ $user->profile->github }}"><br>
                Web : <input type="text" name="web" id="" value="{{ $user->profile->web }}"><br>
                <button>Update</button>
            </form>

        </section>

        <hr>

        <section>
            <h3>Many To Many (User - Group)</h3>

            Total Groups : {{ $user->groups->count() }} <br>
            {{-- form input code to join group --}}
            <form action="{{ url('/groups/join') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                Code : <input type="text" name="code">
                <button type="submit">Join</button>
            </form>

            <br>

            List Group : <br>
            Total groups : {{ $user->groups->count() }} <br>
            {{-- Show user's groups --}}
            <table border="1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Joined At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user->groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->code }}</td>
                            <td>{{ $group->pivot->created_at }}</td>
                            <th>
                                <form action="{{ url('/groups/leave') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="code" value="{{ $group->code }}">
                                    <button>Leave</button>
                                </form>
                                <button><a href="{{ url('/groups/' . $group->code) }}">Detail</a></button>
                            </th>
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
            <h3>One To Many (User - Post)</h3>

            {{-- form input post --}}
            <form action="{{ url('/posts/store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <textarea name="content" placeholder="Content"></textarea><br>
                <button type="submit">Submit</button>
            </form>

            <br>

            {{-- Show user's posts --}}
            List Posts : <br>
            Total Posts : {{ $user->posts->count() }} <br>
            <table>
                @foreach ($user->posts as $post)
                    <tr>
                        <td>
                            <form action="{{ url('/posts/delete/' . $post->id) }}" method="POST">
                                @csrf
                                <button>X</button>
                            </form>
                        </td>
                        <td>
                            {{ $post->content }} - <b>{{ '@' . $user->username }}</b>
                        </td>
                    </tr>
                @endforeach
            </table>
        </section>

    </div>
@endsection
