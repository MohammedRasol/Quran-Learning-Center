@extends('layouts.admin')

@section('app-main')
    <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">تعديل معلومات الشيخ : <u><strong
                                    class="text-success">{{ $shaikh->name . ' ' . $shaikh->last_name . ' ' . $shaikh->family_name }}</strong></u>
                        </h3>
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
                                <h5 class="card-title">معلومات الشيخ
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </h5>
                            </div>

                            <!-- Card Body with Form -->
                            <form method="POST" enctype="multipart/form-data" action="/shaikh/{{ $shaikh->id }}"
                                autocomplete="off">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- First Name -->
                                        <div class="col-md-4">
                                            <label for="name" class="form-label">الإسم الأول</label>
                                            <input type="text" class="form-control" id="name" spellcheck="false"
                                                autocomplete="one-time-code" required name="name"
                                                value="{{ $shaikh->name }}" required>
                                            @error('name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-4">
                                            <label for="last-name" class="form-label">الإسم الأخير</label>
                                            <input type="text" class="form-control" id="last-name"
                                                autocomplete="one-time-code" name="last_name"
                                                value="{{ $shaikh->last_name }}">
                                            @error('last_name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Family Name -->
                                        <div class="col-md-4">
                                            <label for="family-name" class="form-label">إسم العائلة</label>
                                            <input type="text" class="form-control" id="family-name"
                                                autocomplete="one-time-code" name="family_name"
                                                value="{{ $shaikh->family_name }}">
                                            @error('family_name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="family-name" class="form-label">مسؤول عن : </label>
                                            <div class="alert alert-info d-flex">
                                                <div>{{ $shaikh->classroom?$shaikh->classroom->name:'لا يوجد غرف صفية مرتبطة'}}</div>
                                                <div>{{ $shaikh->classroom?$shaikh->classroom->start_date:''}}</div>
                                            </div>
                                        </div>


                                        <!-- Profile Image -->
                                        <div class="col-md-12">
                                            <div class="col-md-3 col-sm-12">
                                                <label for="fileInput" class="form-label">صورة الملف الشخصي</label>
                                                <div class="dropzone p-5 border border-dashed text-center" id="dropzone">
                                                    <input type="file" class="form-control d-none" id="fileInput"
                                                        accept="image/*" name="image">
                                                    <p class="mb-0">إسحب الصورة إلى هنا أو قم بالنقر لتصفح الصور</p>
                                                    <img id="preview" class="mt-3 img-fluid" width="200"
                                                        src="{{ asset('storage/' . $shaikh->image) }}" height="200"
                                                        style="max-height: 200px;" alt="Preview">
                                                </div>
                                            </div>
                                            @error('image')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer ">
                                    <div class=" col-md-2 col-sm-12 ">
                                        <button class="btn btn-success w-100" type="submit">تعديل معلومات الشيخ</button>
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
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');

        dropzone.addEventListener('click', () => fileInput.click());
        dropzone.addEventListener('dragover', (e) => e.preventDefault());
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            showPreview();
        });

        fileInput.addEventListener('change', showPreview);

        function showPreview() {
            const file = fileInput.files[0];
            if (file && file.type.startsWith('image/')) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            }
        }
    </script>
@endsection
