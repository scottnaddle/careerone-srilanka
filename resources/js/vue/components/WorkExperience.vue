<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
        <div class="flex flex-col gap-4 w-full">
            <div class="flex justify-between items-center">
                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('Work Experience')}}</p>
                <div class="flex gap-2">
                    <button @click="showAddExperienceForm" class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="none">
                            <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Add Form -->
            <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Job Title')}} <span class="text-red-600">*</span></label>
                        <input v-model="newExperience.job_title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Job title name')
">
                        <p v-if="errors.job_title" class="mt-1 text-sm text-red-600">{{ errors.job_title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Company or organisation')}} <span class="text-red-600">*</span></label>
                        <input v-model="newExperience.company" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Company or organisation name')
">
                        <p v-if="errors.company" class="mt-1 text-sm text-red-600">{{ errors.company }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}}</label>
                        <input v-model="newExperience.district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('District name')">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>
                        <input type="month" v-model="newExperience.start_date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                        <p v-if="errors.start_date" class="mt-1 text-sm text-red-600">{{ errors.start_date }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>
                        <div class="flex items-center mt-1">
                            <input
                                type="month"
                                v-model="newExperience.end_date"
                                :disabled="newExperience.is_current"
                                :class="newExperience.is_current ? 'bg-gray-100 cursor-not-allowed' : ''"
                                class="block w-full rounded-xl border-gray-300 shadow-sm"
                            >
                            <label class="ml-2 flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="newExperience.is_current"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                >
                                <span class="ml-1 text-sm">{{$t('Present')}}</span>
                            </label>
                        </div>
                        <p v-if="errors.end_date" class="mt-1 text-sm text-red-600">{{ errors.end_date }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skills')}}</label>
                        <textarea v-model="newExperience.skills" rows="2" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Add your top skills used in this role')"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                        <textarea v-model="newExperience.description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Description...')"></textarea>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="cancelAdd" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <button @click="addExperience" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Experience List -->
            <ol class="relative border-s border-primary">
                <li v-for="(experience, index) in experiences" :key="index" class="mb-10 border border-dashed p-4 rounded-lg relative group">
                    <!-- Action Buttons - Visible on hover -->
                    <div class="absolute top-2 right-2 flex gap-1 transition-opacity duration-200 z-10">
                        <button v-if="!editing[index]" @click="startEditing(index)" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button v-if="!editing[index]" @click="removeExperience(index)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <div v-if="!editing[index]">
                        <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5"></div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ experience.job_title }}</h3>
                        <p class="text-md font-medium text-gray-700 dark:text-gray-300">{{ experience.company }} <span v-if="experience.district">• {{ experience.district }}</span></p>
                        <time class="mb-2 text-sm font-normal text-gray-400 dark:text-white">
                            {{ formatDate(experience.start_date) }} - {{ experience.is_current ? $t('Present') : formatDate(experience.end_date) }}
                        </time>
                        <div v-if="experience.skills" class="my-2">
                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Skills')}}:</p>
                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ experience.skills }}</p>
                        </div>
                        <div v-if="experience.description" class="my-2">
                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Description')}}:</p>
                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ experience.description }}</p>
                        </div>

                    </div>

                    <!-- Edit Form -->
                    <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Job Title')}} <span class="text-red-600">*</span></label>
                            <input v-model="editForms[index].job_title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="editErrors[index]?.job_title" class="mt-1 text-sm text-red-600">{{ editErrors[index].job_title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Company/Organization')}} <span class="text-red-600">*</span></label>
                            <input v-model="editForms[index].company" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="editErrors[index]?.company" class="mt-1 text-sm text-red-600">{{ editErrors[index].company }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}}</label>
                            <input v-model="editForms[index].district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>
                            <input type="month" v-model="editForms[index].start_date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="editErrors[index]?.start_date" class="mt-1 text-sm text-red-600">{{ editErrors[index].start_date }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>
                            <div class="flex items-center mt-1">
                                <input
                                    type="month"
                                    v-model="editForms[index].end_date"
                                    :disabled="editForms[index].is_current"
                                    :class="editForms[index].is_current ? 'bg-gray-100 cursor-not-allowed' : ''"
                                    class="block w-full rounded-xl border-gray-300 shadow-sm"
                                />
                                <label class="ml-2 flex items-center">
                                    <input type="checkbox" v-model="editForms[index].is_current" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-1 text-sm">{{$t('Present')}}</span>
                                </label>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skills')}}</label>
                            <textarea v-model="editForms[index].skills" rows="2" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Add your top skills used in this role')"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                            <textarea v-model="editForms[index].description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"></textarea>
                        </div>
                        <div class="md:col-span-2 flex justify-end gap-2">
                            <button @click="cancelEdit(index)" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button @click="saveEdit(index)" class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </li>
            </ol>

            <!-- Warning Modal -->
            <div v-if="showWarning" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full mx-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{$t('Unsaved Changes')}}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                        {{$t('You have unsaved changes. If you leave now, your changes will be lost.')}}
                    </p>
                    <div class="flex justify-end gap-3">
                        <button
                            @click="continueWithoutSaving"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm"
                        >
                            {{$t('Leave Anyway')}}
                        </button>
                        <button
                            @click="saveAndContinue"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"
                        >
                            {{$t('Save and Continue')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        experiences: { type: Array, default: () => [] }
    },

    data() {
        return {
            showAddForm: false,
            newExperience: {
                job_title: '',
                company: '',
                district: '',
                start_date: '',
                end_date: '',
                is_current: false,
                skills: '',
                description: ''
            },
            errors: {},
            editing: [],
            editForms: [],
            editErrors: [],
            isSaving: false,
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            beforeUnloadListener: null
        }
    },

    watch: {
        experiences: {
            handler() { this.resetEditingStates() },
            deep: true,
            immediate: true
        },
        // Watch for changes in new experience form
        newExperience: {
            handler(newVal) {
                const isEmpty = Object.values(newVal).every(
                    value => value === '' || value === null || value === undefined || value === false
                );

                if (!isEmpty && this.showAddForm) {
                    this.setUnsavedChanges(true);
                }
            },
            deep: true
        },
        // Watch for changes in edit forms
        editForms: {
            handler() {
                const hasEditChanges = this.editForms.some((form, index) => {
                    if (!this.editing[index]) return false;

                    const original = this.experiences[index];
                    return JSON.stringify(form) !== JSON.stringify(original);
                });

                if (hasEditChanges) {
                    this.setUnsavedChanges(true);
                }
            },
            deep: true
        },
        // Watch for editing state
        editing: {
            handler() {
                const isEditing = this.editing.some(edit => edit === true);
                if (isEditing) {
                    this.setUnsavedChanges(true);
                }
            },
            deep: true
        }
    },

    mounted() {
        // Set up beforeunload listener
        this.setupBeforeUnloadListener();
    },

    beforeUnmount() {
        // Clean up beforeunload listener
        this.removeBeforeUnloadListener();
    },

    methods: {
        resetEditingStates() {
            this.editing = this.experiences.map(() => false)
            this.editForms = this.experiences.map(exp => ({ ...exp }))
            this.editErrors = this.experiences.map(() => ({}))
            this.setUnsavedChanges(false);
        },

        formatDate(dateString) {
            if (!dateString) return this.$t('Not specified');

            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
        },

        validate(experience) {
            const errors = {};
            const yearRegex = /^\d{4}-\d{2}$/;
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1; // Tháng tính từ 0

            if (!experience.job_title?.trim()) {
                errors.job_title = this.$t('Job title is required');
            }

            if (!experience.company?.trim()) {
                errors.company = this.$t('Company/organization is required');
            }

            if (!experience.start_date?.trim()) {
                errors.start_date = this.$t('Start date is required');
            } else if (!yearRegex.test(experience.start_date)) {
                errors.start_date = this.$t('Start date format must be YYYY-MM');
            } else {
                const [startYear, startMonth] = experience.start_date.split('-').map(Number);
                if (startYear < 1900) {
                    errors.start_date = this.$t('Start year must be 1900 or later');
                } else if (
                    startYear > currentYear ||
                    (startYear === currentYear && startMonth > currentMonth)
                ) {
                    errors.start_date = this.$t('Start date cannot be in the future');
                }
            }

            if (!experience.is_current) {
                if (!experience.end_date?.trim()) {
                    errors.end_date = this.$t('End date is required');
                } else if (!yearRegex.test(experience.end_date)) {
                    errors.end_date = this.$t('End date format must be YYYY-MM');
                } else {
                    // Kiểm tra end_date >= start_date
                    const [startYear, startMonth] = experience.start_date.split('-').map(Number);
                    const [endYear, endMonth] = experience.end_date.split('-').map(Number);

                    if (
                        endYear < startYear ||
                        (endYear === startYear && endMonth < startMonth)
                    ) {
                        errors.end_date = this.$t('End date cannot be earlier than start date');
                    }
                }
            }

            return errors;
        },

        showAddExperienceForm() {
            this.showAddForm = true;
        },

        addExperience() {
            this.errors = this.validate(this.newExperience)
            if (Object.keys(this.errors).length) return

            // If "Present" is checked, clear end_date
            const experienceToAdd = { ...this.newExperience };
            if (experienceToAdd.is_current) {
                experienceToAdd.end_date = '';
            }

            this.$emit('add', experienceToAdd)
            this.setUnsavedChanges(false);
            this.cancelAdd()
            this.requestSavePortfolio();
        },

        cancelAdd() {
            if (this.hasUnsavedChanges) {
                // Show warning if there are unsaved changes
                this.showWarning = true;
                this.pendingAction = 'cancelAdd';
            } else {
                this.doCancelAdd();
            }
        },

        doCancelAdd() {
            this.showAddForm = false
            this.newExperience = {
                job_title: '',
                company: '',
                district: '',
                start_date: '',
                end_date: '',
                is_current: false,
                skills: '',
                description: ''
            }
            this.errors = {}
            this.setUnsavedChanges(false);
        },

        startEditing(index) {
            this.editing = this.editing.map((item, i) => i === index)
            this.editErrors[index] = {}
        },

        cancelEdit(index) {
            if (this.hasEditChanges(index)) {
                // Show warning if there are unsaved changes
                this.showWarning = true;
                this.pendingAction = 'cancelEdit';
                this.pendingIndex = index;
            } else {
                this.doCancelEdit(index);
            }
        },

        doCancelEdit(index) {
            this.editing = this.editing.map((item, i) => i === index ? false : item)
            this.editForms[index] = { ...this.experiences[index] }
            this.editErrors[index] = {}
            this.checkUnsavedChangesState();
        },

        saveEdit(index) {
            this.editErrors[index] = this.validate(this.editForms[index])
            if (Object.keys(this.editErrors[index]).length) return

            // If "Present" is checked, clear end_date
            const experienceToUpdate = { ...this.editForms[index] };
            if (experienceToUpdate.is_current) {
                experienceToUpdate.end_date = '';
            }

            this.$emit('update', { index, experience: experienceToUpdate })
            this.editing = this.editing.map((item, i) => i === index ? false : item)
            this.requestSavePortfolio();
            this.setUnsavedChanges(false);
        },

        removeExperience(index) {
            if (confirm(this.$t('Are you sure you want to remove this work experience?'))) {
                this.$emit('remove', index)
                this.requestSavePortfolio();
            }
        },

        requestSavePortfolio() {
            // Emit an event to the parent component to trigger saving
            this.$emit('save-portfolio');

            // Show saving state in this component
            this.isSaving = true;

            // Reset saving state after a delay (parent should handle the actual saving)
            setTimeout(() => {
                this.isSaving = false;
            }, 2000);
        },

        // Handle when user chooses to leave without saving
        continueWithoutSaving() {
            this.showWarning = false;

            if (this.pendingAction === 'cancelAdd') {
                this.doCancelAdd();
            } else if (this.pendingAction === 'cancelEdit') {
                this.doCancelEdit(this.pendingIndex);
            }

            this.pendingAction = null;
            this.pendingIndex = null;
        },

        // Handle when user chooses to save and continue
        saveAndContinue() {
            this.showWarning = false;

            if (this.pendingAction === 'cancelAdd') {
                this.addExperience();
            } else if (this.pendingAction === 'cancelEdit') {
                this.saveEdit(this.pendingIndex);
            }

            this.pendingAction = null;
            this.pendingIndex = null;
        },

        // Check if there are changes in a specific edit form
        hasEditChanges(index) {
            if (!this.editing[index]) return false;

            const original = this.experiences[index];
            return JSON.stringify(this.editForms[index]) !== JSON.stringify(original);
        },

        // Check overall unsaved changes state
        checkUnsavedChangesState() {
            const hasNewChanges = this.showAddForm && Object.values(this.newExperience).some(
                value => value !== '' && value !== null && value !== undefined && value !== false
            );

            const hasEditChanges = this.editForms.some((form, index) => this.hasEditChanges(index));

            this.setUnsavedChanges(hasNewChanges || hasEditChanges);
        },

        // Set unsaved changes state
        setUnsavedChanges(hasChanges) {
            this.hasUnsavedChanges = hasChanges;
        },

        // Set up beforeunload listener to warn user when leaving page
        setupBeforeUnloadListener() {
            this.beforeUnloadListener = (e) => {
                if (this.hasUnsavedChanges) {
                    // Standard message for browsers
                    e.preventDefault();
                    e.returnValue = this.$t('You have unsaved changes. Are you sure you want to leave?');
                    return e.returnValue;
                }
            };

            window.addEventListener('beforeunload', this.beforeUnloadListener);
        },

        // Remove beforeunload listener
        removeBeforeUnloadListener() {
            if (this.beforeUnloadListener) {
                window.removeEventListener('beforeunload', this.beforeUnloadListener);
            }
        },

        // Method for parent component to check for unsaved changes
        checkUnsavedChanges() {
            if (this.hasUnsavedChanges) {
                this.showWarning = true;
                this.pendingAction = 'navigate';
                return false;
            }
            return true;
        }
    }
}
</script>
<!--<template>-->
<!--    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">-->
<!--        <div class="flex flex-col gap-4 w-full">-->
<!--            <div class="flex justify-between items-center">-->
<!--                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Work Experience</p>-->
<!--                <div class="flex gap-2">-->
<!--                    <button @click="showAddForm = true" class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="none">-->
<!--                            <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->

