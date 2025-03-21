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
                        <h3 class="mb-2">قائمة المجموعات</h3>
                    </div>
                    <div class="col-md-2 col-sm-12 ">
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <input type="text" class="form-control w-100" placeholder="إبحث بإسم المجموعة">
                    </div>
                    <div class="col-md-1 col-sm-12 ">
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <div class="d-flex ml-3 justify-content-center justify-content-md-end ">
                            <button class="btn btn-success" style="margin-left:5px"
                                onclick="location.href='/class-room/create'"> غرفة صفية جديدة</button>
                            <button class="btn btn-primary" style="margin-left:15px"> غرفة صفية جديدة</button>
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
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="p-0">
                                <div class="row text-center m-1">
                                    @if (!empty($classrooms))
                                        @foreach ($classrooms as $classroom)
                                            <div class="p-1">
                                                <div class="card-header">
                                                    <h3 class="card-title">Bordered Table</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="">
                                                    <table class="table table-bordered w-100">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th style="width: 32%"> الغرفة الصفية</th>
                                                                <th style="width: 30%">الإنجاز</th>
                                                                <th style="width: 40px">Label</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr class="align-middle">
                                                                <td>4.</td>
                                                                <td> {{ $classroom->name .= $classroom->nick_name ? '-' . $classroom->nick_name : '' }}
                                                                </td>
                                                                <td>
                                                                    <div class="progress progress-xs progress-striped "
                                                                        style="width:85% ;">
                                                                        <div class="progress-bar text-bg-success"
                                                                            style="width: 90%"></div>

                                                                    </div>
                                                                    <span class="badge text-bg-success">90%</span>

                                                                </td>

                                                                <td>
                                                                    <div class="d-flex">

                                                                    <button class="btn btn-sm btn-info text-light"
                                                                        onclick="location.href='/class-room/{{ $classroom->id }}'">
                                                                        <i class="bi bi-eye" style="font-size:1rem"></i>
                                                                    </button>

                                                                    <button class="btn btn-sm btn-info text-light"
                                                                        onclick="location.href='/class-room/{{ $classroom->id }}'">
                                                                        <i class="bi bi-eye" style="font-size:1rem"></i>
                                                                    </button>
                                                                </div>

                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer clearfix">
                                                    <ul class="pagination pagination-sm m-0 float-end">
                                                        <li class="page-item"><a class="page-link"
                                                                href="#">&laquo;</a></li>
                                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                        <li class="page-item"><a class="page-link"
                                                                href="#">&raquo;</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <hr class="d-md-none">
                                        @endforeach

                                        <!-- /.users-list -->

                                        {{-- to fix  view on mobile screen dont remove below empty divs  --}}
                                        <div class="col-md-2 col-sm-4 p-2"
                                            style="visibility: hidden;height:20vh;width:20vh ">
                                        </div>
                                        <div class="col-md-2 col-sm-4 p-2"
                                            style="visibility: hidden;height:20vh;width:20vh ">
                                        </div>
                                        <div class="col-md-2 col-sm-4 p-2"
                                            style="visibility: hidden;height:20vh;width:20vh ">
                                        </div>
                                    @else
                                        <div class="col-12 p-5">
                                            <h1 class="alert alert-info">يرجى إضافة غرفة صفية للبدء</h1>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-footer -->
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
