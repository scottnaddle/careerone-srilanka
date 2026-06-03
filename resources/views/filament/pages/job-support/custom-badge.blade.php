@props(['status', 'label'])

<div class="flex gap-y-2 flex-col">
    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="data.roles">
        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
            {{ $label }}
        </span>
    </label>
    @if ($status === 1)
       <span style='font-size:14px;color: #4984F6; background-color: #F2F9FF; padding: 0.2rem 0.4rem; border-radius: 0.25rem;font-weight:600;width:fit-content;'>Progress</span>
    @else
        <span style='font-size:14px;color: #F34550; background-color: #FFF0F0; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600;width:fit-content;'>Close</span>
    @endif

</div>
