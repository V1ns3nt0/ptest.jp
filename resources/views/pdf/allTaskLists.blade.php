<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>All your taskLists</title>
</head>
<body>
<h2 class="text-center mb-5">All your taskLists</h2>

<div class="">
    @foreach($lists as $list)
    <div class="card mb-3 mx-3" style="max-width: 340px;">
        <div class="row no-gutters">
            <div class="card-body">
                <h5 class="card-title">{{ $list->name }}</h5>
                <p class="card-text">Status: @if($list->is_opened == 1) Opened @else Closed @endif</p>
                <p class="card-text"><small class="text-muted">Last updated {{ $list->updated_at }}</small></p>
                <p class="card-text"><small class="text-muted">Created {{ $list->created_at }}</small></p>
            </div>
        </div>
    </div>
    @endforeach
</div>
</body>
</html>


