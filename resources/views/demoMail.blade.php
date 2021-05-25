<!DOCTYPE html>
<html>
<head>
    <title>Mail Send in Laravel Example with</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
<div class="container">
    <h1>Mail Send in Laravel Example with <a href="https://codingdriver.com/">Coding Driver</a></h1>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('send.email') }}" method="post">
        @csrf
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Enter Email">
            @error('email')
            <span class="text-danger"> {{ $message }} </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Subject:</label>
            <input type="text" name="subject" class="form-control" placeholder="Enter subject">
            @error('subject')
            <span class="text-danger"> {{ $message }} </span>
            @enderror
        </div>

        <div class="form-group">
            <strong>Content:</strong>
            <textarea name="content" rows="5" class="form-control" placeholder="Enter Your Message"></textarea>
            @error('content1')
            <span class="text-danger"> {{ $message }} </span>
            @enderror
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success save-data">Send</button>
        </div>
    </form>
</div>
</body>
</html>
