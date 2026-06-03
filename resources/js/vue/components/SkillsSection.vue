<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
        <div class="flex justify-between items-center">
            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('Skills')}}</p>
            <button
                @click="showAddSkillForm"
                class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="none">
                    <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- Add Form -->
        <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skill name')}} <span class="text-red-600">*</span></label>
                    <input
                        v-model="newSkill.name"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                        :placeholder="$t('Skill name')"
                        :class="{'border-red-500': errors.name}"
                    >
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                    <textarea
                        v-model="newSkill.description"
                        rows="3"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                        :placeholder="$t('Description')"
                    ></textarea>
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-1">
                <button
                    @click="cancelAdd"
                    class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
                <button
                    @click="addSkill"
                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Skills List -->
        <div class="flex flex-col gap-4">
            <div v-for="(skill, index) in skills" :key="index" class="relative group">
                <div class="flex gap-4 items-baseline">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                            <circle cx="5" cy="5" r="5" fill="#4984F6" />
                        </svg>
                    </div>
                    <div class="flex flex-col gap-2 w-full relative border p-2 rounded border-dashed">
                        <div v-if="!editing[index]">
                            <p>
                                <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ skill.name }}</span>
                            </p>
                            <div class="text-[#91919A] dark:text-white whitespace-pre-line">
                                {{ skill.description }}
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div v-else class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skill name')}} <span class="text-red-600">*</span></label>
                                <input
                                    v-model="editForms[index].name"
                                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                                    :class="{'border-red-500': editErrors[index]?.name}"
                                >
                                <p v-if="editErrors[index]?.name" class="mt-1 text-sm text-red-600">{{ editErrors[index].name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                                <textarea
                                    v-model="editForms[index].description"
                                    rows="3"
                                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                                ></textarea>
                            </div>
                        </div>

                        <div class="flex gap-1 mt-2 justify-end">
                            <button
                                v-if="!editing[index]"
                                @click="startEditing(index)"
                                class="px-2 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button
                                v-if="!editing[index]"
                                @click="removeSkill(index)"
                                class="px-2 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" class="" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                            <button
                                v-if="editing[index]"
                                @click="cancelEdit(index)"
                                class="px-2 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button
                                v-if="editing[index]"
                                @click="saveEdit(index)"
                                class="px-2 py-1 bg-primary text-white rounded text-sm hover:bg-blue-600"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
</template>

<script>
export default {
    props: {
        skills: {
            type: Array,
            required: true,
            default: () => []
        }
    },

    data() {
        return {
            showAddForm: false,
            newSkill: {
                name: '',
                description: ''
            },
            editing: [],
            editForms: [],
            errors: {},
            editErrors: [],
            isSaving: false,
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            pendingIndex: null,
            beforeUnloadListener: null
        };
    },

    watch: {
        skills: {
            handler() {
                this.resetEditingStates();
            },
            deep: true,
            immediate: true
        },
        // Watch for changes in new skill form
        newSkill: {
            handler(newVal) {
                const isEmpty = Object.values(newVal).every(
                    value => value === '' || value === null || value === undefined
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

                    const original = this.skills[index];
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
            if (!Array.isArray(this.skills)) {
                this.editing = [];
                this.editForms = [];
                this.editErrors = [];
                return;
            }

            this.editing = this.skills.map(() => false);
            this.editForms = this.skills.map(skill => ({
                name: skill?.name || '',
                description: skill?.description || ''
            }));
            this.editErrors = this.skills.map(() => ({}));
            this.setUnsavedChanges(false);
        },

        validate(skill) {
            const errors = {};
            if (!skill.name.trim()) {
                errors.name = this.$t('Skill name is required');
            } else if (skill.name.length > 50) {
                errors.name = this.$t('Skill name must be less than 50 characters');
            }
            return errors;
        },

        showAddSkillForm() {
            this.showAddForm = true;
        },

        addSkill() {
            this.errors = this.validate(this.newSkill);
            if (Object.keys(this.errors).length) return;

            this.$emit('add', {...this.newSkill});
            this.setUnsavedChanges(false);
            this.cancelAdd();
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
            this.showAddForm = false;
            this.newSkill = { name: '', description: '' };
            this.errors = {};
            this.setUnsavedChanges(false);
        },

        startEditing(index) {
            this.editing = this.editing.map((item, i) => i === index ? true : item);
            this.editErrors[index] = {};
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
            this.editing = this.editing.map((item, i) => i === index ? false : item);
            if (this.skills[index]) {
                this.editForms[index] = {
                    name: this.skills[index].name || '',
                    description: this.skills[index].description || ''
                };
                this.editErrors[index] = {};
            }
            this.checkUnsavedChangesState();
        },

        saveEdit(index) {
            this.editErrors[index] = this.validate(this.editForms[index]);
            if (Object.keys(this.editErrors[index]).length) return;

            this.$emit('update', {
                index,
                skill: {...this.editForms[index]}
            });
            this.editing = this.editing.map((item, i) => i === index ? false : item);
            this.requestSavePortfolio();
            this.setUnsavedChanges(false);
        },

        removeSkill(index) {
            if (confirm(this.$t('Are you sure you want to remove this skill?'))) {
                this.$emit('remove', index);
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
                this.addSkill();
            } else if (this.pendingAction === 'cancelEdit') {
                this.saveEdit(this.pendingIndex);
            }

            this.pendingAction = null;
            this.pendingIndex = null;
        },

        // Check if there are changes in a specific edit form
        hasEditChanges(index) {
            if (!this.editing[index]) return false;

            const original = this.skills[index];
            return JSON.stringify(this.editForms[index]) !== JSON.stringify(original);
        },

        // Check overall unsaved changes state
        checkUnsavedChangesState() {
            const hasNewChanges = this.showAddForm && Object.values(this.newSkill).some(
                value => value !== '' && value !== null && value !== undefined
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
};
</script>
<!--<template>-->
<!--    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">-->
<!--        <div class="flex justify-between items-center">-->
<!--            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Skills</p>-->
<!--            <button-->
<!--                @click="showAddForm = true"-->
<!--                class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600"-->
<!--            >-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="none">-->
<!--                    <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                </svg>-->
<!--            </button>-->
<!--        </div>-->

<!--        &lt;!&ndash; Add Form &ndash;&gt;-->
<!--        <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">-->
<!--            <div class="grid grid-cols-1 gap-4">-->
<!--                <div>-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Skill Name <span class="text-red-600">*</span></label>-->
<!--                    <input-->
<!--                        v-model="newSkill.name"-->
<!--                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"-->
<!--                        placeholder="Skill name"-->
<!--                        :class="{'border-red-500': errors.name}"-->
<!--                    >-->
<!--                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>-->
<!--                    <textarea-->
<!--                        v-model="newSkill.description"-->
<!--                        rows="3"-->
<!--                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"-->
<!--                        placeholder="Skill description"-->
<!--                    ></textarea>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="mt-4 flex justify-end gap-1">-->
<!--                <button-->
<!--                    @click="cancelAdd"-->
<!--                    class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"-->
<!--                >-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                    </svg>-->
<!--                </button>-->
<!--                <button-->
<!--                    @click="addSkill"-->
<!--                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"-->
<!--                >-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                    </svg>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->

<!--        &lt;!&ndash; Skills List &ndash;&gt;-->
<!--        <div class="flex flex-col gap-4">-->
<!--            <div v-for="(skill, index) in skills" :key="index" class="relative group">-->
<!--                <div class="flex gap-4 items-baseline">-->
<!--                    <div>-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">-->
<!--                            <circle cx="5" cy="5" r="5" fill="#4984F6" />-->
<!--                        </svg>-->
<!--                    </div>-->
<!--                    <div class="flex flex-col gap-2 w-full relative border p-2 rounded border-dashed">-->
<!--                        <div v-if="!editing[index]">-->
<!--                            <p>-->
<!--                                <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ skill.name }}</span>-->
<!--                            </p>-->
<!--                            <p>-->
<!--                                <span class="text-[#91919A] dark:text-white">{{ skill.description }}</span>-->
<!--                            </p>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Edit Form &ndash;&gt;-->
<!--                        <div v-else class="grid grid-cols-1 gap-4">-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">Skill Name <span class="text-red-600">*</span></label>-->
<!--                                <input-->
<!--                                    v-model="editForms[index].name"-->
<!--                                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"-->
<!--                                    :class="{'border-red-500': editErrors[index]?.name}"-->
<!--                                >-->
<!--                                <p v-if="editErrors[index]?.name" class="mt-1 text-sm text-red-600">{{ editErrors[index].name }}</p>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>-->
<!--                                <textarea-->
<!--                                    v-model="editForms[index].description"-->
<!--                                    rows="3"-->
<!--                                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"-->
<!--                                ></textarea>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="flex gap-1 mt-2 justify-end">-->
<!--                            <button-->
<!--                                v-if="!editing[index]"-->
<!--                                @click="startEditing(index)"-->
<!--                                class="p-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600"-->
<!--                            >-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 21 20" fill="none">-->
<!--                                    <path d="M11.75 5.41664L15.0833 8.74997M3.83334 16.6666H7.16668L15.9167 7.91663C16.3587 7.47461 16.607 6.87509 16.607 6.24997C16.607 5.62485 16.3587 5.02533 15.9167 4.5833C15.4746 4.14127 14.8751 3.89294 14.25 3.89294C13.6249 3.89294 13.0254 4.14127 12.5833 4.5833L3.83334 13.3333V16.6666Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                            <button-->
<!--                                v-if="!editing[index]"-->
<!--                                @click="removeSkill(index)"-->
<!--                                class="p-1 bg-red-500 text-white rounded text-sm hover:bg-red-600"-->
<!--                            >-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                    <path stroke-linecap="round" class="" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                            <button-->
<!--                                v-if="editing[index]"-->
<!--                                @click="cancelEdit(index)"-->
<!--                                class="p-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600"-->
<!--                            >-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                            <button-->
<!--                                v-if="editing[index]"-->
<!--                                @click="saveEdit(index)"-->
<!--                                class="p-1 bg-green-500 text-white rounded text-sm hover:bg-green-600"-->
<!--                            >-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                                </svg>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--    props: {-->
<!--        skills: {-->
<!--            type: Array,-->
<!--            required: true,-->
<!--            default: () => []-->
<!--        }-->
<!--    },-->

<!--    data() {-->
<!--        return {-->
<!--            showAddForm: false,-->
<!--            newSkill: {-->
<!--                name: '',-->
<!--                description: ''-->
<!--            },-->
<!--            editing: [],-->
<!--            editForms: [],-->
<!--            errors: {},-->
<!--            editErrors: [],-->
<!--            isSaving: false,-->
<!--        };-->
<!--    },-->

<!--    watch: {-->
<!--        skills: {-->
<!--            handler() {-->
<!--                this.resetEditingStates();-->
<!--            },-->
<!--            deep: true,-->
<!--            immediate: true-->
<!--        }-->
<!--    },-->

<!--    methods: {-->
<!--        resetEditingStates() {-->
<!--            if (!Array.isArray(this.skills)) {-->
<!--                this.editing = [];-->
<!--                this.editForms = [];-->
<!--                this.editErrors = [];-->
<!--                return;-->
<!--            }-->

<!--            this.editing = this.skills.map(() => false);-->
<!--            this.editForms = this.skills.map(skill => ({-->
<!--                name: skill?.name || '',-->
<!--                description: skill?.description || ''-->
<!--            }));-->
<!--            this.editErrors = this.skills.map(() => ({}));-->
<!--        },-->

<!--        validate(skill) {-->
<!--            const errors = {};-->
<!--            if (!skill.name.trim()) {-->
<!--                errors.name = 'Skill name is required';-->
<!--            } else if (skill.name.length > 50) {-->
<!--                errors.name = 'Skill name must be less than 50 characters';-->
<!--            }-->
<!--            return errors;-->
<!--        },-->

<!--        cancelAdd() {-->
<!--            this.showAddForm = false;-->
<!--            this.newSkill = { name: '', description: '' };-->
<!--            this.errors = {};-->
<!--        },-->

<!--        addSkill() {-->
<!--            this.errors = this.validate(this.newSkill);-->
<!--            if (Object.keys(this.errors).length) return;-->

<!--            this.$emit('add', {...this.newSkill});-->
<!--            this.cancelAdd();-->
<!--            this.requestSavePortfolio();-->
<!--        },-->

<!--        startEditing(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index ? true : item);-->
<!--            this.editErrors[index] = {};-->
<!--        },-->

<!--        cancelEdit(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index ? false : item);-->
<!--            if (this.skills[index]) {-->
<!--                this.editForms[index] = {-->
<!--                    name: this.skills[index].name || '',-->
<!--                    description: this.skills[index].description || ''-->
<!--                };-->
<!--                this.editErrors[index] = {};-->
<!--            }-->
<!--        },-->

<!--        saveEdit(index) {-->
<!--            this.editErrors[index] = this.validate(this.editForms[index]);-->
<!--            if (Object.keys(this.editErrors[index]).length) return;-->

<!--            this.$emit('update', {-->
<!--                index,-->
<!--                skill: {...this.editForms[index]}-->
<!--            });-->
<!--            this.editing = this.editing.map((item, i) => i === index ? false : item);-->
<!--            this.requestSavePortfolio();-->
<!--        },-->

<!--        removeSkill(index) {-->
<!--            if (confirm('Are you sure you want to remove this skill?')) {-->
<!--                this.$emit('remove', index);-->
<!--                this.requestSavePortfolio();-->
<!--            }-->
<!--        }-->
<!--        ,-->
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
<!--};-->
<!--</script>-->
