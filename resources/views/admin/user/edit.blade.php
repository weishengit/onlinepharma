@extends('layouts.admin')

@section('content')
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        {{-- Message --}}
        @if (session()->has('message'))
        <div class="p-10 flex flex-col space-y-3">
            <div class="bg-blue-100 p-5 w-full sm:w-1/2 border-l-4 border-blue-500">
              <div class="flex space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-blue-500 h-4 w-4">
                  <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" /></svg>
                <div class="flex-1 leading-tight text-sm text-blue-700">{{ session()->get('message') }}</div>
              </div>
            </div>
        </div>
        @endif
        {{-- Error --}}
        @if ($errors->any())
            <div class="w-4/5 m-auto mt-10 pl-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Title --}}
        <h1 class="border-2 flex items-center font-sans font-bold break-normal text-gray-900 px-2 py-8 text-lg md:text-2xl">
			<a 
                href="{{ route('admin.index') }}">
                <p 
                    class="text-blue-500 hover:text-blue-700 font-bold">
                    Dashboard&nbsp;
                </p>
            </a>
            /&nbsp;
            <a 
                href="{{ route('admin.user.index') }}">
                <p 
                    class="text-blue-500 hover:text-blue-700 font-bold">
                    Accounts&nbsp;
                </p>
            </a>
            /&nbsp;
            <p class="text-indigo-700">
                {{ $user->name }}
            </p>
		</h1>
        {{-- Profile --}}
        <div>
            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-5">
                <div class="border-t border-gray-200"></div>
                </div>
            </div>
        
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-2 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-3xl font-medium leading-6 text-gray-900">Account Information</h3>
                                
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-8 gap-6">
                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                            <input disabled value="{{ $user->name ?? ''}}" type="text" name="username" id="username" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                                            <input disabled value="{{ $user->first_name ?? ''}}"type="text" name="first_name" id="first_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                                            <input disabled value="{{ $user->last_name ?? ''}}" type="text" name="last_name" id="last_name" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                    
                                        <div class="col-span-6 sm:col-span-4">
                                            <label for="email_address" class="block text-sm font-medium text-gray-700">Email address</label>
                                            <input disabled value="{{ $user->email ?? ''}}" type="text" name="email_address" id="email_address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                    
                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                            <label for="contact" class="block text-sm font-medium text-gray-700">Contact number</label>
                                            <input disabled value="{{ $user->contact ?? ''}}" type="text" name="contact" id="contact" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                    
                                        <div class="col-span-6">
                                            <label for="address" class="block text-sm font-medium text-gray-700">Street address</label>
                                            <input disabled value="{{ $user->address ?? ''}}" type="text" name="address" id="address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                        
                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                            <label for="scid" class="block text-sm font-medium text-gray-700">SCID</label>
                                            <input disabled value="{{ $user->scid ?? ''}}" type="text" name="scid" id="scid" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                        
                                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                            <label for="created" class="block text-sm font-medium text-gray-700">Account Creation</label>
                                            <input disabled value="{{ $user->created_at ?? ''}}" type="text" name="created" id="created" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                        
                                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Last Updated</label>
                                            <input disabled value="{{ $user->updated_at ?? ''}}" type="text" name="postal_code" id="postal_code" autocomplete="postal-code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    @if ($user->is_active == 0)
                                        <form 
                                            action="{{ route('admin.user.unban', ['id' => $user->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                                        <label for="reason" class="text-left block text-lg font-medium text-gray-700">Reason for ban:</label>
                                                        <input disabled value="{{ $user->ban->reason }}" type="text" name="reason" id="reason" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                                        <label for="banned_by" class="text-left block text-lg font-medium text-gray-700">Banned By:</label>
                                                        <input disabled value="{{ $user->ban->banned_by }}" type="text" name="banned_by" id="banned_by" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                        <button type="submit" class="block py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            Unban
                                                        </button>
                                                    </div>
                                                </div>
                                    @else
                                        <div class="grid grid-cols-2 gap-6">
                                            <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                                                <label for="reason" class="text-left block text-lg font-medium text-gray-700">Reason for ban:</label>
                                                <input  placecholder="reason for ban..." type="text" name="reason" id="reason" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <form 
                                                    action="{{ route('admin.user.ban', ['id' => $user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="block py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Ban
                                                    </button>
                                                </form>
                                            </div>
                                            @if ($user->is_admin == 0)
                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <form 
                                                    action="{{ route('admin.make.admin', ['id' => $user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="block py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Make Admin
                                                    </button>
                                                </form>
                                            </div>
                                            @else
                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <form 
                                                    action="{{ route('admin.remove.admin', ['id' => $user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="block py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Remove Admin
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                        
                                    @endif
                                </div>
                                
                            </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Profile End --}}
        
    </div>
</div>
@endsection