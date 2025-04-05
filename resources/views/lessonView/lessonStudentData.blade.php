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
                                            <select class="form-select" id='surah_id'
                                                onchange="getSurahData(this,'{{ $student->id }}','{{ $lesson->id }}');">

                                                <option value="">السورة</option>
                                                @foreach ($surahs as $surah)
                                                    <option value='{{ $surah->id }}'>
                                                        {{ $surah->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('surah_id')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 col-sm-12  pt-0">
                                            <label for="name" class="form-label">من أية </label>
                                            <select class="form-select" id='from_verse' onchange="verseChange(this)">
                                                <option value="">من أية</option>
                                            </select>

                                            <div class="alert alert-danger h-20 d-none"> </div>

                                        </div>

                                        <div class="col-md-3 col-sm-12  pt-0">
                                            <label for="name" class="form-label">الى أيه</label>
                                            <select class="form-select" id='to_verse'>
                                                <option value="">الى أيه</option>
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
                                                            <th style="width: 10%">*</th>
                                                            <th align="center" style="width:25%">السورة</th>
                                                            <th style="width:20%">الإنجاز</th>
                                                            <th style="width: 15%" align="center">النسبة</th>
                                                            <th style="width: 15%" align="center">التقييم</th>
                                                            <th style="width: 10%" alignJonah align="center">
                                                                #
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($studentRecitationSummary as $key => $recitation)
                                                            @set($recitationPercenter = ($recitation['total_verses_recited'] / $recitation['surah']->total_verses) * 100)
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
                                                                <td> </td>
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
                                                                    <i class="fa-solid fa-star text-warning"></i>
                                                                    {{ round($recitation['rate']) }}
                                                                </td>
                                                                <td>
                                                                    {{-- <a href='/lesson/{{ $lesson->id }}/student/{{ $student->id }}/surah/{{ $recitation['surah']->id }}/edit' type='button' class="btn btn-sm btn-primary">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                    </a> --}}
                                                                    <button type='button' class="btn btn-sm btn-danger"
                                                                        onclick="deleteRecitations(this,'{{ $recitation['surah']->id }}','{{ $student->id }}','{{ $lesson->id }}');">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
        var recitations = {};
        var range = [];
        // ${studentId}/lesson/${lessonId}/recitations
        function getSurahData(surah, studentId, lessonId) {
            $.ajax({
                url: `/ajax/getLessonSurahInfo/${surah.value}/${lessonId}/${studentId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(data) {
                    let response = data.data ? data.data : null;
                    const allNumbers = new Set();

                    $("#from_verse").html(`<option value=''>من آية</option>`);
                    if (response) {
                        range = [];
                        var total_verses = response["surah"]["total_verses"];
                        var msg = "";
                        var completed = false;


                        for (let index = 0; index < response.recitations.length; index++) {

                            const element = response.recitations[index];

                            // Add all numbers in this range to the set
                            for (let i = element.from_verse; i <= element.to_verse; i++) {
                                allNumbers.add(i);
                            }

                            if (!recitations[surah.value]) {
                                recitations[surah.value] = [];
                            }
                            recitations[surah.value][index] = {
                                from: element.from_verse,
                                to: element.to_verse
                            };


                        }


                        range = Array.from(allNumbers).sort((a, b) => a - b);
                        if (findMissingNumbers(range,1,total_verses).length==0) {
                            msg = "تم تسميع السورة بالكامل ";
                            completed = true;
                        }

                        if (!completed) {
                            // Convert set to sorted array
                            var fromVerseOptions = "";
                            var toVerseOptions = "";
                            fromVerseOptions += `<option value=''>من آية</option>`;
                            for (let index = 1; index <= total_verses; index++) {
                                if (!range.includes(index)) {
                                    fromVerseOptions += `<option value=${index}>${index}</option>`;
                                }
                            }
                            $("#from_verse").html(fromVerseOptions);
                        }

                        $("#recitations_note").addClass("alert-primary");

                        $("#recitations_note").html(msg != "" ? msg : "لم يتسم التسميع السورة بالكامل ");
                        $("#recitations_note").parent().removeClass("d-none");
                        $("#recitations_note").removeClass("d-none");
                    }




                    console.log(recitations);

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
            let count = 0;
            var addOne = 1;
            if (firstOption == lastOption)
                addOne = 0;
            for (let index = firstOption + addOne; index <= (lastOption + addOne); index++) {
                if (index > lastOption)
                    break;
                if (!range.includes(index)) {
                    count++;
                    toVerseOptions += `<option value=${index}>${index}</option>`;
                } else {
                    if (count == 0) {
                        if (firstOption == 1) { //في حالة تبقى تسميع الاية الاولى 
                            toVerseOptions += `<option value=${firstOption}>${firstOption}</option>`;
                        } else {
                            toVerseOptions += `<option value=''>يرجى إختيار من ايه اخرى </option>`;
                        }
                    }
                    break;
                }

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

        function deleteRecitations(el, surahId, studentId, lessonId) {
            let tr = el.closest("tr");
            if (confirm("سوف يتم حذف هذا التمسيع ولا يمكن التراجع! ")) {

                $.ajax({
                    url: `/ajax/deletRecitation/${lessonId}/${studentId}/${surahId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
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

                // $(tr).fadeOut();
            }
        }

        function findMissingNumbers(arr,min,max) {
            const set = new Set(arr);
            const missing = [];
             for (let i = 1; i <= max; i++) {
                if (!set.has(i)) {
                    missing.push(i);
                }
            }
            return missing;
        }

    
    </script>
@endsection
