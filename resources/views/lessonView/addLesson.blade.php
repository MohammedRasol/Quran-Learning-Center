@extends('layouts.admin')

@section('app-main')
    <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">إضافة الغرفة الصفية</h3>
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
                                <h5 class="card-title">معلومات الغرفة الصفية
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </h5>
                            </div>

                            <!-- Card Body with Form -->
                            <form method="POST" enctype="multipart/form-data" action="/lesson" autocomplete="off"
                                id="form">
                                @csrf
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- First Name -->
                                        <div class="col-md-4 col-sm-12  ">
                                            <label for="topic" class="form-label">موضوع الحصة</label>
                                            <input type="text" class="form-control" id="topic" spellcheck="false"
                                                autocomplete="one-time-code" required name="topic"
                                                value="{{ old('topic') }}" required>
                                            @error('topic')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-8 d-sm-block d-none  ">
                                        </div>
                                        <div class="col-md-4 col-sm-12  ">
                                            <label for="user_id" class="form-label">الشيخ المسؤول</label>
                                            <select class="form-select" name="user_id" required
                                                {{ Auth::user()->role == 2 ? 'onclick=this.blur()' : '' }}>
                                                @if (Auth::user()->role != 2)
                                                    <option value=""> الشيخ المسؤول</option>
                                                @endif
                                                @foreach ($shaikhs as $shaikh)
                                                    <option value='{{ $shaikh->id }}'
                                                        {{ Auth::user()->role == 2 && Auth::user()->id == $shaikh->id ? 'selected' : '' }}>
                                                        {{ $shaikh->name . ' ' . $shaikh->last_name . ' ' . $shaikh->family_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-8 d-sm-block d-none  ">
                                        </div>
                                        <div class="col-md-4 col-sm-12  ">
                                            <label for="name" class="form-label">الغرف الصفية</label>
                                            <select class="form-select" name="class_room[]" id='class_room' multiple
                                                onchange="checkClassRoomGroup()">
                                                <option value=""> الغرف الصفية</option>
                                                @foreach ($classrooms as $classroom)
                                                    <option value='{{ $classroom->id }}'
                                                        {{ in_array($classroom->id, old('class_room', [])) ? 'selected' : '' }}>
                                                        {{ $classroom->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('class_room')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12  ">
                                            <label for="name" class="form-label">المجموعة</label>
                                            <select class="form-select" name="group_id" id='group_id'
                                                onchange="checkClassRoomGroup()">
                                                <option value="">المجموعة</option>
                                                @foreach ($groups as $group)
                                                    <option value='{{ $group->id }}'
                                                        {{ $group->id == old('group') ? 'selected' : '' }}>
                                                        {{ $group->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('group_id')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 d-sm-block d-none  ">
                                        </div>
                                        <div class="col-md-4 col-sm-12  ">
                                            <label for="start_date" class="form-label">وقت الحصة</label>
                                            <input type="time" class="form-control" id="start_date" spellcheck="false"
                                                autocomplete="one-time-code" required name="start_date"
                                                value="{{ old('start_date') }}" required>
                                            @error('start_date')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
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
    </script>
@endsection
