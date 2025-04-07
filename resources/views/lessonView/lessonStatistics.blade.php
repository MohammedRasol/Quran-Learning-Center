@extends('layouts.admin')
@section('app-main')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">إحصائيات درس : <span class=" text-success">{{ $lessonData->topic }}</span></h3>
                    </div>

                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-mic-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">عدد المسمعين</span>
                                <span
                                    class="info-box-number">{{ count($lessonData->recitations) ."/". $lessonData->totalStudents ." النسبة ". count($lessonData->recitations)/$lessonData->totalStudents *100 . "%"}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                    <!-- fix for small devices only -->
                    <!-- <div class="clearfix hidden-md-up"></div> -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-success shadow-sm">
                                <i class="bi bi-cart-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">تقييم أداء التسميع</span>
                                <span class="info-box-number">41,410</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    {{-- <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-info text-light shadow-sm">
                                <i class="bi bi-people-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;"> الحائزين على تقييم كامل</span>
                                <span class="info-box-number">41,410</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div> --}}
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-danger shadow-sm">
                                <i class="bi bi-person-fill-x"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">الغياب عن الحصة</span>
                                <span class="info-box-number">41,410</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!--begin::Row-->

                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-md-8 mb-2">
                        <!--begin::Row-->

                        <!--end::Row-->
                        <!--begin::Latest Order Widget-->
                        <div class="card" style="height: 100%;">
                            <div class="card-header">
                                <h3 class="card-title">اداء الطلاب</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Item</th>
                                                <th>Status</th>
                                                <th>Popularity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                                </td>
                                                <td>Call of Duty IV</td>
                                                <td><span class="badge text-bg-success"> Shipped </span></td>
                                                <td>
                                                    <div id="table-sparkline-1"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                                </td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge text-bg-warning">Pending</span></td>
                                                <td>
                                                    <div id="table-sparkline-2"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                </td>
                                                <td>iPhone 6 Plus</td>
                                                <td><span class="badge text-bg-danger"> Delivered </span></td>
                                                <td>
                                                    <div id="table-sparkline-3"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                </td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge text-bg-info">Processing</span></td>
                                                <td>
                                                    <div id="table-sparkline-4"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                                </td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge text-bg-warning">Pending</span></td>
                                                <td>
                                                    <div id="table-sparkline-5"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                </td>
                                                <td>iPhone 6 Plus</td>
                                                <td><span class="badge text-bg-danger"> Delivered </span></td>
                                                <td>
                                                    <div id="table-sparkline-6"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                                </td>
                                                <td>Call of Duty IV</td>
                                                <td><span class="badge text-bg-success">Shipped</span></td>
                                                <td>
                                                    <div id="table-sparkline-7"></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->

                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="height: 100%;">
                            <div class="card-header">
                                <h3 class="card-title">رسم بياني لأداء الطلاب</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body ">
                                <!--begin::Row-->
                                <div class="row ">
                                    <div class="">
                                        <div id="pie-chart"></div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!--end::Row-->
                            </div>
                        </div>
                    </div>
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

<script>
    const pie_chart_options = {
        series: [700, 500, 400, 600, 300, 100],
        chart: {
            type: 'donut',
        },
        labels: ['Chrome', 'Edge', 'FireFox', 'Safari', 'Opera', 'IE'],
        dataLabels: {
            enabled: false,
        },
        colors: ['#0d6efd', '#20c997', '#ffc107', '#d63384', '#6f42c1', '#adb5bd'],
    };

    addEventListener("DOMContentLoaded", (event) => {
        const pie_chart = new ApexCharts(document.querySelector('#pie-chart'), pie_chart_options);
        pie_chart.render();
    });
</script>
