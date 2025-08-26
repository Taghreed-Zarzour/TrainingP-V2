<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Programs</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Training Programs</h1>

        <div class="row">
            <div class="col-12">
                <h2>Draft Programs</h2>
                @if(count($drafts) > 0)
                    <div class="card-deck mb-4">
                        @foreach($drafts as $program)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $program->title }}</h5>
                                    <p class="card-text">Completion: {{ $program->completion_percentage }}%</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No draft programs available.</p>
                @endif
            </div>

            <div class="col-12">
                <h2>Announced Programs</h2>
                @if(count($announced) > 0)
                    <div class="card-deck mb-4">
                        @foreach($announced as $program)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $program->title }}</h5>
                                    <p class="card-text">Completion: {{ $program->completion_percentage }}%</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No announced programs available.</p>
                @endif
            </div>

            <div class="col-12">
                <h2>Ongoing Programs</h2>
                @if(count($ongoing) > 0)
                    <div class="card-deck mb-4">
                        @foreach($ongoing as $program)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $program->title }}</h5>
                                    <p class="card-text">Completion: {{ $program->completion_percentage }}%</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No ongoing programs available.</p>
                @endif
            </div>

            <div class="col-12">
                <h2>Completed Programs</h2>
                @if(count($completed) > 0)
                    <div class="card-deck mb-4">
                        @foreach($completed as $program)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $program->title }}</h5>
                                    <p class="card-text">Completion: {{ $program->completion_percentage }}%</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No completed programs available.</p>
                @endif
            </div>

            <div class="col-12">
                <h2>Stopped Programs</h2>
                @if(count($stoppedPrograms) > 0)
                    <div class="card-deck mb-4">
                        @foreach($stoppedPrograms as $program)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $program->title }}</h5>
                                    <p class="card-text">Completion: {{ $program->completion_percentage }}%</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No stopped programs available.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>