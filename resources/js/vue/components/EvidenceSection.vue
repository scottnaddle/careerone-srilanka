<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('Supporting Documents')}}</p>
                <p class="text-[#9F9FAA] dark:text-white">{{$t('Upload certificates, letters, and other official documents that verify your training, work experience, or achievements. These records help validate your skills and career progress.')}}
                </p>
            </div>

            <button @click="showAddEvidenceForm" class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="none">
                    <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- Add Form -->
        <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Document Type -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Type')}} <span class="text-red-600">*</span></label>
                    <select v-model="newEvidence.document_type" :class="{'border-red-500': errors.document_type}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2">
                        <option value="" disabled selected>{{$t('Select document type')}}</option>
                        <option value="NVQ certificate">{{$t('NVQ certificate')}}</option>
                        <option value="On-the-Job Training (OJT) completion letter">{{$t('On-the-Job Training (OJT) completion letter')}}</option>
                        <option value="Internship Completion Letter">{{$t('Internship Completion Letter')}}</option>
                        <option value="Employment Service Letter">{{$t('Employment Service Letter')}}</option>
                    </select>
                    <p v-if="errors.document_type" class="mt-1 text-sm text-red-600">{{ errors.document_type }}</p>
                </div>

                <!-- Document Title -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Title')}} <span class="text-red-600">*</span></label>
                    <input v-model="newEvidence.name" :placeholder="$t('Document title name')" :class="{'border-red-500': errors.name}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </div>

                <!-- Issuing Organisation -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issuing Organisation')}} <span class="text-red-600">*</span></label>
                    <input v-model="newEvidence.issuing_organisation" :placeholder="$t('Issuing organisation name')" :class="{'border-red-500': errors.issuing_organisation}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                    <p v-if="errors.issuing_organisation" class="mt-1 text-sm text-red-600">{{ errors.issuing_organisation }}</p>
                </div>

                <!-- Issue Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issue Date')}} <span class="text-red-600">*</span></label>
                    <flowbite-datepicker type="month" v-model="newEvidence.issue_date" :placeholder="$t('Issue Date')" :class="{'border-red-500': errors.issue_date}"></flowbite-datepicker>
                    <p v-if="errors.issue_date" class="mt-1 text-sm text-red-600">{{ errors.issue_date }}</p>
                </div>

                <!-- Validity Period -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Validity Period (if applicable)')}}</label>
                    <flowbite-datepicker type="month" v-model="newEvidence.validity_period" :placeholder="$t('Validity Period')"></flowbite-datepicker>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                    <textarea v-model="newEvidence.description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Description')"></textarea>
                </div>

                <!-- Certificate Image -->
                <div class="md:col-span-2 relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Upload Document')}} <span class="text-red-600">*</span></label>
                    <label for="evidence-upload" class="absolute text-white px-4 py-2 rounded bg-gray-500 cursor-pointer hover:bg-gray-600">
                        {{$t('Select file')}}
                    </label>
                    <input type="file" id="evidence-upload" @change="handleFileUpload" class="mt-1 block w-full hidden" :class="{'border-red-500': errors.file}">
                    <p v-if="errors.file" class="mt-1 text-sm text-red-600" style="padding-left: 12rem">{{ errors.file }}</p>
                    <img v-if="newEvidence.attachment_path" :src="newEvidence.attachment_path" class="mt-10 h-32 object-contain">
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button @click="cancelAdd" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
                <button
                    @click="addEvidence"
                    :disabled="isLoading"
                    class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600 flex items-center justify-center gap-1"
                >
                    <svg v-if="isLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span v-if="!isLoading">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                  </span>
                </button>
            </div>
        </div>

        <!-- Evidence List -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div v-for="(evidence, index) in evidences" :key="index" class="mb-10 px-4 border border-dashed p-2 border-gray-300 dark:border-white rounded-xl relative group">
                <div class="absolute top-0 right-0 flex gap-1 z-30">
                    <button v-if="!editing[index]" @click="startEditing(index)" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button v-if="!editing[index]" @click="removeEvidence(index)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>

                <div v-if="!editing[index]">
                    <div class="h-96 overflow-hidden flex justify-center border-b border-gray-300 dark:border-white">
                        <img :src="evidence.attachment_path" class="object-cover object-center h-full w-auto !filter-none">
                    </div>
                    <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-2 dark:text-white break-words">
                        {{ evidence.document_type }}: {{ evidence.name }}
                    </h2>

                    <div class="mb-1">
                        <span class="font-semibold dark:text-white">{{$t('Issued by')}}: </span>
                        <span class="dark:text-gray-300 break-words">{{ evidence.issuing_organisation }}</span>
                    </div>

                    <div class="mb-1">
                        <span class="font-semibold dark:text-white">{{$t('Issue Date')}}: </span>
                        <span class="dark:text-gray-300">{{ formatDate(evidence.issue_date) }}</span>
                    </div>

                    <div v-if="evidence.validity_period" class="mb-1">
                        <span class="font-semibold dark:text-white">{{$t('Valid until')}}: </span>
                        <span class="dark:text-gray-300">{{ formatDate(evidence.validity_period) }}</span>
                    </div>

                    <div v-if="evidence.description" class="mb-12">
                        <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Description')}}:</p>
                        <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ evidence.description }}</p>
                    </div>
                </div>

                <!-- Edit Form -->
                <div v-else>
                    <div class="relative h-96 flex justify-center items-center border rounded-xl overflow-hidden shadow-md group">
                        <!-- Image preview -->
                        <img
                            v-if="editForms[index].attachment_path"
                            :src="editForms[index].attachment_path"
                            class="object-cover object-center h-full w-full transition duration-300 group-hover:blur-sm"
                        >
                        <div v-else class="flex flex-col items-center justify-center h-full w-full bg-gray-100 dark:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10 0h3a1 1 0 001-1V7m-5 4V5a1 1 0 00-1-1H9a1 1 0 00-1 1v6m8 0h-8" />
                            </svg>
                            <p class="text-gray-400 mt-2">{{$t('Image empty')}}</p>
                        </div>

                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black bg-opacity-50  flex justify-center items-center transition duration-300">
                            <label class="px-4 py-2 bg-white text-gray-700 font-medium rounded-lg shadow cursor-pointer hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>

                                <input type="file" @change="handleEditFileUpload(index, $event)" class="hidden">
                            </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Type')}} <span class="text-red-600">*</span></label>
                        <select v-model="editForms[index].document_type" :class="{'border-red-500': editErrors[index].document_type}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2">
                            <option value="" disabled>{{$t('Select document type')}}</option>
                            <option value="NVQ certificate">{{$t('NVQ certificate')}}</option>
                            <option value="On-the-Job Training (OJT) completion letter">{{$t('On-the-Job Training (OJT) completion letter')}}</option>
                            <option value="Internship Completion Letter">{{$t('Internship Completion Letter')}}</option>
                            <option value="Employment Service Letter">{{$t('Employment Service Letter')}}</option>
                        </select>
                        <p v-if="editErrors[index]?.document_type" class="mt-1 text-sm text-red-600">{{ editErrors[index].document_type }}</p>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Title')}} <span class="text-red-600">*</span></label>
                        <input v-model="editForms[index].name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :class="{'border-red-500': editErrors[index].name}">
                        <p v-if="editErrors[index]?.name" class="mt-1 text-sm text-red-600">{{ editErrors[index].name }}</p>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issuing Organisation')}} <span class="text-red-600">*</span></label>
                        <input v-model="editForms[index].issuing_organisation" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :class="{'border-red-500': editErrors[index].issuing_organisation}">
                        <p v-if="editErrors[index]?.issuing_organisation" class="mt-1 text-sm text-red-600">{{ editErrors[index].issuing_organisation }}</p>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issue Date')}} <span class="text-red-600">*</span></label>
                        <flowbite-datepicker type="month" v-model="editForms[index].issue_date" :placeholder="$t('Issue Date')" :class="{'border-red-500': editErrors[index]?.issue_date}"></flowbite-datepicker>
                        <p v-if="editErrors[index]?.issue_date" class="mt-1 text-sm text-red-600">{{ editErrors[index].issue_date }}</p>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Validity Period (if applicable)')}}</label>
                        <flowbite-datepicker type="month" v-model="editForms[index].validity_period" :placeholder="$t('Validity Period')"></flowbite-datepicker>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                        <textarea v-model="editForms[index].description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div class="mt-4 flex justify-end gap-1">
                        <button @click="cancelEdit(index)" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button
                            @click="saveEdit(index)"
                            :disabled="isLoading"
                            class="px-2 py-1  bg-primary text-white rounded hover:bg-blue-600 "
                        >
                            <svg v-if="isLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 极 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span >
                                <svg v-if="!isLoading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </span>
                        </button>
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
        evidences: { type: Array, default: () => [] }
    },

    data() {
        return {
            showAddForm: false,
            newEvidence: {
                document_type: '',
                name: '',
                issuing_organisation: '',
                issue_date: '', // Will be stored as 'YYYY-MM'
                validity_period: '', // Will be stored as 'YYYY-MM'
                description: '',
                attachment_path: ''
            },
            file: null,
            errors: {},
            editing: [],
            editForms: [],
            editFiles: {},
            editErrors: [],
            isLoading: false,
            isAdding: false,
            isEditing: {},
            isUploading: false,
            isSaving: false,
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            pendingIndex: null,
            beforeUnloadListener: null
        }
    },

    watch: {
        // Watch for changes in new evidence form
        newEvidence: {
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

                    const original = this.evidences[index];
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
        },
        evidences: {
            handler() { this.resetEditingStates() },
            deep: true,
            immediate: true
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
        // Set up warning when leaving page
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

        // Remove event listener
        removeBeforeUnloadListener() {
            if (this.beforeUnloadListener) {
                window.removeEventListener('beforeunload', this.beforeUnloadListener);
            }
        },

        // Update changes state
        setUnsavedChanges(hasChanges) {
            this.hasUnsavedChanges = hasChanges;
        },

        // Existing methods updated to manage change state
        resetEditingStates() {
            this.editing = this.evidences.map(() => false);
            this.editForms = this.evidences.map(ev => {
                // Convert date format from YYYY-MM-DD to YYYY-MM if needed
                let issue_date = ev?.issue_date || '';
                let validity_period = ev?.validity_period || '';

                // Convert from YYYY-MM-DD to YYYY-MM if needed
                if (issue_date && issue_date.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    issue_date = issue_date.substring(0, 7); // Take YYYY-MM
                }
                if (validity_period && validity_period.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    validity_period = validity_period.substring(0, 7); // Take YYYY-MM
                }

                return {
                    ...ev,
                    issue_date,
                    validity_period
                };
            });
            this.editErrors = this.evidences.map(() => ({}));
            this.editFiles = {};
            this.setUnsavedChanges(false); // Reset change state
        },

        showAddEvidenceForm() {
            this.showAddForm = true;
        },

        async addEvidence() {
            this.isAdding = true;
            this.errors = this.validate(this.newEvidence);
            if (Object.keys(this.errors).length) return;

            this.isLoading = true;
            try {
                const uploadedPath = await this.uploadFile(this.file);
                if (uploadedPath) {
                    this.newEvidence.attachment_path = uploadedPath;
                }

                this.$emit('add', { ...this.newEvidence });
                this.requestSavePortfolio();
                this.setUnsavedChanges(false);
                this.cancelAdd();
                this.setUnsavedChanges(false); // Reset after successful save
            } catch (error) {
                this.errors.file = error.message;
            } finally {
                this.isLoading = false;
            }
        },

        async saveEdit(index) {
            this.isEditing[index] = true;
            this.editErrors[index] = this.validate(this.editForms[index], true);
            if (Object.keys(this.editErrors[index]).length) return;

            this.isLoading = true;
            try {
                if (this.editFiles[index]) {
                    const uploadedPath = await this.uploadFile(this.editFiles[index]);
                    if (uploadedPath) {
                        this.editForms[index].attachment_path = uploadedPath;
                    }
                }

                this.$emit('update', { index, evidence: { ...this.editForms[index] } });
                this.editing = this.editing.map((item, i) => i === index ? false : item);
                delete this.editFiles[index];
                this.requestSavePortfolio();
                this.setUnsavedChanges(false); // Reset after successful save
            } catch (error) {
                this.editErrors[index].file = error.message;
            } finally {
                this.isLoading = false;
                this.isEditing[index] = false;
            }
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
            this.newEvidence = {
                document_type: '',
                name: '',
                issuing_organisation: '',
                issue_date: '',
                validity_period: '',
                description: '',
                attachment_path: ''
            };
            this.file = null;
            this.errors = {};
            this.setUnsavedChanges(false); // Reset when canceling
            if (this.newEvidence.attachment_path) {
                URL.revokeObjectURL(this.newEvidence.attachment_path);
            }
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
            this.editForms[index] = { ...this.evidences[index] };
            this.editErrors[index] = {};
            this.setUnsavedChanges(false); // Reset when canceling
            if (this.editFiles[index] && this.editForms[index].attachment_path) {
                URL.revokeObjectURL(this.editForms[index].attachment_path);
            }
            delete this.editFiles[index];
        },

        removeEvidence(index) {
            if (confirm( this.$t('Are you sure you want to remove this evidence?'))) {
                this.$emit('remove', index);
                this.requestSavePortfolio();
            }
        },

        validate(evidence, isEdit = false) {
            const errors = {};
            const today = new Date();

            if (!evidence.document_type) {
                errors.document_type =  this.$t('Document type is required');
            }
            if (!evidence.name?.trim()) {
                errors.name =  this.$t('Document title is required');
            }
            if (!evidence.issuing_organisation?.trim()) {
                errors.issuing_organisation =  this.$t('Issuing organisation is required');
            }

            const monthRegex = /^\d{4}-\d{2}$/;
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;

            // Validate Issue Date - accept both formats
            if (!evidence.issue_date) {
                errors.issue_date = this.$t('Issue date is required');
            } else if (!monthRegex.test(evidence.issue_date) && !dateRegex.test(evidence.issue_date)) {
                errors.issue_date = this.$t('Issue date must be in YYYY-MM format');
            } else {
                // Normalize to YYYY-MM-DD for validation
                let issueDateStr = evidence.issue_date;
                if (monthRegex.test(issueDateStr)) {
                    issueDateStr = evidence.issue_date + '-01'; // Append day 01
                }

                const issueDate = new Date(issueDateStr);
                const year = issueDate.getFullYear();

                if (year < 1900) {
                    errors.issue_date =  this.$t('Year must be 1900 or later');
                } else if (issueDate > today) {
                    errors.issue_date =  this.$t('Issue date cannot be in the future');
                }
            }

            if (!isEdit && !this.file && !evidence.attachment_path) {
                errors.file =  this.$t('Document image is required');
            }

            return errors;
        },

        formatDate(dateString) {
            if (!dateString) return 'N/A';

            let year, month;

            // Handle both formats: YYYY-MM and YYYY-MM-DD
            if (dateString.match(/^\d{4}-\d{2}$/)) {
                // New format: YYYY-MM
                [year, month] = dateString.split('-');
            } else if (dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
                // Old format: YYYY-MM-DD
                [year, month] = dateString.split('-');
            } else {
                return 'N/A'; // Invalid format
            }

            const date = new Date(year, month - 1);
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            return `${monthNames[parseInt(month) - 1]} ${year}`;
        },

        async handleFileUpload(event) {
            this.isLoading = true;
            try {
                const file = event.target.files[0]
                if (!file) return

                if (!file.type.match('image.*')) {
                    this.errors.file =  this.$t('Please select an image file (JPEG, PNG, GIF)')
                    return
                }

                if (file.size > 50 * 1024 * 1024) {
                    this.errors.file =  this.$t('Image file cannot exceed 50MB')
                    return
                }

                this.file = file
                this.newEvidence.attachment_path = URL.createObjectURL(file)
                this.errors.file = ''
                this.setUnsavedChanges(true);
            } catch (error) {
                console.error( this.$t('File upload error:'), error)
                this.errors.file = this.$t('Error processing file')
            } finally {
                this.isLoading = false;
            }
        },

        async handleEditFileUpload(index, event) {
            this.isLoading = true;
            try {
                const file = event.target.files[0]
                if (!file) return

                if (!file.type.match('image.*')) {
                    this.editErrors[index].file =  this.$t('Please select an image file (JPEG, PNG, GIF)')
                    return
                }

                if (file.size > 50 * 1024 * 1024) {
                    this.editErrors[index].file =  this.$t('Image file cannot exceed 50MB')
                    return
                }

                this.editFiles[index] = file
                this.editForms[index].attachment_path = URL.createObjectURL(file)
                this.editErrors[index].file = ''
                this.setUnsavedChanges(true);
            } catch (error) {
                console.error( this.$t('Edit file upload error:'), error)
                this.editErrors[index].file =  this.$t('Error processing file')
            } finally {
                this.isLoading = false;
            }
        },

        async uploadFile(file) {
            this.isLoading = true;
            if (!file) return null

            try {
                const formData = new FormData()
                formData.append('file', file)
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content)

                const response = await axios.post('/trainee/career-guidance/portfolios/evidence-upload', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                })

                return response.data?.url || null
            } catch (error) {
                console.error( this.$t('Upload error:'), error)
                throw new Error(error.response?.data?.message ||  this.$t('File upload failed'))
            } finally {
                this.isLoading = false;
            }
        },

        startEditing(index) {
            this.editing = this.editing.map((item, i) => i === index)
            this.editErrors[index] = {}
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
                this.addEvidence();
            } else if (this.pendingAction === 'cancelEdit') {
                this.saveEdit(this.pendingIndex);
            }

            this.pendingAction = null;
            this.pendingIndex = null;
        },

        // Check if there are changes in a specific edit form
        hasEditChanges(index) {
            if (!this.editing[index]) return false;

            const original = this.evidences[index];
            return JSON.stringify(this.editForms[index]) !== JSON.stringify(original);
        },

        // Check overall unsaved changes state
        checkUnsavedChangesState() {
            const hasNewChanges = this.showAddForm && Object.values(this.newEvidence).some(
                value => value !== '' && value !== null && value !== undefined
            );

            const hasEditChanges = this.editForms.some((form, index) => this.hasEditChanges(index));

            this.setUnsavedChanges(hasNewChanges || hasEditChanges);
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

<style scoped>
/* CSS cho input month */
input[type="month"] {
    appearance: none;
    -webkit-appearance: none;
    padding: 0.5rem;
}

input[type="month"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    filter: invert(0.5);
}

.dark input[type="month"]::-webkit-calendar-picker-indicator {
    filter: invert(0.8);
}
</style>
<!--<template>-->
<!--    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">-->
<!--        <div class="flex justify-between items-center">-->
<!--            <div>-->
<!--                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('Supporting Documents')}}</p>-->
<!--                <p class="text-[#9F9FAA] dark:text-white">{{$t('Upload certificates, letters, and other official documents that verify your training, work experience, or achievements. These records help validate your skills and career progress.')}}-->
<!--                </p>-->
<!--            </div>-->

