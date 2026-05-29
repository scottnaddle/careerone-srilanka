<div>
    <style>
       table thead tr th span{
           color:blue;
       }
       #search-status{
           background-color: #F9FBFF;
           color: #4984F6;
           border: none;
       }
   </style>
   
   <div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
    <div class="flex items-center">
        <x-filament::breadcrumbs :breadcrumbs="[
          '/admin/overview' =>  'Admin',
          '#' =>  'Member Signup'
      ]" />
  </div>
    <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
        Member Signup
     </h1>

       <form method="get" action="{{ url()->current() }}">
        <!-- Date picker section -->
        <div class="flex gap-4 items-center mb-6">
            <!-- First Date Picker -->
            <div class="flex-1">
                <input 
                    type="date" 
                    id="datePicker1" 
                    value="{{ request()->query('startDate') }}" 
                    name="startDate" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500" 
                />
            </div>
            <div class="flex-1">
                <input 
                    type="date" 
                    id="datePicker2" 
                    value="{{ request()->query('endDate') }}" 
                    name="endDate" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500" 
                />
            </div>
            <div class="flex-3">
                <button 
                    type="submit" 
                    class="w-full px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors">
                    {{ __('admin/company.search') }}
                </button>
            </div>
        </div>
    
        <!-- Filter Section -->
        <div class="flex items-center justify-between gap-4 mt-4">
            <label for="search-status" class="text-lg font-semibold text-[#706F81]">
                @if (request()->query())
                    {{ __('admin/company.result') }}
                @endif
            </label>
            
        </div>
    </form>
    
       <div>
      
       </div>
        <x-filament-panels::page class="w-full">
   
       </x-filament-panels::page>
   </div>   
   </div>
   
   