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
                                        {{-- <div class="col-md-2 col-sm-12  ">
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
                                        </div> --}}

                                        <div class="col-md-12 col-sm-12 p-0">
                                            <div class="recitation-container" style="max-height: 70vh; overflow-y: auto;">
                                                <div class="recitation-grid">
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
                                                        <div class="recitation-card">
                                                            <div class="card-header">
                                                                <h3>{{ $recitation['surah']->name }}</h3>
                                                                {{-- <button type="button" class="delete-btn" 
                                                                    onclick="deleteRecitations(this,'{{ $recitation['surah']->id }}','{{ $student->id }}','{{ $lesson->id }}');">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button> --}}
                                                            </div>

                                                            <div class="card-body auto-scroll p-1">
                                                                <div class="row col-12">
                                                                    <div
                                                                        class="col d-flex justify-content-between align-items-center">
                                                                        <div class="progress-circle">
                                                                            <svg class="progress-ring w-100 h-100">
                                                                                <circle class="progress-ring__background"
                                                                                    cx="40" cy="40" r="36" />
                                                                                <circle
                                                                                    class="progress-ring__circle bg-{{ $strokeColor }}"
                                                                                    cx="40" cy="40" r="36"
                                                                                    style="stroke: {{ $strokeColor }}; stroke-dasharray: {{ 226.2 * ($recitationPercenter / 100) }} 226.2;" />
                                                                            </svg>
                                                                            <span
                                                                                class="percentage">{{ number_format($recitationPercenter, 1) }}%</span>
                                                                        </div>
                                                                        <div
                                                                            class="col d-flex justify-content-evenly align-items-center">
                                                                            <table
                                                                                class="table table-sm align-middle text-center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            التقييم الشامل : 4 <i class="fa-solid fa-star text-warning"></i>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            تبقى 200 آية
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @foreach ($recitations as $rec)
                                                                    @set($rowColor = 'info')
                                                                    @foreach ($rec as $recKey => $surahRecitations)
                                                                        @if ($surahRecitations->surah_id == $recitation['surah']->id)
                                                                            <div class="verse-detail bg-{{ $rowColor }}">
                                                                                <div class="verse-range">
                                                                                    <span>من آيه: <button class="btn">
                                                                                            {{ $surahRecitations->from_verse }}</button></span>
                                                                                    <span>إلى آيه:<button class="btn">
                                                                                            {{ $surahRecitations->to_verse }}</button></span>

                                                                                    <span class="rating">
                                                                                        <i
                                                                                            class="fa-solid fa-star text-warning"></i>
                                                                                        {{ round($surahRecitations->rate) }}
                                                                                    </span>
                                                                                    <button type="button"
                                                                                        class="delete-btn-sm"
                                                                                        onclick="deleteRecitationsById(this,'{{ $surahRecitations->id }}','{{ $student->id }}','{{ $lesson->id }}');">
                                                                                        <i class="fa-solid fa-xmark"></i>
                                                                                    </button>
                                                                                </div>
                                                                         
                                                                                <p> ملاحظات التسميع :
                                                                                    تمسيع جميل
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

    .recitation-card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        padding: 15px;
        background: linear-gradient(135deg, #007bff, #00b4db);
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