<!--            <button @click="showAddEvidenceForm" class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600">-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="none">-->
<!--                    <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                </svg>-->
<!--            </button>-->
<!--        </div>-->

<!--        &lt;!&ndash; Add Form &ndash;&gt;-->
<!--        <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">-->
<!--            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">-->
<!--                &lt;!&ndash; Document Type &ndash;&gt;-->
<!--                <div class="md:col-span-2">-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Type')}} <span class="text-red-600">*</span></label>-->
<!--                    <select v-model="newEvidence.document_type" :class="{'border-red-500': errors.document_type}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2">-->
<!--                        <option value="" disabled selected>{{$t('Select document type')}}</option>-->
<!--                        <option value="NVQ certificate">{{$t('NVQ certificate')}}</option>-->
<!--                        <option value="On-the-Job Training (OJT) completion letter">{{$t('On-the-Job Training (OJT) completion letter')}}</option>-->
<!--                        <option value="Internship Completion Letter">{{$t('Internship Completion Letter')}}</option>-->
<!--                        <option value="Employment Service Letter">{{$t('Employment Service Letter')}}</option>-->
<!--                    </select>-->
<!--                    <p v-if="errors.document_type" class="mt-1 text-sm text-red-600">{{ errors.document_type }}</p>-->
<!--                </div>-->

