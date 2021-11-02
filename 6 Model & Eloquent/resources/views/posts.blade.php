@extends('layouts.app')

@section('content')
    <style>
        .card {
            /* Add shadows to create the "card" effect */
            padding: 12px;
            margin-top: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        /* On mouse-over, add a deeper shadow */
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.5);
        }

    </style>

    <div style="padding: 12px;">
        <h3>List All Post</h3>
        @forelse ($posts as $post)
            <div class="card">
                <span>
                    <b><a href="{{ url('/users/' . $post->user->id) }}">{{ '@' . $post->user->username }}</a></b> &nbsp;
                    {{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                    <p>{{ $post->content }}</p>
                </span>
            </div>
        @empty
            No Posts...
        @endforelse
    </div>

@endsection
