<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center justify-center rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
        <div class="w-full bg-white dark:bg-[#1E1E1E] transform duration-200 easy-in-out rounded-xl">
            <div class="h-64 overflow-hidden relative">
                <img class="w-full rounded-t-xl" :src="backgroundImage" alt="background cover" />
                <button
                    @click="showBackgroundUpload = true"
                    class="absolute top-2 right-2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70"
                    :disabled="isUploadingBackground"
                >
                    <svg v-if="isUploadingBackground" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <div class="flex justify-start px-5 -mt-12 relative">
                <img class="h-32 w-32 bg-white p-1 rounded-full" :src="avatarImage" alt="avatar" />
                <button
                    @click="showAvatarUpload = true"
                    class="absolute bottom-2 left-[4.5rem] bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70"
                    :disabled="isUploadingAvatar"
                >
                    <svg v-if="isUploadingAvatar" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <div class="p-5 w-full">
                <!-- View Mode -->
                <div v-if="!editing" class="text-left px-5 border border-dashed py-2 rounded w-full relative group">
                    <div class="flex justify-end w-full">
                        <!--                        <button-->
                        <!--                            @click="requestSavePortfolio"-->
                        <!--                            :disabled="isSaving"-->
                        <!--                            class="mb-2 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-75 disabled:cursor-not-allowed flex items-center justify-center gap-1 text-sm"-->
                        <!--                            title="Save Portfolio"-->
                        <!--                        >-->
                        <!--                            <svg v-if="isSaving" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">-->
                        <!--                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
                        <!--                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
                        <!--                            </svg>-->
                        <!--                            <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">-->
                        <!--                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
                        <!--                            </svg>-->
                        <!--                            <span class="hidden sm:inline">Save</span>-->
                        <!--                        </button>-->
                        <button
                            @click="startEditing"
                            class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h2 class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold">
                            {{ localPortfolio.fullname || $t('Your Name') }}
                        </h2>
                        <p class="text-[#706F81] dark:text-white">
                            {{ localPortfolio.description || $t('Headline') }}
                        </p>
                        <p class="text-[#91919A] dark:text-white italic">
                            {{ localPortfolio.summary || '' }}
                        </p>
                    </div>

                    <!--                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">-->
                    <!--                        <button-->
                    <!--                            @click="startEditing"-->
                    <!--                            class="p-1 bg-gray-500 text-white rounded hover:bg-gray-600"-->
                    <!--                        >-->
                    <!--                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 21 20" fill="none">-->
                    <!--                                <path d="M11.75 5.41664L15.0833 8.74997M3.83334 16.6666H7.16668L15.9167 7.91663C16.3587 7.47461 16.607 6.87509 16.607 6.24997C16.607 5.62485 16.3587 5.02533 15.9167 4.5833C15.4746 4.14127 14.8751 3.89294 14.25 3.89294C13.6249 3.89294 13.0254 4.14127 12.5833 4.5833L3.83334 13.3333V16.6666Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
                    <!--                            </svg>-->
                    <!--                        </button>-->
                    <!--                    </div>-->
                </div>

                <!-- Edit Form -->
                <div v-else class="p-4 border border-gray-300 rounded-lg mb-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Full Name')}} <span class="text-red-600">*</span></label>
                            <input
                                v-model="editForm.fullname"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2"
                                :placeholder="$t('Your Name')"
                                :class="{'border-red-500': errors.fullname}"
                            >
                            <p v-if="errors.fullname" class="mt-1 text-sm text-red-600">{{ errors.fullname }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Headline')}}</label>
                            <input
                                v-model="editForm.description"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2"
                                :placeholder="$t('Headline')"
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

                <!--                <div class="h-20 pr-4">-->
                <!--                    &lt;!&ndash; Skills passport card placeholder &ndash;&gt;-->
                <!--                </div>-->
            </div>

            <!-- Background Upload Modal -->
            <div v-if="showBackgroundUpload" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-[#1E1E1E] p-6 rounded-lg w-full max-w-md flex flex-col gap-4">
                    <h3 class="text-lg font-semibold">{{$t('Upload Background Image')}}</h3>
                    <label for="background-upload" class="w-full px-4 py-2 flex justify-center cursor-pointer border border-dashed rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="5rem" viewBox="0 0 24 24" width="5rem" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M21.02 5H19V2.98c0-.54-.44-.98-.98-.98h-.03c-.55 0-.99.44-.99.98V5h-2.01c-.54 0-.98.44-.99.98v.03c0 .55.44.99.99.99H17v2.01c0 .54.44.99.99.98h.03c.54 0 .98-.44.98-.98V7h2.02c.54 0 .98-.44.98-.98v-.04c0-.54-.44-.98-.98-.98zM16 9.01V8h-1.01c-.53 0-1.03-.21-1.41-.58-.37-.38-.58-.88-.58-1.44 0-.36.1-.69.27-.98H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8.28c-.3.17-.64.28-1.02.28-1.09-.01-1.98-.9-1.98-1.99zM15.96 19H6c-.41 0-.65-.47-.4-.8l1.98-2.63c.21-.28.62-.26.82.02L10 18l2.61-3.48c.2-.26.59-.27.79-.01l2.95 3.68c.26.33.03.81-.39.81z"/></svg>
                    </label>
                    <input id="background-upload"
                           type="file"
                           @change="handleBackgroundUpload"
                           accept="image/*"
                           class="mb-4 hidden"
                           :disabled="isUploadingBackground"
                    >

                    <div class="flex justify-end gap-2">
                        <button
                            @click="showBackgroundUpload = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded"
                            :disabled="isUploadingBackground"
                        >
                            {{$t('Cancel')}}
                        </button>
                        <button
                            @click="saveBackgroundImage"
                            :disabled="!newBackgroundFile || isUploadingBackground"
                            class="px-4 py-2 bg-blue-500 text-white rounded flex items-center justify-center gap-2 min-w-[80px] disabled:opacity-50"
                        >
                            <svg
                                v-if="isUploadingBackground"
                                class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ isUploadingBackground ? $t('Uploading...') : $t('Save') }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Avatar Upload Modal -->
            <div v-if="showAvatarUpload" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-[#1E1E1E] p-6 rounded-lg w-full max-w-md flex flex-col gap-2">
                    <h3 class="text-lg font-semibold">{{$t('Upload Profile Picture')}}</h3>
                    <label for="avatar-upload" class="w-full px-4 py-2 flex justify-center cursor-pointer border border-dashed rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" height="5rem" viewBox="0 0 24 24" width="5rem" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M21.02 5H19V2.98c0-.54-.44-.98-.98-.98h-.03c-.55 0-.99.44-.99.98V5h-2.01c-.54 0-.98.44-.99.98v.03c0 .55.44.99.99.99H17v2.01c0 .54.44.99.99.98h.03c.54 0 .98-.44.98-.98V7h2.02c.54 0 .98-.44.98-.98v-.04c0-.54-.44-.98-.98-.98zM16 9.01V8h-1.01c-.53 0-1.03-.21-1.41-.58-.37-.38-.58-.88-.58-1.44 0-.36.1-.69.27-.98H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8.28c-.3.17-.64.28-1.02.28-1.09-.01-1.98-.9-1.98-1.99zM15.96 19H6c-.41 0-.65-.47-.4-.8l1.98-2.63c.21-.28.62-.26.82.02L10 18l2.61-3.48c.2-.26.59-.27.79-.01l2.95 3.68c.26.33.03.81-.39.81z"/></svg>
                    </label>
                    <input
                        type="file"
                        id="avatar-upload"
                        @change="handleAvatarUpload"
                        accept="image/*"
                        class="mb-4 hidden"
                        :disabled="isUploadingAvatar"
                    >
                    <div class="flex justify-end gap-2">
                        <button
                            @click="showAvatarUpload = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded"
                            :disabled="isUploadingAvatar"
                        >
                            {{$t('Cancel')}}
                        </button>
                        <button
                            @click="saveAvatarImage"
                            :disabled="!newAvatarFile || isUploadingAvatar"
                            class="px-4 py-2 bg-blue-500 text-white rounded flex items-center justify-center gap-2 min-w-[80px] disabled:opacity-50"
                        >
                            <svg
                                v-if="isUploadingAvatar"
                                class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ isUploadingAvatar ? $t('Uploading...') : $t('Save') }}</span>
                        </button>
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
    </div>
