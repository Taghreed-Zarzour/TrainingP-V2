<style>
    /* كلاسات معزولة ببادئة خاصة */


    .tr-sessions-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 10px;
        margin-bottom: 20px;
    }

    .tr-sessions-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {
        .tr-sessions-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .tr-sessions-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .tr-sessions-add-btn {
        background-color: #3498db;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    /* تصميم الجدول للشاشات الكبيرة */
    .tr-sessions-table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .tr-sessions-table {
        width: 100%;

        border-radius: 8px;
        overflow: hidden;

    }

    .tr-sessions-table thead th {
        background-color: #DAE3FF;
        color: #003090;
        font-weight: 400;
        padding: 12px 15px;
        text-align: right;
    }

    .tr-sessions-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f1;
    }

    .tr-sessions-table tbody tr:last-child td {
        border-bottom: none;
    }

    .tr-session-title {
        font-weight:500;
        color: #232323;
    }

    /* إخفاء عمود الأرقام على الشاشات الكبيرة */
    .tr-session-number-col {
        display: none;
    }

    .tr-status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        text-align: center;
        min-width: 90px;
    }

    .tr-status-completed {
        background-color: #AFEDCC;
        color: #00AF6C;
    }

    .tr-status-in-progress {
        background-color: #FFC62A45;
        color: #FFC62A;

    }

    .tr-status-not-started {
        background-color: #D6D6D6;
        color: white;

    }

    .tr-attendees-btn {
        padding: 10px 20px;
        border-radius: 50px;
        text-align: center;
        cursor: pointer;
        border: 1px solid #003090;
        color: #003090;
        background-color: white;
        transition: background-color 0.3s ease;
    }

    .tr-attendees-btn:hover {
        background-color: #e4e4e4;
    }
