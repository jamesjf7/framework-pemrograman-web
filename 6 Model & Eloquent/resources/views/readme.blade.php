@extends('layouts.app')

@section('content')

    <div style="padding: 12px">
        <script src="https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2/webcomponents-loader.min.js"></script>
        <script type="module" src="https://cdn.jsdelivr.net/gh/zerodevx/zero-md@1/src/zero-md.min.js"></script>
        <zero-md src="README.md"></zero-md>
    </div>

@endsection