<!--                &lt;!&ndash; Document Title &ndash;&gt;-->
<!--                <div class="md:col-span-2">-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Title')}} <span class="text-red-600">*</span></label>-->
<!--                    <input v-model="newEvidence.name" :placeholder="$t('Document title name')" :class="{'border-red-500': errors.name}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>-->
<!--                </div>-->

<!--                &lt;!&ndash; Issuing Organisation &ndash;&gt;-->
<!--                <div class="md:col-span-2">-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issuing Organisation')}} <span class="text-red-600">*</span></label>-->
<!--                    <input v-model="newEvidence.issuing_organisation" :placeholder="$t('Issuing organisation name')" :class="{'border-red-500': errors.issuing_organisation}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                    <p v-if="errors.issuing_organisation" class="mt-1 text-sm text-red-600">{{ errors.issuing_organisation }}</p>-->
<!--                </div>-->

<!--                &lt;!&ndash; Issue Date &ndash;&gt;-->
<!--                <div>-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issue Date')}} <span class="text-red-600">*</span></label>-->
<!--                    <input v-model="newEvidence.issue_date" type="date" :class="{'border-red-500': errors.issue_date}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2">-->
<!--                    <p v-if="errors.issue_date" class="mt-1 text-sm text-red-600">{{ errors.issue_date }}</p>-->
<!--                </div>-->

