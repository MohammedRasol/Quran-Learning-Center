@extends('layouts.admin')
@section('app-main')
    <style>
        @media (max-width: 576px) {
            .sm-collapsed-card {
                display: none;
                /* Collapsed on small screens */
            }
        }
    </style>
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

                            <span
                                class="info-box-icon text-bg-{{ getRecitationColor((count($lessonData->recitations) / $lessonData->totalStudents) * 100) }} shadow-sm">
                                <i class="bi bi-mic-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">عدد المسمعين</span>
                                <div class="d-flex justify-content-between w-50">

                                    <span
                                        class="info-box-number">{{ count($lessonData->totalRecitations) . ' من أصل ' . $lessonData->totalStudents }}</span>
                                    <span
                                        class="info-box-number">{{ (count($lessonData->totalRecitations) / $lessonData->totalStudents) * 100 . '%' }}</span>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <!-- <div class="clearfix hidden-md-up"></div> -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">



                            <span
                                class="info-box-icon text-bg-{{ getRecitationColor($lessonData->avarageRate * 20) }} shadow-sm">
                                <i class="bi bi-cart-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">تقييم أداء التسميع</span>
                                <span class="info-box-number">
                                    @for ($i = 1; $i <= $lessonData->avarageRate; $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                    @for ($i = $lessonData->avarageRate; $i < 5; $i++)
                                        <i class="bi bi-star"></i>
                                    @endfor
                                </span>
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
                            <span
                                class="info-box-icon text-bg-{{ getRecitationColor((($lessonData->totalStudents - $lessonData->totalStudentAbsent) / $lessonData->totalStudents) * 100) }} shadow-sm">
                                <i class="bi bi-person-fill-x"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">الغياب عن الحصة</span>
                                <span
                                    class="info-box-number">{{ $lessonData->totalStudentAbsent . 'من أصل ' . $lessonData->totalStudents }}</span>
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
                        <div class="card " style="height: 100%;">
                            <div class="card-header">
                                <h3 class="card-title">اداء الطلاب</h3>
                                <div class="card-tools">

                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">

                                    </button>
                                    <button type="button" class="btn btn-tool" onclick="toggleCard(this)">
                                        <i class="bi bi-arrows-angle-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0 sm-collapsed-card">
                                <div class="table-responsive" style="max-height: 400px">
                                    <table class="table m-0">
                                        <thead>
                                            <tr class="sticky">
                                                <th>الطالب</th>
                                                <th>ملاحظات الدرس</th>
                                                <th>التقييم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lessonData->summaryRecitationsForEachStudent as $summaryRecitationsStudent)
                                                <tr>
                                                    <td>
                                                        <a href="pages/examples/invoice.html"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                                            {{ $summaryRecitationsStudent['student_name'] }}
                                                        </a>
                                                    </td>
                                                    <td>Call of Duty IV</td>
                                                    <td><span class="badge ">
                                                            @for ($i = 1; $i <= $summaryRecitationsStudent['averageRate']; $i++)
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @endfor
                                                            @for ($i = $summaryRecitationsStudent['averageRate']; $i < 5; $i++)
                                                                <i class="bi bi-star text-warning"></i>
                                                            @endfor
                                                        </span></td>
                                                </tr>
                                            @endforeach

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

                                    <button type="button" class="btn btn-tool">

                                    </button>
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i class="bi bi-arrows-angle-expand"></i>

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
    function toggleCard(header) {
        $(".sm-collapsed-card").slideToggle();
    }

    const summaryRecitationsForEachStudent = JSON.parse(@json($lessonData->summaryRecitationsForEachStudentJson));
    // المصفوفة الأولى: أسماء الطلاب وأرقامهم
    const studentsArray = summaryRecitationsForEachStudent.map(student => student.student_name);
    // المصفوفة الثانية: عدد الآيات
    const versesArray = summaryRecitationsForEachStudent.map(student => student.total_verses);

    const pie_chart_options = {
        series: versesArray,
        chart: {
            type: 'pie',
        },
        labels: studentsArray,
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex] + " آية "; // Returns raw value
            }
        },
        legend: {
            fontSize: '20px' // Adjust this value to change the legend text font size
        },
        colors: generateColorArray(versesArray.length),
    };

    addEventListener("DOMContentLoaded", (event) => {
        const pie_chart = new ApexCharts(document.querySelector('#pie-chart'), pie_chart_options);
        pie_chart.render();
    });

    function generateColorArray(length) {
        // Array to store the colors
        const colors = [];

        // Generate 'length' number of random hex colors
        for (let i = 0; i < length; i++) {
            const randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
            colors.push(randomColor);
        }

        return colors;
    }
</script>
