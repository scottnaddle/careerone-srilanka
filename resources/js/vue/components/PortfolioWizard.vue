<template>
    <div class="portfolio-wizard max-w-[1000px] mx-auto px-4 py-4 md:py-8 my-6 bg-white rounded-xl">
        <!-- Save Draft Button -->
        <div class="flex justify-end mb-2">
            <button
                @click="saveDraft"
                :disabled="isSaving"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors disabled:opacity-50"
            >
                <svg v-if="isSaving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                {{ $t('Save Draft') }}
            </button>
        </div>
        <!-- Progress Bar / Header -->
        <div class="mb-10 max-w-5xl mx-auto w-full overflow-x-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="w-full min-w-[600px] px-4 mx-auto">
                <!-- Single row: label on top, circle on bottom, lines float-end aligned -->
                <div style="display:flex; align-items:flex-end; width:100%;">
                    <template v-for="(stepName, index) in stepNames" :key="'step-' + index">
                        <!-- Step: label + circle -->
                        <div
                            style="flex-shrink:0; display:flex; flex-direction:column; align-items:center; width:120px;"
                            :class="{'cursor-pointer': index <= highestMainStepReached}"
                            @click="index <= highestMainStepReached ? goToMainStep(index) : null"
                        >
                            <!-- Label -->
                            <span
                                style="font-size:13px; text-align:center; font-weight:500; line-height:1.3; margin-bottom:10px; min-height:32px; display:flex; align-items:flex-end; justify-content:center;"
                                :style="{ color: currentMainStep >= index ? '#4984F6' : '#9CA3AF' }"
                                v-html="stepName.replace(' ', '<br/>')"
                            ></span>
                            <!-- Circle -->
                            <div
                                style="width:16px; height:16px; border-radius:50%; border-width:2px; border-style:solid; background:#fff; transition:border-color 0.3s; flex-shrink:0;"
                                :style="{ borderColor: currentMainStep >= index ? '#4984F6' : '#D1D5DB' }"
                            ></div>
                        </div>

                        <!-- Line between steps -->
                        <div v-if="index < stepNames.length - 1"
                            style="flex:1; height:3px; background:#E5E7EB; position:relative; margin-bottom:6.5px; min-width:20px;"
                        >
                            <div
                                style="position:absolute; top:0; left:0; height:100%; background:#4984F6; transition:width 0.5s ease-in-out;"
                                :style="{ width: currentMainStep > index ? '100%' : '0%' }"
                            ></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Divider separating navigation and content -->
        <hr class="border-gray-200 mb-8 max-w-4xl mx-auto" />

        <!-- Dynamic Component for Current Step -->
        <div class="step-content relative min-h-[400px]">
            <transition name="fade" mode="out-in">
                <component
                    :is="currentStepComponent"
                    :portfolio="portfolio"
                    :districts="districts"
                    :genders="genders"
                    :isSaving="isSaving"
                    @update="updatePortfolio"
                    @next="nextStep"
                    @previous="previousStep"
                    @submit="submitPortfolio"
                    @yes="handleOjtAnswer(true)"
                    @no="handleOjtAnswer(false)"
                />
            </transition>
        </div>
    </div>
</template>

<script>
import StepProfileBasics from './StepProfileBasics.vue';
import StepEducationBackground from './StepEducationBackground.vue';
import StepCareerFields from './StepCareerFields.vue';
import StepWorkEnvironment from './StepWorkEnvironment.vue';
import StepTechnicalSkills from './StepTechnicalSkills.vue';
import StepOjtQuestion from './StepOjtQuestion.vue';
import StepGoalType from './StepGoalType.vue';
import StepExperience from './StepExperience.vue';
import StepReview from './StepReview.vue';
import { useToast } from 'vue-toastification';

