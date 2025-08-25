<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trainer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef1f5;
            font-family: 'Segoe UI', sans-serif;
        }
        .budget-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s ease;
        }
        .budget-card:hover {
            transform: translateY(-4px);
        }
        .budget-header {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: #343a40;
        }
        .budget-label {
            font-weight: 600;
            color: #6c757d;
            margin-right: 8px;
        }
        .badge {
            margin: 4px 4px 4px 0;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 12px;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h2 class="mb-5 text-center text-primary"><i class="bi bi-person-lines-fill me-2"></i>Trainer Budgets Overview</h2>

        @foreach($trainers as $trainer)
            <div class="budget-card">
                <div class="budget-header">
                    <i class="bi bi-person-circle me-2"></i>{{ $trainer->user->name ?? '—' }} {{ $trainer->last_name }}
                </div>
                @if($trainer->image)
                    <img src="{{ asset('storage/' . $trainer->user->image) }}" alt="Trainer Image"
                        class="img-thumbnail mb-3" style="max-width: 150px;">
                @endif
                <p>
                    <span class="budget-label">
                        <i class="bi bi-geo-alt-fill me-1"></i> rating count:
                    </span>
                    {{ $ratings->where('trainer_id', $trainer->id)->count() }}
                </p>

                <p>
                    <span class="budget-label">
                        <i class="bi bi-star-fill me-1 text-warning"></i> rating average:
                    </span>
                    {{
                        $ratings->where('trainer_id', $trainer->id)->count() > 0
                            ? number_format(
                                (
                                    $ratings->where('trainer_id', $trainer->id)->sum('clarity') +
                                    $ratings->where('trainer_id', $trainer->id)->sum('interaction') +
                                    $ratings->where('trainer_id', $trainer->id)->sum('organization')
                                ) / ($ratings->where('trainer_id', $trainer->id)->count() * 3), 1)
                            : 'لا يوجد تقييم بعد'
                    }} نجوم
                </p>

                <p><span class="budget-label"><i class="bi bi-geo-alt-fill me-1"></i>Location:</span>
                    {{ $trainer->user->country->name ?? '—' }} , {{ $trainer->user->city ?? '—' }}
                </p>

                <p><span class="budget-label"><i class="bi bi-chat-left-quote-fill me-1"></i>Headline:</span>
                    {{ $trainer->headline }}
                </p>

                <p><span class="budget-label"><i class="bi bi-briefcase-fill me-1"></i>Provided Services:</span>
                    @foreach($trainer->provided_services as $serviceId)
                        <span class="badge bg-primary">{{ $services[$serviceId] ?? 'Unknown' }}</span>
                    @endforeach
                </p>

                <p><span class="budget-label"><i class="bi bi-diagram-3-fill me-1"></i>Work Fields:</span>
                    @foreach($trainer->work_fields as $fieldId)
                        <span class="badge bg-secondary">{{ $work_fields[$fieldId] ?? 'Unknown' }}</span>
                    @endforeach
                </p>

                <p><span class="budget-label"><i class="bi bi-lightbulb-fill me-1"></i>Important Topics:</span>
                    @foreach($trainer->important_topics as $topic)
                        <span class="badge bg-info text-dark">{{ $topic }}</span>
                    @endforeach
                </p>
            </div>
        @endforeach
    </div>
</body>
</html>