<!--                &lt;!&ndash; Validity Period &ndash;&gt;-->
<!--                <div>-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Validity Period (if applicable)')}}</label>-->
<!--                    <input v-model="newEvidence.validity_period" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2">-->
<!--                </div>-->

<!--                &lt;!&ndash; Description &ndash;&gt;-->
<!--                <div class="md:col-span-2">-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>-->
<!--                    <textarea v-model="newEvidence.description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Description')"></textarea>-->
<!--                </div>-->

<!--                &lt;!&ndash; Certificate Image &ndash;&gt;-->
<!--                <div class="md:col-span-2 relative">-->
<!--                    <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Upload Document')}} <span class="text-red-600">*</span></label>-->
<!--                    <label for="evidence-upload" class="absolute text-white px-4 py-2 rounded bg-gray-500 cursor-pointer hover:bg-gray-600">-->
<!--                        {{$t('Select file')}}-->
<!--                    </label>-->
<!--                    <input type="file" id="evidence-upload" @change="handleFileUpload" class="mt-1 block w-full hidden" :class="{'border-red-500': errors.file}">-->
<!--                    <p v-if="errors.file" class="mt-1 text-sm text-red-600" style="padding-left: 12rem">{{ errors.file }}</p>-->
<!--                    <img v-if="newEvidence.attachment_path" :src="newEvidence.attachment_path" class="mt-10 h-32 object-contain">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="mt-4 flex justify-end gap-2">-->
<!--                <button @click="cancelAdd" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                    </svg>-->
<!--                </button>-->
<!--                <button-->
<!--                    @click="addEvidence"-->
<!--                    :disabled="isLoading"-->
<!--                    class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600 flex items-center justify-center gap-1"-->
<!--                >-->
<!--                    <svg v-if="isLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">-->
<!--                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
<!--                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
<!--                    </svg>-->
<!--                    <span v-if="!isLoading">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                    </svg>-->
<!--                  </span>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->

