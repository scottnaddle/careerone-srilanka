<div class="flex flex-col items-center">
    <x-filament::button
        :color="$getColor()"
        :disabled="$isDisabled()"
        :icon="$getIcon()"
        :icon-position="$getIconPosition()"
        :size="$getSize()"
        :type="$canSubmitForm() ? 'submit' : 'button'"
{{--        :wire:click="$getAction()"--}}
        :x-on:click="$getAlpineClickHandler()"
        :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())"
    >
        {{ $getLabel() }}
    </x-filament::button>

</div>
<p class="text-sm dark:text-white text-gray-500 absolute top-12 whitespace-nowrap right-0">({{ $message }}, <a href="/admin/company-approval-detail?id={{$company_id}}" class="underline text-primary">{{trans('company.Go here')}}</a>)</p>
