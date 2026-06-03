<template>
    <div class="portfolio-container p-4">
        <div class="max-w-[1440px] xl:px-[54px] mx-auto flex flex-col gap-6">
            <!-- Header Section -->
            <portfolio-header
                :portfolio="portfolio"
                @update-portfolio="updatePortfolio"
                @save-portfolio="savePortfolio"
            />

            <!-- Basic Information Section -->
            <basic-information
                :basicInfo="portfolio.basic_information"
                @update="updateBasicInfo"
                @save-portfolio="savePortfolio"
            />

            <!-- About Me Section -->
            <about-me
                :aboutMe="portfolio.about_me"
                @update="updateAboutMe"
                @save-portfolio="savePortfolio"
            />

            <!-- Education Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <tvec-education
                    :educations="portfolio.tvec_educations"
                    @add="addTvecEducation"
                    @update="updateTvecEducation"
                    @remove="removeTvecEducation"
                />
                <nvq-education
                    :educations="portfolio.nvq_educations"
                    @add="addNvqEducation"
                    @update="updateNvqEducation"
                    @remove="removeNvqEducation"
                />
            </div>

            <!-- Other Sections -->
            <general-education
                :educations="portfolio.educations"
                @add="addEducation"
                @update="updateEducation"
                @remove="removeEducation"
                @save-portfolio="savePortfolio"
            />

            <ojt-experience
                :ojts="portfolio.ojt_experiences"
                @add="addOjtExperience"
                @update="updateOjtExperience"
                @remove="removeOjtExperience"
                @save-portfolio="savePortfolio"
            />

            <work-experience
                :experiences="portfolio.experiences"
                @add="addExperience"
                @update="updateExperience"
                @remove="removeExperience"
                @save-portfolio="savePortfolio"
            />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <skills-section
                    :skills="portfolio.skills"
                    @add="addSkill"
                    @update="updateSkill"
                    @remove="removeSkill"
                    @save-portfolio="savePortfolio"
                />
                <languages-section
                    :languages="portfolio.languages"
                    @add="addLanguage"
                    @update="updateLanguage"
                    @remove="removeLanguage"
                    @save-portfolio="savePortfolio"
                />
            </div>

            <evidence-section
                :evidences="portfolio.evidences"
                @add="addEvidence"
                @update="updateEvidence"
                @remove="removeEvidence"
                @save-portfolio="savePortfolio"
            />

            <!-- Save Button -->
<!--            <div class="mt-6 flex justify-end">-->
<!--                <button-->
<!--                    @click="savePortfolio"-->
<!--                    :disabled="isLoading"-->
<!--                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:opacity-75 disabled:cursor-not-allowed flex items-center justify-center gap-2 min-w-[120px]"-->
<!--                >-->
<!--                    <svg v-if="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">-->
<!--                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
<!--                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
<!--                    </svg>-->
<!--                    <span>{{ isLoading ? 'Saving...' : 'Save Portfolio' }}</span>-->
<!--                </button>-->
<!--            </div>-->
                <div class="mt-6 flex justify-end">
                    <a href="/trainee/career-guidance/portfolio/my-portfolio"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:opacity-75 disabled:cursor-not-allowed flex items-center justify-center gap-2 min-w-[120px]"
                    >
                        {{$t('Back')}}
                    </a>
                </div>

        </div>
    </div>
</template>