<!--        &lt;!&ndash; Evidence List &ndash;&gt;-->
<!--        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">-->
<!--            <div v-for="(evidence, index) in evidences" :key="index" class="mb-10 px-4 border border-dashed p-2 border-gray-300 dark:border-white rounded-xl relative group">-->
<!--                <div class="absolute top-0 right-0 flex gap-1 z-30">-->
<!--                    <button v-if="!editing[index]" @click="startEditing(index)" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-500">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                    <button v-if="!editing[index]" @click="removeEvidence(index)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                </div>-->

<!--                <div v-if="!editing[index]">-->
<!--                    <div class="h-96 overflow-hidden flex justify-center border-b border-gray-300 dark:border-white">-->
<!--                        <img :src="evidence.attachment_path" class="object-cover object-center h-full w-auto !filter-none">-->
<!--                    </div>-->
<!--                    <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-2 dark:text-white break-words">-->
<!--                        {{ evidence.document_type }}: {{ evidence.name }}-->
<!--                    </h2>-->

<!--                    <div class="mb-1">-->
<!--                        <span class="font-semibold dark:text-white">{{$t('Issued by')}}: </span>-->
<!--                        <span class="dark:text-gray-300 break-words">{{ evidence.issuing_organisation }}</span>-->
<!--                    </div>-->

<!--                    <div class="mb-1">-->
<!--                        <span class="font-semibold dark:text-white">{{$t('Issue Date')}}: </span>-->
<!--                        <span class="dark:text-gray-300">{{ formatDate(evidence.issue_date) }}</span>-->
<!--                    </div>-->

<!--                    <div v-if="evidence.validity_period" class="mb-1">-->
<!--                        <span class="font-semibold dark:text-white">{{$t('Valid until')}}: </span>-->
<!--                        <span class="dark:text-gray-300">{{ formatDate(evidence.validity_period) }}</span>-->
<!--                    </div>-->

<!--                    <div v-if="evidence.description" class="mb-12">-->
<!--                        <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Description')}}:</p>-->
<!--                        <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ evidence.description }}</p>-->
<!--                    </div>-->
<!--                </div>-->

<!--                &lt;!&ndash; Edit Form &ndash;&gt;-->
<!--                <div v-else>-->
<!--                    <div class="relative h-96 flex justify-center items-center border rounded-xl overflow-hidden shadow-md group">-->
<!--                        &lt;!&ndash; Image preview &ndash;&gt;-->
<!--                        <img-->
<!--                            v-if="editForms[index].attachment_path"-->
<!--                            :src="editForms[index].attachment_path"-->
<!--                            class="object-cover object-center h-full w-full transition duration-300 group-hover:blur-sm"-->
<!--                        >-->
<!--                        <div v-else class="flex flex-col items-center justify-center h-full w-full bg-gray-100 dark:bg-gray-700">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10 0h3a1 1 0 001-1V7m-5 4V5a1 1 0 00-1-1H9a1 1 0 00-1 1v6m8 0h-8" />-->
<!--                            </svg>-->
<!--                            <p class="text-gray-400 mt-2">{{$t('Image empty')}}</p>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Overlay on hover &ndash;&gt;-->
<!--                        <div class="absolute inset-0 bg-black bg-opacity-50  flex justify-center items-center transition duration-300">-->
<!--                            <label class="px-4 py-2 bg-white text-gray-700 font-medium rounded-lg shadow cursor-pointer hover:bg-gray-100">-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />-->
<!--                                </svg>-->

<!--                                <input type="file" @change="handleEditFileUpload(index, $event)" class="hidden">-->
<!--                            </label>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="mt-4">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Type')}} <span class="text-red-600">*</span></label>-->
<!--                        <select v-model="editForms[index].document_type" :class="{'border-red-500': editErrors[index].document_type}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2">-->
<!--                            <option value="" disabled>{{$t('Select document type')}}</option>-->
<!--                            <option value="NVQ certificate">{{$t('NVQ certificate')}}</option>-->
<!--                            <option value="On-the-Job Training (OJT) completion letter">{{$t('On-the-Job Training (OJT) completion letter')}}</option>-->
<!--                            <option value="Internship Completion Letter">{{$t('Internship Completion Letter')}}</option>-->
<!--                            <option value="Employment Service Letter">{{$t('Employment Service Letter')}}</option>-->
<!--                        </select>-->
<!--                        <p v-if="editErrors[index]?.document_type" class="mt-1 text-sm text-red-600">{{ editErrors[index].document_type }}</p>-->
<!--                    </div>-->

<!--                    <div class="mt-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Document Title')}} <span class="text-red-600">*</span></label>-->
<!--                        <input v-model="editForms[index].name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :class="{'border-red-500': editErrors[index].name}">-->
<!--                        <p v-if="editErrors[index]?.name" class="mt-1 text-sm text-red-600">{{ editErrors[index].name }}</p>-->
<!--                    </div>-->

<!--                    <div class="mt-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issuing Organisation')}} <span class="text-red-600">*</span></label>-->
<!--                        <input v-model="editForms[index].issuing_organisation" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :class="{'border-red-500': editErrors[index].issuing_organisation}">-->
<!--                        <p v-if="editErrors[index]?.issuing_organisation" class="mt-1 text-sm text-red-600">{{ editErrors[index].issuing_organisation }}</p>-->
<!--                    </div>-->

<!--                    <div class="mt-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Issue Date')}} <span class="text-red-600">*</span></label>-->
<!--                        <input v-model="editForms[index].issue_date" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2" :class="{'border-red-500': editErrors[index].issue_date}">-->
<!--                        <p v-if="editErrors[index]?.issue_date" class="mt-1 text-sm text-red-600">{{ editErrors[index].issue_date }}</p>-->
<!--                    </div>-->

<!--                    <div class="mt-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Validity Period (if applicable)')}}</label>-->
<!--                        <input v-model="editForms[index].validity_period" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm p-2">-->
<!--                    </div>-->

