<template>
    <div class="bg-white rounded-xl p-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $t('Experience') }}</h2>
        <p class="text-gray-500 text-sm mb-6">{{ $t('Please fill in the fields below') }}</p>

        <!-- OJT Experience -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $t('OJT Experience') }}</h3>

            <div v-for="(ojt, index) in ojtRows" :key="'ojt-' + index" class="border border-gray-200 rounded-xl p-5 mb-4 relative bg-gray-50 shadow-sm">
                <button @click="removeOjt(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500" title="Remove">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('OJT Title') }} <span class="text-red-500">*</span></label>
                        <input v-model="ojt.title" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. Trainee Engineer">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Company or Organisation') }} <span class="text-red-500">*</span></label>
                        <input v-model="ojt.organization" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Company Name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('District') }} <span class="text-red-500">*</span></label>
                        <select v-model="ojt.district" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">{{ $t('Select District') }}</option>
                            <option v-for="district in districts" :key="district.id" :value="district.name">
                                {{ district.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Start Date') }} <span class="text-red-500">*</span></label>
                        <flowbite-datepicker type="month" v-model="ojt.from" placeholder="From Date"></flowbite-datepicker>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('End Date') }} <span class="text-red-500">*</span></label>
                        <flowbite-datepicker type="month" v-model="ojt.to" placeholder="To Date"></flowbite-datepicker>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Skills') }}</label>
                    <input v-model="ojt.skills" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. Teamwork, Communication">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Description') }}</label>
                    <textarea v-model="ojt.description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe your responsibilities..."></textarea>
                </div>
            </div>

            <button @click="addOjt" class="w-full border border-[#4984F6] text-[#4984F6] rounded-lg py-2.5 flex items-center justify-center gap-2 hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ $t('Add OJT Experience') }}
            </button>
        </div>

        <!-- Work Experience -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $t('Work Experience') }}</h3>

            <div v-for="(exp, index) in expRows" :key="'exp-' + index" class="border border-gray-200 rounded-xl p-5 mb-4 relative bg-gray-50 shadow-sm">
                <button @click="removeExp(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500" title="Remove">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Job Title') }} <span class="text-red-500">*</span></label>
                        <input v-model="exp.job_title" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. Software Developer">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Company or Organisation') }} <span class="text-red-500">*</span></label>
                        <input v-model="exp.company" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Company Name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('District') }}</label>
                        <select v-model="exp.district" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">{{ $t('Select District') }}</option>
                            <option v-for="district in districts" :key="district.id" :value="district.name">
                                {{ district.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Start Date') }} <span class="text-red-500">*</span></label>
                        <flowbite-datepicker type="month" v-model="exp.start_date" placeholder="Start Date"></flowbite-datepicker>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('End Date') }} <span class="text-red-500">*</span></label>
                        <flowbite-datepicker type="month" v-model="exp.end_date" placeholder="End Date"></flowbite-datepicker>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Skills') }}</label>
                    <input v-model="exp.skills" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. Management, Excel">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Description') }}</label>
                    <textarea v-model="exp.description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe your responsibilities..."></textarea>
                </div>
            </div>

            <button @click="addExp" class="w-full border border-[#4984F6] text-[#4984F6] rounded-lg py-2.5 flex items-center justify-center gap-2 hover:bg-blue-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ $t('Add Work Experience') }}
            </button>
        </div>

        <hr class="border-gray-200 my-8" />
        <!-- Navigation -->
        <div class="flex gap-3 justify-end mt-8">
            <button @click="$emit('previous')" class="text-center bg-blue-50 text-[#4984F6] border border-transparent py-2 px-4 rounded-lg font-medium hover:bg-blue-100 transition-colors">
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
            ojtRows: JSON.parse(JSON.stringify(this.portfolio.ojt_experiences || [])),
            expRows: JSON.parse(JSON.stringify(this.portfolio.experiences || []))
        };
    },

    methods: {
        addOjt() { 
            this.ojtRows.push({ title: '', organization: '', district: '', from: '', to: '', skills: '', description: '' }); 
        },
        removeOjt(index) { 
            this.ojtRows.splice(index, 1); 
        },
        addExp() { 
            this.expRows.push({ job_title: '', company: '', district: '', start_date: '', end_date: '', skills: '', description: '', is_current: false }); 
        },
        removeExp(index) { 
            this.expRows.splice(index, 1); 
        },
        handleNext() {
            const validOjt = this.ojtRows.filter(r => r.title && r.title.trim() !== '');
            const validExp = this.expRows.filter(r => r.job_title && r.job_title.trim() !== '');

            this.$emit('update', {
                ojt_experiences: validOjt,
                experiences: validExp
            });
            this.$emit('next');
        }
    }
};
</script>