.tr-attendees-btn:disabled {
    color: #c0c0c0; /* لون الخط فضي */
    border: 1px solid #D6D6D6; /* لون البوردر فضي */ /* لون الخلفية يبقى كما هو أو يمكن تغييره */
    cursor: not-allowed; /* تغيير شكل المؤشر إلى علامة عدم السماح */
  }
    .tr-action-buttons {
        display: flex;
        background-color: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
        border: 1px solid #B6BDD5;
    }

    .tr-action-btn {
        border: none;
        background: none;
        padding: 6px 10px;
        transition: all 0.2s;
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .tr-action-btn:not(:last-child) {
        border-left: 1px solid #B6BDD5;
    }

    .tr-action-edit {
        color: #2980b9;
    }

    .tr-action-edit:hover {
        background-color: rgba(41, 128, 185, 0.1);
    }

    .tr-action-delete {
        color: #e74c3c;
    }

    .tr-action-delete:hover {
        background-color: rgba(231, 76, 60, 0.1);
    }

    /* تصميم الجدول للجوال - تحويل إلى بطاقات */
    @media (max-width: 767px) {
        .tr-sessions-table {
            min-width: 100%;
            border: none;
        }

        .tr-sessions-table thead {
            display: none;
        }

        .tr-sessions-table tbody,
        .tr-sessions-table tr,
        .tr-sessions-table td {
            display: block;
            width: 100%;
            text-align: right;
        }

        .tr-sessions-table tr {
            position: relative;
            background: #fff;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 12px 12px 40px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* رقم الجلسة على الجوال */
        .tr-sessions-table tr::before {
            content: attr(data-session-number);
            position: absolute;
            left: 10px;
            top: 15px;
            font-weight: 700;
            color: #2980b9;
            background-color: #f0f7ff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d0e3ff;
        }

        .tr-sessions-table td {
            padding: 5px 0px !important;
            position: relative;
            font-size: 0.95rem;
            border: none;
            border-bottom: 1px solid #f5f5f5;
        }

        .tr-sessions-table td:last-child {
            border-bottom: none;
        }

        .tr-sessions-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 4px;
            font-size: 0.85rem;
        }

        .tr-status-badge {
            min-width: 80px;
            padding: 5px 10px;
        }

        .tr-action-btn {
            padding: 6px 8px;
            border-radius: 4px;
            margin: 2px;
            background-color: #f8f9fa;
        }

        /* إخفاء عمود الأرقام على الجوال (تم استبداله بالرقم في الزاوية) */
        .tr-session-number-col {
            display: none;
        }
    }
</style>

<div class="tr-sessions-container">
    <div class="tr-sessions-card">
        <div class="tr-sessions-header">
            <h1 class="tr-sessions-title">الجلسات التدريبية</h1>
            <button class="custom-btn"  data-bs-toggle="modal"
                                              data-bs-target="#addSessionModal">
              <img src="/images/cources/plus.svg">
              إضافة جلسة جديدة
            </button>
        </div>

        <div class="tr-sessions-table-container">
            <table class="tr-sessions-table">
                <thead>
                    <tr>

                        <th>عنوان الجلسة</th>
                        <th>التاريخ</th>
                        <th>التوقيت</th>
                        <th>الحضور</th>
                        <th>الحالة</th>
                        <th>المتدربون</th>
                        <th>تفاعل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-session-number="1">

                        <td class="tr-session-title" data-label="عنوان الجلسة">مقدمة عامة</td>
                        <td data-label="التاريخ">10/7/2025</td>
                        <td data-label="التوقيت">11:00 - 12:00</td>
                        <td data-label="الحضور">30</td>
                        <td data-label="الحالة"><span class="tr-status-badge tr-status-completed">مكتمل</span></td>
                        <td data-label="المتدربون"><button class="tr-attendees-btn">عرض الحضور</button></td>
                        <td data-label="تفاعل">
                            <div class="tr-action-buttons">
                                <button class="tr-action-btn tr-action-delete"><img
                                        src="/images/cources/trash.svg"></button>

                                <button class="tr-action-btn tr-action-edit"  data-bs-toggle="modal"
                                              data-bs-target="#editSessionModal">
                                  <img src="/images/cources/edit-session.svg">
                                      </button>
                            </div>
                        </td>
                    </tr>
                    <tr data-session-number="2">

                        <td class="tr-session-title" data-label="عنوان الجلسة">دراسة شخصية المستخدم</td>
                        <td data-label="التاريخ">10/8/2025</td>
                        <td data-label="التوقيت">11:00 - 12:00</td>
                        <td data-label="الحضور">30</td>
                        <td data-label="الحالة"><span class="tr-status-badge tr-status-in-progress">قيد التقدم</span>
                        </td>
                        <td data-label="المتدربون"><button class="tr-attendees-btn">تحديد الحضور</button></td>
                        <td data-label="تفاعل">
                            <div class="tr-action-buttons">
                                <button class="tr-action-btn tr-action-delete">
                                  <img
                                        src="/images/cources/trash.svg"></button>

                                <button class="tr-action-btn tr-action-edit"  data-bs-toggle="modal"
                                              data-bs-target="#editSessionModal">
                                  <img src="/images/cources/edit-session.svg">
                                      </button>
                            </div>
                        </td>
                    </tr>
                    <tr data-session-number="3">

                        <td class="tr-session-title" data-label="عنوان الجلسة">تحليل سلوك المستخدم</td>
                        <td data-label="التاريخ">10/9/2025</td>
                        <td data-label="التوقيت">12:00 - 13:00</td>
                        <td data-label="الحضور">30</td>
                        <td data-label="الحالة"><span class="tr-status-badge tr-status-not-started">لم تبدأ</span></td>
                        <td data-label="المتدربون"><button class="tr-attendees-btn " disabled>تحديد الحضور</button></td>
                        <td data-label="تفاعل">
                            <div class="tr-action-buttons">
                                <button class="tr-action-btn tr-action-delete"><img
                                        src="/images/cources/trash.svg"></button>

                              <button class="tr-action-btn tr-action-edit"  data-bs-toggle="modal"
                                              data-bs-target="#editSessionModal">
                                  <img src="/images/cources/edit-session.svg">
                                      </button>
                            </div>
                        </td>
                    </tr>
                    <tr data-session-number="4">

                        <td class="tr-session-title" data-label="عنوان الجلسة">تقييم تجربة المستخدم</td>
                        <td data-label="التاريخ">10/10/2025</td>
                        <td data-label="التوقيت">1:00 - 2:00</td>
                        <td data-label="الحضور">30</td>
                        <td data-label="الحالة"><span class="tr-status-badge tr-status-not-started">لم تبدأ</span></td>
                        <td data-label="المتدربون"><button class="tr-attendees-btn " disabled>تحديد الحضور</button></td>
                        <td data-label="تفاعل">
                            <div class="tr-action-buttons">
                                <button class="tr-action-btn tr-action-delete"><img
                                        src="/images/cources/trash.svg"></button>

                          <button class="tr-action-btn tr-action-edit"  data-bs-toggle="modal"
                                              data-bs-target="#editSessionModal">
                                  <img src="/images/cources/edit-session.svg">
                                      </button>
                            </div>
                        </td>
                    </tr>
                    <tr data-session-number="5">

                        <td class="tr-session-title" data-label="عنوان الجلسة">تحديد احتياجات العمل</td>
                        <td data-label="التاريخ">10/11/2025</td>
                        <td data-label="التوقيت">2:00 - 1:00</td>
                        <td data-label="الحضور">30</td>
                        <td data-label="الحالة"><span class="tr-status-badge tr-status-not-started">لم تبدأ</span></td>
                        <td data-label="المتدربون"><button class="tr-attendees-btn " disabled>تحديد الحضور</button></td>
                        <td data-label="تفاعل">
                            <div class="tr-action-buttons">
                                <button class="tr-action-btn tr-action-delete"><img
                                        src="/images/cources/trash.svg"></button>

                      <button class="tr-action-btn tr-action-edit"  data-bs-toggle="modal"
                                              data-bs-target="#editSessionModal">
                                  <img src="/images/cources/edit-session.svg">
                                      </button>
                            </div>
                        </td>
                    </tr>
                    <tr data-session-number="6">

                        <td class="tr-session-title" data-label="عنوان الجلسة">تحسين واجهة المستخدم</td>
                        <td data-label="التاريخ">10/12/2025</td>
                        <td data-label="التوقيت">11:00 - 12:00</td>
                        <td data-label="الحضور">30</td>
                        <td data-label="الحالة"><span class="tr-status-badge tr-status-not-started">لم تبدأ</span>
                        </td>
                        <td data-label="المتدربون"><button class="tr-attendees-btn " disabled>تحديد الحضور</button></td>
                        <td data-label="تفاعل">
                            <div class="tr-action-buttons">
                                <button class="tr-action-btn tr-action-delete"><img
                                        src="/images/cources/trash.svg"></button>

                                <button class="tr-action-btn tr-action-edit"  data-bs-toggle="modal"
                                              data-bs-target="#editSessionModal">
                                  <img src="/images/cources/edit-session.svg">
                                      </button>
                            </div>
                        </td>
                    </tr>
                    <tr data-session-number="7">

                        <td class="tr-session-title" data-label="عنوان الجلسة">اختبار قابلية الاستخدام</td>
                        <td data-label="التاريخ">10/13/2025</td>
                        <td data-label="التوقيت">-</td>
                        <td data-label="الحضور">-</td>
                        <td data-label="الحالة"><span class="tr-status-badge tr-status-not-started">لم تبدأ</span>
                        </td>
                        <td data-label="المتدربون"><button class="tr-attendees-btn " disabled>تحديد الحضور</button></td>
                        <td data-label="تفاعل">
                            <div class="tr-action-buttons">
                                <button class="tr-action-btn tr-action-delete"><img
                                        src="/images/cources/trash.svg"></button>

                            <button class="tr-action-btn tr-action-edit"  data-bs-toggle="modal"
                                              data-bs-target="#editSessionModal">
                                  <img src="/images/cources/edit-session.svg">
                                      </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- مودال تعديل الجلسة -->
<div class="modal fade" id="editSessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content px-3 py-3">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="editSessionForm" class="p-0" method="POST">
                    @csrf
                    @method('PUT')
                    

                    
                    <!-- تاريخ ومواعيد الجلسة -->
                    <div class="input-group mb-4">
                        <div class="d-flex flex-column-reverse">
                            <label class="w-100">تاريخ الجلسة ومدتها <span class="required">*</span></label>
                        </div>
                        <div class="sub-label mb-2">
                            اختر التاريخ الذي ستعقد فيه الجلسة ومدة كل جلسة بالدقائق.
                        </div>

                        <div class="row g-3">
                            <!-- حقل التاريخ -->
                            <div class="col-md-4">
                                <input type="date" name="session_date" class="form-control" placeholder="مثال: 15 يونيو 2025" required>
                            </div>

                            <!-- حقل وقت البداية -->
                            <div class="col-md-4">
                                <input type="time" name="start_time" class="form-control" required>
                            </div>

                            <!-- حقل وقت النهاية -->
                            <div class="col-md-4">
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-0">
                <!-- زر الحفظ بكامل عرض المودال -->
                <button type="submit" form="editSessionForm" class="custom-btn w-100 py-2">
                    حفظ التعديلات
                                        <img src="{{ asset('images/cources/arrow-left.svg') }}">

                </button>
            </div>
        </div>
    </div>
</div>



<!-- مودال إضافة جلسة جديدة -->
<div class="modal fade" id="addSessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg ">
        <div class="modal-content px-3 py-3">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="addSessionForm" class="p-0" method="POST">
                    @csrf
                    <div class="session-fields-container">
                        <!-- الجلسة الأولى -->
                        <div class="session-group" style="position: relative; margin-top: 20px;">
                            
                            <div class="input-group">
                                <div class="d-flex flex-column-reverse">
                                    <label class="w-100">تاريخ الجلسة و مدتها<span class="required">*</span></label>
                                </div>
                                <div class="sub-label">
                                    اختر التاريخ الذي ستُعقد فيه الجلسة ووقتي بدء وانتهاء الجلسة.
                                </div>

                                <div class="input-group-2col inner mb-3" style="align-items: flex-start;">
                                    <div style="width: 100%;">
                                        <input type="date" name="schedules[0][session_date]" placeholder="مثال: 15 يونيو 2025" required>
                                    </div>

                                    <div style="width: 100%;">
                                        <input type="time" name="schedules[0][start_time]" required>
                                    </div>

                                    <div style="width: 100%;">
                                        <input type="time" name="schedules[0][end_time]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mt-3">
                        <button type="button" class="add-more-btn" id="add-session-btn">
                            <img src="{{ asset('images/icons/plus-main.svg') }}" />
                            <span>أضف جلسة جديدة</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center flex-row-reverse w-100 d-flex">
                <button type="button" class="btn-cancel mx-2 flex-fill" data-bs-dismiss="modal">
                    إلغاء
                </button>
                <button type="submit" form="addSessionForm" class="custom-btn btn-warning mx-2 flex-fill">
                    حفظ و متابعة
                    <img src="{{ asset('images/cources/arrow-left.svg') }}">
                </button>
            </div>
        </div>
    </div>
</div>

<script>
//تكرار التاريخ والوقت
document.addEventListener('DOMContentLoaded', function () {
    let sessionIndex = 1;

    document.getElementById('add-session-btn').addEventListener('click', function () {
        const container = document.querySelector('.session-fields-container');
        const newSession = document.createElement('div');

        newSession.className = 'session-group';
        newSession.style.position = 'relative';
        newSession.style.marginTop = '20px';

        newSession.innerHTML = `
                
            
            <div class="input-group">
                <div class="d-flex flex-column-reverse">
                    <label class="w-100">تاريخ الجلسة و مدتها<span class="required">*</span></label>
                </div>
                <div class="sub-label">
                    اختر التاريخ الذي ستُعقد فيه الجلسة ووقتي بدء وانتهاء الجلسة.
                </div>

                <div class="input-group-2col inner mb-3" style="align-items: flex-start;">
                    <div style="width: 100%;">
                        <input type="date" name="schedules[${sessionIndex}][session_date]" placeholder="مثال: 15 يونيو 2025" required>
                    </div>

                    <div style="width: 100%;">
                        <input type="time" name="schedules[${sessionIndex}][start_time]" required>
                    </div>

                    <div style="width: 100%;">
                        <input type="time" name="schedules[${sessionIndex}][end_time]" required>
                    </div>
                </div>
            </div>

            <button type="button" class="remove-session-btn" 
                    style="position: absolute; left: -6px; top: -3px; background: none; border: none; cursor: pointer;"
                    onclick="this.closest('.session-group').remove()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                    <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                </svg>
            </button>
        `;

        container.appendChild(newSession);
        sessionIndex++;
    });
});
</script>