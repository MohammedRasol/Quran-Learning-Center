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
                                onclick="location.href='/group/create'">إضافة مجموعة جديد</button>
                            <button class="btn btn-primary" style="margin-left:15px">إضافة مجموعة جديد</button>
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
                            <div class="card-body p-0 ">
                                <div class="row text-center m-1">
                                    @if (!empty($groups))
                                        @foreach ($groups as $group)
                                            <div class="col-md-2 col-sm-4 m-md-1 pt-2" style="background:#f1f1f1">
                                                <img class="img-fluid rounded-circle" style="height:20vh;width:20vh "
                                                    src="{{ $group->image ? asset('storage/' . $group->image) : asset('adminlte/dist/assets/img/group.png') }}"
                                                    onerror="this.src='{{ asset('adminlte/dist/assets/img/group.png') }}';this.onerror=null;"
                                                    alt="User Image" />

                                                <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                                                    href="#">
                                                    {{ $group->name . ' ' . $group->family_name }}
                                                </a>
                                                <div class=" mb-1 p-1 d-flex justify-content-evenly">
                                                    <button class="btn btn-info text-light"
                                                        onclick="location.href='/group/{{ $group->id }}'">
                                                        <i class="bi bi-eye" style="font-size:1rem"></i>
                                                    </button>
                                                    <button class="btn btn-primary ">
                                                        <i class="bi bi-journal-text" style="font-size:1rem"></i>
                                                    </button> <button class="btn btn-primary ">
                                                        <i class="bi bi-journal-text" style="font-size:1rem"></i>
                                                    </button> <button class="btn btn-primary ">
                                                        <i class="bi bi-journal-text" style="font-size:1rem"></i>
                                                    </button> <button class="btn btn-primary ">
                                                        <i class="bi bi-journal-text" style="font-size:1rem"></i>
                                                    </button>
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
                                            <h1 class="alert alert-info">يرجى إضافة مجموعة للبدء</h1>
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
