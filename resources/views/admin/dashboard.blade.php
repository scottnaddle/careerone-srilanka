@extends('admin.layouts.master')
@section('title', 'Admin System - Dashboard')
@section('content')
    <div class="pl-5 sm:ml-96 flex flex-col gap-6">
        <div>
            <span class="text-lg text-black font-semibold mr-4">Weekly Task</span>
            <span class="bg-primary text-white text-base font-medium me-2 px-2.5 py-1 rounded-2xl dark:bg-blue-900 dark:text-blue-300 font-semibold">19/68</span>
        </div>
        <div class="bg-primary grid grid-cols-6 divide-x divide-white px-2 py-8 rounded-xl">
            <div class="flex flex-col gap-1 text-white px-8">
                <span class="text-3xl font-bold">200</span>
                <span>cgo.Approval Per 1000</span>
            </div>
            <div class="flex flex-col gap-1 text-white px-8">
                <span class="text-3xl font-bold">200</span>
                <span>cgo.Approval Per 1000</span>
            </div>
            <div class="flex flex-col gap-1 text-white px-8">
                <span class="text-3xl font-bold">200</span>
                <span>cgo.Approval Per 1000</span>
            </div>
            <div class="flex flex-col gap-1 text-white px-8">
                <span class="text-3xl font-bold">200</span>
                <span>cgo.Approval Per 1000</span>
            </div>
            <div class="flex flex-col gap-1 text-white px-8">
                <span class="text-3xl font-bold">200</span>
                <span>cgo.Approval Per 1000</span>
            </div>
            <div class="flex flex-col gap-1 text-white px-8">
                <span class="text-3xl font-bold">200</span>
                <span>cgo.Approval Per 1000</span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-4 bg-white p-3">
                <div class="flex justify-between">
                    <span class="text-xl text-blue-500 flex justify-center items-center"><div class="mr-2 w-1 h-4 bg-blue-500" ></div>Member Registration</span>
                    <span>
                        <a href="" class="flex gap-2 text-[#91919A]">View more
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-base text-primary uppercase bg-gray-50 dark:bg-[#1E1E1E] dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Product name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Color
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Apple MacBook Pro 17"
                            </th>
                            <td class="px-6 py-4">
                                Silver
                            </td>
                            <td class="px-6 py-4">
                                Laptop
                            </td>
                            <td class="px-6 py-4">
                                $2999
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Microsoft Surface Pro
                            </th>
                            <td class="px-6 py-4">
                                White
                            </td>
                            <td class="px-6 py-4">
                                Laptop PC
                            </td>
                            <td class="px-6 py-4">
                                $1999
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Magic Mouse 2
                            </th>
                            <td class="px-6 py-4">
                                Black
                            </td>
                            <td class="px-6 py-4">
                                Accessories
                            </td>
                            <td class="px-6 py-4">
                                $99
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
