<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Task list</title>
</head>
<body>
<h2 class="text-center mb-5">{{$list['taskList']->name}}</h2>
<div class="container col-8">
    <p class="card-text">Status: @if($list['taskList']->is_opened == 1) Opened @else Closed @endif</p>
    <p class="card-text"><small class="text-muted">Last updated {{ $list['taskList']->updated_at }}</small></p>
    <p class="card-text"><small class="text-muted">Created {{ $list['taskList']->created_at }}</small></p>
</div>
<div>
</div>
<div class="">
    <div>
        <h3>Tasks</h3>
        <div class="card" style="width: 18rem;">
            <ul>
                @foreach($list['tasks'] as $task)
                    <li>
                        {{ $task->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div>
        <h3>SubLists</h3>
        @foreach($list['sublists'] as $sub)
        <div class="card mb-3 mx-3" style="max-width: 340px;">
            <div class="row no-gutters">
                <div class="card-body">
                    <h5 class="card-title">{{ $sub->name }}</h5>
                    <p class="card-text">Status: @if($sub->is_opened == 1) Opened @else Closed @endif</p>
                    <p class="card-text"><small class="text-muted">Last updated {{ $sub->updated_at }}</small></p>
                    <p class="card-text"><small class="text-muted">Created {{ $sub->created_at }}</small></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</body>
</html>
