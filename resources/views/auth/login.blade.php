<x-guest-layout>
    <style>
        html,
        body {
            font-family: sans-serif !important;
        }
    </style>

    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" dir="rtl">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('إسم المستخدم')" class="text-right" />
            <x-text-input id="email" class="block mt-1 w-full text-right" type="text" name="user_name"
                :value="old('email')" required autofocus autocomplete="username" />
         </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" class="text-right" />
            <x-text-input id="password" class="block mt-1 w-full text-right" type="password" name="password" required
                autocomplete="current-password" />
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
        <!-- Remember Me -->
        <div class="block mt-4 text-right">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="me-2 text-sm text-gray-600 dark:text-gray-400">{{ __('generic.Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-start mt-4">
            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}
            <div class="col-12" style="width:100%;display:flex;justify-content: center;">
                <x-primary-button class="me-3 col-4" style='padding:10px;font-size:25px;    letter-spacing: normal;'>
                    {{ __('generic.Log in') }}
                </x-primary-button>
            </div>

        </div>
    </form>
</x-guest-layout>
