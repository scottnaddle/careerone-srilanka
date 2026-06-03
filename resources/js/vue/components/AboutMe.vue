
<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
        <div class="flex justify-between items-center">
            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('About me')}}</p>
            <button v-if="!editing"
                    @click="startEditing"
                    class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>
        </div>

        <!-- View Mode -->
        <div v-if="!editing" class="relative group">
            <div class="text-lg text-[#706F81] dark:text-white bg-transparent p-2 rounded-xl border border-dashed border-transparent group-hover:border-gray-300 transition-colors">
                <p v-if="localAboutMe" class="text-lg text-[#706F81] dark:text-white whitespace-pre-line break-words">{{ localAboutMe }}</p>
                <p v-else class="text-gray-400 italic">{{$t('Tell us about yourself...')}}</p>
            </div>
        </div>

        <!-- Edit Form -->
        <div v-else class="p-4 border border-gray-300 rounded-lg">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white mb-2">{{$t('About me')}} <span class="text-red-600">*</span></label>
                <textarea
                    v-model="editForm.aboutMe"
                    rows="5"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2"
                    :placeholder="$t('Tell us about yourself...')"
                    :class="{'border-red-500': errors.aboutMe}"
                ></textarea>
                <p v-if="errors.aboutMe" class="mt-1 text-sm text-red-600">{{ errors.aboutMe }}</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    {{$t('Character count:')}} {{ editForm.aboutMe.length }}/1000
                </p>
            </div>
            <div class="mt-4 flex justify-end gap-1">
                <button
                    @click="cancelEdit"
                    class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
                <button
                    @click="saveEdit"
                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </button>
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
        aboutMe: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            localAboutMe: this.aboutMe || '',
            isSaving: false,
            editing: false,
            editForm: {
                aboutMe: ''
            },
            errors: {},
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            beforeUnloadListener: null
        };
    },

    watch: {
        aboutMe(newVal) {
            this.localAboutMe = newVal || '';
        },
        // Watch for changes in edit form
        'editForm.aboutMe': function(newVal) {
            const hasChanges = newVal !== this.localAboutMe;
            if (hasChanges && this.editing) {
                this.setUnsavedChanges(true);
            }
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
        validate() {
            this.errors = {};
            let isValid = true;

            if (!this.editForm.aboutMe.trim()) {
                this.errors.aboutMe = this.$t('About me is required');
                isValid = false;
            } else if (this.editForm.aboutMe.length > 1000) {
                this.errors.aboutMe = this.$t('About me must be less than 1000 characters');
                isValid = false;
            }

            return isValid;
        },

        startEditing() {
            this.editing = true;
            this.editForm.aboutMe = this.localAboutMe || '';
            this.errors = {};
            this.setUnsavedChanges(false); // Reset khi bắt đầu chỉnh sửa
        },

        cancelEdit() {
            if (this.hasUnsavedChanges) {
                // Show warning if there are unsaved changes
                this.showWarning = true;
                this.pendingAction = 'cancelEdit';
            } else {
                this.doCancelEdit();
            }
        },

        doCancelEdit() {
            this.editing = false;
            this.editForm.aboutMe = '';
            this.errors = {};
            this.setUnsavedChanges(false);
        },

        saveEdit() {
            if (!this.validate()) return;

            this.localAboutMe = this.editForm.aboutMe;
            this.$emit('update', this.localAboutMe);
            this.editing = false;
            this.requestSavePortfolio();
            this.setUnsavedChanges(false); // Reset sau khi lưu thành công
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

            if (this.pendingAction === 'cancelEdit') {
                this.doCancelEdit();
            }

            this.pendingAction = null;
        },

        // Handle when user chooses to save and continue
        saveAndContinue() {
            this.showWarning = false;

            if (this.pendingAction === 'cancelEdit') {
                this.saveEdit();
            }

            this.pendingAction = null;
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