export default {
    props: {
        initialPortfolio: { type: Object, required: true },
        districts: { type: Array, default: () => [] },
        genders: { type: Array, default: () => [] },
        saveUrl: { type: String, required: true },
        redirectUrl: { type: String, required: true }
    },

    components: {
        StepProfileBasics,
        StepEducationBackground,
        StepCareerFields,
        StepWorkEnvironment,
        StepTechnicalSkills,
        StepOjtQuestion,
        StepGoalType,
        StepExperience,
        StepReview
    },

    setup() {
        const toast = useToast();
        return { toast };
    },

    data() {
        return {
            currentStep: 1,
            highestMainStepReached: Object.keys(this.initialPortfolio).length > 2 ? 5 : 0,
            isSaving: false,
            portfolio: {
                ...JSON.parse(JSON.stringify(this.initialPortfolio)),
                career_interests: this.initialPortfolio.career_interests || {
                    work_type: '',
                    work_mode: '',
                    career_fields: []
                },
                technical_skills: this.initialPortfolio.technical_skills || [],
                languages: this.initialPortfolio.languages || [],
                has_work_experience: this.initialPortfolio.has_work_experience ?? null,
                goal_type: this.initialPortfolio.goal_type || '',
                ojt_experiences: this.initialPortfolio.ojt_experiences || [],
                experiences: this.initialPortfolio.experiences || [],
                educations: this.initialPortfolio.educations || [],
                certificate_file: null,
            },
            
            stepNames: [
                this.$t('Profile Basics'),
                this.$t('Education Background'),
                this.$t('Career Interests'),
                this.$t('Skills & Competencies'),
                this.$t('Work Experience'),
                this.$t('Review')
            ],

            // Mapping wizard steps (1-9) to main progress bar indices (0-5)
            stepToMainStep: {
                1: 0, // Profile
                2: 1, // Education
                3: 2, // Career Fields
                4: 2, // Work Environment
                5: 3, // Technical Skills
                6: 4, // OJT Question
                7: 4, // Experience Form
                8: 4, // Goal Type
                9: 5  // Review
            }
        };
    },

    computed: {
        currentMainStep() {
            return this.stepToMainStep[this.currentStep] || 0;
        },
        currentStepComponent() {
            switch (this.currentStep) {
                case 1: return 'StepProfileBasics';
                case 2: return 'StepEducationBackground';
                case 3: return 'StepCareerFields';
                case 4: return 'StepWorkEnvironment';
                case 5: return 'StepTechnicalSkills';
                case 6: return 'StepOjtQuestion';
                case 7: return 'StepExperience';
                case 8: return 'StepGoalType';
                case 9: return 'StepReview';
                default: return 'StepProfileBasics';
            }
        }
    },

    watch: {
        currentMainStep(newVal) {
            if (newVal > this.highestMainStepReached) {
                this.highestMainStepReached = newVal;
            }
        }
    },

    methods: {
        goToMainStep(index) {
            const mainStepToFirstStep = {
                0: 1, // Profile Basics
                1: 2, // Education Background
                2: 3, // Career Fields
                3: 5, // Technical Skills
                4: 6, // Work Experience
                5: 9  // Review
            };
            if (mainStepToFirstStep[index] !== undefined) {
                this.currentStep = mainStepToFirstStep[index];
            }
        },

        updatePortfolio(data) {
            this.portfolio = { ...this.portfolio, ...data };
        },

        handleOjtAnswer(hasExperience) {
            if (hasExperience) {
                this.currentStep = 7; // Go to Experience form
            } else {
                this.currentStep = 8; // Go to Goal type
            }
        },

        nextStep() {
            if (this.currentStep === 6) {
                // Handled by handleOjtAnswer
                return;
            } else if (this.currentStep === 8) {
                this.currentStep = 9; // Goal type goes to Review
            } else if (this.currentStep < 9) {
                this.currentStep++;
            }
        },

        previousStep() {
            if (this.currentStep === 9) {
                this.currentStep = 8; // Review goes back to Goal Type
            } else if (this.currentStep === 8) {
                if (this.portfolio.has_work_experience) {
                    this.currentStep = 7; // Goal Type goes back to Experience Form
                } else {
                    this.currentStep = 6; // Goal Type goes back to OJT Question
                }
            } else if (this.currentStep === 7) {
                this.currentStep = 6; // Experience Form goes back to OJT Question
            } else if (this.currentStep > 1) {
                this.currentStep--;
            }
        },

        async submitPortfolio() {
            this.isSaving = true;
            try {
                const formData = new FormData();
                
                // Add all portfolio data as JSON
                const dataToSave = { ...this.portfolio };
                delete dataToSave.certificate_file; // Don't send file in JSON
                
                formData.append('json_data', JSON.stringify({ data: dataToSave }));
                
                if (this.portfolio.certificate_file) {
                    formData.append('certificate', this.portfolio.certificate_file);
                }
                
                // Keep the csrf token logic
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(this.saveUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    this.toast.success(this.$t('Portfolio completed successfully!'));
                    window.location.href = this.redirectUrl;
                } else {
                    const error = await response.json();
                    this.toast.error(error.message || this.$t('Failed to save portfolio'));
                }
            } catch (error) {
                console.error(error);
                this.toast.error(this.$t('An unexpected error occurred'));
            } finally {
                this.isSaving = false;
            }
        },

        async saveDraft() {
            this.isSaving = true;
            try {
                const formData = new FormData();
                const dataToSave = { ...this.portfolio };
                delete dataToSave.certificate_file;
                formData.append('json_data', JSON.stringify({ data: dataToSave }));
                if (this.portfolio.certificate_file) {
                    formData.append('certificate', this.portfolio.certificate_file);
                }
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(this.saveUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                if (response.ok) {
                    this.toast.success(this.$t('Draft saved successfully!'));
                } else {
                    const error = await response.json();
                    this.toast.error(error.message || this.$t('Failed to save draft'));
                }
            } catch (error) {
                console.error(error);
                this.toast.error(this.$t('An unexpected error occurred'));
            } finally {
                this.isSaving = false;
            }
        }
    }
};
</script>

<style scoped>
.scroll-hide::-webkit-scrollbar {
    display: none;
}
</style>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-enter-from {
    opacity: 0;
    transform: translateX(10px);
}
.fade-leave-to {
    opacity: 0;
    transform: translateX(-10px);
}
</style>
