@extends('layouts.admin')

@section('app-main')
    <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">إضافة ارشيف للطالب </h3>
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

        <div class="app-content">

            <div class="container-fluid">

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <div class="card-header">
                                <div class="card-title">الأجزاء</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                @foreach ($quranParts as $part)
                                    <div class="accordion " id="accordionExample-{{ $part[0]['part'] }}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne-{{ $part[0]['part'] }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseOne-{{ $part[0]['part'] }}">
                                                    الجزء {{ $part[0]['part'] }}
                                                </button>
                                            </h2>
                                        </div>
                                    </div>
                                    @set($count = 0)
                                    @foreach ($part as $surah)
                                        <div id="collapseOne-{{ $surah->part }}" class="accordion-collapse collapse mb-3"
                                            data-bs-parent="#accordionExample-{{ $surah->part }}">
                                            <div class="accordion-body mb-0 pb-0">
                                                @if ($count++ == 0)
                                                    <div
                                                        class="flex items-center p-3 bg-gray-50 rounded-lg shadow-sm hover:bg-gray-100 transition-colors d-flex bg-info">
                                                        <input type="checkbox" id="check-surah-{{ $surah->surah->id }}"
                                                            style="width: 25px;height:25px"
                                                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                                                        &nbsp;&nbsp;
                                                        <label for="check-surah-{{ $surah->surah->id }}"
                                                            class="ml-3 text-gray-700 font-medium cursor-pointer select-none fw-bold">
                                                            تم تسميع الجزء بالكامل
                                                        </label>
                                                    </div>
                                                @endif
                                                <div
                                                    class="flex items-center p-3 bg-gray-50 rounded-lg shadow-sm hover:bg-gray-100 transition-colors bg-   mt-2" style="background-color: rgb(218, 218, 218)">
                                                    <div class="fw-bold p-2 bg-  mb-1" style="color: rgb(46, 213, 255)">
                                                      سورة {{ $surah->surah->name }}
                                                    </div>
                                                    <div class="d-flex justify-content-between "> 
                                                                <label for="surah-{{ $surah->surah->id }}"
                                                        class="ml-3 text-gray-700 font-medium cursor-pointer select-none fw-bold">
                                                        تم تسميع السورة بالكامل
                                                    </label>
                                                    <input type="checkbox" id="surah-{{ $surah->surah->id }}"
                                                        style="width: 25px;height:25px"
                                                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                                             
                                                    </div>
                                            

                                                    <br>
                                                    <div class="d-flex justify-content-between"> 
                                                         <label for="select-surah-{{ $surah->surah->id }}"
                                                            class="ml-3 text-gray-700 font-medium cursor-pointer select-none fw-bold">
                                                            تم تسميع  إلى آية     
                                                        </label>
                                                        <select name="" id="select-surah-{{ $surah->surah->id }}" class="p-0 " style="width: 100px">
                                                            <option value=""> إلى آية</option>
                                                            @for ($i = 1; $i <= $surah->surah->total_verses; $i++)
                                                                <option value="{{ $i }}">  
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>   
                                                    </div>
                                    
                                                </div>

                                                {{-- <div class="bg-warning p-3 "> --}}

                                                {{-- <input id="surah-{{ $surah->surah->id }}"
                                                        value="{{ $surah->surah->id }}" style="width: 25px;height:25px"
                                                        onclick="$('.label').fadeIn();$('#searchInput').val('')"
                                                        part-id='part-{{ $part[0]['part'] }}'
                                                        class="part-{{ $part[0]['part'] }} w-20" type="checkbox"
                                                        onchange="changeColer(this,'{{ $surah->surah->id }}')">
                                                    <label for="surah-{{ $surah->surah->id }}"
                                                        id="surah-label-{{ $surah->surah->id }}" style="cursor: pointer"
                                                        class="label ">{{ $surah->surah->name }}</label>
                                                            <select name="" id="select-surah-{{ $surah->surah->id }}"
                                                                class="p-0 mb-2"
                                                                style="min-width:80%">
                                                                <option value=""> إلى آية</option>
                                                                @for ($i = 1; $i <= $surah->surah->total_verses; $i++)
                                                                    <option value="{{ $i }}"> إية -
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
    
                                                            </select>                --}}
                                                {{-- </div> --}}

                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <div class="row col-md-6 col-sm-12 text-md-start text-center">
                        <div class=" col-md-3 col-sm-12">
                            <button class="btn btn-success w-100" type="submit">حفظ المعلومات</button>
                        </div>
                        <div class=" col-3">
                            @if (session('success'))
                                <span class="text-success  d-md-inline d-none">
                                    {{ session('success') }}
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card card-info card-outline">
                            <div class="container  col-md-6 col-sm-12 ">
                                <div class="w-100 mt-1">
                                    <input type="text" class="form-control" id="searchInput"
                                        oninput="debouncedSearchSurah(this)" onchange="debouncedSearchSurah(this)"
                                        placeholder="البحث (بإسم / رقم) السورة">
                                </div>
                                <div class="items">
                                    @foreach ($quranParts as $part)
                                        @foreach ($part as $surah)
                                            <input id="surah-{{ $surah->surah->id }}" value="{{ $surah->surah->id }}" onclick="$('.label').fadeIn();$('#searchInput').val('')"
                                                part-id='part-{{ $part[0]['part'] }}' class="part-{{ $part[0]['part'] }}"
                                                type="checkbox">
                                            <label for="surah-{{ $surah->surah->id }}"
                                                class="label">{{ $surah->surah->name }}</label>
                                        @endforeach
                                    @endforeach

                                    <h2 class="done" aria-live="polite">تم اضافة</h2>
                                    <h2 class="undone" aria-live="polite">غير مضافة</h2>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}
    </main>
@endsection
<script>
    function selectQuranPart(partId) {
        $.ajax({
            url: `/ajax/getQuranPartSurahs/${partId}`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(data) {
                const resp = data.data;
                const surahs = document.getElementById('surahs');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Debounce function to delay execution
    function debounce(func, delay) {
        let timeoutId;
        return function(...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(this, args), delay);
        };
    }

    function changeColer(el, id) {
        if (el.checked) {
            $("#surah-label-" + id).addClass("bg-success text-light");
            $("#surah-label-" + id).removeClass("bg-warning text-light");

        } else {
            $("#surah-label-" + id).addClass("bg-warning text-light");
            $("#surah-label-" + id).removeClass("bg-success text-light");
        }

    }
</script>