<!--                    <div class="mt-2">-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>-->
<!--                        <textarea v-model="editForms[index].description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm"></textarea>-->
<!--                    </div>-->

<!--                    <div class="mt-4 flex justify-end gap-1">-->
<!--                        <button @click="cancelEdit(index)" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                            </svg>-->
<!--                        </button>-->
<!--                        <button-->
<!--                            @click="saveEdit(index)"-->
<!--                            :disabled="isLoading"-->
<!--                            class="px-2 py-1  bg-primary text-white rounded hover:bg-blue-600 "-->
<!--                        >-->
<!--                            <svg v-if="isLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">-->
<!--                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
<!--                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 极 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
<!--                            </svg>-->
<!--                            <span >-->
<!--                                <svg v-if="!isLoading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                                </svg>-->
<!--                            </span>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

<!--        &lt;!&ndash; Warning Modal &ndash;&gt;-->
<!--        <div v-if="showWarning" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">-->
<!--            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full mx-4">-->
<!--                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{$t('Unsaved Changes')}}</h3>-->
<!--                <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">-->
<!--                    {{$t('You have unsaved changes. If you leave now, your changes will be lost.')}}-->
<!--                </p>-->
<!--                <div class="flex justify-end gap-3">-->
<!--                    <button-->
<!--                        @click="continueWithoutSaving"-->
<!--                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm"-->
<!--                    >-->
<!--                        {{$t('Leave Anyway')}}-->
<!--                    </button>-->
<!--                    <button-->
<!--                        @click="saveAndContinue"-->
<!--                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"-->
<!--                    >-->
<!--                        {{$t('Save and Continue')}}-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--    props: {-->
<!--        evidences: { type: Array, default: () => [] }-->
<!--    },-->

<!--    data() {-->
<!--        return {-->
<!--            showAddForm: false,-->
<!--            newEvidence: {-->
<!--                document_type: '',-->
<!--                name: '',-->
<!--                issuing_organisation: '',-->
<!--                issue_date: '',-->
<!--                validity_period: '',-->
<!--                description: '',-->
<!--                attachment_path: ''-->
<!--            },-->
<!--            file: null,-->
<!--            errors: {},-->
<!--            editing: [],-->
<!--            editForms: [],-->
<!--            editFiles: {},-->
<!--            editErrors: [],-->
<!--            isLoading: false,-->
<!--            isAdding: false,-->
<!--            isEditing: {},-->
<!--            isUploading: false,-->
<!--            isSaving: false,-->
<!--            showWarning: false,-->
<!--            hasUnsavedChanges: false,-->
<!--            pendingAction: null,-->
<!--            pendingIndex: null,-->
<!--            beforeUnloadListener: null-->
<!--        }-->
<!--    },-->

<!--    watch: {-->
<!--        // Watch for changes in new evidence form-->
<!--        newEvidence: {-->
<!--            handler(newVal) {-->
<!--                const isEmpty = Object.values(newVal).every(-->
<!--                    value => value === '' || value === null || value === undefined-->
<!--                );-->

<!--                if (!isEmpty && this.showAddForm) {-->
<!--                    this.setUnsavedChanges(true);-->
<!--                }-->
<!--            },-->
<!--            deep: true-->
<!--        },-->
<!--        // Watch for changes in edit forms-->
<!--        editForms: {-->
<!--            handler() {-->
<!--                const hasEditChanges = this.editForms.some((form, index) => {-->
<!--                    if (!this.editing[index]) return false;-->

<!--                    const original = this.evidences[index];-->
<!--                    return JSON.stringify(form) !== JSON.stringify(original);-->
<!--                });-->

<!--                if (hasEditChanges) {-->
<!--                    this.setUnsavedChanges(true);-->
<!--                }-->
<!--            },-->
<!--            deep: true-->
<!--        },-->
<!--        // Watch for editing state-->
<!--        editing: {-->
<!--            handler() {-->
<!--                const isEditing = this.editing.some(edit => edit === true);-->
<!--                if (isEditing) {-->
<!--                    this.setUnsavedChanges(true);-->
<!--                }-->
<!--            },-->
<!--            deep: true-->
<!--        },-->
<!--        evidences: {-->
<!--            handler() { this.resetEditingStates() },-->
<!--            deep: true,-->
<!--            immediate: true-->
<!--        }-->
<!--    },-->

<!--    mounted() {-->
<!--        // Set up beforeunload listener-->
<!--        this.setupBeforeUnloadListener();-->
<!--    },-->

<!--    beforeUnmount() {-->
<!--        // Clean up beforeunload listener-->
<!--        this.removeBeforeUnloadListener();-->
<!--    },-->

