@extends('layouts.admin')

@section('app-main')
    <style>
        .disable-item {
            cursor: not-allowed;
            opacity: 0.5 !important;
            text-decoration: none !important;
        }
    </style>
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
                                                            <th class="hide-on-sm text-center">تسميع</th>
                                                        @endif
                                                        <th class="hide-on-sm text-center">سجل تسميع الدرس</th>
                                                        {{-- <th class="hide-on-sm text-center ">الإحصائيات</th> --}}
                                                        <th class="hide-on-sm text-center ">الحضور</th>
                                                        <th class="hide-on-md text-center ">#</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($students as $key => $student)
                                                        @set($isAbsent = in_array($student->id, $absences))

                                                        <tr class="align-middle" id='student-{{ $student->id }}'>
                                                            <td class="{{ $isAbsent ? 'bg-danger' : '' }}">
                                                                {{ $key + 1 }}
                                                            </td>
                                                            <td class="{{ $isAbsent ? 'bg-danger' : '' }}">
                                                                <a id="student-name"
                                                                    href="javascript:showData('{{ $student->id }}')">
                                                                    {{ $student->getFullName() }}
                                                                    {{-- <span
                                                                        class="hide-on-md text-center fw-bold   {{ $isAbsent ? '' : 'd-none' }} ">
                                                                        -   غـــيـــاب
                                                                    </span> --}}
                                                                </a>

                                                            </td>

                                                            @if ($isRunning)
                                                                <td class="hide-on-sm text-center   absences-show {{ $isAbsent ? 'bg-danger' : ' ' }}"
                                                                    style="{{ $isAbsent ? 'display:none' : '' }}">
                                                                    <a
                                                                        @if (!in_array($student->id, $absences)) href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}"
                                                                         class="btn btn-primary btn-sm"
                                                                    @else
                                                                        class="btn btn-primary btn-sm"
                                                                         data-href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}" @endif>
                                                                        <i class="fa-solid fa-ear-listen"></i>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            <td class="hide-on-sm text-center absences-show {{ $isAbsent ? 'bg-danger' : ' ' }}"
                                                                style="{{ $isAbsent ? 'display:none' : '' }}">
                                                                <a
                                                                    @if (!in_array($student->id, $absences)) href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}/activities"
                                                                    class="btn btn-secondary btn-sm"
                                                                @else
                                                                class="btn btn-secondary btn-sm "
                                                                     data-href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}/activities" @endif>

                                                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                                                </a>
                                                            </td>
                                                            {{-- <td class="hide-on-sm text-center  absences-show {{ $isAbsent ? 'bg-danger' : ' ' }}"
                                                                style="{{ $isAbsent ? 'display:none' : '' }}">
                                                                <a class="btn btn-warning btn-sm"
                                                                    @if (!in_array($student->id, $absences)) href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}"
                                                                @else
                                                                     data-href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}" @endif>

                                                                    <i class="fa-solid fa-chart-simple"></i>
                                                                </a>
                                                            </td> --}}

                                                            <td class="hide-on-sm text-center  absences-text bg-danger fw-bold"
                                                                style="{{ $isAbsent ? '' : 'display:none' }}"
                                                                colspan="2">
                                                                غـــيـــاب
                                                            </td>

                                                            <td
                                                                class="hide-on-sm text-center {{ $isAbsent ? 'bg-danger' : ' ' }} ">
                                                                <button class="btn btn-success btn-sm" type="button"
                                                                    onclick="addStudentAbsent(this,'{{ $lesson->id }}','{{ $student->id }}')">
                                                                    <i class="fa-solid fa-hand"></i>
                                                                </button>
                                                            </td>

                                                            <td
                                                                class="hide-on-md text-center {{ $isAbsent ? 'bg-danger' : ' ' }}">
                                                                <div class="dropdown">
                                                                    <a class="btn btn-secondary " href="#"
                                                                        role="button" id="dropdownMenuLink"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu p-0"
                                                                        aria-labelledby="dropdownMenuLink">
                                                                        @if ($isRunning)
                                                                            <a class="dropdown-item bg-primary text-light btn btn-sm p-2 dropdown-menu-options "
                                                                                style="{{ $isAbsent ? 'display:none' : '' }}"
                                                                                href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}">
                                                                                <div
                                                                                    class=" d-flex pr-2 pl-3 justify-content-between">
                                                                                    تسميع
                                                                                    <i
                                                                                        class="fa-solid fa-ear-listen mt-1"></i>
                                                                                </div>
                                                                            </a>
                                                                        @endif

                                                                        <a class="dropdown-item bg-info text-light  btn btn-sm p-2  dropdown-menu-options"
                                                                            style="{{ $isAbsent ? 'display:none' : '' }}"
                                                                            href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}/activities">

                                                                            <div
                                                                                class=" d-flex pr-2 pl-3 justify-content-between">
                                                                                سجل تسميع الدرس
                                                                                <i
                                                                                    class="fa-solid fa-clock-rotate-left mt-1"></i>
                                                                            </div>
                                                                        </a>

                                                                        <a class="dropdown-item  
                                                                            {{ $isAbsent ? 'bg-success' : 'bg-danger ' }} 
                                                                        text-light  btn btn-sm p-2"
                                                                            id="mobile-abcene-div" href="#">
                                                                            <div class=" d-flex pr-2 pl-3 justify-content-between"
                                                                                id="mobile-abcene-button"
                                                                                onclick="addStudentAbsent(this,'{{ $lesson->id }}','{{ $student->id }}')">
                                                                                تسجيل {{ $isAbsent ? 'حضور' : 'غياب ' }}
                                                                                <i class="fa-solid fa-hand mt-1"></i>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="student-data" id='student_{{ $student->id }}'
                                                            style="display: none;">
                                                            <td colspan="12">
                                                                <table class="table table-striped ">
                                                                    @if (count($student->summary) != 0)
                                                                        <thead>
                                                                            <tr>
                                                                                <th>السورة</th>
                                                                                <th>الانجاز</th>
                                                                                <th style="width: 40px" colspan="2">
                                                                                    النسبة</th>
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
                                <div class="card-footer col-12 d-sm-flex justify-content-evenly">
                                    <div class=" col-md-4 col-sm-12 ">
                                        <a  href="/lesson/{{ $lesson->id }}/statistics/"                                        
                                        class="btn btn-primary w-100 fw-bold" type="button">الإحصائيات 
                                            
                                            <i class="fa-solid fa-chart-simple"></i> 
                                        </a>
                                    </div>

                                    <div class=" col-md-4 col-sm-12 mt-1 mt-sm-0">
                                        @if ($isRunning)
                                            <button class="btn btn-danger w-100" type="button"
                                                onclick="closeLesson({{ $lesson->id }})">إغلاق الغرفة الصفية</button>
                                        @else
                                            <strong>
                                                <div class="alert alert-danger text-center"> الغرفة مغلقة
                                                    {{ Carbon\Carbon::parse($lesson->finished_at)->locale('ar')->diffForHumans() }}
                                                    <br>
                                                    {{ getArabicDate($lesson->finished_at) }}
                                                    <br>
                                                    الساعة
                                                    {{ date('H:i:s', strtotime($lesson->finished_at)) }}

                                            </strong>
                                        @endif
                                    </div>

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

        function addStudentAbsent(el, lessonId, studentId) {
            $.ajax({
                url: `/ajax/addStudentAbsent/${lessonId}/${studentId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    disableRow(el.closest("tr"), studentId, response.status);

                    if (response.status == 200) {
                        $(".dropdown-menu-options").fadeOut();
                        $("#mobile-abcene-button").text("تسجيل حضور");
                        // alert($("#mobile-abcene-button").text())
                        $("#mobile-abcene-div").addClass("bg-success");
                        $("#mobile-abcene-div").removeClass("bg-danger");
                    } else if (response.status == 202) {
                        $(".dropdown-menu-options").fadeIn();
                        $("#mobile-abcene-button").text("تسجيل غياب");
                        $("#mobile-abcene-div").removeClass("bg-success");
                        $("#mobile-abcene-div").addClass("bg-danger");
                    }



                    // alert(response.data)
                },
                error: function(response) {
                    console.log(response);
                    disableRow(el.closest("tr"), studentId, response.status);
                    if (response.status == 403)
                        alert(response.responseJSON.message)
                }
            });
        }

        function disableRow(row, studentId, status) {
            let items = row.querySelectorAll("td");
            for (let index = 0; index < items.length; index++) {
                const item = items[index];
                if (status == 200) {
                    if (item.classList.contains("absences-show")) {
                        item.style.display = 'none';
                    }
                    if (item.classList.contains("absences-text")) {
                        item.style.display = '';
                    }
                    item.classList.add("bg-danger")
                    $(".dropdown-menu-options").fadeOut();

                } else if (status == 202) {
                    if (item.classList.contains("absences-show")) {
                        item.style.display = '';
                    }
                    if (item.classList.contains("absences-text")) {
                        item.style.display = 'none';
                    }
                    item.classList.remove("bg-danger")
                    $(".dropdown-menu-options").fadeIn();

                }
            }



            // if (status == 200)
            //     disableATag(row);
            // else
            //     enableATag(row);
            // row.querySelector("#student-name").setAttribute();
            // const elements = row.querySelectorAll('input, button, select, textarea');
            // // Disable each element
            // elements.forEach(element => {
            //     element.disabled = true;
            // });
            // "Disable" links

            // $(`#absent-${studentId}`).text("غـــيـــاب");
        }

        function disableATag(row) {
            const links = row.querySelectorAll('a');
            links.forEach(link => {
                link.dataset.href = link.getAttribute('href'); // Backup original href
                link.removeAttribute('href');
                link.style.pointerEvents = 'none';
                link.style.opacity = '0.5';
                link.style.textDecoration = 'none';
            });
        }

        function enableATag(row) {
            const links = row.querySelectorAll('a');
            var url = "";
            links.forEach(link => {
                url = link.getAttribute('data-href'); // Backup original href
                link.setAttribute('href', url);
                link.style.pointerEvents = ' ';
                link.style.opacity = '1';
                link.style.textDecoration = '';
            });
        }
    </script>
@endsection
