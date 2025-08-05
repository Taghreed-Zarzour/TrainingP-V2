@extends('frontend.layouts.master')

@section('title', 'التدريبات')

@section('css')

@endsection

@section('content')

  
    <!-- Blue Header Section -->
    <div class="blue-header full-width-header mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-7 text-center">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">
                        تدريباتي
                    </h1>
                </div>
                <div class="mb-4">
                    التدريبات/التدريبات الجارية/تدريب أساسيات تجربة المستخدم/قائمة المسجلين
                </div>
            </div>
        </div>
    </div>




    <div class="tr-trainees-container">
        <div class="tr-trainees-card">
            <div class="tr-trainees-header">
                <div class="tr-bulk-actions">
                    <button class="tr-select-all-btn" id="selectAllBtn">تحديد الكل</button>
                    <button class="tr-mark-present-btn" id="markPresentBtn">تحديد كحضور</button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary view-toggle-btn active" data-view="grid"
                        id="tableViewBtn" title="عرض شبكي">
                    <img src="/images/cources/list.svg">
                    </button>
                    <button type="button" id="gridViewBtn" class="btn btn-outline-primary view-toggle-btn" data-view="list"
                        title="عرض قائمة">
                        
                            <img src="/images/cources/grid.svg">
                    </button>
                </div>




            </div>

            <div class="tr-trainees-content tr-view-table">
                <!-- طريقة العرض الجدول -->
                <div class="tr-trainees-table-container tr-table-view">
                    <table class="tr-trainees-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="masterCheckbox" class="tr-checkbox"></th>
                                <th>اسم المتدرب</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>التفاصيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="tr-checkbox trainee-checkbox"></td>
                                <td>
                                    <div class="tr-trainee-name">
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب"
                                            class="tr-trainee-avatar">
                                        <span>أحمد محمد</span>
                                    </div>
                                </td>
                                <td>ahmed@example.com</td>
                                <td>+966501234567</td>
                                <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="tr-checkbox trainee-checkbox"></td>
                                <td>
                                    <div class="tr-trainee-name">
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب"
                                            class="tr-trainee-avatar">
                                        <span>سارة عبدالله</span>
                                    </div>
                                </td>
                                <td>sara@example.com</td>
                                <td>+966502345678</td>
                                <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="tr-checkbox trainee-checkbox"></td>
                                <td>
                                    <div class="tr-trainee-name">
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب"
                                            class="tr-trainee-avatar">
                                        <span>خالد سعيد</span>
                                    </div>
                                </td>
                                <td>khaled@example.com</td>
                                <td>+966503456789</td>
                                <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- طريقة العرض الشبكة -->
                <div class="tr-grid-view">
                    <div class="tr-trainees-grid">
                        <div class="tr-trainee-card">
                            <input type="checkbox" class="tr-checkbox tr-trainee-card-checkbox trainee-checkbox">
                            <div class="tr-trainee-card-header">
                                <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar">
                                <span>أحمد محمد</span>
                            </div>
                            <div class="tr-trainee-card-body">
                                <div class="tr-trainee-card-field">
                                    <span class="tr-trainee-card-label">البريد الإلكتروني</span>
                                    <span class="tr-trainee-card-value">ahmed@example.com</span>
                                </div>
                                <div class="tr-trainee-card-field">
                                    <span class="tr-trainee-card-label">رقم الهاتف</span>
                                    <span class="tr-trainee-card-value">+966501234567</span>
                                </div>
                            </div>
                            <div class="tr-trainee-card-actions">
                                <button class="tr-details-btn">عرض التفاصيل</button>
                            </div>
                        </div>

                        <div class="tr-trainee-card">
                            <input type="checkbox" class="tr-checkbox tr-trainee-card-checkbox trainee-checkbox">
                            <div class="tr-trainee-card-header">
                                <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar">
                                <span>سارة عبدالله</span>
                            </div>
                            <div class="tr-trainee-card-body">
                                <div class="tr-trainee-card-field">
                                    <span class="tr-trainee-card-label">البريد الإلكتروني</span>
                                    <span class="tr-trainee-card-value">sara@example.com</span>
                                </div>
                                <div class="tr-trainee-card-field">
                                    <span class="tr-trainee-card-label">رقم الهاتف</span>
                                    <span class="tr-trainee-card-value">+966502345678</span>
                                </div>
                            </div>
                            <div class="tr-trainee-card-actions">
                                <button class="tr-details-btn">عرض التفاصيل</button>
                            </div>
                        </div>

                        <div class="tr-trainee-card">
                            <input type="checkbox" class="tr-checkbox tr-trainee-card-checkbox trainee-checkbox">
                            <div class="tr-trainee-card-header">
                                <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar">
                                <span>خالد سعيد</span>
                            </div>
                            <div class="tr-trainee-card-body">
                                <div class="tr-trainee-card-field">
                                    <span class="tr-trainee-card-label">البريد الإلكتروني</span>
                                    <span class="tr-trainee-card-value">khaled@example.com</span>
                                </div>
                                <div class="tr-trainee-card-field">
                                    <span class="tr-trainee-card-label">رقم الهاتف</span>
                                    <span class="tr-trainee-card-value">+966503456789</span>
                                </div>
                            </div>
                            <div class="tr-trainee-card-actions">
                                <button class="tr-details-btn">عرض التفاصيل</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تبديل طريقة العرض
            const tableViewBtn = document.getElementById('tableViewBtn');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const traineesContent = document.querySelector('.tr-trainees-content');

            tableViewBtn.addEventListener('click', function() {
                this.classList.add('active');
                gridViewBtn.classList.remove('active');
                traineesContent.classList.remove('tr-view-grid');
                traineesContent.classList.add('tr-view-table');
            });

            gridViewBtn.addEventListener('click', function() {
                this.classList.add('active');
                tableViewBtn.classList.remove('active');
                traineesContent.classList.remove('tr-view-table');
                traineesContent.classList.add('tr-view-grid');
            });

            // تحديد الكل
            const masterCheckbox = document.getElementById('masterCheckbox');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const traineeCheckboxes = document.querySelectorAll('.trainee-checkbox');

            masterCheckbox.addEventListener('change', function() {
                traineeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            selectAllBtn.addEventListener('click', function() {
                const allChecked = Array.from(traineeCheckboxes).every(cb => cb.checked);
                traineeCheckboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });
                masterCheckbox.checked = !allChecked;
            });

            // تحديد كحضور
            const markPresentBtn = document.getElementById('markPresentBtn');
            markPresentBtn.addEventListener('click', function() {
                const selectedTrainees = Array.from(traineeCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => {
                        const row = cb.closest('tr') || cb.closest('.tr-trainee-card');
                        return row.querySelector('.tr-trainee-name span').textContent;
                    });

                if (selectedTrainees.length === 0) {
                    alert('الرجاء تحديد متدرب واحد على الأقل');
                    return;
                }

                alert('تم تحديد الحضور للمتدربين: ' + selectedTrainees.join(', '));
                // هنا يمكنك إضافة الكود لإرسال البيانات إلى الخادم
            });
        });
    </script>



@endsection

@section('scripts')

@endsection