<!--            &lt;!&ndash; Add Form &ndash;&gt;-->
<!--            <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">-->
<!--                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">-->
<!--                    <div class="md:col-span-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Job Title <span class="text-red-600">*</span></label>-->
<!--                        <input v-model="newExperience.job_title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="e.g., Software Engineer">-->
<!--                        <p v-if="errors.job_title" class="mt-1 text-sm text-red-600">{{ errors.job_title }}</p>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Company/Organization <span class="text-red-600">*</span></label>-->
<!--                        <input v-model="newExperience.company" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="e.g., Google Inc.">-->
<!--                        <p v-if="errors.company" class="mt-1 text-sm text-red-600">{{ errors.company }}</p>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">District</label>-->
<!--                        <input v-model="newExperience.district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="e.g., District 1">-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Start Date <span class="text-red-600">*</span></label>-->
<!--                        <input type="month" v-model="newExperience.start_date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                        <p v-if="errors.start_date" class="mt-1 text-sm text-red-600">{{ errors.start_date }}</p>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">End Date</label>-->
<!--                        <div class="flex items-center mt-1">-->
<!--                            <input type="month" v-model="newExperience.end_date" :disabled="newExperience.is_current" class="block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <label class="ml-2 flex items-center">-->
<!--                                <input type="checkbox" v-model="newExperience.is_current" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">-->
<!--                                <span class="ml-1 text-sm">Present</span>-->
<!--                            </label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="md:col-span-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Skills</label>-->
<!--                        <textarea v-model="newExperience.skills" rows="2" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Add your top skills used in this role"></textarea>-->
<!--                    </div>-->
<!--                    <div class="md:col-span-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>-->
<!--                        <textarea v-model="newExperience.description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Describe your responsibilities and achievements"></textarea>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="mt-4 flex justify-end gap-2">-->
<!--                    <button @click="cancelAdd" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                    <button @click="addExperience" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->

