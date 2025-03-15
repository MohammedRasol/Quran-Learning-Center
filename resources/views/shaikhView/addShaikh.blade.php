@extends('layouts.admin')

@section('app-main')
    <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">إضافة شيخ جديد</h3>
                    </div>
                </div>
            </div>
        </div>
        {{-- @if ($errors->all())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
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
                            <form method="POST" enctype="multipart/form-data" action="/shaikh" autocomplete="off">
                                @csrf
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- First Name -->
                                        <div class="col-md-4">
                                            <label for="name" class="form-label">الإسم الأول</label>
                                            <input type="text" class="form-control" id="name" spellcheck="false"
                                                autocomplete="one-time-code" required name="name"
                                                value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-4">
                                            <label for="last-name" class="form-label">الإسم الأخير</label>
                                            <input type="text" class="form-control" id="last-name"
                                                autocomplete="one-time-code" name="last_name"
                                                value="{{ old('last_name') }}">
                                            @error('last_name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Family Name -->
                                        <div class="col-md-4">
                                            <label for="family-name" class="form-label">إسم العائلة</label>
                                            <input type="text" class="form-control" id="family-name"
                                                autocomplete="one-time-code" name="family_name"
                                                value="{{ old('family_name') }}">
                                            @error('family_name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Username -->
                                        {{-- <div class="col-md-4">
                                            <label for="user-name" class="form-label">
                                                إسم المستخدم <small class="text-muted">(تسجيل الدخول من خلاله)</small>
                                            </label>
                                            <div class="input-group">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="generateUserName(1)">إنشاء</button>
                                                <input type="text" class="form-control" id="user-name"
                                                    autocomplete="one-time-code" name="user_name"
                                                    value="{{ old('user_name') }}" required>
                                            </div>
                                            @error('user_name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        <!-- Password -->
                                        <div class="col-md-4">

                                            <label for="password" class="form-label">كلمة المرور</label>

                                            <input type="password" class="form-control" id="password" name="password"
                                                autocomplete="one-time-code" required>
                                            @error('password')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Password Confirmation -->
                                        <div class="col-md-4">
                                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                            <input type="password" class="form-control" id="password_confirmation" required
                                                autocomplete="one-time-code" name="password_confirmation">
                                        </div>

                                        <!-- Profile Image -->
                                        <div class="col-md-12">
                                            <div class="col-md-3 col-sm-12">
                                                <label for="fileInput" class="form-label">صورة الملف الشخصي</label>
                                                <div class="dropzone p-5 border border-dashed text-center" id="dropzone">
                                                    <input type="file" class="form-control d-none" id="fileInput"
                                                        accept="image/*" name="image">
                                                    <p class="mb-0">إسحب الصورة إلى هنا أو قم بالنقر لتصفح الصور</p>
                                                    <img id="preview" class="mt-3 img-fluid d-none" width="200"
                                                        height="200" style="max-height: 200px;" alt="Preview">
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
                                        <button class="btn btn-success w-100" type="submit">إضافة الشيخ</button>
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
