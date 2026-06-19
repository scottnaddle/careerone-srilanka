<template>
    <div class="relative w-full">
        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
        </div>
        <input
            ref="inputRef"
            type="text"
            :class="['block p-2.5 w-full rounded-lg border-gray-300 bg-white shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm', inputClass]"
            style="padding-left: 2.75rem !important;"
            :placeholder="placeholder"
            :disabled="disabled"
            :required="required"
        >
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'date', // 'date' or 'month'
        validator: (value) => ['date', 'month'].includes(value)
    },
    placeholder: {
        type: String,
        default: 'Select date'
    },
    inputClass: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:modelValue']);

const inputRef = ref(null);
let datepicker = null;

onMounted(() => {
    if (inputRef.value && window.Datepicker) {
        const format = props.type === 'month' ? 'yyyy-mm' : 'yyyy-mm-dd';
        const pickLevel = props.type === 'month' ? 1 : 0;
        
        // Initialize flowbite-datepicker
        datepicker = new window.Datepicker(inputRef.value, {
            format: format,
            pickLevel: pickLevel,
            autohide: true,
            clearBtn: true,
            todayBtn: props.type === 'date',
        });

        // Set initial value
        if (props.modelValue) {
            datepicker.setDate(props.modelValue);
        }

        // Listen for datepicker changes
        inputRef.value.addEventListener('changeDate', (e) => {
            // flowbite datepicker might fire changeDate with empty when cleared
            emit('update:modelValue', inputRef.value.value);
        });

        // Fallback for manual typing or clearing
        inputRef.value.addEventListener('change', (e) => {
             emit('update:modelValue', e.target.value);
        });
    }
});

// Watch for external model changes (e.g. form reset or props changing)
watch(() => props.modelValue, (newVal) => {
    if (datepicker) {
        // Only update if it's actually different to avoid circular updates
        if (newVal !== inputRef.value.value) {
            if (newVal) {
                datepicker.setDate(newVal);
            } else {
                inputRef.value.value = '';
            }
        }
    }
});

onBeforeUnmount(() => {
    if (datepicker) {
        datepicker.destroy();
    }
});
</script>
