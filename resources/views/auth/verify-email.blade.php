<x-app-layout>
  <div class="w-[400px] mx-auto py-32">
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-gray-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>
    <div class="flex p-5">
        <form action="{{ route('verification.send') }}" method="post">
      @csrf
      <div>
        <x-button>{{ __('Resend Verification Email') }}</x-button>
        </div> 
        </form>
        <form class="pl-10" action="{{ route('logout') }}" method="post">
                @csrf
                <div>
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Log Out') }}
                </button>
                </div>
        </form>
    </div>
  </div>
</x-app-layout>
