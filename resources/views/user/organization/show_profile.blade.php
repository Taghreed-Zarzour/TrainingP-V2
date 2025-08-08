@extends('frontend.layouts.master')

@section('title', 'الملف الشخصي للمؤسسة')
@section('content')
    <style>
        /* العناصر العامة */
        .profile-header {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f0f0f0;
        }

        .org-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .org-type {
            color: #666;
            font-size: 0.9rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .info-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .edit-btn {
            background: #f0f0f0;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .edit-btn:hover {
            background: #e0e0e0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .about-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .about-text {
            line-height: 1.6;
            color: #444;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .contact-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
        }

        .contact-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }

        .contact-value {
            font-weight: bold;
        }

        .sectors-section {
            margin-bottom: 20px;
        }

        .sectors-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .sector-tag {
            background: #e0f7fa;
            color: #00796b;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .branches-section {
            margin-bottom: 20px;
        }

        .branches-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .branch-card {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            border-left: 3px solid #00796b;
        }

        .branch-city {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .branch-country {
            color: #666;
            font-size: 0.9rem;
        }

        /* التعديلات للشاشات المتوسطة */
        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* التعديلات للشاشات الصغيرة */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .contact-info {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .profile-info {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <main class="organization-profile-page">
        <div class="container py-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- رأس الملف الشخصي -->
            <div class="custom-card mb-4">
                <div class="profile-header">
                    <div class="profile-info">
                        @if ($organization->logo)
                            <img src="{{ asset('storage/' . $organization->logo) }}" alt="شعار المؤسسة" class="profile-image">
                        @else
                            <img src="{{ asset('images/default-org.png') }}" alt="شعار افتراضي" class="profile-image">
                        @endif
                        <div>
                            <div class="org-name">{{ $organization->name }}</div>
                            <div class="org-type">{{ $organization->type->name ?? 'مؤسسة غير ربحية' }}</div>
                        </div>
                    </div>
                    <button class="edit-btn" onclick="openEditModal()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.06 9.02L14.98 9.94L5.92 19H5V18.08L14.06 9.02ZM17.66 3C17.41 3 17.15 3.1 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C18.17 3.09 17.92 3 17.66 3ZM14.06 6.19L3 17.25V21H6.75L17.81 9.94L14.06 6.19Z" fill="#555"/>
                        </svg>
                        تعديل المعلومات
                    </button>
                </div>

                <!-- معلومات المؤسسة الأساسية -->
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">سنة التأسيس</div>
                        <div class="info-value">{{ $organization->established_year ?? 'غير محدد' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">عدد الموظفين</div>
                        <div class="info-value">{{ $organization->employeeNumber->range ?? 'غير محدد' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">الميزانية السنوية</div>
                        <div class="info-value">{{ $organization->AnnualBudget->name ?? 'غير محددة' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">الدولة</div>
                        <div class="info-value">{{ $user->country->name ?? 'غير محددة' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">المدينة</div>
                        <div class="info-value">{{ $user->city ?? 'غير محددة' }}</div>
                    </div>
                </div>
            </div>

            <!-- قسم حول المؤسسة -->
            <div class="custom-card mb-4">
                <div class="section-title">
                    <span>حول المؤسسة</span>
                    <button class="btn btn-sm btn-link" onclick="openEditModal('about')">تعديل</button>
                </div>
                <div class="about-section">
                    <p class="about-text">
                        {{ $organization->description ?? 'مجتمع حيوي يزود الشباب السوري بالمعرفة والمهارات والأدوات اللازمة لدخول سوق العمل الحر' }}
                    </p>
                </div>
            </div>

            <!-- قسم القطاعات -->
            <div class="custom-card mb-4">
                <div class="section-title">
                    <span>القطاعات</span>
                    <button class="btn btn-sm btn-link" onclick="openEditModal('sectors')">تعديل</button>
                </div>
                <div class="sectors-section">
                    <div class="sectors-container">
                        @forelse($organization_workSectors as $sector)
                            <span class="sector-tag">{{ $sector->name }}</span>
                        @empty
                            <span class="text-muted">لا توجد قطاعات محددة</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- قسم معلومات التواصل -->
            <div class="custom-card mb-4">
                <div class="section-title">
                    <span>معلومات التواصل</span>
                    <button class="btn btn-sm btn-link" onclick="openEditModal('contact')">تعديل</button>
                </div>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-label">عنوان المركز الرئيسي</div>
                        <div class="contact-value">{{ $organization->address ?? 'غير محدد' }}</div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">البريد الإلكتروني</div>
                        <div class="contact-value">{{ $user->email ?? 'غير محدد' }}</div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">الموقع الإلكتروني</div>
                        <div class="contact-value">
                            @if($organization->website)
                                <a href="{{ $organization->website }}" target="_blank">{{ $organization->website }}</a>
                            @else
                                غير محدد
                            @endif
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">رقم الهاتف</div>
                        <div class="contact-value">{{ $user->phone_code }} {{ $user->phone_number }}</div>
                    </div>
                </div>
            </div>

            <!-- قسم الفروع -->
            @if(count($branches) > 0)
                <div class="custom-card mb-4">
                    <div class="section-title">
                        <span>الفروع</span>
                        <button class="btn btn-sm btn-link" onclick="openEditModal('branches')">تعديل</button>
                    </div>
                    <div class="branches-section">
                        <div class="branches-list">
                            @foreach($branches as $branch)
                                <div class="branch-card">
                                    <div class="branch-city">{{ $branch['city'] }}</div>
                                    <div class="branch-country">
                                        @php
                                            $country = $countries->find($branch['country_id']);
                                        @endphp
                                        {{ $country->name ?? 'غير محددة' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Modal التعديل -->
    <div id="editModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل معلومات المؤسسة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="organizationForm" action="{{ route('organization.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="logo" class="form-label">شعار المؤسسة</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                            @if($organization->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $organization->logo) }}" width="100" class="img-thumbnail">
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">اسم المؤسسة</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $organization->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type_id" class="form-label">نوع المؤسسة</label>
                                <select class="form-select" id="type_id" name="type_id" required>
                                    @foreach($organizationTypes as $type)
                                        <option value="{{ $type->id }}" {{ $organization->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="established_year" class="form-label">سنة التأسيس</label>
                                <input type="number" class="form-control" id="established_year" name="established_year" value="{{ $organization->established_year }}" min="1900" max="{{ date('Y') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="employee_number_id" class="form-label">عدد الموظفين</label>
                                <select class="form-select" id="employee_number_id" name="employee_number_id">
                                    <option value="">اختر نطاق الموظفين</option>
                                    @foreach($employeeNumbers as $number)
                                        <option value="{{ $number->id }}" {{ $organization->employee_number_id == $number->id ? 'selected' : '' }}>{{ $number->range }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="annual_budget_id" class="form-label">الميزانية السنوية</label>
                                <select class="form-select" id="annual_budget_id" name="annual_budget_id">
                                    <option value="">اختر الميزانية</option>
                                    @foreach($annualBudgets as $budget)
                                        <option value="{{ $budget->id }}" {{ $organization->annual_budget_id == $budget->id ? 'selected' : '' }}>{{ $budget->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">حول المؤسسة</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $organization->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">القطاعات</label>
                            <div class="row">
                                @foreach($workSectors as $sector)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="work_sectors[]" value="{{ $sector->id }}" id="sector{{ $sector->id }}"
                                                {{ in_array($sector->id, $organization_workSectors->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sector{{ $sector->id }}">
                                                {{ $sector->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="website" class="form-label">الموقع الإلكتروني</label>
                            <input type="url" class="form-control" id="website" name="website" value="{{ $organization->website }}">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">عنوان المركز الرئيسي</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $organization->address }}">
                        </div>

                        <div id="branchesContainer">
                            <label class="form-label">الفروع</label>
                            @foreach($branches as $index => $branch)
                                <div class="branch-item mb-3 p-3 border rounded">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label class="form-label">البلد</label>
                                            <select class="form-select branch-country" name="branches[{{ $index }}][country_id]" required>
                                                <option value="">اختر البلد</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $branch['country_id'] == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">المدينة</label>
                                            <input type="text" class="form-control branch-city" name="branches[{{ $index }}][city]" value="{{ $branch['city'] }}" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-branch">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm mb-3" id="addBranch">إضافة فرع جديد</button>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // فتح مودال التعديل
        function openEditModal(section = '') {
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
            
            if (section) {
                // يمكنك هنا إضافة منطق للتركيز على قسم معين في المودال
                // مثلاً تمرير إلى قسم القطاعات أو الفروع
            }
        }

        // إضافة فرع جديد
        document.getElementById('addBranch').addEventListener('click', function() {
            const container = document.getElementById('branchesContainer');
            const index = document.querySelectorAll('.branch-item').length;
            
            const branchHtml = `
                <div class="branch-item mb-3 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label">البلد</label>
                            <select class="form-select branch-country" name="branches[${index}][country_id]" required>
                                <option value="">اختر البلد</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">المدينة</label>
                            <input type="text" class="form-control branch-city" name="branches[${index}][city]" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-branch">حذف</button>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', branchHtml);
        });

        // حذف فرع
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-branch')) {
                e.target.closest('.branch-item').remove();
            }
        });

        // التحقق من صحة النموذج
        document.getElementById('organizationForm').addEventListener('submit', function(e) {
            let valid = true;
            
            // يمكنك إضافة المزيد من التحقق هنا
            
            if (!valid) {
                e.preventDefault();
            }
        });
    </script>
@endsection