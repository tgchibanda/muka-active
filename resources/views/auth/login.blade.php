<x-app-layout>  
<form action="{{ route('login') }}" method="post" class="w-[400px] mx-auto p-6 my-16">
@csrf
        <h2 class="text-2xl font-semibold text-center mb-5">
          Login to your account
        </h2>
        <p class="text-center text-gray-500 mb-6">
          or
          <a
            href="{{ route('register') }}"
            class="text-sm text-yellow-700 hover:text-yellow-600"
            >create new account</a
          >
        </p>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        <div class="mb-4">
          <x-input
            id="loginEmail"
            type="email"
            :value="old('email')"
            :errors="$errors"
            name="email"
            placeholder="Your email address"
            required autofocus autocomplete="username" 
          />
        </div>
        <div class="mb-4">
          <x-input
            id="loginPassword"
            type="password"
            name="password"
            placeholder="Your password"
          />
          
        </div>

        <div class="flex justify-between items-center mb-5">
          <div class="flex items-center">
            <input
              id="loginRememberMe"
              name="remember"
              type="checkbox"
              class="mr-3 rounded border-gray-300 text-yellow-500 focus:ring-yellow-500"
            />
            <label for="loginRememberMe">Remember Me</label>
          </div>
          <a href="{{ route('password.request') }}" class="text-sm text-yellow-700 hover:text-yellow-600">Forgot Password?</a>
        </div>
        <button
          class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
        >
          Login
        </button>
      </form>
</x-app-layout>