</template>

<script>
export default {
    props: {
        portfolio: {
            type: Object,
            required: true,
            default: () => ({
                fullname: '',
                description: '',
                summary: '',
                background_image: '',
                avatar: ''
            })
        }
    },

    data() {
        return {
            localPortfolio: {...this.portfolio},
            showBackgroundUpload: false,
            showAvatarUpload: false,
            backgroundImage: this.portfolio.cover_photo || 'https://images.unsplash.com/photo-1605379399642-870262d3d051?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80',
            avatarImage: this.portfolio.avatar || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80',
            newBackgroundFile: null,
            newAvatarFile: null,
            isUploadingBackground: false,
            isUploadingAvatar: false,
            isSaving: false,
            editing: false,
            editForm: {
                fullname: '',
                description: ''
            },
            errors: {},
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            beforeUnloadListener: null
        };
    },

    watch: {
        portfolio: {
            handler(newVal) {
                this.localPortfolio = {...newVal};
                this.updateImageUrls(newVal);
            },
            deep: true,
            immediate: true
        },
        // Watch for changes in edit form
        editForm: {
            handler() {
                const hasChanges = JSON.stringify(this.editForm) !== JSON.stringify({
                    fullname: this.localPortfolio.fullname,
                    description: this.localPortfolio.description
                });

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
        this.cleanupImageUrls();
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

            if (this.editForm.description && this.editForm.description.length > 200) {
                this.errors.description =  this.$t('Headline must be less than 200 characters');
                isValid = false;
            }

            return isValid;
        },

        startEditing() {
            this.editing = true;
            this.editForm = {
                fullname: this.localPortfolio.fullname || '',
                description: this.localPortfolio.description || ''
            };
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
                description: ''
            };
            this.errors = {};
            this.setUnsavedChanges(false);
        },

        saveEdit() {
            if (!this.validate()) return;

            this.localPortfolio.fullname = this.editForm.fullname;
            this.localPortfolio.description = this.editForm.description;

            this.$emit('update-portfolio', {
                fullname: this.localPortfolio.fullname,
                description: this.localPortfolio.description,
                summary: this.localPortfolio.summary
            });

            this.editing = false;
            this.requestSavePortfolio();
            this.setUnsavedChanges(false);
        },

        updateImageUrls(portfolio) {
            if (portfolio.background_image) {
                this.backgroundImage = portfolio.cover_photo;
            }
            if (portfolio.avatar) {
                this.avatarImage = portfolio.avatar;
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

        handleBackgroundUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (!file.type.match('image.*')) {
                alert(this.$t('Please select an image file'));
                return;
            }

            this.newBackgroundFile = file;
            this.backgroundImage = URL.createObjectURL(file);
        },

        handleAvatarUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (!file.type.match('image.*')) {
                alert(this.$t('Please select an image file'));
                return;
            }

            this.newAvatarFile = file;
            this.avatarImage = URL.createObjectURL(file);
        },

        async saveBackgroundImage() {
            if (!this.newBackgroundFile) {
                this.showBackgroundUpload = false;
                return;
            }

            this.isUploadingBackground = true;
            try {
                const imagePath = await this.uploadFile(this.newBackgroundFile, 'background');
                this.backgroundImage = imagePath;
                this.$emit('update-portfolio', { cover_photo: imagePath });
                this.showBackgroundUpload = false;
                this.newBackgroundFile = null;
                this.requestSavePortfolio();
            } catch (error) {
                console.error(this.$t('Error uploading background image:'), error);
                // You can add a toast notification here if needed
            } finally {
                this.isUploadingBackground = false;
            }
        },

        async saveAvatarImage() {
            if (!this.newAvatarFile) {
                this.showAvatarUpload = false;
                return;
            }

            this.isUploadingAvatar = true;
            try {
                const imagePath = await this.uploadFile(this.newAvatarFile, 'avatar');
                this.avatarImage = imagePath;
                this.$emit('update-portfolio', { avatar: imagePath });
                this.showAvatarUpload = false;
                this.newAvatarFile = null;
                this.requestSavePortfolio();
            } catch (error) {
                console.error(this.$t('Error uploading avatar:'), error);
                // You can add a toast notification here if needed
            } finally {
                this.isUploadingAvatar = false;
            }
        },

        async uploadFile(file, type) {
            try {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('type', type);

                const response = await axios.post('/trainee/career-guidance/portfolios/upload-image', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                return response.data.url;
            } catch (error) {
                console.error(this.$t('Upload error:'), error.response?.data?.message || error.message);
                throw error;
            }
        },

        cleanupImageUrls() {
            if (this.newBackgroundFile) {
                URL.revokeObjectURL(this.backgroundImage);
            }
            if (this.newAvatarFile) {
                URL.revokeObjectURL(this.avatarImage);
            }
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