<!--            &lt;!&ndash; Experience List &ndash;&gt;-->
<!--            <ol class="relative border-s border-primary">-->
<!--                <li v-for="(experience, index) in experiences" :key="index" class="mb-10 border border-dashed p-4 rounded-lg relative group">-->
<!--                    &lt;!&ndash; Action Buttons - Visible on hover &ndash;&gt;-->
<!--                    <div class="absolute top-2 right-2 flex gap-1 transition-opacity duration-200 z-10">-->
<!--                        <button v-if="!editing[index]" @click="startEditing(index)" class="p-1 bg-gray-500 text-white rounded hover:bg-gray-600">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />-->
<!--                            </svg>-->
<!--                        </button>-->
<!--                        <button v-if="!editing[index]" @click="removeExperience(index)" class="p-1 bg-red-500 text-white rounded hover:bg-red-600">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />-->
<!--                            </svg>-->
<!--                        </button>-->
<!--                    </div>-->

<!--                    <div v-if="!editing[index]">-->
<!--                        <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5"></div>-->
<!--                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ experience.job_title }}</h3>-->
<!--                        <p class="text-md font-medium text-gray-700 dark:text-gray-300">{{ experience.company }} <span v-if="experience.district">• {{ experience.district }}</span></p>-->
<!--                        <time class="mb-2 text-sm font-normal text-gray-400 dark:text-white">-->
<!--                            {{ formatDate(experience.start_date) }} - {{ experience.is_current ? 'Present' : formatDate(experience.end_date) }}-->
<!--                        </time>-->
<!--                        <div v-if="experience.skills" class="my-2">-->
<!--                            <p class=" font-semibold text-gray-700 dark:text-gray-300">Skills:</p>-->
<!--                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2">{{ experience.skills }}</p>-->
<!--                        </div>-->
<!--                        <div v-if="experience.description" class="my-2">-->
<!--                            <p class=" font-semibold text-gray-700 dark:text-gray-300">Description:</p>-->
<!--                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2">{{ experience.description }}</p>-->
<!--                        </div>-->

