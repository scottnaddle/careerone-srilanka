<template>
    <div class="bg-white rounded-xl p-8 max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $t('Last step to build your Portfolio') }}</h1>
            <p class="text-gray-400 text-sm">{{ $t('Please review your information before finish.') }}</p>
        </div>

        <!-- Fullname -->
        <div class="mb-5">
            <label class="block text-sm text-gray-600 mb-1">{{ $t('Fullname') }}</label>
            <input type="text" :value="portfolio.basic_information?.fullname || portfolio.fullname" readonly
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700" />
        </div>

        <!-- D.O.B -->
        <div class="mb-5">
            <label class="block text-sm text-gray-600 mb-1">{{ $t('D.O.B') }}</label>
            <div class="flex border border-gray-300 rounded-lg px-4 py-2.5 items-center gap-2 bg-gray-50">
                <span class="flex-1 text-gray-700">{{ portfolio.basic_information?.dob || '' }}</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <!-- Education (First Item) -->
        <div class="mb-5">
            <label class="block text-sm text-gray-600 mb-1">{{ $t('Recent Education') }}</label>
            <div class="relative">
                <input type="text" :value="firstEducation" readonly
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700 pr-10" />
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <!-- Work Type -->
        <div class="mb-5">
            <label class="block text-sm text-gray-600 mb-1">{{ $t('Work Type') }}</label>
            <div class="relative">
                <input type="text" :value="portfolio.career_interests?.work_type || ''" readonly
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700 pr-10" />
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <!-- Work Mode -->
        <div class="mb-5">
            <label class="block text-sm text-gray-600 mb-1">{{ $t('Work Mode') }}</label>
            <div class="relative">
                <input type="text" :value="portfolio.career_interests?.work_mode || ''" readonly
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700 pr-10" />
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <!-- Language -->
        <div class="mb-5">
            <label class="block text-sm text-gray-600 mb-1">{{ $t('Language') }}</label>
            <div class="relative">
                <input type="text" :value="(portfolio.languages || []).join(', ')" readonly
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700 pr-10" />
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <!-- Technical Skills -->
        <div class="mb-5">
            <label class="block text-sm text-gray-600 mb-2">{{ $t('Technical Skills') }}</label>
            <div class="border border-gray-200 rounded-lg p-3 space-y-3 bg-gray-50">
                <div v-for="skill in (portfolio.technical_skills || [])" :key="skill.name" class="flex items-center justify-between">
                    <span class="text-sm text-gray-700 flex-1">{{ skill.name }}</span>
                    <div class="flex gap-0.5">
                        <svg v-for="star in 5" :key="star"
                             :class="star <= skill.proficiency ? 'text-[#4984F6]' : 'text-gray-300'"
                             class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
                <div v-if="!(portfolio.technical_skills && portfolio.technical_skills.length)" class="text-sm text-gray-500 italic">
                    {{ $t('No technical skills added.') }}
                </div>
            </div>
        </div>

        <!-- OJT Question -->
        <div class="mb-4">
            <p class="text-sm text-gray-600 mb-2">{{ $t('Have you completed any OJT or work experience?') }}</p>
            <div class="flex gap-4">
                <label class="flex items-center gap-2">
                    <div :class="['w-4 h-4 rounded-full border-2 flex items-center justify-center', portfolio.has_work_experience === true ? 'border-[#4984F6]' : 'border-gray-300']">
                        <div v-if="portfolio.has_work_experience === true" class="w-2 h-2 rounded-full bg-[#4984F6]"></div>
                    </div>
                    <span class="text-sm text-gray-700">{{ $t('Yes') }}</span>
                </label>
                <label class="flex items-center gap-2">
                    <div :class="['w-4 h-4 rounded-full border-2 flex items-center justify-center', portfolio.has_work_experience === false ? 'border-[#4984F6]' : 'border-gray-300']">
                        <div v-if="portfolio.has_work_experience === false" class="w-2 h-2 rounded-full bg-[#4984F6]"></div>
                    </div>
                    <span class="text-sm text-gray-700">{{ $t('No') }}</span>
                </label>
            </div>
        </div>

        <!-- Goals -->
        <div class="mb-6">
            <label class="block text-sm text-gray-600 mb-2">{{ $t('Goals') }}</label>
            <div class="space-y-4">
                <div>
                    <span class="text-sm font-medium text-gray-700">{{ $t('Short-term Goals (within 1 year):') }}</span>
                    <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-3 rounded-lg border border-gray-200 whitespace-pre-wrap">{{ portfolio.short_term_goals || $t('Not provided') }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-700">{{ $t('Long-term Goals (over 1 year):') }}</span>
                    <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-3 rounded-lg border border-gray-200 whitespace-pre-wrap">{{ portfolio.long_term_goals || $t('Not provided') }}</p>
                </div>
            </div>
        </div>


        <!-- Certificate/Evidences Upload -->
        <div class="mb-8">
            <evidence-section
                :evidences="portfolio.evidences || []"
                @add="handleAddEvidence"
                @update="handleUpdateEvidence"
                @remove="handleRemoveEvidence"
            />
        </div>

        <hr class="border-gray-200 my-8" />
        <!-- Navigation -->
        <div class="flex gap-3 justify-end">
            <button @click="$emit('previous')" class="text-center bg-blue-50 text-[#4984F6] py-2 px-4 rounded-lg font-medium hover:bg-blue-100 transition-colors border border-transparent">
                {{ $t('Previous') }}
            </button>
            <button
                @click="$emit('submit')"
                :disabled="isSaving"
                class="text-center bg-[#4984F6] text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-600 transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <span v-if="isSaving">{{ $t('Saving...') }}</span>
                <span v-else>{{ $t('Confirm and Submit') }}</span>
            </button>
        </div>
    </div>
</template>

<script>
import EvidenceSection from './EvidenceSection.vue';

export default {
    components: { EvidenceSection },
    props: {
        portfolio: { type: Object, required: true },
        isSaving: { type: Boolean, default: false }
    },

    data() {
        return {};
    },

    computed: {
        firstEducation() {
            const nvqs = this.portfolio.nvq_educations || [];
            if (nvqs.length > 0) return nvqs[0].qualification_name || 'NVQ Qualification';
            
            const tvec = this.portfolio.tvec_educations || [];
            if (tvec.length > 0) return tvec[0].course_name || 'TVEC Course';
            
            const edus = this.portfolio.educations || [];
            if (edus.length > 0) return edus[0].school_name || 'General Education';
            
            return '';
        }
    },

    methods: {
        handleAddEvidence(newEvidence) {
            const updatedEvidences = [...(this.portfolio.evidences || []), newEvidence];
            this.$emit('update', { evidences: updatedEvidences });
        },
        handleUpdateEvidence({ index, evidence }) {
            const updatedEvidences = [...(this.portfolio.evidences || [])];
            updatedEvidences[index] = evidence;
            this.$emit('update', { evidences: updatedEvidences });
        },
        handleRemoveEvidence(index) {
            const updatedEvidences = [...(this.portfolio.evidences || [])];
            updatedEvidences.splice(index, 1);
            this.$emit('update', { evidences: updatedEvidences });
        }
    }
};
</script>
