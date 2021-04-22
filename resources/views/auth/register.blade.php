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
                    <input type="password" name="password" id="" placeholder="Your Password" minlength="6"
                        class="w-full px-4 py-2 text-base text-black transition duration-500 ease-in-out transform bg-gray-100 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        required>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium leading-relaxed tracking-tighter text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="" placeholder="Your Password" minlength="6"
                        class="w-full px-4 py-2 text-base text-black transition duration-500 ease-in-out transform bg-gray-100 border-transparent rounded-lg focus:border-gray-500 focus:bg-white focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 "
                        required>
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