<!--                    </div>-->

<!--                    &lt;!&ndash; Edit Form &ndash;&gt;-->
<!--                    <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">-->
<!--                        <div class="md:col-span-2">-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Job Title <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="editForms[index].job_title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="editErrors[index]?.job_title" class="mt-1 text-sm text-red-600">{{ editErrors[index].job_title }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Company/Organization <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="editForms[index].company" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="editErrors[index]?.company" class="mt-1 text-sm text-red-600">{{ editErrors[index].company }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">District</label>-->
<!--                            <input v-model="editForms[index].district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Start Date <span class="text-red-600">*</span></label>-->
<!--                            <input type="month" v-model="editForms[index].start_date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="editErrors[index]?.start_date" class="mt-1 text-sm text-red-600">{{ editErrors[index].start_date }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">End Date</label>-->
<!--                            <div class="flex items-center mt-1">-->
<!--                                <input type="month" v-model="editForms[index].end_date" :disabled="editForms[index].is_current" class="block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                <label class="ml-2 flex items-center">-->
<!--                                    <input type="checkbox" v-model="editForms[index].is_current" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">-->
<!--                                    <span class="ml-1 text-sm">Present</span>-->
<!--                                </label>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="md:col-span-2">-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Skills</label>-->
<!--                            <textarea v-model="editForms[index].skills" rows="2" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Add your top skills used in this role"></textarea>-->
<!--                        </div>-->
<!--                        <div class="md:col-span-2">-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>-->
<!--                            <textarea v-model="editForms[index].description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"></textarea>-->
<!--                        </div>-->
<!--                        <div class="md:col-span-2 flex justify-end gap-2">-->
<!--                            <button @click="cancelEdit(index)" class="p-1 bg-gray-500 text-white rounded hover:bg-gray-600">-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                            <button @click="saveEdit(index)" class="p-1 bg-green-500 text-white rounded hover:bg-green-600">-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </li>-->
<!--            </ol>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--    props: {-->
<!--        experiences: { type: Array, default: () => [] }-->
<!--    },-->

