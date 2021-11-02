<header>
    <style>
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        nav li {
            float: left;
        }

        nav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav li a:hover {
            background-color: #111;
        }

    </style>
    <nav>
        <ul>
            <li><a href=" {{ url('/users') }}">Users</a></li>
            <li><a href="{{ url('/posts') }}">Posts</a></li>
            <li><a href="{{ url('/groups') }}">Groups</a></li>

            <li><a href="{{ url('/readme') }}">readme</a></li>
        </ul>
    </nav>
</header>
