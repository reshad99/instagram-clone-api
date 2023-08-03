<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <style>
        .chat-row {
            margin: 50px;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        ul li {
            padding: 8px;
            background: #928787;
            margin-bottom: 20px;
        }

        ul li:nth-child(2n-2) {
            background: #c3c5c5;
        }

        .chat-input {
            border: 1px solid lightgray;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            padding: 8px 10px;
            background-color: #928787
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="chat-content">
                <ul>
                </ul>
            </div>

            <div class="chat-section">
                <div class="chat-box">
                    <div class="chat-input bg-white" id="chat-input" contenteditable=""></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"
        integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous">
    </script>

    <script>
        window.laravel_echo_port = "{{ config('ports.laravel_echo_port') }}";
    </script>

    <script src="//{{ Request::getHost() }}:{{ config('ports.laravel_echo_port') }}/socket.io/socket.io.js"></script>

    <script src="{{ url('js/laravel-echo-setup.js') }}"></script>
    <script src="{{ url('js/ajax.js') }}"></script>
    <script src="{{ url('js/socketio.js') }}"></script>
</body>

</html>