<!--    data() {-->
<!--        return {-->
<!--            showAddForm: false,-->
<!--            newExperience: {-->
<!--                job_title: '',-->
<!--                company: '',-->
<!--                district: '',-->
<!--                start_date: '',-->
<!--                end_date: '',-->
<!--                is_current: false,-->
<!--                skills: '',-->
<!--                description: ''-->
<!--            },-->
<!--            errors: {},-->
<!--            editing: [],-->
<!--            editForms: [],-->
<!--            editErrors: [],-->
<!--            isSaving: false-->
<!--        }-->
<!--    },-->

<!--    watch: {-->
<!--        experiences: {-->
<!--            handler() { this.resetEditingStates() },-->
<!--            deep: true,-->
<!--            immediate: true-->
<!--        }-->
<!--    },-->

<!--    methods: {-->
<!--        resetEditingStates() {-->
<!--            this.editing = this.experiences.map(() => false)-->
<!--            this.editForms = this.experiences.map(exp => ({ ...exp }))-->
<!--            this.editErrors = this.experiences.map(() => ({}))-->
<!--        },-->

<!--        formatDate(dateString) {-->
<!--            if (!dateString) return 'Not specified';-->

<!--            const date = new Date(dateString);-->
<!--            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });-->
<!--        },-->

<!--        validate(experience) {-->
<!--            const errors = {}-->
<!--            if (!experience.job_title?.trim()) {-->
<!--                errors.job_title = 'Job title is required'-->
<!--            }-->
<!--            if (!experience.company?.trim()) {-->
<!--                errors.company = 'Company/organization is required'-->
<!--            }-->
<!--            if (!experience.start_date?.trim()) {-->
<!--                errors.start_date = 'Start date is required'-->
<!--            }-->
<!--            return errors-->
<!--        },-->

