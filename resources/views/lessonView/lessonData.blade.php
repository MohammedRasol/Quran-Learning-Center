@extends('layouts.admin')

@section('app-main')
    <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">الحصة جارية الأن</h3>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->all())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- App Content -->
        <div class="app-content" style="overflow-y: auto; height: fit-content; max-height: 80vh; min-height: 80vh;">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card card-info card-outline">
                            <!-- Card Header -->
                            <div class="card-header">
                                <h5 class="card-title w-100 text-center alert alert-info fw-bold"> {{ $lesson->topic }}</h5>
                            </div>

                            <!-- Card Body with Form -->
                            <form method="POST" enctype="multipart/form-data" action="/lesson" autocomplete="off"
                                id="form">
                                @csrf
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-12 text-primary ">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="alert alert-primary"> الشيخ المسؤول :
                                                    {{ $lesson->shaikh->getFulleName() }}</div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-4 col-sm-12  pt-0">
                                            <label for="name" class="form-label">إختر السورة</label>
                                            <select class="form-select" name="class_room[]" id='class_room'
                                                onchange="showStudentLessonData()">
                                                <option value="">السورة</option>
                                                @foreach ($students as $student)
                                                    <option value='{{ $student->id }}'>
                                                        {{ $student->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('class_room')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        <div class="col-md-12 col-sm-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px"></th>
                                                        <th>الطالب</th>
                                                        @if ($isRunning)
                                                            <th  class="hide-on-sm text-center">تسميع</th>
                                                        @endif
                                                        <th  class="hide-on-sm text-center"  >سجل تسميع الدرس</th>
                                                        <th class="hide-on-sm text-center ">الإحصائيات</th>
                                                        <th class="hide-on-sm text-center ">الحضور</th>
                                                        <th class="hide-on-md text-center ">#</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($students as $key => $student)
                                                        <tr class="align-middle">
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>
                                                                <a href="javascript:showData('{{ $student->id }}')">{{ $student->getFullName() }}</a>

                                                            </td>
                                                            @if ($isRunning)
                                                                <td class="hide-on-sm text-center">
                                                                    <a class="btn btn-primary btn-sm"
                                                                        href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}">
                                                                        <i class="fa-solid fa-ear-listen"></i>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            <td class="hide-on-sm text-center"  >
                                                                <a class="btn btn-secondary btn-sm"
                                                                    href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}/activities">
                                                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                                                </a>
                                                            </td>
                                                            <td class="hide-on-sm text-center">
                                                                <a class="btn btn-warning btn-sm"
                                                                    href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}">
                                                                    <i class="fa-solid fa-chart-simple"></i>
                                                                </a>
                                                            </td>
                                                            <td class="hide-on-sm text-center">
                                                                <a class="btn btn-success btn-sm"
                                                                    href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}">
                                                                    <i class="fa-solid fa-hand"></i>
                                                                </a>
                                                            </td>
                                                            <td class="hide-on-md text-center">
                                                                <div class="dropdown">
                                                                    <a class="btn btn-secondary " href="#"
                                                                        role="button" id="dropdownMenuLink"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu p-0"
                                                                        aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item bg-primary text-light btn btn-sm p-2"
                                                                            href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}">
                                                                            <div
                                                                                class=" d-flex pr-2 pl-3 justify-content-between">
                                                                                تسميع
                                                                                <i class="fa-solid fa-ear-listen mt-1"></i>
                                                                            </div>
                                                                        </a>
                                                                        <a class="dropdown-item bg-secondary text-light  btn btn-sm p-2"
                                                                        href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}/activities">

                                                                            <div
                                                                                class=" d-flex pr-2 pl-3 justify-content-between">
                                                                                سجل تسميع الدرس
                                                                                <i
                                                                                    class="fa-solid fa-clock-rotate-left mt-1"></i>
                                                                            </div>
                                                                        </a>
                                                                        <a class="dropdown-item bg-warning text-light  btn btn-sm p-2"
                                                                            href="#">
                                                                            <div
                                                                                class=" d-flex pr-2 pl-3 justify-content-between">
                                                                                الإحصائيات
                                                                                <i
                                                                                    class="fa-solid fa-chart-simple mt-1"></i>
                                                                            </div>
                                                                        </a>
                                                                        <a class="dropdown-item bg-success text-light  btn btn-sm p-2"
                                                                            href="#">
                                                                            <div
                                                                                class=" d-flex pr-2 pl-3 justify-content-between">
                                                                                الحضور
                                                                                <i class="fa-solid fa-hand mt-1"></i>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="student-data" id='student_{{ $student->id }}'
                                                            style="display: none;">
                                                            <td colspan="4">

                                                                <table class="table table-striped ">
                                                                    @if (count($student->summary) != 0)
                                                                        <thead>
                                                                            <tr>

                                                                                <th>السورة</th>
                                                                                <th>الانجاز</th>
                                                                                <th style="width: 40px">النسبة</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($student->summary as $summary)
                                                                                @set($recitationPercenter = $summary['percentage'])
                                                                                @set($color = 'primary')
                                                                                @if ($recitationPercenter <= 25)
                                                                                    @set($color = 'secondary')
                                                                                @elseif($recitationPercenter <= 50)
                                                                                    @set($color = 'warning')
                                                                                @elseif($recitationPercenter <= 75)
                                                                                    @set($color = 'primary')
                                                                                @elseif($recitationPercenter <= 100)
                                                                                    @set($color = 'success')
                                                                                @endif

                                                                                <tr class="align-middle">

                                                                                    <td>سورة {{ $summary['surah']->name }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="progress progress-xs progress-striped active">
                                                                                            <div class="progress-bar text-bg-{{ $color }}"
                                                                                                style="width: {{ $summary['percentage'] }}%">
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td><span
                                                                                            class="badge text-bg-{{ $color }}">{{ $summary['percentage'] }}%</span>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                </td>
                                                                            </tr>

                                                                        </tbody>
                                                                    @else
                                                                        <tr>
                                                                            <td align="center">
                                                                                لم يتسم التسميع للطالب بعد
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Footer -->
                                <div class="card-footer ">
                                    <div class=" col-md-4 col-sm-12 ">
                                        @if ($isRunning)
                                            <button class="btn btn-danger w-100" type="button"
                                                onclick="closeLesson({{ $lesson->id }})">إغلاق الغرفة الصفية</button>
                                        @else
                                            <strong>
                                                <div class="alert alert-danger text-center"> الغرفة مغلقة
                                                    {{ Carbon\Carbon::parse($lesson->finished_at)->locale('ar')->diffForHumans() }}
                                                    <br>
                                                    بتاريخ
                                                    {{ getArabicDate($lesson->finished_at) }}
                                                    <br>
                                                    الساعة
                                                    {{ date('H:i:s', strtotime($lesson->finished_at)) }}

                                            </strong>
                                    </div>
                                    @endif
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <!-- JavaScript for Dropzone -->

    <script>
        function checkClassRoomGroup() {
            var clsrom = document.getElementById("class_room");
            var group = document.getElementById("group_id");
            if (clsrom && clsrom.value != '') {
                group.disabled = true;
                clsrom.false = false;
            } else if (group && group.value != '') {
                group.false = false;
                clsrom.disabled = true;
            } else {
                group.disabled = false;
                clsrom.disabled = false;
            }

        }

        function showData(id) {
            $(".student-data").hide("fast", function() {
                $("#student_" + id).slideDown("fast");
            });
        }

        function closeLesson(id) {
            if (confirm(" إنهاء الغرفة !!")) {
                $.ajax({
                    url: `/ajax/closeLesson/${id}`,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            alert("تم إنهاء الغرفة ")
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

        }
    </script>
@endsection
