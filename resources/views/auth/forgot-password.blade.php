<x-app-layout>

<form action="{{ route('password.email') }}" method="post" class="w-[400px] mx-auto p-6 my-16">
@csrf
        <h2 class="text-2xl font-semibold text-center mb-5">
          Enter your Email to reset password 
        </h2>
        <p class="text-center text-gray-500 mb-6">
          or
          <a
            href="{{ route('login') }}"
            class="text-yellow-600 hover:text-yellow-500"
            >login with existing account</a
          >
        </p>
        <div class="mb-3">
        <x-input
            id="loginEmail"
            type="email"
            name="email"
            placeholder="Your email address"
            required
          />
        </div>
        <button
          class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
        >
          Submit
        </button>
      </form>


   
</x-app-layout>
