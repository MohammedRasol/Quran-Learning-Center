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
                                            <div class="col-md-4 col-sm-12 alert alert-info">
                                                <label for="user_id" class="form-label fw-bold">الطالب :
                                                    {{ $student->getFullName() }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12  pt-0">
                                            <label for="name" class="form-label">إختر
                                                السورة</label>
                                            <select class="form-select" name="class_room[]" id='class_room'
                                                onchange="getSurahData(this,'{{ $student->id }}','{{ $lesson->id }}');">

                                                <option value="">السورة</option>
                                                @foreach ($surahs as $surah)
                                                    <option value='{{ $surah->id }}'>
                                                        {{ $surah->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('class_room')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12  pt-0">
                                            <label for="name" class="form-label">من أية </label>
                                            <select class="form-select" id='from_verse'>
                                                <option value="">من أية</option>
                                            </select>

                                            <div class="alert alert-danger h-20 d-none"> </div>

                                        </div>

                                        <div class="col-md-4 col-sm-12  pt-0">
                                            <label for="name" class="form-label">الى أيه</label>
                                            <select class="form-select" id='to_verse'>
                                                <option value="">الى أيه</option>
                                            </select>

                                            <div class="alert alert-danger h-20 d-none"> </div>

                                        </div>


                                        <div class="col-md-8 col-sm-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">1</th>
                                                        <th align="center">Task</th>
                                                        <th>Progress</th>
                                                        <th style="width: 40px" align="center">Label</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($studentRecitationSummary as $recitation)
                                                        @set($recitationPercenter = ($recitation['total_verses_recited'] / $recitation['surah']->total_verses) * 100)
                                                        <tr class="align-middle">
                                                            <td>
                                                                1
                                                            </td>
                                                            <td>
                                                                {{ $recitation['surah']->name }}
                                                            </td>
                                                            <td>
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar progress-bar-danger"
                                                                        style="width:{{ number_format($recitationPercenter, 1) }}%">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><span class="badge text-bg-danger">
                                                                    {{ number_format($recitationPercenter, 1) }}%</span>
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
                                    <div class=" col-md-2 col-sm-12 ">
                                        <button class="btn btn-success w-100" type="submit">إضافة الغرفة الصفية</button>
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
        // ${studentId}/lesson/${lessonId}/recitations
        function getSurahData(el, studentId, lessonId) {

            $.ajax({
                url: `/ajax/getSurahinfo/${el.value}/${lessonId}/${studentId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(data) {

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        }
    </script>
@endsection
