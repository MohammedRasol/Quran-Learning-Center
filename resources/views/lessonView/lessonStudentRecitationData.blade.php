@extends('layouts.admin')

@section('app-main')
    <style>
        /* Add this CSS to make the thead sticky */
        thead th {
            position: sticky;
            top: 0;
            background-color: #fff;
            /* Adjust background color as needed */
            z-index: 1;
            /* Ensures the header stays above the body content */
        }

        /* Optional: Add a shadow or border to distinguish the sticky header */
        thead th {
            border-bottom: 2px solid #ddd;
            /* Example border */
        }

        /* Ensure the table is scrollable if needed */
        .table-container {
            max-height: 400px;
            /* Adjust height as needed */
            overflow-y: auto;
            /* Enable vertical scrolling */
            display: block;
            /* Ensures the container respects max-height */
        }
    </style>
    <main class="app-main">
        <!-- App Content Header -->
        {{-- <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">الحصة جارية الأن</h3>
                    </div>
                </div>
            </div>
        </div> --}}

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
        <div class="app-content" style="overflow-y: auto; height: fit-content; max-height:100vh; min-height: 80vh;">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card card-info card-outline">
                            <!-- Card Header -->
                            <div class="card-header">
                                <h5 class="card-title w-100 text-center alert alert-primary fw-bold"> {{ $lesson->topic }}
                                </h5>
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
                                            <label for="surah_id" class="form-label">إختر
                                                السورة</label>
                                            <select class="form-select" id='surah_id'>
                                                <option value='{{ $surah->id }}'>
                                                    {{ $surah->name }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-12  pt-0">
                                            <label for="name" class="form-label">من أية </label>
                                            <select class="form-select" id='from_verse' onchange="verseChange(this)">
                                                <option value="{{ $recitation->min_from_verse }}">{{ $recitation->min_from_verse }}</option>
                                            </select>

                                            <div class="alert alert-danger h-20 d-none"> </div>

                                        </div>

                                        <div class="col-md-3 col-sm-12  pt-0">
                                            <label for="name" class="form-label">الى أيه</label>
                                            <select class="form-select" id='to_verse'>
                                                <option value="{{ $recitation->max_to_verse }}">{{ $recitation->max_to_verse }}</option>
                                            </select>
                                            <div class="alert alert-danger h-20 d-none"> </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12  pt-0  d-none">
                                            <label for="name" class="form-label">ملاحظات</label>
                                            <div class="alert  p-1 d-none" id='recitations_note'></div>
                                        </div>

                                        <div class="col-md-8 col-sm-12 ">
                                            <label for="name" class="form-label">ملاحظات على التسميع</label>
                                            <input class="form-control" id='notes'>
                                        </div>

                                        <div class="col-md-2 col-sm-12  ">
                                            <div class="container mt-md-5 mt-sm-2">
                                                <div class="star-rating d-flex justify-content-evenly" id="starRating">
                                                    <i class="fa-solid fa-star" data-value="1"></i>
                                                    <i class="fa-solid fa-star" data-value="2"></i>
                                                    <i class="fa-solid fa-star" data-value="3"></i>
                                                    <i class="fa-solid fa-star" data-value="4"></i>
                                                    <i class="fa-solid fa-star" data-value="5"></i>
                                                </div>
                                                <p class="text-center mt-3" id="ratingText">التقييم : <span
                                                        id="ratingValue">0</span> / 5</p>
                                            </div>
                                        </div>

                                        <div class="col-md-8 col-sm-12">
                                            <div class="table-container"
                                                style="overflow-y: auto; height: fit-content; max-height:30vh ;border:1px #ddd solid ">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th align="center" style="width:25%">السورة</th>
                                                            <th style="width:20%">الإنجاز</th>
                                                            <th style="width: 15%" align="center">النسبة</th>
                                                            <th style="width: 30%" alignJonah align="center">
                                                                #
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @set($recitationPercenter = $recitation['percentage'])
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

                                                            <td>{{ $recitation['surah']->name }}</td>
                                                            <td>
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar progress-bar-{{ $color }} bg-{{ $color }} "
                                                                        style="width:{{ number_format($recitationPercenter, 1) }}%">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge text-bg-{{ $color }}">
                                                                    {{ number_format($recitationPercenter, 1) }}%
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href='/lesson/{{ $lesson->id }}/student/{{ $student->id }}/surah/{{ $recitation['surah']->id }}/edit'
                                                                    type='button' class="btn btn-sm btn-primary">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <button type='button' class="btn btn-sm btn-danger">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer ">
                                    <div class=" col-md-2 col-sm-12 ">
                                        <button class="btn btn-success w-100" type="button"
                                            onclick="saveRecitations('{{ $student->id }}','{{ $lesson->id }}');">حفظ
                                            التسميعات</button>
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
        //RATING DIV
        const stars = document.querySelectorAll('#starRating .fa-star');
        const ratingValue = document.getElementById('ratingValue');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                updateRating(value);
            });

            star.addEventListener('mouseover', () => {
                const value = star.getAttribute('data-value');
                highlightStars(value);
            });

            star.addEventListener('mouseout', () => {
                const currentValue = ratingValue.textContent;
                highlightStars(currentValue);
            });
        });

        function updateRating(value) {
            ratingValue.textContent = value;
            highlightStars(value);
        }

        function highlightStars(value) {
            stars.forEach(star => {
                const starValue = star.getAttribute('data-value');
                if (starValue <= value) {
                    star.classList.add('checked');
                    star.classList.add('text-warning');
                } else {
                    star.classList.remove('text-warning');
                    star.classList.remove('checked');
                }
            });
        }
        //END RATING DIV

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
                    let response = data.data ? data.data : null;
                    if (response.total_verses) {
                        let firstVerse = response.min_from_verse ? response.min_from_verse : 1;
                        let lastVerse = response.max_to_verse ? (response.max_to_verse) : 1;
                        let totalVerse = response.total_verses ? response.total_verses : 1;
                        let fromVerseOptions = "";
                        let toVerseOptions = "";
                        let count = 0;
                        let startVerse = lastVerse == 1 ? lastVerse : lastVerse + 1;



                        for (let index = startVerse; index <= totalVerse; index++) {

                            fromVerseOptions += `<option value=${index}>${index}</option>`;
                            if (count > 0)
                                toVerseOptions += `<option value=${index}>${index}</option>`;
                            count++;
                        }
                        $("#from_verse").html(fromVerseOptions);
                        $("#to_verse").html(toVerseOptions);
                        console.log([totalVerse == lastVerse, totalVerse, lastVerse]);
                        if (totalVerse == lastVerse) {
                            $("#recitations_note").addClass("alert-success");
                            $("#recitations_note").removeClass("alert-primary");
                        } else {
                            $("#recitations_note").removeClass("alert-success");
                            $("#recitations_note").addClass("alert-primary");
                        }

                        $("#recitations_note").html(response.note ?? "لم يتسم التسميع ");
                        $("#recitations_note").parent().removeClass("d-none");
                        $("#recitations_note").removeClass("d-none");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });


        }

        function verseChange(el) {
            if (el.value == '') {
                alert()
                return;
            }
            const firstOption = parseInt(el.value);
            const lastOption = parseInt(el.querySelector('select option:last-child').value);
            let toVerseOptions = "";
            console.log([firstOption, lastOption]);
            for (let index = firstOption + 1; index <= lastOption; index++) {
                toVerseOptions += `<option value=${index}>${index}</option>`;
            }
            $("#to_verse").html(toVerseOptions);

        }

        function saveRecitations(studentId, lessonId) {
            let surahId = $("#surah_id").val();
            let firstVerse = $("#from_verse").val();
            let lastVerse = $("#to_verse").val();
            let notes = $("#notes").val();
            let rating = $("#ratingValue").text();



            $.ajax({
                url: `/ajax/saveRecitations/${surahId}/${lessonId}/${studentId}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                data: {
                    surahId: surahId,
                    firstVerse: firstVerse,
                    lastVerse: lastVerse,
                    notes: notes,
                    rating: rating
                },
                success: function(response) {
                    if (response.status == 200) {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
@endsection
