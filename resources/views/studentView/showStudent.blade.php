@extends('layouts.admin')

@section('app-main')
    <main class="app-main">
        <!-- App Content Header -->

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
                            <div class="card-header col-12 row text-info ">
                                <div class="col-sm-12 col-md-4 h4 text-success  text-md-start text-center">
                                    @if (session('success'))
                                        {{ session('success') }}
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-4 h4 text-center ">
                                    معلومات الطالب
                                </div>
                            </div>

                            <!-- Card Body with Form -->
                            <form method="POST" enctype="multipart/form-data" action="/student/{{ $student->id }}"
                                autocomplete="off" id="form">
                                @method('put')

                                @csrf
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- First Name -->
                                        <div class="col-md-4">
                                            <label for="name" class="form-label">الإسم الأول</label>
                                            <input type="text" class="form-control" id="name" spellcheck="false"
                                                autocomplete="one-time-code" name="name" value="{{ $student->name }}"
                                                required>
                                            @error('name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-4">
                                            <label for="last-name" class="form-label">الإسم الأخير</label>
                                            <input type="text" class="form-control" id="last-name"
                                                autocomplete="one-time-code" name="last_name"
                                                value="{{ $student->last_name }}">
                                            @error('last_name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Family Name -->
                                        <div class="col-md-4">
                                            <label for="family-name" class="form-label">إسم العائلة</label>
                                            <input type="text" class="form-control" id="family-name"
                                                autocomplete="one-time-code" name="family_name"
                                                value="{{ $student->family_name }}">
                                            @error('family_name')
                                                <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone" class="form-label">رقم هاتف ولي الأمر</label>
                                            <input type="text" class="form-control " id="phone" dir="ltr"
                                                style="text-align:right;" autocomplete="one-time-code" name="phone"
                                                value="{{ $student->phone }}" placeholder="مثال: 0791234567">
                                            <div id="phone-error" class="alert alert-danger h-20" style="display: none;">
                                            </div>
                                            @error('phone')
                                                <div class="alert alert-danger h-20">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">تاريخ الميلاد</label>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="number" class="form-control" id="birth_day"
                                                        style="text-align:right;" name="birth_day" placeholder="اليوم"
                                                        min="1" max="31"
                                                        onchange="validateDate('birth_day','birth_month','birth_year','date-error' )"
                                                        spellcheck="false" autocomplete="one-time-code" required
                                                        value="{{ $student->birth_day }}">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" id="birth_month"
                                                        style="text-align:right;" name="birth_month" placeholder="الشهر"
                                                        min="1" max="12"
                                                        onchange="validateDate('birth_day','birth_month','birth_year','date-error' )"
                                                        spellcheck="false" autocomplete="one-time-code" required
                                                        value="{{ $student->birth_month }}">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" id="birth_year"
                                                        style="text-align:right;" name="birth_year" placeholder="السنة"
                                                        min="1900"
                                                        onchange="validateDate('birth_day','birth_month','birth_year','date-error' )"
                                                        max="{{ date('Y') }}" spellcheck="false"
                                                        autocomplete="one-time-code" required
                                                        value="{{ $student->birth_year }}">
                                                </div>
                                            </div>
                                            <div id="date-error" class="alert alert-info h-20" style="display: none;">
                                            </div>
                                            @error('birth_day')
                                                <div class="alert alert-info h-20">{{ $message }}</div>
                                            @enderror
                                            @error('birth_month')
                                                <div class="alert alert-info h-20">{{ $message }}</div>
                                            @enderror
                                            @error('birth_year')
                                                <div class="alert alert-info h-20">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4">

                                            <label class="form-label">تاريخ الإنضمام لمركز القران</label>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="number" class="form-control" id="join_day"
                                                        style="text-align:right;" name="join_day" placeholder="اليوم"
                                                        min="1"
                                                        onchange="validateDate('join_day','join_month','join_year','join-date-error' )"
                                                        max="31" spellcheck="false" autocomplete="one-time-code"
                                                        required value="{{ $student->join_day }}">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" id="join_month"
                                                        style="text-align:right;" name="join_month" placeholder="الشهر"
                                                        min="1" max="12"
                                                        onchange="validateDate('join_day','join_month','join_year','join-date-error' )"
                                                        spellcheck="false" autocomplete="one-time-code" required
                                                        value="{{ $student->join_month }}">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" id="join_year"
                                                        style="text-align:right;" name="join_year" placeholder="السنة"
                                                        min="1990" max="{{ date('Y') }}"
                                                        onchange="validateDate('join_day','join_month','join_year','join-date-error' )"
                                                        spellcheck="false" autocomplete="one-time-code" required
                                                        value="{{ $student->join_year }}">
                                                </div>
                                            </div>
                                            <div id="join-date-error" class="alert alert-info h-20"
                                                style="display: none;">
                                            </div>
                                            @error('join_day')
                                                <div class="alert alert-info h-20">{{ $message }}</div>
                                            @enderror
                                            @error('join_month')
                                                <div class="alert alert-info h-20">{{ $message }}</div>
                                            @enderror
                                            @error('join_year')
                                                <div class="alert alert-info h-20">{{ $message }}</div>
                                            @enderror
                                        </div>



                                        <div class="col-md-4">
                                            <label for="classroom" class="form-label">الصف </label>
                                            <select class="form-select " name="classroom">
                                                <option value="">الصف</option>
                                                @foreach ($classrooms as $classroom)
                                                    <option value='{{ $classroom->id }}'
                                                        {{ $student->classroom ? ($student->classroom == $classroom->id ? 'selected' : '') : '' }}>
                                                        {{ $classroom->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom')
                                                <div class="alert alert-danger h-20">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-sm-12 d-flex justify-content-center">
                                            <div class="col-md-6 col-sm-12">
                                                <label for="fileInput" class="form-label">صورة الملف الشخصي</label>
                                                <div class="dropzone p-2 border border-dashed text-center" id="dropzone">
                                                    <input type="file" class="form-control d-none" id="fileInput"
                                                        accept="image/*" name="image">
                                                    <p class="mb-0">إسحب الصورة إلى هنا أو قم بالنقر لتصفح الصور</p>
                                                    <img id="preview" class="mt-3 img-fluid  " width="200"
                                                        src="{{ asset('storage/' . $student->image) }}" height="200"
                                                        style="max-height: 200px; object-fit: contain;" alt="Preview">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                        @error('image')
                                            <div class="alert alert-danger h-20 ">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                                <!-- Card Footer -->
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


        function validateDate(dayId, monthId, yearId, errorDiv) {

            const dayInput = document.getElementById(dayId);
            const monthInput = document.getElementById(monthId);
            const yearInput = document.getElementById(yearId);

            var errorDiv = document.getElementById(errorDiv);
            const day = parseInt(dayInput.value);
            const month = parseInt(monthInput.value);
            const year = parseInt(yearInput.value);
            let errorMessage = '';
            // Clear previous error
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';

            // Basic range validation
            if (isNaN(day) || day < 1 || day > 31) {
                errorMessage = 'اليوم يجب أن يكون بين 1 و 31';
            } else if (isNaN(month) || month < 1 || month > 12) {
                errorMessage = 'الشهر يجب أن يكون بين 1 و 12';
            } else if (isNaN(year) || year < 1900 || year > {{ date('Y') }}) {
                errorMessage = 'السنة يجب أن تكون بين 1900 و {{ date('Y') }}';
            }
            // Validate days in month
            else {
                const daysInMonth = new Date(year, month, 0).getDate();
                if (day > daysInMonth) {
                    errorMessage = `الشهر ${month} يحتوي على ${daysInMonth} يوم فقط`;
                }
            }

            // Special case for February in leap years
            if (month === 2 && day > 28) {
                const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
                if (!isLeapYear && day > 28) {
                    errorMessage = 'فبراير يحتوي على 28 يوم فقط';
                } else if (isLeapYear && day > 29) {
                    errorMessage = 'فبراير يحتوي على 29 يوم فقط في السنة الكبيسة';
                }
            }

            if (errorMessage) {
                errorDiv.textContent = errorMessage;
                errorDiv.style.display = 'block';
                return false;
            }
            return true;
        }


        const phoneInput = document.getElementById('phone');


        function validateJordanPhone() {
            var errorDiv = document.getElementById('phone-error');
            const phone = phoneInput.value.trim();
            let errorMessage = '';

            // Clear previous error
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';

            // Jordan mobile numbers pattern:
            // Starts with +9627 or 07
            // Followed by 7, 8, or 9
            // Then 7 digits
            // Total length: 10 digits (without country code) or 12/13 (with country code)
            const jordanPhoneRegex = /^(?:\+9627[789]|07[789])\d{7}$/;

            if (!phone) {
                errorMessage = 'رقم الهاتف مطلوب';
            } else if (!jordanPhoneRegex.test(phone)) {
                errorMessage = 'يرجى إدخال رقم هاتف أردني صحيح (مثال: 0791234567 أو +962791234567)';
            }

            if (errorMessage) {
                errorDiv.textContent = errorMessage;
                errorDiv.style.display = 'block';
                return false;
            }
            return true;
        }

        // Add event listeners
        phoneInput.addEventListener('input', validateJordanPhone);
        phoneInput.addEventListener('change', validateJordanPhone);

        // Form submission validation
        var form = phoneInput.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateJordanPhone()) {
                    e.preventDefault();
                }
            });
        }

        // Optional: Format input as user types
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits

            // If starts with 962, keep it, otherwise assume 0
            if (value.startsWith('9627')) {
                value = '+962' + value.slice(3);
            } else if (value.startsWith('07')) {
                // Keep as is
            } else if (value.startsWith('7')) {
                value = '07' + value.slice(1);
            }

            // Limit length
            if (value.length > 10 && !value.startsWith('+')) {
                value = value.slice(0, 10);
            } else if (value.length > 13 && value.startsWith('+')) {
                value = value.slice(0, 13);
            }

            e.target.value = value;
        });

        // Form submission validation (assuming the inputs are in a form)
        var form = document.getElementById('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateDate("birth_day", "birth_month", "birth_year") || !validateDate(
                        "join_day", "join_month", "join_year")) {
                    e.preventDefault();
                }
            });
        }
    </script>
@endsection
