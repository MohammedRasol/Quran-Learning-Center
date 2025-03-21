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
                        <h3 class="mb-2">قائمة الطلاب</h3>
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
                                onclick="location.href='/student/create'">إضافة طالب جديد</button>
                            <button class="btn btn-primary" style="margin-left:15px">إضافة طالب جديد</button>
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
                            <div class="card-header">
                                <div class="card-title">Accordion</div>
                            </div>

                            @if (!empty($students))
                                @foreach ($students as $student)
                                    <div class="card-body">
                                        <div class="accordion" id="id-{{ $student->id }}">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#student-{{ $student->id }}" aria-expanded="true"
                                                        aria-controls="student-{{ $student->id }}">
                                                        {{ $student->name . ' ' . $student->name . ' ' . $student->family_name }}
                                                    </button>
                                                </h2>
                                                <div id="student-{{ $student->id }}" class="accordion-collapse collapse "
                                                    data-bs-parent="#id-{{ $student->id }}">
                                                    <div class="accordion-body">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Task</th>
                                                                    <th>Progress</th>
                                                                    <th style="width: 40px">Label</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="align-middle">
                                                                    <td>1.</td>
                                                                    <td>Update software</td>
                                                                    <td>
                                                                        <div class="progress progress-xs">
                                                                            <div class="progress-bar progress-bar-danger"
                                                                                style="width: 55%"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td><span class="badge text-bg-danger">55%</span></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td>2.</td>
                                                                    <td>Clean database</td>
                                                                    <td>
                                                                        <div class="progress progress-xs">
                                                                            <div class="progress-bar text-bg-warning"
                                                                                style="width: 70%"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td><span class="badge text-bg-warning">70%</span></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td>3.</td>
                                                                    <td>Cron job running</td>
                                                                    <td>
                                                                        <div
                                                                            class="progress progress-xs progress-striped active">
                                                                            <div class="progress-bar text-bg-primary"
                                                                                style="width: 30%"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td><span class="badge text-bg-primary">30%</span></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td>4.</td>
                                                                    <td>Fix and squish bugs</td>
                                                                    <td>
                                                                        <div
                                                                            class="progress progress-xs progress-striped active">
                                                                            <div class="progress-bar text-bg-success"
                                                                                style="width: 90%"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td><span class="badge text-bg-success">90%</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
