<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{asset('/js/sudoku.js')}}"></script>
    <link href="{{asset('/css/app.css')}}" rel="stylesheet">
    <title>Let's play sudoku!</title>
    <style>
        .container {
            max-width: 500px;
        }
        dl, ol, ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    </style>
</head>
<body class="bg-light">
<div class="container">

<div class="row justify-content-md-center">
    <div class="p-5 rounded mt-5 ">
        <form method="post" enctype="multipart/form-data" id="sudoku-form">
            <h3 class="text-center mb-5">Let's play sudoku!</h3>
            @csrf
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group mt-4">
                <input type="file" name="file" class="form-control" accept=".txt" required>
                <p id="file-errors" class="errors"></p>
            </div>
            <button type="button" class="btn btn-primary btn-block mt-4" id="upload-button" disabled>
                Upload file with sudoku
            </button>
        </form>
    </div>
</div>
</div>
<div class="container-fluid">
<div class="row justify-content-between">
    <div class="col-md-5">
        <h5 class="text-center mb-3" id="unsolved-title"></h5>
        <div id="unsolved-wrapper"></div>
    </div>

    <div class="col-md-5 pu">
        <h5 class="text-center mb-3" id="solved-title"></h5>
        <div id="solved-wrapper"></div>
    </div>
</div>
</div>

</body>
</html>
