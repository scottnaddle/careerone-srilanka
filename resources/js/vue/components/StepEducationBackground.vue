<template>
    <div class="bg-white rounded-xl p-8 max-w-2xl mx-auto shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $t('Education Background') }}</h2>
        <p class="text-gray-500 text-sm mb-6">{{ $t('Please review your synced education and add any other education below.') }}</p>

        <!-- NVQ Qualification -->
        <div class="mb-6">
            <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                <div class="flex flex-col gap-4 w-full h-full">
                    <div class="flex justify-between items-center">
                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('NVQ Qualification')}}</p>
                    </div>
                    <div class="flex flex-col gap-4 cursor-not-allowed">
                        <div v-if="nvqEducations.length === 0" class="text-gray-500 text-sm italic">
                            {{ $t('No synced education found.') }}
                        </div>
                        <div v-for="(education, index) in nvqEducations" :key="'nvq-' + index" class="relative group">
                            <div class="flex gap-4 items-baseline">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                        <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                    </svg>
                                </div>
                                <div class="flex flex-col gap-2 w-full">
                                    <div>
                                        <p>
                                            <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ education.qualification_name }}</span>
                                            <span class="text-[#706F81] dark:text-white" v-if="education.level"> ({{ education.level }})</span>
                                        </p>
                                        <p>
                                            <span class="text-[#91919A] dark:text-white"><span>{{ formatOriginalDate(education.effective_date) }}</span></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TVEC Education -->
        <div class="mb-8">
            <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                <div class="flex flex-col gap-4 w-full h-full">
                    <div class="flex justify-between items-center">
                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('TVEC Education')}}</p>
                    </div>
                    <div class="flex flex-col gap-4 cursor-not-allowed">
                        <div v-if="tvecEducations.length === 0" class="text-gray-500 text-sm italic">
                            {{ $t('No synced education found.') }}
                        </div>
                        <div v-for="(education, index) in tvecEducations" :key="'tvec-' + index" class="relative group">
                            <div class="flex gap-4 items-baseline">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                        <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                    </svg>
                                </div>
                                <div class="flex flex-col gap-2 w-full">
                                    <div>
                                        <p>
                                            <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ education.institute }}</span>
                                            <span class="text-[#706F81] dark:text-white" v-if="education.industry_sector"> ({{$t('Industry sector')}}: {{ education.industry_sector }})</span>
                                        </p>
                                        <p class="dark:text-white">
                                            <span class="font-semibold" v-if="education.course_name">{{$t('Course name')}}: {{ education.course_name }}</span>
                                            <span class="text-sm"> ({{ formatOriginalDate(education.from) }} - {{ formatOriginalDate(education.to) }})</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Education Form -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ $t('Other Education') }}</h3>
            
            <div v-for="(edu, index) in educations" :key="'edu-' + index" class="border border-gray-200 rounded-xl p-5 mb-4 relative bg-white shadow-sm">
                <button @click="removeEducation(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500" title="Remove">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-2">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('School Name') }} <span class="text-red-500">*</span></label>
                        <input v-model="edu.school_name" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. Royal College">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('District') }}</label>
                        <select v-model="edu.district" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">{{ $t('Select District') }}</option>
                            <option v-for="district in districts" :key="district.id" :value="district.name">
                                {{ district.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Field of Study') }}</label>
                        <input v-model="edu.field" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. Science">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Start Date') }}</label>
                        <flowbite-datepicker type="month" v-model="edu.from" placeholder="From Date"></flowbite-datepicker>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('End Date') }}</label>
                        <flowbite-datepicker type="month" v-model="edu.to" placeholder="To Date"></flowbite-datepicker>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Grade (Optional)') }}</label>
                        <input v-model="edu.results" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. A">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Description (Optional)') }}</label>
                    <textarea v-model="edu.description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe your achievements..."></textarea>
                </div>
            </div>

            <button @click="addEducation" class="w-full border border-[#4984F6] text-[#4984F6] rounded-lg py-2.5 flex items-center justify-center gap-2 hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ $t('Add Education') }}
            </button>
        </div>

        <hr class="border-gray-200 my-8" />
        <!-- Navigation -->
        <div class="flex gap-3 justify-end mt-8">
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
        portfolio: { type: Object, required: true },
        districts: { type: Array, default: () => [] }
    },

    data() {
        return {
            educations: JSON.parse(JSON.stringify(this.portfolio.educations || [])),
            nvqEducations: this.portfolio.nvq_educations || [],
            tvecEducations: this.portfolio.tvec_educations || []
        };
    },

    methods: {
        formatOriginalDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },
        addEducation() {
            this.educations.push({
                school_name: '',
                district: '',
                field: '',
                from: '',
                to: '',
                results: '',
                description: ''
            });
        },
        removeEducation(index) {
            this.educations.splice(index, 1);
        },
        handleNext() {
            const validEducations = this.educations.filter(e => e.school_name.trim() !== '');
            this.$emit('update', { educations: validEducations });
            this.$emit('next');
        }
    }
};
</script>
