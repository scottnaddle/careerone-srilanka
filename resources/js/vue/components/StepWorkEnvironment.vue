<template>
    <div class="bg-white rounded-xl p-4 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-1 text-center">{{ $t('Preferred Work Environment') }}</h2>
        <p class="text-gray-500 text-sm mb-8 text-center">{{ $t('Select your preferred work conditions') }}</p>

        <!-- Work Type -->
        <div class="mb-6 relative">
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $t('Work Type') }}</label>
            <div class="border border-gray-300 rounded-lg overflow-hidden">
                <button
                    @click="toggleWorkType"
                    class="w-full flex items-center justify-between px-4 py-3 text-sm bg-white hover:bg-gray-50 focus:outline-none"
                >
                    <span :class="localData.work_type ? 'text-gray-900 font-medium' : 'text-gray-500'">
                        {{ localData.work_type || $t('Select your Work Type') }}
                    </span>
                    <svg :class="['w-4 h-4 text-gray-400 transition-transform', showWorkType ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div v-if="showWorkType" class="border-t border-gray-200">
                    <div
                        v-for="opt in workTypeOptions"
                        :key="opt"
                        @click="selectWorkType(opt)"
                        class="flex items-center justify-between px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors"
                    >
                        <span :class="['text-sm', localData.work_type === opt ? 'text-[#4984F6] font-medium' : 'text-gray-700']">{{ opt }}</span>
                        <div :class="[
                            'w-4 h-4 rounded-full border-2 flex items-center justify-center',
                            localData.work_type === opt ? 'border-[#4984F6]' : 'border-gray-300'
                        ]">
                            <div v-if="localData.work_type === opt" class="w-2 h-2 rounded-full bg-[#4984F6]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Work Mode -->
        <div class="mb-8 relative">
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $t('Work Mode') }}</label>
            <div class="border border-gray-300 rounded-lg overflow-hidden">
                <button
                    @click="toggleWorkMode"
                    class="w-full flex items-center justify-between px-4 py-3 text-sm bg-white hover:bg-gray-50 focus:outline-none"
                >
                    <span :class="localData.work_mode ? 'text-gray-900 font-medium' : 'text-gray-500'">
                        {{ localData.work_mode || $t('Select your Work Mode') }}
                    </span>
                    <svg :class="['w-4 h-4 text-gray-400 transition-transform', showWorkMode ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div v-if="showWorkMode" class="border-t border-gray-200">
                    <div
                        v-for="opt in workModeOptions"
                        :key="opt"
                        @click="selectWorkMode(opt)"
                        class="flex items-center justify-between px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors"
                    >
                        <span :class="['text-sm', localData.work_mode === opt ? 'text-[#4984F6] font-medium' : 'text-gray-700']">{{ opt }}</span>
                        <div :class="[
                            'w-4 h-4 rounded-full border-2 flex items-center justify-center',
                            localData.work_mode === opt ? 'border-[#4984F6]' : 'border-gray-300'
                        ]">
                            <div v-if="localData.work_mode === opt" class="w-2 h-2 rounded-full bg-[#4984F6]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-gray-200 my-8" />
        <!-- Navigation -->
        <div class="flex gap-3 justify-end">
            <button @click="$emit('previous')" class="text-center bg-blue-50 text-[#4984F6] py-2 px-4 rounded-lg font-medium hover:bg-blue-100 transition-colors">
                {{ $t('Previous') }}
            </button>
            <button @click="handleNext" class="text-center bg-[#4984F6] text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                {{ $t('Next') }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        portfolio: { type: Object, required: true }
    },

    data() {
        const ci = this.portfolio.career_interests || {};
        return {
            showWorkType: false,
            showWorkMode: false,
            localData: {
                work_type: ci.work_type || '',
                work_mode: ci.work_mode || ''
            },
            workTypeOptions: ['All', 'Full-time', 'Part-time', 'Hybrid'],
            workModeOptions: ['All', 'Onsite', 'Remote']
        };
    },

    methods: {
        toggleWorkType() { 
            this.showWorkType = !this.showWorkType;
            if(this.showWorkType) this.showWorkMode = false;
        },
        toggleWorkMode() { 
            this.showWorkMode = !this.showWorkMode;
            if(this.showWorkMode) this.showWorkType = false;
        },
        selectWorkType(opt) {
            this.localData.work_type = opt;
            this.showWorkType = false;
        },
        selectWorkMode(opt) {
            this.localData.work_mode = opt;
            this.showWorkMode = false;
        },
        handleNext() {
            const ci = { ...(this.portfolio.career_interests || {}), ...this.localData };
            this.$emit('update', { career_interests: ci });
            this.$emit('next');
        }
    }
};
</script>
