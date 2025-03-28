@extends('layouts.admin')
@section('app-main')
    <main class="app-main" style="overflow-y: scroll">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-md-2 col-sm-12">
                        <h3 class="mb-2">قائمة الحصص</h3>
                    </div>
                    <div class="col-md-2 col-sm-12 ">
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <input type="text" class="form-control w-100" placeholder="إبحث بإسم الطالب">
                    </div>
                    <div class="col-md-1 col-sm-12 ">
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <div class="d-flex ml-3 justify-content-center justify-content-md-end ">
                            <button class="btn btn-success" style="margin-left:5px"
                                onclick="location.href='/lesson/create'">إضافة حصة جديدة</button>
                            <button class="btn btn-primary" style="margin-left:15px">إضافة طالب جديد</button>
                        </div>
                    </div>

                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        @if ($errors)
            <div style="color: red;">
                <ul>
                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!--begin::App Content-->
        <div class="app-content" style="overflow-y: auto; height: min-content; max-height:100vh;">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="row text-center m-1">
                                    @if (!empty($lessons))
                                        @foreach ($lessons as $lesson)
                                            <div class="col-md-4 col-lg-2  col-sm-2 p-0">
                                                <div class="card h-60 m-1 alert alert-info card-hover">
                                                    <a href="/lesson/show/{{ $lesson->id }}" class="card-body "
                                                        style="text-decoration:none">
                                                        <small class="text-muted"
                                                            style="position: absolute;right:5px;top:3px;">
                                                            {{ $lesson->arabicDateTranslator($lesson->started_at) }}

                                                        </small>
                                                        <small class="text-muted"
                                                            style="position: absolute;left:5px;top:3px;">الساعة :
                                                            {{ date('h:s', strtotime($lesson->started_at)) }}

                                                        </small>
                                                        <div class="fw-bold mb-1 h1">{{ $lesson->topic }}</div>
                                                        <small class="text-muted">
                                                            @foreach ($lesson->classrooms as $classroom)
                                                                {{ $classroom->name }}
                                                            @endforeach
                                                        </small>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{ $lessons->links() }}
                                    @else
                                        <tr>
                                            <h1 class="alert alert-info">يرجى إضافة طلبة للبدء</h1>
                                        </tr>
                                    @endif
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
