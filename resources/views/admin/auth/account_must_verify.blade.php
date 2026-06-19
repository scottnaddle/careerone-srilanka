@extends('auth.layouts.master')

@section('title', 'Sign Up')

@section('content')
    <div class="max-w-2xl mx-auto w-full leading-9 my-20 rounded-xl">
        <div class="bg-white  space-y-6  px-10 py-5 dark:bg-gray-800 ">
            <div class="flex flex-col gap-6 justify-center items-center">
                <a href="/" class="flex items-center rtl:space-x-reverse">
                    <img src="/images/TVET.svg" class="h-20" alt="TVET Logo" />
                </a>

                <p>Your account is not be verified by Admin. Please contact Admin to active you account!</p>
                <form action="{{route('admin.auth.logout')}}" method="post">
                    @csrf
                    <button type="submit"
                            class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in to another account
                    </button>
                </form>
            </div>
        </div>
</div>
@stop
