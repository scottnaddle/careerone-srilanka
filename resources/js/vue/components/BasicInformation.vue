<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
        <div class="flex justify-between items-center">
            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('Basic Information')}}</p>
<!--            <button-->
<!--                @click="requestSavePortfolio"-->
<!--                :disabled="isSaving"-->
<!--                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-75 disabled:cursor-not-allowed flex items-center justify-center gap-1 text-sm"-->
<!--                title="Save Portfolio"-->
<!--            >-->
<!--                <svg v-if="isSaving" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">-->
<!--                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
<!--                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
<!--                </svg>-->
<!--                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">-->
<!--                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                </svg>-->
<!--                <span class="hidden sm:inline">Save</span>-->
<!--            </button>-->
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
        <div v-if="!editing" class="flex flex-col gap-6">
            <div class="flex flex-col gap-4">
                <div class="flex gap-4 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M16.6654 17.5C16.6654 16.337 16.6654 15.7555 16.5218 15.2824C16.1987 14.217 15.365 13.3834 14.2996 13.0602C13.8265 12.9167 13.245 12.9167 12.082 12.9167H7.91537C6.7524 12.9167 6.17091 12.9167 5.69775 13.0602C4.63241 13.3834 3.79873 14.217 3.47556 15.2824C3.33203 15.7555 3.33203 16.337 3.33203 17.5M13.7487 6.25C13.7487 8.32107 12.0698 10 9.9987 10C7.92763 10 6.2487 8.32107 6.2487 6.25C6.2487 4.17893 7.92763 2.5 9.9987 2.5C12.0698 2.5 13.7487 4.17893 13.7487 6.25Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-sm text-[#464559] dark:text-white w-full py-1 px-2">
                        {{ localBasicInfo.fullname || $t('Full Name') }}
                    </div>
                </div>

                <div class="flex gap-4 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87038 6.63568 6.82146 6.92256 6.88957 7.15619C6.90873 7.22193 6.93367 7.27389 6.98356 7.37779Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-sm text-[#464559] dark:text-white w-full py-1 px-2">
                        {{ localBasicInfo.phone || $t('Phone Number') }}
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex gap-4 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M17.9179 14.9997L12.3823 9.99967M7.62035 9.99967L2.08466 14.9997M1.66797 5.83301L8.47207 10.5959C9.02304 10.9816 9.29853 11.1744 9.59819 11.2491C9.86288 11.3151 10.1397 11.3151 10.4044 11.2491C10.7041 11.1744 10.9796 10.9816 11.5305 10.5959L18.3346 5.83301M5.66797 16.6663H14.3346C15.7348 16.6663 16.4348 16.6663 16.9696 16.3939C17.44 16.1542 17.8225 15.7717 18.0622 15.3013C18.3346 14.7665 18.3346 14.0665 18.3346 12.6663V7.33301C18.3346 5.93288 18.3346 5.23281 18.0622 4.69803C17.8225 4.22763 17.44 3.84517 16.9696 3.60549C16.4348 3.33301 15.7348 3.33301 14.3346 3.33301H5.66797C4.26784 3.33301 3.56777 3.33301 3.03299 3.60549C2.56259 3.84517 2.18014 4.22763 1.94045 4.69803C1.66797 5.23281 1.66797 5.93288 1.66797 7.33301V12.6663C1.66797 14.0665 1.66797 14.7665 1.94045 15.3013C2.18014 15.7717 2.56259 16.1542 3.03299 16.3939C3.56777 16.6663 4.26784 16.6663 5.66797 16.6663Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-sm text-[#464559] dark:text-white w-full py-1 px-2">
                        {{ localBasicInfo.email || $t('Email') }}
                    </div>
                </div>

                <div class="flex gap-4 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M9.9987 10.417C11.3794 10.417 12.4987 9.2977 12.4987 7.91699C12.4987 6.53628 11.3794 5.41699 9.9987 5.41699C8.61799 5.41699 7.4987 6.53628 7.4987 7.91699C7.4987 9.2977 8.61799 10.417 9.9987 10.417Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9.9987 18.3337C11.6654 15.0003 16.6654 12.8489 16.6654 8.33366C16.6654 4.65176 13.6806 1.66699 9.9987 1.66699C6.3168 1.66699 3.33203 4.65176 3.33203 8.33366C3.33203 12.8489 8.33203 15.0003 9.9987 18.3337Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-sm text-[#464559] dark:text-white w-full py-1 px-2">
                        {{ localBasicInfo.address || $t('Address') }}
                    </div>
                </div>
            </div>

<!--            <div class="flex justify-end">-->
<!--                <button-->
<!--                    @click="startEditing"-->
<!--                    class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"-->
<!--                >-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 21 20" fill="none">-->
<!--                        <path d="M11.75 5.41664L15.0833 8.74997M3.83334 16.6666H7.16668L15.9167 7.91663C16.3587 7.47461 16.607 6.87509 16.607 6.24997C16.607 5.62485 16.3587 5.02533 15.9167 4.5833C15.4746 4.14127 14.8751 3.89294 14.25 3.89294C13.6249 3.89294 13.0254 4.14127 12.5833 4.5833L3.83334 13.3333V16.6666Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                    </svg>-->
<!--                </button>-->
<!--            </div>-->
        </div>

        <!-- Edit Form -->
        <div v-else class="p-4 border border-gray-300 rounded-lg mb-4">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Full Name')}} <span class="text-red-600">*</span></label>
                    <input
                        v-model="editForm.fullname"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                        :placeholder="$t('Full Name')"
                        :class="{'border-red-500': errors.fullname}"
                    >
                    <p v-if="errors.fullname" class="mt-1 text-sm text-red-600">{{ errors.fullname }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Phone Number')}}</label>
                    <input
                        v-model="editForm.phone"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                        :placeholder="$t('Phone Number')"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Email')}} <span class="text-red-600">*</span></label>
                    <input
                        v-model="editForm.email"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                        :placeholder="$t('Email')"
                        :class="{'border-red-500': errors.email}"
                    >
                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Address')}}</label>
                    <input
                        v-model="editForm.address"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"
                        :placeholder="$t('Address')"
                    >
                </div>
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
        basicInfo: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            localBasicInfo: JSON.parse(JSON.stringify(this.basicInfo)),
            isSaving: false,
            editing: false,
            editForm: {
                fullname: '',
                phone: '',
                email: '',
                address: ''
            },
            errors: {},
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            beforeUnloadListener: null
        };
    },

    watch: {
        basicInfo: {
            handler(newVal) {
                this.localBasicInfo = JSON.parse(JSON.stringify(newVal));
            },
            deep: true
        },
        // Watch for changes in edit form
        editForm: {
            handler() {
                const hasChanges = JSON.stringify(this.editForm) !== JSON.stringify(this.localBasicInfo);
                if (hasChanges && this.editing) {
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
        validate() {
            this.errors = {};
            let isValid = true;

            if (!this.editForm.fullname.trim()) {
                this.errors.fullname = this.$t('Full name is required');
                isValid = false;
            } else if (this.editForm.fullname.length > 100) {
                this.errors.fullname = this.$t('Full name must be less than 100 characters');
                isValid = false;
            }

            if (!this.editForm.email.trim()) {
                this.errors.email = this.$t('Email is required');
                isValid = false;
            } else if (!this.isValidEmail(this.editForm.email)) {
                this.errors.email = this.$t('Please enter a valid email address');
                isValid = false;
            }

            return isValid;
        },

        isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

        startEditing() {
            this.editing = true;
            this.editForm = JSON.parse(JSON.stringify(this.localBasicInfo));
            this.errors = {};
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
            this.editForm = {
                fullname: '',
                phone: '',
                email: '',
                address: ''
            };
            this.errors = {};
            this.setUnsavedChanges(false);
        },

        saveEdit() {
            if (!this.validate()) return;

            this.localBasicInfo = JSON.parse(JSON.stringify(this.editForm));
            this.$emit('update', this.localBasicInfo);
            this.editing = false;
            this.requestSavePortfolio();
            this.setUnsavedChanges(false);
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
