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
                                    <div class="row  ">
                                        <div class="col-md-4 col-sm-12 alert alert-info mrl-1">
                                            <label for="user_id" class="form-label fw-bold">الطالب :
                                                {{ $student->getFullName() }}</label>
                                        </div>
                                        <div class="col-md-12 col-sm-12 p-0">
                                            <div class="recitation-container" style="max-height: 70vh; overflow-y: scroll;">
                                                <div class=" ">
                                                    @foreach ($studentRecitationSummary as $key => $recitation)
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
                                                        
                                                        @set($strokeColor = 'var(--bs-primary)')
                                                        @if ($color == 'secondary')
                                                            @set($strokeColor = 'var(--bs-secondary)')
                                                        @elseif ($color == 'warning')
                                                            @set($strokeColor = 'var(--bs-warning)')
                                                        @elseif ($color == 'success')
                                                            @set($strokeColor = 'var(--bs-success)')
                                                        @endif
                                                        <div class="recitation-card"
                                                            id="main-div-{{ $recitation['surah']->id }}">
                                                            <div class="accordion-item mt-1">
                                                                <div class="card-header" data-bs-toggle="collapse"
                                                                    data-bs-target="#{{ $recitation['surah']->name }}"
                                                                    aria-expanded="true"
                                                                    aria-controls="{{ $recitation['surah']->name }}">
                                                                    <h2 class="accordion-header ">

                                                                        {{ $recitation['surah']->name }}

                                                                    </h2>
                                                                    {{-- <h3>{{ $recitation['surah']->name }}</h3> --}}
                                                                    {{-- <button type="button" class="delete-btn" 
                                                                    onclick="deleteRecitations(this,'{{ $recitation['surah']->id }}','{{ $student->id }}','{{ $lesson->id }}');">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button> --}}
                                                                </div>
                                                                <div id="{{ $recitation['surah']->name }}"
                                                                    class="accordion-collapse collapse   auto-scroll p-1 "
                                                                    data-bs-parent="#accordionExample">
                                                                    {{-- <div class="card-body auto-scroll p-1"> --}}
                                                                    <div class="row col-12">
                                                                        <div
                                                                            class="col d-flex justify-content-between align-items-center">
                                                                            <div class="progress-circle ">
                                                                                <svg class="progress-ring w-100 h-100 ">
                                                                                    <circle
                                                                                        class="progress-ring__background  "
                                                                                        cx="40" cy="40"
                                                                                        r="36" />
                                                                                    <circle
                                                                                        id='circle-{{ $recitation['surah']->id }}'
                                                                                        class="progress-ring__circle bg-{{ $color }}"
                                                                                        cx="40" cy="40" r="36"
                                                                                        style="stroke: {{ $strokeColor }}; stroke-dasharray: {{ 226.2 * ($recitationPercenter / 100) }} 226.2;" />
                                                                                </svg>
                                                                                <span class="percentage"
                                                                                    id='percentage-{{ $recitation['surah']->id }}'>{{ number_format($recitationPercenter, 1) }}%</span>
                                                                            </div>
                                                                            <div
                                                                                class="col d-flex justify-content-evenly align-items-center">
                                                                                <table
                                                                                    class="table table-sm align-middle text-center">
                                                                                    <tbody>
                                                                                        <tr>

                                                                                            <td colspan="2"
                                                                                                align="center">
                                                                                                التقييم الشامل :
                                                                                                <span
                                                                                                    id='rate-{{ $recitation['id'] }}'>
                                                                                                    {{ $recitation['rate'] }}</span>
                                                                                                <i
                                                                                                    class="fa-solid fa-star text-warning"></i>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            @if ($recitation['total_verses_recited'] == $recitation['total_verses_in_surah'])
                                                                                                <td
                                                                                                    id='surah-finish-{{ $recitation['surah']->id }}'>
                                                                                                    تم تسميع السورة كاملة
                                                                                                </td>

                                                                                                <td
                                                                                                    id='verses-left-{{ $recitation['surah']->id }}'>
                                                                                                    ما شاءالله
                                                                                                </td>
                                                                                            @else
                                                                                                <td
                                                                                                    id='surah-finish-{{ $recitation['surah']->id }}'>
                                                                                                    سمع
                                                                                                    {{ $recitation['total_verses_recited'] }}
                                                                                                    آية
                                                                                                </td>

                                                                                                <td
                                                                                                    id='verses-left-{{ $recitation['surah']->id }}'>
                                                                                                    تبقى
                                                                                                    {{ $recitation['total_verses_in_surah'] - $recitation['total_verses_recited'] }}
                                                                                                    آية
                                                                                                </td>
                                                                                            @endif


                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    @foreach ($recitations as $rec)
                                                                        @set($rowColor = '#d0e7ec')
                                                                        @foreach ($rec as $recKey => $surahRecitations)
                                                                            @if ($surahRecitations->surah_id == $recitation['surah']->id)
                                                                                <div id='surah-{{ $surahRecitations->id }}'
                                                                                    class="verse-detail text-dark fw-bold"
                                                                                    style="background-color:{{ $rowColor }}">
                                                                                    <div class="verse-range">
                                                                                        <span>من آيه: <button
                                                                                                class="btn">
                                                                                                {{ $surahRecitations->from_verse }}</button></span>
                                                                                        <span>إلى آيه:<button
                                                                                                class="btn">
                                                                                                {{ $surahRecitations->to_verse }}</button></span>

                                                                                        <span class="rating">
                                                                                            <i
                                                                                                class="fa-solid fa-star text-warning"></i>
                                                                                            {{ round($surahRecitations->rate) }}
                                                                                        </span>
                                                                                        <span class="rating">*
                                                                                            {{ $surahRecitations->to_verse - $surahRecitations->from_verse + 1 }}
                                                                                            آيات
                                                                                        </span>
                                                                                        <div class="dropdown">
                                                                                            <a class="btn btn-secondary "
                                                                                                href="#"
                                                                                                role="button"
                                                                                                id="dropdownMenuLink"
                                                                                                data-bs-toggle="dropdown"
                                                                                                aria-expanded="false">
                                                                                                <i
                                                                                                    class="fa-solid fa-ellipsis-vertical"></i>
                                                                                            </a>
                                                                                            <div class="dropdown-menu p-0"
                                                                                                aria-labelledby="dropdownMenuLink">
                                                                                                {{-- <a class="dropdown-item bg-primary text-light btn btn-sm p-2"
                                                                                                    href="/lesson/{{ $lesson->id }}/student/{{ $student->id }}">
                                                                                                    <div
                                                                                                        class=" d-flex pr-2 pl-3 justify-content-between">
                                                                                                        تعديل الملاحظات
                                                                                                        <i
                                                                                                            class="fa-solid fa-file-lines"></i>
                                                                                                    </div>
                                                                                                </a> --}}
                                                                                                <a class="dropdown-item bg-danger text-light  btn btn-sm p-2"
                                                                                                    href="javascript:void(0)">

                                                                                                    <div class=" d-flex pr-2 pl-3 justify-content-between"
                                                                                                        onclick="deleteRecitationById(this,'{{ $lesson->id }}','{{ $student->id }}','{{ $surahRecitations->surah_id }}','{{ $surahRecitations->id }}');">
                                                                                                        حذف التسميع
                                                                                                        <i
                                                                                                            class="fa-solid fa-remove"></i>
                                                                                                    </div>
                                                                                                </a>


                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <p class=" p-2 m-0"> ملاحظات التسميع :
                                                                                        {{ $surahRecitations->notes ? $surahRecitations->notes : 'لايوجد ملاحظات' }}
                                                                                    </p>

                                                                                </div>
                                                                            @else
                                                                                @continue;
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                {{-- <div class="card-footer ">
                                    <div class=" col-md-2 col-sm-12 ">
                                        <button class="btn btn-success w-100" type="button"
                                            onclick="saveRecitations('{{ $student->id }}','{{ $lesson->id }}');">حفظ
                                            التسميعات</button>
                                    </div>
                                </div> --}}
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

                    if (response) {
                        var total_verses = response["surah"]["total_verses"];
                        var msg = "";
                        var completed = false;
                        for (let index = 0; index < response.recitations.length; index++) {

                            const element = response.recitations[index];


                            if (total_verses == element.to_verse) {
                                msg = "تم تسميع السورة بالكامل ";
                                completed = true;
                                break;
                            }
                            if (!recitations[surah.value]) {
                                recitations[surah.value] = [];
                            }
                            recitations[surah.value][index] = {
                                from: element.from_verse,
                                to: element.to_verse
                            };

                            // Add all numbers in this range to the set
                            for (let i = element.from_verse; i <= element.to_verse; i++) {
                                allNumbers.add(i);
                            }
                        }

                        if (!completed) {
                            // Convert set to sorted array
                            range = Array.from(allNumbers).sort((a, b) => a - b);
                            var fromVerseOptions = "";
                            var toVerseOptions = "";
                            fromVerseOptions += `<option value=''>من آية</option>`;
                            for (let index = 1; index < total_verses; index++) {
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
            for (let index = firstOption + 1; index <= (lastOption + 1); index++) {
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

        function deleteRecitationById(el, lessonId, studentId, surahId, recitation_id) {
            let tr = el.closest("tr");
            if (confirm("سوف يتم حذف هذا التمسيع ولا يمكن التراجع! ")) {

                $.ajax({
                    url: `/ajax/deletRecitationById/${lessonId}/${studentId}/${surahId}/${recitation_id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            // location.reload();
                            if (response.data.length > 0) {
                                $(`#surah-${recitation_id}`).slideUp()
                                $(`#percentage-${surahId}`).text((response.data[0].percentage));
                                $(`#surah-finish-${surahId}`).text(
                                    `سمع ${response.data[0].total_verses_recited} آية`);
                                $(`#verses-left-${surahId}`).text(
                                    `تبقى ${response.data[0].total_verses_in_surah - response.data[0].total_verses_recited} آية`
                                );


                                // Set initial stroke color
                                let strokeColor = 'var(--bs-primary)';
                                // Set initial color
                                let color = 'primary';
                                var recitationPercenter = response.data[0].percentage;
                                // Determine color based on percentage
                                if (recitationPercenter <= 25) {
                                    color = 'secondary';
                                } else if (recitationPercenter <= 50) {
                                    color = 'warning';
                                } else if (recitationPercenter <= 75) {
                                    color = 'primary';
                                } else if (recitationPercenter <= 100) {
                                    color = 'success';
                                }

                                // Set initial stroke color

                                // Map color to corresponding CSS variable
                                if (color === 'secondary') {
                                    strokeColor = 'var(--bs-secondary)';
                                } else if (color === 'warning') {
                                    strokeColor = 'var(--bs-warning)';
                                } else if (color === 'success') {
                                    strokeColor = 'var(--bs-success)';
                                }


                                // $(`#circle-${surahId}`).addClass(`bg-${color}`);

                                $(`#circle-${surahId}`).css({
                                    "stroke": strokeColor,
                                    "stroke-dasharray": `${(226.2 * response.data[0].percentage) / 100} 226.2`,
                                    "transition": "stroke-dasharray 0.5s ease-in-out"
                                });




                                // const color =  ;
                                // const strokeColor =   ;
                                // const recitationPercenter =   ;

                                // const circleElement = `<circle
                            //         id="circle-${surahId}"
                            //         class="progress-ring__circle bg-${color}"
                            //         cx="40" 
                            //         cy="40" 
                            //         r="36"
                            //         style="stroke: ${strokeColor}; stroke-dasharray: ${226.2 * (recitationPercenter / 100)} 226.2;"
                            //     />
                            // `;



                            } else {
                                $(`#main-div-${surahId}`).slideUp();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });

                // $(tr).fadeOut();
            }
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

    </script>
@endsection
<style>
    /* [Previous CSS remains unchanged] */
    .recitation-container {
        background: #f8f9fa;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .recitation-grid {
        display: grid;
        gap: 10px;
        padding: 5px;
    }

    .recitation-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .card-header:hover {
        cursor: pointer;
    }

    .card-header {
        padding: 15px;
        background: linear-gradient(135deg, #024388, #d0e7ec);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.2rem;
    }

    .card-body {
        padding: 15px;
    }

    .progress-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .progress-circle {
        position: relative;
        width: 80px;
        height: 80px;
    }

    .progress-ring {
        transform: rotate(-90deg);
    }

    .progress-ring__background {
        fill: none;
        stroke: #e9ecef;
        stroke-width: 8;
    }

    .progress-ring__circle {
        fill: none;
        stroke-width: 8;
        stroke-linecap: round;
        stroke-dasharray: 0 226.2;
        transition: stroke-dasharray 0.35s;
    }

    .percentage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    .verse-detail {
        padding: 10px;
        border-radius: 8px;
        margin: 5px 0;
        color: white;
    }

    .verse-range {
        display: flex;
        justify-content: space-evenly;
        margin-bottom: 5px;
    }

    .verse-stats {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .delete-btn,
    .delete-btn-sm {
        background: #dc3545;
        border: none;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .delete-btn:hover,
    .delete-btn-sm:hover {
        background: #c82333;
    }

    .rating {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .auto-scroll {
        overflow-y: scroll;
        max-height: 50vh;
    }
</style>