<!--        addExperience() {-->
<!--            this.errors = this.validate(this.newExperience)-->
<!--            if (Object.keys(this.errors).length) return-->

<!--            // If "Present" is checked, clear end_date-->
<!--            const experienceToAdd = { ...this.newExperience };-->
<!--            if (experienceToAdd.is_current) {-->
<!--                experienceToAdd.end_date = '';-->
<!--            }-->

<!--            this.$emit('add', experienceToAdd)-->
<!--            this.cancelAdd()-->
<!--            this.requestSavePortfolio();-->
<!--        },-->

<!--        cancelAdd() {-->
<!--            this.showAddForm = false-->
<!--            this.newExperience = {-->
<!--                job_title: '',-->
<!--                company: '',-->
<!--                district: '',-->
<!--                start_date: '',-->
<!--                end_date: '',-->
<!--                is_current: false,-->
<!--                skills: '',-->
<!--                description: ''-->
<!--            }-->
<!--            this.errors = {}-->
<!--        },-->

<!--        startEditing(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index)-->
<!--            this.editErrors[index] = {}-->
<!--        },-->

<!--        cancelEdit(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index ? false : item)-->
<!--            this.editForms[index] = { ...this.experiences[index] }-->
<!--            this.editErrors[index] = {}-->
<!--        },-->

<!--        saveEdit(index) {-->
<!--            this.editErrors[index] = this.validate(this.editForms[index])-->
<!--            if (Object.keys(this.editErrors[index]).length) return-->

<!--            // If "Present" is checked, clear end_date-->
<!--            const experienceToUpdate = { ...this.editForms[index] };-->
<!--            if (experienceToUpdate.is_current) {-->
<!--                experienceToUpdate.end_date = '';-->
<!--            }-->

<!--            this.$emit('update', { index, experience: experienceToUpdate })-->
<!--            this.editing = this.editing.map((item, i) => i === index ? false : item)-->
<!--            this.requestSavePortfolio();-->
<!--        },-->

<!--        removeExperience(index) {-->
<!--            if (confirm('Are you sure you want to remove this work experience?')) {-->
<!--                this.$emit('remove', index)-->
<!--                this.requestSavePortfolio();-->
<!--            }-->
<!--        },-->

<!--        requestSavePortfolio() {-->
<!--            // Emit an event to the parent component to trigger saving-->
<!--            this.$emit('save-portfolio');-->

<!--            // Show saving state in this component-->
<!--            this.isSaving = true;-->

<!--            // Reset saving state after a delay (parent should handle the actual saving)-->
<!--            setTimeout(() => {-->
<!--                this.isSaving = false;-->
<!--            }, 2000);-->
<!--        }-->
<!--    }-->
<!--}-->
<!--</script>-->
