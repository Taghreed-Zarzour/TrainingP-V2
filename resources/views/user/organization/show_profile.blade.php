@extends('frontend.layouts.master')

@section('title', 'الملف الشخصي للمؤسسة')
@section('content')
    <style>
        /* تخصيصات التصميم */
        .org-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 20px;
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

        .info-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .edit-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
            font-size: 1rem;
            width: 100%;
            max-width: 180px;
            margin-left: auto;
        }

        .edit-btn:hover {
            background: #0069d9;
        }

        .about-container {


        }

        .about-content {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .about-text {
            line-height: 1.6;
            color: #333;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
            padding: 0 10px;
        }

        .sectors-container {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 10px;
            margin-top: 15px;
        }

        .sector-tag {
            background: #e1f5fe;
            color: #0288d1;
            padding: 10px 18px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin: 0 8px 0px 0;
            border: 1px solid #b3e5fc;
        }


        .contact-info {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 20px;
        }

        .contact-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .contact-item:last-child {
            margin-bottom: 0;
        }

        .contact-label {
            font-size: 0.9rem;
            color: #666;
        }

        .contact-value {
            font-weight: bold;
            direction: ltr;
            text-align: left;
        }

        /* توزيع الأعمدة */
        .about-column {
            flex: 0 0 65%;
            max-width: 65%;
        }

        .contact-column {
            flex: 0 0 35%;
            max-width: 35%;
        }

        /* التجاوب مع أحجام الشاشات */
        @media (max-width: 992px) {
            .about-column,
            .contact-column {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .contact-container {
                margin-top: 20px;
            }
        }

        @media (max-width: 768px) {
            .org-image {
                width: 80px;
                height: 80px;
                border-radius: 15px;
            }

            .org-name {
                font-size: 1.2rem;
            }

            .edit-btn {
                padding: 8px 15px;
                font-size: 0.9rem;
                max-width: 150px;
            }

            .about-container,
            .contact-container {
                border-radius: 20px;
                padding: 10px;
            }

            .about-content,
            .sectors-container,
            .contact-info {
                border-radius: 15px;
                padding: 10px;
            }
        }
    </style>

    <div class="container py-4">
        <!-- الصف الأول: معلومات المؤسسة الأساسية -->
        <div class="row align-items-center mb-4">
            <!-- العمود الأول: الصورة واسم المؤسسة -->
            <div class="col-md-3 col-sm-12 mb-3 mb-md-0">
                <div class="d-flex align-items-center">
                    @if ($organization->logo)
                        <img src="{{ asset('storage/' . $organization->logo) }}" alt="شعار المؤسسة" class="org-image me-3">
                    @else
                        <img src="{{ asset('images/default-org.png') }}" alt="شعار افتراضي" class="org-image me-3">
                    @endif
                    <div>
                        <div class="org-name">{{ $organization->user->getTranslation('name', 'ar') }} </div>
                        <div class="org-type">مؤسسة غير ربحية</div>
                    </div>
                </div>
            </div>

            <!-- العمود الثاني: سنة التأسيس -->
            <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                <div class="info-label">سنة التأسيس</div>
                <div class="info-value">2023</div>
            </div>

            <!-- العمود الثالث: عدد الموظفين -->
            <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                <div class="info-label">عدد الموظفين</div>
                <div class="info-value">2 - 10</div>
            </div>

            <!-- العمود الرابع: الميزانية السنوية -->
            <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                <div class="info-label">الميزانية السنوية</div>
                <div class="info-value">0 - 10000</div>
            </div>

            <!-- العمود الخامس: زر التعديل -->
            <div class="col-md-3 col-sm-12">
                <button class="edit-btn" onclick="openEditModal()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.06 9.02L14.98 9.94L5.92 19H5V18.08L14.06 9.02ZM17.66 3C17.41 3 17.15 3.1 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C18.17 3.09 17.92 3 17.66 3ZM14.06 6.19L3 17.25V21H6.75L17.81 9.94L14.06 6.19Z" fill="white"/>
                    </svg>
                    تعديل المعلومات
                </button>
            </div>
        </div>

        <!-- الصف الثاني: حول المؤسسة والقطاعات مقابل معلومات التواصل -->
        <div class="row">
            <!-- العمود الأول: حول المؤسسة والقطاعات (أوسع) -->
            <div class="about-column col-lg-8 col-md-7">
                <div class="about-container">
                    <div class="section-title">حول المؤسسة</div>
                    <div class="about-content">
                        <p class="about-text m-0">
                            مجتمع معرفي يزود الشباب السوري بالمعرفة والمهارات والأدوات اللازمة لدخول سوق العمل الحر
                        </p>
                    </div>

                    <div class="section-title">القطاعات</div>
                    <div class="sectors-container">
                        <span class="sector-tag">التدريب</span>
                        <span class="sector-tag">التمكين</span>
                        <span class="sector-tag">الخريجين الجدد</span>
                        <span class="sector-tag">زيادة الأعمال</span>
                    </div>
                </div>
            </div>

            <!-- العمود الثاني: معلومات التواصل (أصغر) -->
            <div class="contact-column col-lg-4 col-md-5">
                <div class="contact-container">

                    <div class="contact-info">
                        <div class="section-title">معلومات التواصل</div>
                        <div class="contact-item">
                            <span class="contact-label">عنوان المركز الرئيسي</span>
                            <span class="contact-value">سوريا، حلب</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">البريد الإلكتروني</span>
                            <span class="contact-value">info@sygeeks.net</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">الموقع الإلكتروني</span>
                            <span class="contact-value">www.sygeeks.net</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">رقم الهاتف</span>
                            <span class="contact-value">+90 531 497 70 81</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal التعديل -->
    <div id="editModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل معلومات المؤسسة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="organizationForm" action="{{ route('update_organization_profile') }}" method="POST" enctype="multipart/form-data">
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
                                    <option value="1" selected>مؤسسة غير ربحية</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="established_year" class="form-label">سنة التأسيس</label>
                                <input type="number" class="form-control" id="established_year" name="established_year" value="2023" min="1900" max="{{ date('Y') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="employee_number_id" class="form-label">عدد الموظفين</label>
                                <select class="form-select" id="employee_number_id" name="employee_number_id">
                                    <option value="1" selected>2 - 10</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="annual_budget_id" class="form-label">الميزانية السنوية</label>
                                <select class="form-select" id="annual_budget_id" name="annual_budget_id">
                                    <option value="1" selected>0 - 10000</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">حول المؤسسة</label>
                            <textarea class="form-control" id="description" name="description" rows="3">مجتمع معرفي يزود الشباب السوري بالمعرفة والمهارات والأدوات اللازمة لدخول سوق العمل الحر</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">القطاعات</label>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="work_sectors[]" value="1" id="sector1" checked>
                                        <label class="form-check-label" for="sector1">التدريب</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="work_sectors[]" value="2" id="sector2" checked>
                                        <label class="form-check-label" for="sector2">التمكين</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="work_sectors[]" value="3" id="sector3" checked>
                                        <label class="form-check-label" for="sector3">الخريجين الجدد</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="work_sectors[]" value="4" id="sector4" checked>
                                        <label class="form-check-label" for="sector4">زيادة الأعمال</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="website" class="form-label">الموقع الإلكتروني</label>
                            <input type="url" class="form-control" id="website" name="website" value="www.sygeeks.net">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">عنوان المركز الرئيسي</label>
                            <input type="text" class="form-control" id="address" name="address" value="سوريا، حلب">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" value="info@sygeeks.net">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="+90 531 497 70 81">
                        </div>

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
        function openEditModal() {
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }
    </script>
@endsection