<!--    methods: {-->
<!--        // Set up warning when leaving page-->
<!--        setupBeforeUnloadListener() {-->
<!--            this.beforeUnloadListener = (e) => {-->
<!--                if (this.hasUnsavedChanges) {-->
<!--                    // Standard message for browsers-->
<!--                    e.preventDefault();-->
<!--                    e.returnValue = this.$t('You have unsaved changes. Are you sure you want to leave?');-->
<!--                    return e.returnValue;-->
<!--                }-->
<!--            };-->

<!--            window.addEventListener('beforeunload', this.beforeUnloadListener);-->
<!--        },-->

<!--        // Remove event listener-->
<!--        removeBeforeUnloadListener() {-->
<!--            if (this.beforeUnloadListener) {-->
<!--                window.removeEventListener('beforeunload', this.beforeUnloadListener);-->
<!--            }-->
<!--        },-->

<!--        // Update changes state-->
<!--        setUnsavedChanges(hasChanges) {-->
<!--            this.hasUnsavedChanges = hasChanges;-->
<!--        },-->

<!--        // Existing methods updated to manage change state-->
<!--        resetEditingStates() {-->
<!--            this.editing = this.evidences.map(() => false);-->
<!--            this.editForms = this.evidences.map(ev => ({ ...ev }));-->
<!--            this.editErrors = this.evidences.map(() => ({}));-->
<!--            this.editFiles = {};-->
<!--            this.setUnsavedChanges(false); // Reset change state-->
<!--        },-->

<!--        showAddEvidenceForm() {-->
<!--            this.showAddForm = true;-->
<!--        },-->

<!--        async addEvidence() {-->
<!--            this.isAdding = true;-->
<!--            this.errors = this.validate(this.newEvidence);-->
<!--            if (Object.keys(this.errors).length) return;-->

<!--            this.isLoading = true;-->
<!--            try {-->
<!--                const uploadedPath = await this.uploadFile(this.file);-->
<!--                if (uploadedPath) {-->
<!--                    this.newEvidence.attachment_path = uploadedPath;-->
<!--                }-->

<!--                this.$emit('add', { ...this.newEvidence });-->
<!--                this.requestSavePortfolio();-->
<!--                this.setUnsavedChanges(false);-->
<!--                this.cancelAdd();-->
<!--                this.setUnsavedChanges(false); // Reset after successful save-->
<!--            } catch (error) {-->
<!--                this.errors.file = error.message;-->
<!--            } finally {-->
<!--                this.isLoading = false;-->
<!--            }-->
<!--        },-->

<!--        async saveEdit(index) {-->
<!--            this.isEditing[index] = true;-->
<!--            this.editErrors[index] = this.validate(this.editForms[index], true);-->
<!--            if (Object.keys(this.editErrors[index]).length) return;-->

<!--            this.isLoading = true;-->
<!--            try {-->
<!--                if (this.editFiles[index]) {-->
<!--                    const uploadedPath = await this.uploadFile(this.editFiles[index]);-->
<!--                    if (uploadedPath) {-->
<!--                        this.editForms[index].attachment_path = uploadedPath;-->
<!--                    }-->
<!--                }-->

<!--                this.$emit('update', { index, evidence: { ...this.editForms[index] } });-->
<!--                this.editing = this.editing.map((item, i) => i === index ? false : item);-->
<!--                delete this.editFiles[index];-->
<!--                this.requestSavePortfolio();-->
<!--                this.setUnsavedChanges(false); // Reset after successful save-->
<!--            } catch (error) {-->
<!--                this.editErrors[index].file = error.message;-->
<!--            } finally {-->
<!--                this.isLoading = false;-->
<!--                this.isEditing[index] = false;-->
<!--            }-->
<!--        },-->

<!--        cancelAdd() {-->
<!--            if (this.hasUnsavedChanges) {-->
<!--                // Show warning if there are unsaved changes-->
<!--                this.showWarning = true;-->
<!--                this.pendingAction = 'cancelAdd';-->
<!--            } else {-->
<!--                this.doCancelAdd();-->
<!--            }-->
<!--        },-->

<!--        doCancelAdd() {-->
<!--            this.showAddForm = false;-->
<!--            this.newEvidence = {-->
<!--                document_type: '',-->
<!--                name: '',-->
<!--                issuing_organisation: '',-->
<!--                issue_date: '',-->
<!--                validity_period: '',-->
<!--                description: '',-->
<!--                attachment_path: ''-->
<!--            };-->
<!--            this.file = null;-->
<!--            this.errors = {};-->
<!--            this.setUnsavedChanges(false); // Reset when canceling-->
<!--            if (this.newEvidence.attachment_path) {-->
<!--                URL.revokeObjectURL(this.newEvidence.attachment_path);-->
<!--            }-->
<!--        },-->

<!--        cancelEdit(index) {-->
<!--            if (this.hasEditChanges(index)) {-->
<!--                // Show warning if there are unsaved changes-->
<!--                this.showWarning = true;-->
<!--                this.pendingAction = 'cancelEdit';-->
<!--                this.pendingIndex = index;-->
<!--            } else {-->
<!--                this.doCancelEdit(index);-->
<!--            }-->
<!--        },-->

<!--        doCancelEdit(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index ? false : item);-->
<!--            this.editForms[index] = { ...this.evidences[index] };-->
<!--            this.editErrors[index] = {};-->
<!--            this.setUnsavedChanges(false); // Reset when canceling-->
<!--            if (this.editFiles[index] && this.editForms[index].attachment_path) {-->
<!--                URL.revokeObjectURL(this.editForms[index].attachment_path);-->
<!--            }-->
<!--            delete this.editFiles[index];-->
<!--        },-->

<!--        removeEvidence(index) {-->
<!--            if (confirm( this.$t('Are you sure you want to remove this evidence?'))) {-->
<!--                this.$emit('remove', index);-->
<!--                this.requestSavePortfolio();-->
<!--            }-->
<!--        },-->

<!--        validate(evidence, isEdit = false) {-->
<!--            const errors = {};-->
<!--            const today = new Date();-->

<!--            if (!evidence.document_type) {-->
<!--                errors.document_type =  this.$t('Document type is required');-->
<!--            }-->
<!--            if (!evidence.name?.trim()) {-->
<!--                errors.name =  this.$t('Document title is required');-->
<!--            }-->
<!--            if (!evidence.issuing_organisation?.trim()) {-->
<!--                errors.issuing_organisation =  this.$t('Issuing organisation is required');-->
<!--            }-->

<!--            if (!evidence.issue_date) {-->
<!--                errors.issue_date = this.$t('Issue date is required');-->
<!--            } else {-->
<!--                // Check YYYY-MM-DD format-->
<!--                if (!/^\d{4}-\d{2}-\d{2}$/.test(evidence.issue_date)) {-->
<!--                    errors.issue_date =  this.$t('Date format must be YYYY-MM-DD');-->
<!--                } else {-->
<!--                    const issueDate = new Date(evidence.issue_date);-->
<!--                    const year = issueDate.getFullYear();-->

<!--                    // Year must have 4 digits and be >=1900-->
<!--                    if (year < 1900) {-->
<!--                        errors.issue_date =  this.$t('Year must be 1900 or later');-->
<!--                    } else if (issueDate > today) {-->
<!--                        errors.issue_date =  this.$t('Issue date cannot be in the future');-->
<!--                    }-->
<!--                }-->
<!--            }-->

<!--            if (!isEdit && !this.file && !evidence.attachment_path) {-->
<!--                errors.file =  this.$t('Document image is required');-->
<!--            }-->

<!--            return errors;-->
<!--        },-->


