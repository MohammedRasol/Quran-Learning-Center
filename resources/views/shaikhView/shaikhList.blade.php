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
                        <h3 class="mb-2">قائمة المشايخ</h3>
                    </div>
                    <div class="col-md-2 col-sm-12 ">
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <input type="text" class="form-control w-100" placeholder="إبحث بإسم الشيخ">
                    </div>
                    <div class="col-md-1 col-sm-12 ">
                    </div>
                    <div class="col-md-3 col-sm-12 ">
                        <div class="d-flex ml-3 justify-content-center justify-content-md-end ">
                            <button class="btn btn-success" style="margin-left:5px"
                                onclick="location.href='/shaikh/create'">إضافة شيخ جديد</button>
                            <button class="btn btn-primary" style="margin-left:15px">إضافة شيخ جديد</button>
                        </div>
                    </div>
                    {{-- <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-start">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">قائمة المشايخ</li>
                        </ol>
                    </div> --}}
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
                            <div class="card-body p-0">
                                <div class="row text-center m-1">
                                    @if (!empty($shaikhs))
                                        @foreach ($shaikhs as $shaikh)
                                            <div class="col-md-2 col-sm-4 p-2">
                                                <img class="img-fluid rounded-circle" style="height:20vh;width:20vh "
                                                    src="{{ $shaikh->image ? asset('storage/' . $shaikh->image) : asset('adminlte/dist/assets/img/avatar.png') }}"
                                                    onerror="this.src='{{ asset('adminlte/dist/assets/img/avatar.png') }}'"
                                                    alt="User Image" />

                                                <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                    href="#">
                                                    {{ $shaikh->name . ' ' . $shaikh->family_name }}
                                                </a>
                                            </div>
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
                                            <h1 class="alert alert-info">يرجى إضافة شيوخ للبدء</h1>
                                      </div>
                                    @endif

                                </div>


                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer text-center">
                    <a
                      href="javascript:"
                      class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                      >View All Users</a
                    >
                  </div> --}}
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
