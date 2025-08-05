<style>
    /* كلاسات معزولة ببادئة خاصة */
    .tr-trainees-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 10px;
        margin-bottom: 20px;
    }

    .tr-trainees-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {
        .tr-trainees-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }


    /* تصميم الجدول للشاشات الكبيرة */
    .tr-trainees-table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .tr-trainees-table {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }

    .tr-trainees-table thead th {
        background-color: #DAE3FF;
        color: #003090;
        font-weight: 400;
        padding: 12px 15px;
        text-align: right;
    }

    .tr-trainees-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f1;
    }

    .tr-trainees-table tbody tr:last-child td {
        border-bottom: none;
    }

    .tr-trainee-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tr-trainee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .tr-details-btn {
        padding: 10px 20px;
        border-radius: 50px;
        text-align: center;
        cursor: pointer;
        border: 1px solid #003090;
        color: #003090;
        background-color: white;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .tr-details-btn:hover {
        background-color: #e4e4e4;
    }

    /* تصميم الجدول للجوال - تحويل إلى بطاقات */
    @media (max-width: 767px) {
        .tr-trainees-table {
            min-width: 100%;
            border: none;
        }

        .tr-trainees-table thead {
            display: none;
        }

        .tr-trainees-table tbody,
        .tr-trainees-table tr,
        .tr-trainees-table td {
            display: block;
            width: 100%;
            text-align: right;
        }

        .tr-trainees-table tr {
            position: relative;
            background: #fff;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 12px 12px 40px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

      
        .tr-trainees-table td {
            padding: 5px 0px !important;
            position: relative;
            font-size: 0.95rem;
            border: none;
            border-bottom: 1px solid #f5f5f5;
        }

        .tr-trainees-table td:last-child {
            border-bottom: none;
        }

        .tr-trainees-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 4px;
            font-size: 0.85rem;
        }

  
    }
</style>

<div class="tr-trainees-container">
    <div class="tr-trainees-card">


        <div class="tr-trainees-table-container">
            <table class="tr-trainees-table">
                <thead>
                    <tr>
                        <th>الرقم التسلسلي</th>
                        <th>اسم المتدرب</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الهاتف</th>
                        <th>نسبة الحضور</th>
                        <th>التفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="tr-trainee-name">
                          <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar" alt="صورة المتدرب">

                                <span>أحمد محمد</span>
                            </div>
                        </td>
                        <td>ahmed@example.com</td>
                        <td>+966501234567</td>
                        <td>85%</td>
                        <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <div class="tr-trainee-name">
                          <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar" alt="صورة المتدرب">
                                <span>سارة عبدالله</span>
                            </div>
                        </td>
                        <td>sara@example.com</td>
                        <td>+966502345678</td>
                        <td>92%</td>
                        <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <div class="tr-trainee-name">
                          <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar" alt="صورة المتدرب">
                                <span>خالد سعيد</span>
                            </div>
                        </td>
                        <td>khaled@example.com</td>
                        <td>+966503456789</td>
                        <td>78%</td>
                        <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <div class="tr-trainee-name">
                          <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar" alt="صورة المتدرب">
                                <span>نورة علي</span>
                            </div>
                        </td>
                        <td>nora@example.com</td>
                        <td>+966504567890</td>
                        <td>65%</td>
                        <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>
                            <div class="tr-trainee-name">
                          <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب" class="tr-trainee-avatar" alt="صورة المتدرب">
                                <span>محمد حسن</span>
                            </div>
                        </td>
                        <td>mohamed@example.com</td>
                        <td>+966505678901</td>
                        <td>95%</td>
                        <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>