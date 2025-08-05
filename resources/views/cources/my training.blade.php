@extends('frontend.layouts.master')

@section('title', 'تدريباتي')

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
                    الرئيسية / إدارة التدريبات
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <!-- تبويبات  -->
        <div class="text-center mb-3">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="announced-tab" data-bs-toggle="tab"
                            data-bs-target="#announced" type="button" role="tab">التدريبات المعلنة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="under-construction-tab" data-bs-toggle="tab"
                            data-bs-target="#under-construction" type="button" role="tab">تدريبات قيد
                            الإنشاء</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ongoing-tab" data-bs-toggle="tab" data-bs-target="#ongoing"
                            type="button" role="tab">التدريبات الجارية</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
                            type="button" role="tab">التدريبات المكتملة</button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- محتوى التبويبات -->
        <div class="tab-content" id="myTabContent">
            <!-- تبويب التدريبات المعلنة -->
            <div class="tab-pane fade show active mb-4" id="announced" role="tabpanel">
                <div class="row">
                    @for ($i = 0; $i < 4; $i++)
                        <!-- كارت 1 -->
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card p-3">
                                <img src="{{ asset('images/cources/sample-course.jpg') }}" class="card-img-top"
                                    alt="صورة التدريب">
                                <div class="card-body">
                                    <h5 class="card-title">تدريب إحراك تصميم العروض التقليدية</h5>
                                    <div class="stats">
                                        <div class="stat-item">
                                            <img class="ps-2" src="{{ asset('images/cources/member-admin.svg') }}">

                                            <span>20 متقدم</span>
                                        </div>
                                        <div class="stat-item">

                                            <img class="ps-2" src="{{ asset('images/cources/clock-admin.svg') }}">

                                            <span>12 ساعة</span>
                                        </div>
                                        <div class="stat-item">
                                            <img class="ps-2" src="{{ asset('images/cources/views.svg') }}">
                                            <span>45 مشاهدة</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class=" d-flex gap-2">
                                        <div class="edit-btn">
                                            <a href="#" class="" title="تعديل">
                                                <!-- أيقونة التعديل -->
                                                <img class="" src="{{ asset('images/cources/edit.svg') }}">

                                            </a>
                                        </div>
                                        <div class="stop-btn">
                                            {{-- data-bs-target="#deleteTrainingModal-{{ $training->id }}" --}}
                                            <a href="#" class="pb-1" title="إيقاف الإعلان"
                                                data-bs-toggle="modal" data-bs-toggle="modal"
                                                data-bs-target="#stopAdModal">
                                                <img class="" src="{{ asset('images/cources/stop.svg') }}">
                                            </a>
                                        </div>

                                    </div>

                                    <button class="btn btn-register">
                                        <img class="" src="{{ asset('images/cources/register-icon.svg') }}">

                                        قائمة المسجلين</button>
                                </div>
                            </div>
                        </div>
                    @endfor

                </div>
            </div>

            <!-- تبويب تدريبات قيد الإنشاء -->
            <div class="tab-pane fade mb-4" id="under-construction" role="tabpanel">
                <div class="row">

                    @for ($i = 0; $i < 4; $i++)
                        <!-- كارت 1 -->
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card p-3">
                                <img src="{{ asset('images/cources/sample-course.jpg') }}" class="card-img-top"
                                    alt="صورة التدريب">

                                <div class="card-body">
                                    <h5 class="card-title">تدريب إحراك تصميم العروض التقليدية</h5>

                                    <!-- شريط التقدم -->
                                    <div class="progress-container my-3 mt-5"
                                        data-progress="{{ $training->progress ?? 60 }}">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                        <div class="progress-label"></div>
                                    </div>

                                </div>

                                <div class="card-footer gap-2">
                                    <div class="d-flex ">
                                        <div class="stop-btn">
                                            <a href="#" class="pb-1" title="إيقاف الإعلان"
                                                data-bs-toggle="modal" data-bs-target="#deleteTrainingModal">
                                                <img src="{{ asset('images/cources/delete.svg') }}">
                                            </a>
                                        </div>
                                    </div>
                                    <button class="custom-btn">
                                        إكمال معلومات التدريب
                                        <img src="{{ asset('images/cources/arrow-left.svg') }}">
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endfor

                </div>
            </div>

            <!-- تبويب التدريبات الجارية -->
            <div class="tab-pane fade mb-4" id="ongoing" role="tabpanel">
                <div class="row">

                    @for ($i = 0; $i < 4; $i++)
                        <!-- كارت 1 -->
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card p-3">
                                <img src="{{ asset('images/cources/sample-course.jpg') }}" class="card-img-top"
                                    alt="صورة التدريب">
                                <div class="card-body">
                                    <h5 class="card-title">تدريب إحراك تصميم العروض التقليدية</h5>
                                    <div class="stats">
                                        <div class="stat-item">
                                            <img class="ps-2" src="{{ asset('images/cources/member-admin.svg') }}">

                                            <span>20 متقدم</span>
                                        </div>
                                        <div class="stat-item">

                                            <img class="ps-2" src="{{ asset('images/cources/clock-admin.svg') }}">

                                            <span>12 ساعة</span>
                                        </div>
                                        <div class="stat-item">
                                            <img class="ps-2" src="{{ asset('images/cources/views.svg') }}">
                                            <span>45 مشاهدة</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                  

                                        <button class="btn btn-register w-100">
                                            <img class=""
                                                src="{{ asset('images/cources/members.svg') }}">
                                            المتدربين المنضمين
                                          </button>
                                  
                                </div>
                            </div>
                            </div>
                    @endfor

                </div>
            </div>

            <!-- تبويب التدريبات المكتملة -->
            <div class="tab-pane fade mb-4" id="completed" role="tabpanel">
                <div class="row">
      @for ($i = 0; $i < 4; $i++)
                        <!-- كارت 1 -->
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card p-3">
                                <img src="{{ asset('images/cources/sample-course.jpg') }}" class="card-img-top"
                                    alt="صورة التدريب">
                                <div class="card-body">
                                    <h5 class="card-title">تدريب إحراك تصميم العروض التقليدية</h5>
                                    <div class="stats">
                                        <div class="stat-item">
                                            <img class="ps-2" src="{{ asset('images/cources/member-admin.svg') }}">

                                            <span>20 متقدم</span>
                                        </div>
                                        <div class="stat-item">

                                            <img class="ps-2" src="{{ asset('images/cources/clock-admin.svg') }}">

                                            <span>12 ساعة</span>
                                        </div>
                                        <div class="stat-item">
                                            <img class="ps-2" src="{{ asset('images/cources/views.svg') }}">
                                            <span>45 مشاهدة</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                  

                                        <button class="btn btn-register w-100">
                                            <img class=""
                                                src="{{ asset('images/cources/members.svg') }}">
                                            المتدربين المنضمين
                                          </button>
                                  
                                </div>
                            </div>
                            </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>


    <!-- مودال إيقاف الإعلان -->
    <div class="modal fade" id="stopAdModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/cources/pause-training.svg') }}" class="img-fluid">
                    </div>
                    <h4 class="modal-title text-center mb-3 fw-bold custom-style">
                        إيقاف الإعلان عن التدريب
                    </h4>
                    <p class="text-center text-muted">
                        هل أنت متأكد من إيقاف الإعلان عن التدريب؟<br>
                        بعد الإيقاف، لن يظهر التدريب للمستخدمين، ولن يتمكن أحد من التسجيل، لكن ستظل البيانات محفوظة.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center flex-row-reverse w-100 d-flex">
                    <!-- زر الإلغاء -->
                    <button type="button" class="btn-cancel mx-2 flex-fill" data-bs-dismiss="modal">
                        إلغاء
                    </button>

                    <!-- زر الإيقاف (نموذج Laravel) -->
                    <form id="stopAdForm" method="POST" class="d-inline-flex flex-fill">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="custom-btn btn-warning mx-2 w-100">
                            نعم، أوقف الإعلان
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال الحذف -->
    <div class="modal fade" id="deleteTrainingModal" tabindex="-1" aria-labelledby="deleteTrainingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 justify-content-end">

                    <button type="button" class="btn-close align-self-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/cources/delete-img.svg') }}" class="img-fluid">
                    </div>
                    <h4 class="modal-title text-center mb-3 fw-bold custom-style" id="deleteTrainingModalLabel">
                        حذف التدريب
                    </h4>

                    <p class="text-center text-muted">
                        هل أنت متأكد من رغبتك في حذف هذا التدريب؟
                        <br>
                        لم يتم نشر هذا التدريب بعد، وسيتم حذف جميع البيانات المدخلة نهائياً ولن تتمكن من استعادتها
                        لاحقاً.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center flex-row-reverse w-100 d-flex">
                    <!-- زر الإلغاء -->
                    <button type="button" class="btn-cancel mx-2 flex-fill" data-bs-dismiss="modal">
                        إلغاء
                    </button>

                    <!-- زر الحذف (نموذج Laravel) -->
                    <form action="" method="POST" class="d-inline-flex flex-fill">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="custom-btn mx-2 w-100">
                            احذف التدريب
                        </button>
                    </form>
                </div>


            </div>
        </div>
    </div>

@endsection


{{-- تضمين ملفات حافا سكريبت جديدة JS --}}
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.progress-container').forEach(container => {
            let progress = container.getAttribute('data-progress');
            let bar = container.querySelector('.progress-bar');
            let label = container.querySelector('.progress-label');

            // تعبئة الشريط
            bar.style.width = progress + "%";

            // كتابة النسبة داخل البالون
            label.textContent = progress + "%";

            // التحقق إذا كان اتجاه الصفحة RTL أو LTR
            if (document.dir === "rtl") {
                label.style.right = progress + "%"; // يحسب من اليمين
            } else {
                label.style.left = progress + "%"; // يحسب من اليسار
            }
        });
    </script>
@endsection
