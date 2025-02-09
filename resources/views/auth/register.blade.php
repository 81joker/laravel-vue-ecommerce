<x-app-layout>
    <form  method="POST" action="{{ route('register') }}" class="w-[400px] mx-auto p-6 my-20" >
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-4">Create an account</h2>
        <p class="text-center text-gray-500 mb-3">
            or
            <a href="{{ route('login') }}" class="text-sm text-purple-700 hover:text-purple-600">login with existing
                account</a>
        </p>
        <div class="mb-4">
            {{-- <x-input-label for="name" :value="__('Name')" /> --}}
            <x-text-input  :value="__('Name')" id="name" placeholder="Your name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />

        </div>
        </p>
        <div class="mb-4">
            {{-- <input placeholder="Your Email" type="email" name="email" x-model="form.email" @input="validateEmail()"
                class="border-gray-300 focus:outline-none  rounded-md w-full"
                :class="errors.email ? errorClasses : (form.email ? successClasses : defaultClasses)" />
            <small x-show="errors.email" x-text="errors.email" class="text-red-600"></small> --}}
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            <x-text-input id="email"
            placeholder="Your Email"
            class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-4">
            {{-- <input placeholder="Password" type="password" name="password" x-model="form.password"
                @input="validatePassword()" class="border-gray-300 focus:outline-none  rounded-md w-full"
                :class="errors.password ? errorClasses : (form.password ? successClasses : defaultClasses)" />
            <small x-show="errors.password" x-text="errors.password" class="text-red-600"></small> --}}
            {{-- <x-input-label for="password" :value="__('Password')" /> --}}
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        </div>
        <div class="mb-4">
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            placeholder="Repeat Password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-start mt-4  tracking-widest">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

        </div>
        <button class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full">
            Signup
        </button>
    </form>

</x-app-layout>