<!--        formatDate(dateString) {-->
<!--            if (!dateString) return 'N/A';-->
<!--            const date = new Date(dateString);-->

<!--            const year = date.getFullYear();-->
<!--            const month = String(date.getMonth() + 1).padStart(2, '0'); // prepend 0 if < 10-->
<!--            const day = String(date.getDate()).padStart(2, '0');-->

<!--            return `${year}-${month}-${day}`; // Y-m-d-->
<!--        },-->

<!--        async handleFileUpload(event) {-->
<!--            this.isLoading = true;-->
<!--            try {-->
<!--                const file = event.target.files[0]-->
<!--                if (!file) return-->

<!--                if (!file.type.match('image.*')) {-->
<!--                    this.errors.file =  this.$t('Please select an image file (JPEG, PNG, GIF)')-->
<!--                    return-->
<!--                }-->

<!--                if (file.size > 50 * 1024 * 1024) {-->
<!--                    this.errors.file =  this.$t('Image file cannot exceed 50MB')-->
<!--                    return-->
<!--                }-->

<!--                this.file = file-->
<!--                this.newEvidence.attachment_path = URL.createObjectURL(file)-->
<!--                this.errors.file = ''-->
<!--                this.setUnsavedChanges(true);-->
<!--            } catch (error) {-->
<!--                console.error( this.$t('File upload error:'), error)-->
<!--                this.errors.file = this.$t('Error processing file')-->
<!--            } finally {-->
<!--                this.isLoading = false;-->
<!--            }-->
<!--        },-->

<!--        async handleEditFileUpload(index, event) {-->
<!--            this.isLoading = true;-->
<!--            try {-->
<!--                const file = event.target.files[0]-->
<!--                if (!file) return-->

<!--                if (!file.type.match('image.*')) {-->
<!--                    this.editErrors[index].file =  this.$t('Please select an image file (JPEG, PNG, GIF)')-->
<!--                    return-->
<!--                }-->

<!--                if (file.size > 50 * 1024 * 1024) {-->
<!--                    this.editErrors[index].file =  this.$t('Image file cannot exceed 50MB')-->
<!--                    return-->
<!--                }-->

<!--                this.editFiles[index] = file-->
<!--                this.editForms[index].attachment_path = URL.createObjectURL(file)-->
<!--                this.editErrors[index].file = ''-->
<!--                this.setUnsavedChanges(true);-->
<!--            } catch (error) {-->
<!--                console.error( this.$t('Edit file upload error:'), error)-->
<!--                this.editErrors[index].file =  this.$t('Error processing file')-->
<!--            } finally {-->
<!--                this.isLoading = false;-->
<!--            }-->
<!--        },-->

<!--        async uploadFile(file) {-->
<!--            this.isLoading = true;-->
<!--            if (!file) return null-->

<!--            try {-->
<!--                const formData = new FormData()-->
<!--                formData.append('file', file)-->
<!--                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content)-->

<!--                const response = await axios.post('/trainee/career-guidance/portfolios/evidence-upload', formData, {-->
<!--                    headers: { 'Content-Type': 'multipart/form-data' }-->
<!--                })-->

<!--                return response.data?.url || null-->
<!--            } catch (error) {-->
<!--                console.error( this.$t('Upload error:'), error)-->
<!--                throw new Error(error.response?.data?.message ||  this.$t('File upload failed'))-->
<!--            } finally {-->
<!--                this.isLoading = false;-->
<!--            }-->
<!--        },-->

<!--        startEditing(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index)-->
<!--            this.editErrors[index] = {}-->
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
<!--        },-->

<!--        // Handle when user chooses to leave without saving-->
<!--        continueWithoutSaving() {-->
<!--            this.showWarning = false;-->

<!--            if (this.pendingAction === 'cancelAdd') {-->
<!--                this.doCancelAdd();-->
<!--            } else if (this.pendingAction === 'cancelEdit') {-->
<!--                this.doCancelEdit(this.pendingIndex);-->
<!--            }-->

<!--            this.pendingAction = null;-->
<!--            this.pendingIndex = null;-->
<!--        },-->

<!--        // Handle when user chooses to save and continue-->
<!--        saveAndContinue() {-->
<!--            this.showWarning = false;-->

<!--            if (this.pendingAction === 'cancelAdd') {-->
<!--                this.addEvidence();-->
<!--            } else if (this.pendingAction === 'cancelEdit') {-->
<!--                this.saveEdit(this.pendingIndex);-->
<!--            }-->

<!--            this.pendingAction = null;-->
<!--            this.pendingIndex = null;-->
<!--        },-->

<!--        // Check if there are changes in a specific edit form-->
<!--        hasEditChanges(index) {-->
<!--            if (!this.editing[index]) return false;-->

<!--            const original = this.evidences[index];-->
<!--            return JSON.stringify(this.editForms[index]) !== JSON.stringify(original);-->
<!--        },-->

<!--        // Check overall unsaved changes state-->
<!--        checkUnsavedChangesState() {-->
<!--            const hasNewChanges = this.showAddForm && Object.values(this.newEvidence).some(-->
<!--                value => value !== '' && value !== null && value !== undefined-->
<!--            );-->

<!--            const hasEditChanges = this.editForms.some((form, index) => this.hasEditChanges(index));-->

<!--            this.setUnsavedChanges(hasNewChanges || hasEditChanges);-->
<!--        },-->

<!--        // Method for parent component to check for unsaved changes-->
<!--        checkUnsavedChanges() {-->
<!--            if (this.hasUnsavedChanges) {-->
<!--                this.showWarning = true;-->
<!--                this.pendingAction = 'navigate';-->
<!--                return false;-->
<!--            }-->
<!--            return true;-->
<!--        }-->
<!--    }-->
<!--}-->
<!--</script>-->