<script>
import PortfolioHeader from './PortfolioHeader.vue';
import BasicInformation from './BasicInformation.vue';
import AboutMe from './AboutMe.vue';
import TvecEducation from './TvecEducation.vue';
import NvqEducation from './NvqEducation.vue';
import GeneralEducation from './GeneralEducation.vue';
import OjtExperience from './OjtExperience.vue';
import WorkExperience from './WorkExperience.vue';
import SkillsSection from './SkillsSection.vue';
import LanguagesSection from './LanguagesSection.vue';
import EvidenceSection from './EvidenceSection.vue';
import { useToast } from 'vue-toastification';
export default {
    components: {
        PortfolioHeader,
        BasicInformation,
        AboutMe,
        TvecEducation,
        NvqEducation,
        GeneralEducation,
        OjtExperience,
        WorkExperience,
        SkillsSection,
        LanguagesSection,
        EvidenceSection
    },
    beforeCreate() {
        console.log('Before create hook');
    },

    created() {
        console.log('Created hook:', this.$options.components);
        console.log('Props received:', this.$props);
    },

    mounted() {
        console.log('Mounted hook');
        console.log('Component instance:', this);
        console.log('Portfolio data:', this.portfolio);

    },
    setup() {
        const toast = useToast();
        return { toast };
    },
    props: {
        initialPortfolio: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            portfolio: JSON.parse(JSON.stringify(this.initialPortfolio)),
            isLoading: false
        };
    },

    methods: {
        updatePortfolio(data) {
            this.portfolio = {...this.portfolio, ...data};
        },

        updateBasicInfo(data) {
            this.portfolio.basic_information = data;
        },

        updateAboutMe(text) {
            this.portfolio.about_me = text;
        },

        // Education methods
        addTvecEducation(education) {
            this.portfolio.tvec_educations.push(education);
        },

        updateTvecEducation({index, education}) {
            this.portfolio.tvec_educations.splice(index, 1, education);
        },

        removeTvecEducation(index) {
            this.portfolio.tvec_educations.splice(index, 1);
        },

        // Similar methods for other sections...
        addNvqEducation(education) {
            this.portfolio.nvq_educations.push(education);
        },

        updateNvqEducation({index, education}) {
            this.portfolio.nvq_educations.splice(index, 1, education);
        },

        removeNvqEducation(index) {
            this.portfolio.nvq_educations.splice(index, 1);
        },

        addEducation(education) {
            this.portfolio.educations.push(education);
        },

        updateEducation({index, education}) {
            this.portfolio.educations.splice(index, 1, education);
        },

        removeEducation(index) {
            this.portfolio.educations.splice(index, 1);
        },

        // Experience methods
        addOjtExperience(experience) {
            this.portfolio.ojt_experiences.push(experience);
        },

        updateOjtExperience({index, experience}) {
            this.portfolio.ojt_experiences.splice(index, 1, experience);
        },

        removeOjtExperience(index) {
            this.portfolio.ojt_experiences.splice(index, 1);
        },

        addExperience(experience) {
            this.portfolio.experiences.push(experience);
        },

        updateExperience({index, experience}) {
            this.portfolio.experiences.splice(index, 1, experience);
        },

        removeExperience(index) {
            this.portfolio.experiences.splice(index, 1);
        },

        // Skills methods
        addSkill(skill) {
            this.portfolio.skills.push(skill);
        },

        updateSkill({index, skill}) {
            this.portfolio.skills.splice(index, 1, skill);
        },

        removeSkill(index) {
            this.portfolio.skills.splice(index, 1);
        },

        // Languages methods
        addLanguage(language) {
            this.portfolio.languages.push(language);
        },

        updateLanguage({index, language}) {
            this.portfolio.languages.splice(index, 1, language);
        },

        removeLanguage(index) {
            this.portfolio.languages.splice(index, 1);
        },

        // Evidence methods
        addEvidence(evidence) {
            this.portfolio.evidences.push(evidence);
        },

        updateEvidence({index, evidence}) {
            this.portfolio.evidences.splice(index, 1, evidence);
        },

        removeEvidence(index) {
            this.portfolio.evidences.splice(index, 1);
        },

        // Save method

        async savePortfolio() {
            this.isLoading = true; // Bật trạng thái loading

            try {
                const response = await axios.post('/trainee/career-guidance/portfolios', this.portfolio);

                // Hiển thị thông báo thành công
                this.toast.success(this.$t('Portfolio updated successfully!'), {
                    timeout: 2000,
                    onClose: () => {
                        // window.location.href = '/trainee/career-guidance/portfolio/my-portfolio';
                    }
                });

            } catch (error) {
                console.error(this.$t('Error saving portfolio:'), error);

                if (error.response && error.response.status === 422) {
                    // Xử lý validation errors
                    const errors = error.response.data.errors || {};

                    // Hiển thị từng lỗi validation
                    for (const [field, messages] of Object.entries(errors)) {
                        this.toast.error(`${this.formatFieldName(field)}: ${messages.join(', ')}`);
                    }

                } else {
                    // Xử lý các lỗi khác
                    this.toast.error(this.$t('Error saving portfolio. Please try again later.'));
                }
            } finally {
                this.isLoading = false; // Tắt trạng thái loading
            }
        },

        formatFieldName(field) {
            // Hàm định dạng tên trường để hiển thị thân thiện hơn
            const fieldMap = {
                'basic_information.name': this.$t('Full name'),
                'basic_information.email': this.$t('Email'),
                'about_me': this.$t('About me'),
                // Thêm các mapping khác nếu cần
            };

            return fieldMap[field] || field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

    }
};
</script>
