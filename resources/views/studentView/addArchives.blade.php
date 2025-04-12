@extends('layouts.admin')
@section('app-main')
 
    <style>
        
        .surah-width {
            width: 45%;
        }

        @media (min-width: 768px) {
            .surah-width {
                width: 15%;
            }
        }

        .calligraphy {
            padding: 10px;
            border-end-end-radius: 20px;
            border-end-start-radius: 20px;
            border-start-start-radius: 20px;
            border-start-end-radius: 20px;
            
            font-family: 'Amiri', serif; /* Replace with your font */
            font-size: 40px;
            color: whitesmoke;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Add depth */

        }
    </style>
    <main class="app-main" style="overflow-y: scroll">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <h3 class="mb-2">آرشيف الطالب : {{ $student->getFullName() }}</h3>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <input type="text" class="form-control w-100" placeholder="إبحث بإسم السورة">
                    </div>
                    <div class="col-md-1 col-sm-12 ">
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <div class="d-flex ml-3 justify-content-center justify-content-md-end ">
                            <button class="btn btn-success" style="margin-left:5px"
                                onclick="location.href='/student/{{ $student->id }}/archive/add'">إضافة سجل جديد</button>
                        </div>
                    </div>

                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content" style="overflow-y: auto; height: min-content; max-height:100vh;">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <!-- USERS LIST -->
                        <div class="card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <h3 align="center" class="p-3 calligraphy">
                                السور المسمعة
                            </h3>
                            <div class="row p-1">
                                @for ($i = 0; $i < 100; $i++)
                                    <div class="col-lg-2 col-6">
                                        <!-- small box -->
                                        <div class="small-box text-bg-success {{ getBootStrapRandoomColors(false,false) }}">
                                                <h3 class="calligraphy p-5 text-center">القرآن</h3>
                                        </div>
                                    </div>
                                @endfor
                                <!-- ./col -->
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
