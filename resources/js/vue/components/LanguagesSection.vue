<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
        <div class="flex justify-between items-center">
            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('Languages')}}</p>
            <button
                @click="showAddLanguageForm"
                class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Language')}}</label>
                    <input
                        v-model="newLanguage"
                        @keyup.enter="addLanguage"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                        :placeholder="$t('Language and level')"
                    >
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-1">
                <button
                    @click="cancelAddLanguage"
                    class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
                <button
                    @click="addLanguage"
                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Languages List -->
        <div class="flex flex-wrap gap-4">
            <div v-for="(language, index) in languages" :key="index" class="relative group">
                <div class="flex items-center gap-2 border border-dashed rounded p-1">
                  <span class="text-[#CF9090] bg-[#FFF7F7] dark:bg-[#282828] px-2 py-1 font-semibold rounded-lg">
                    {{ language }}
                  </span>
                    <button
                        @click="removeLanguage(index)"
                        class="opacity-0 group-hover:opacity-100 text-red-500 hover:text-red-700 transition-opacity"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Warning Modal -->
        <div v-if="showWarning" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{$t('Unsaved Changes')}}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                    {{$t("You are adding a new language but haven't saved it yet. If you leave now, your unsaved data will be lost.")}}
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
        languages: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            showAddForm: false,
            newLanguage: '',
            isSaving: false,
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            beforeUnloadListener: null
        };
    },

    watch: {
        newLanguage(newVal) {
            // Chỉ đánh dấu có thay đổi khi có nội dung và form đang mở
            if (newVal.trim() !== '' && this.showAddForm) {
                this.setUnsavedChanges(true);
            } else {
                this.setUnsavedChanges(false);
            }
        },
        showAddForm(newVal) {
            // Khi đóng form, reset trạng thái thay đổi
            if (!newVal) {
                this.setUnsavedChanges(false);
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
        showAddLanguageForm() {
            this.showAddForm = true;
            this.setUnsavedChanges(false); // Reset khi mở form
        },

        addLanguage() {
            const trimmedLang = this.newLanguage.trim();

            if (trimmedLang && !this.languages.includes(trimmedLang)) {
                this.$emit('add', trimmedLang);
                this.newLanguage = '';
                this.showAddForm = false;
                this.setUnsavedChanges(false); // Reset sau khi thêm
                this.requestSavePortfolio();
            } else if (this.languages.includes(trimmedLang)) {
                alert('Duplicate language: ' + trimmedLang);
            } else if (trimmedLang === '') {
                // Nếu ngôn ngữ trống, chỉ đóng form
                this.showAddForm = false;
                this.setUnsavedChanges(false);
            }
        },


        cancelAddLanguage() {
            if (this.hasUnsavedChanges) {
                // Show warning if there are unsaved changes
                this.showWarning = true;
                this.pendingAction = 'cancel';
            } else {
                this.doCancelAddLanguage();
            }
        },

        doCancelAddLanguage() {
            this.showAddForm = false;
            this.newLanguage = '';
            this.setUnsavedChanges(false);
        },

        removeLanguage(index) {
            if (confirm(this.$t('Are you sure you want to remove this language?'))) {
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
            this.doCancelAddLanguage();
            this.pendingAction = null;
        },

        // Handle when user chooses to save and continue
        saveAndContinue() {
            this.showWarning = false;
            this.addLanguage();
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
