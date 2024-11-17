<x-guest-layout>
    <!-- Back to Home Button -->
    <div class="mb-6 text-center">
        <a href="{{ route('welcome') }}"
            class="btn btn-outline btn-primary dark:btn-secondary shadow-md hover:scale-105 transform transition-transform">
            ← Back to Home Page
        </a>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto">
        @csrf

        <h2 class="text-2xl font-bold text-center text-primary dark:text-primary-content mb-6">
            {{ __('Log In to Your Account') }}
        </h2>

        <!-- Login Address -->
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="login" id="login"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                value="{{ old('login') }}" required autofocus autocomplete="username" placeholder=" " />
            <label for="login"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Login</label>
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative z-0 w-full mb-5 group">
            <input type="password" name="password" id="password"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                required autocomplete="current-password" placeholder=" " />
            <label for="password"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Password</label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="form-control mb-4">
            <label for="remember_me" class="label cursor-pointer">
                <span class="label-text text-gray-600 dark:text-gray-200">{{ __('Remember me') }}</span>
                <input type="checkbox" id="remember_me" name="remember"
                    class="checkbox checkbox-primary dark:checkbox-secondary ml-2" />
            </label>
        </div>

        <!-- Forgot Password -->
        <div class="mb-6 text-right">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link link-primary dark:link-secondary text-sm">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="form-control">
            <button type="submit" class="btn btn-primary dark:btn-secondary w-full">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    <!-- Footer -->
    <footer class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Your App Name') }}. All rights reserved.</p>
    </footer>
</x-guest-layout>
