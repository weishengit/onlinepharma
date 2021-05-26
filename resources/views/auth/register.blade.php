@extends('layouts.login')

@section('style')

@endsection

@section('content')
<section class="flex flex-col items-center h-screen md:flex-row ">
    <div class="hidden w-full h-screen bg-white lg:block md:w-1/3 lg:w-2/3">
         <img src="{{ asset('images/bg_1.jpg') }}"
            alt="" class="object-cover w-full h-full">
    </div>
    <div class="flex items-center justify-center w-full h-screen px-6 bg-white md:max-w-md lg:max-w-full md:mx-auto md:w-1/2 xl:w-1/3 lg:px-16 xl:px-12">
        <div class="w-full h-100">
            <h1 class="mt-12 text-2xl font-semibold text-black tracking-ringtighter sm:text-3xl title-font">Register your
                account</h1>
            {{-- Message --}}
            @if (session()->has('message'))
            <div class="p-10 flex flex-col space-y-3">
                <div class="bg-blue-100 p-5 w-full sm:w-1/2 border-l-4 border-blue-500">
                    <div class="flex space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            class="flex-none fill-current text-blue-500 h-4 w-4">
                            <path
                                d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
                            </svg>
                        <div class="flex-1 leading-tight text-sm text-blue-700">{{ session()->get('message') }}</div>
                    </div>
                </div>
            </div>
            @endif
            {{-- Error --}}
            @if ($errors->any())
            <div class="mt-10 pl-2 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>* {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="mt-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">
                        Username</label>
                    <input type="text" name="name" id="" placeholder="Your Username "
                        class="w-full px-4 py-2 mt-2 text-base text-black transition duration-500 ease-in-out transform bg-gray-100 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        autofocus autocomplete required>
                </div>
                <div>
                    <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">Email
                        Address</label>
                    <input type="email" name="email" id="" placeholder="Your Email "
                        class="w-full px-4 py-2 mt-2 text-base text-black transition duration-500 ease-in-out transform bg-gray-100 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        autofocus autocomplete required>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">Password</label>
                    <input type="password" name="password" id="" placeholder="Your Password"
                        class="w-full px-4 py-2 text-base text-black transition duration-500 ease-in-out transform bg-gray-100 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        required>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="" placeholder="Your Password"
                        class="w-full px-4 py-2 text-base text-black transition duration-500 ease-in-out transform bg-gray-100 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        required>
                </div>
                <div class="mt-4">
                    <input type="checkbox" id="terms" name="terms" value="1">
                    <label for="terms">I have read <a href="https://www.termsandcondiitionssample.com/live.php?token=TCUlrbrerMPL7GTqfrN4eDDghJLBm52J"><span class="text-blue-500">terms and conditions</span></a></label>
                    <br>
                    <input type="checkbox" id="privacy-checkbox" name="privacy" value="1">
                    <label for="privacy">I accept the <a href="https://www.privacypolicies.com/live/b01165fa-fed1-4589-b7f0-93dccdfa1571"><span class="text-blue-500">privacy policy</span></a></label>
                </div>
                <button type="submit" class="block w-full px-4 py-3 mt-6 font-semibold text-white transition duration-500 ease-in-out transform bg-black rounded-lg hover:bg-gray-800 hover:to-black focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ">Register</button>
            </form>
            <hr class="w-full my-6 border-gray-300">
            <p class="mt-8 text-center">Already registered? <a href="{{ route('login') }}"
                    class="font-semibold text-blue-500 hover:text-blue-700">Login</a></p>
        </div>
    </div>
</section>
@endsection
