<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>الملف الشخصي للمؤسسة</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="text-center mb-4">الملف الشخصي للمؤسسة</h2>

  <div class="card shadow">
    <div class="card-body">

      <!-- User Info -->
      <div class="mb-3">
        <strong>اسم المستخدم:</strong> {{ $user->name }}
      </div>
      <div class="mb-3">
        <strong>رقم الجوال:</strong> {{ $user->phone_code }} {{ $user->phone_number }}
      </div>
      <div class="mb-3">
        <strong>الدولة:</strong> {{ $selected_country->name ?? 'غير محددة' }}
      </div>
      <div class="mb-3">
        <strong>المدينة:</strong> {{ $user->city }}
      </div>
      <div class="mb-3">
        <strong>النبذة:</strong>
        <p class="border rounded p-2">{{ $user->bio }}</p>
      </div>

      <!-- Organization Info -->
      <div class="mb-3">
        <strong>نوع المؤسسة:</strong> {{ $organization->type->name ?? 'غير محدد' }}
      </div>
      <div class="mb-3">
        <strong>الموقع الإلكتروني:</strong>
        <a href="{{ $organization->website }}" target="_blank">{{ $organization->website }}</a>
      </div>
      <div class="mb-3">
        <strong>عدد الموظفين:</strong> {{ $organization->employeeNumber->range ?? 'غير محدد' }}
      </div>
      <div class="mb-3">
        <strong>الميزانية السنوية:</strong> {{ $organization->AnnualBudget->name ?? 'غير محددة' }}
      </div>
      <div class="mb-3">
        <strong>سنة التأسيس:</strong> {{ $organization->established_year }}
      </div>

      <!-- Organization Sectors -->
      <div class="mb-3">
        <strong>القطاعات التي تعمل بها المؤسسة:</strong>
        @forelse($organization_workSectors as $sector)
          <span class="badge bg-info me-1">{{ $sector->name }}</span>
        @empty
          <span class="text-muted">لم يتم تحديد قطاعات.</span>
        @endforelse
      </div>

      <!-- Branches -->
      <div class="mb-3">
        <strong>الفروع:</strong>
        @if(count($branches))
          <ul class="list-group">
            @foreach($branches as $branch)
              <li class="list-group-item">
                المدينة: {{ $branch['city'] }}
                @php
                  $country = $countries->find($branch['country_id']);
                @endphp
                - الدولة: {{ $country->name ?? 'غير محددة' }}
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-muted">لا توجد فروع مسجلة.</p>
        @endif
      </div>

    </div>
  </div>
</div>

</body>
</html>
