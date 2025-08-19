<x-app-layout>
    <!-- Session Status -->
    <form method="POST" action="{{ route('login') }}" class="w-[400px] mx-auto p-6 my-20">
      @csrf
      <x-auth-session-status class="mb-4" :status="session('status')" />
        <h2 class="text-2xl font-semibold text-center mb-5">
          Login to your account
        </h2>
        <p class="text-center text-gray-500 mb-6">
          or
          <a
            href="{{ route('register') }}"
            class="text-sm text-purple-700 hover:text-purple-600"
            >create new account</a
          >
        </p>
        <div class="mb-4">
          {{-- <x-input-label for="email" :value="__('Email')" /> --}}
          <x-text-input id="email"
          placeholder="Your email address"
          id="loginEmail"
          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-4">
          {{-- <x-input-label for="password" :value="__(key: 'Password')" /> --}}

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Your password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-between items-center mb-5">
          <div class="flex items-center">
            {{-- <input
              id="loginRememberMe"
              type="checkbox"
              class="mr-3 rounded border-gray-300 text-purple-500 focus:ring-purple-500"
            />
            <label for="loginRememberMe">Remember Me</label> --}}
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                 class="mr-3 rounded border-gray-300 text-purple-500 focus:ring-purple-500"
                {{-- class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"  --}}
                name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>

          </div>
          @if (Route::has('password.request'))
          <a
          class="text-sm text-purple-700 hover:text-purple-600"
           {{-- class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"  --}}
           href="{{ route('password.request') }}">
              {{ __('Forgot your password?') }}
          </a>
      @endif
        </div>
        <x-primary-button>
          Login
        </x-primary-button>
      </form>

</x-app-layout>
