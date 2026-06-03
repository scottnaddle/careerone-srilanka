<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
        <div class="flex flex-col gap-4 w-full h-full">
            <div class="flex justify-between items-center">
                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('Education')}}</p>
                <div class="flex gap-2">
                    <button @click="showAddEducationForm" class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="none">
                            <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Add Form -->
            <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('School Name')}} <span class="text-red-600">*</span></label>
                        <input v-model="newEducation.school_name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('School Name')">
                        <p v-if="errors.add.school_name" class="text-red-500 text-xs mt-1">{{ errors.add.school_name }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}} <span class="text-red-600">*</span></label>
                            <input v-model="newEducation.district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('District name')">
                            <p v-if="errors.add.district" class="text-red-500 text-xs mt-1">{{ errors.add.district }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Field of study')}} <span class="text-red-600">*</span></label>
                            <input v-model="newEducation.field" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Field of Study')">
                            <p v-if="errors.add.field" class="text-red-500 text-xs mt-1">{{ errors.add.field }}</p>
                        </div>
                    </div>
<!--                    <div class="grid grid-cols-2 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newEducation.from" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="errors.add.from" class="text-red-500 text-xs mt-1">{{ errors.add.from }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newEducation.to" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="errors.add.to" class="text-red-500 text-xs mt-1">{{ errors.add.to }}</p>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>
                            <input v-model="newEducation.from" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="errors.add.from" class="text-red-500 text-xs mt-1">{{ errors.add.from }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>
                            <input v-model="newEducation.to" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="errors.add.to" class="text-red-500 text-xs mt-1">{{ errors.add.to }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Grades (results)')}}</label>
                            <textarea
                                v-model="newEducation.results"
                                class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"
                                rows="5"
                                :placeholder="$t('Type your results...')"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                            <textarea
                                v-model="newEducation.description"
                                class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"
                                rows="5"
                                :placeholder="$t('Description...')"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="cancelAdd" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <button @click="addEducation" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Education List -->
            <ol class="relative border-s border-primary">
                <li v-for="(education, index) in educations" :key="index" class="mb-10 border border-dashed p-4 rounded-lg relative group">

                    <div v-if="!editing[index]">
                        <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5"></div>
                        <p>
                            <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ education.school_name }}</span>
                            <span v-if="education.district" class="text-[#706F81] dark:text-white">
                                        ({{ education.district }})
                                    </span>
                        </p>
                        <p>
                            <span class="text-[#91919A] dark:text-white text-sm">{{ formatDate(education.from) }} - {{ formatDate(education.to) }}</span>
                        </p>
                        <p v-if="education.field" class="text-[#464559] dark:text-white"><span class="font-semibold dark:text-white">{{$t('Field of Study')}}: </span> {{ education.field }}</p>
                        <div v-if="education.results" class="my-2">
                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Results')}}:</p>
                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ education.results }}</p>
                        </div>
                        <div v-if="education.description" class="my-2">
                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Description')}}:</p>
                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ education.description }}</p>
                        </div>

                    </div>

                    <!-- Edit Form -->
                    <div v-else class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('School Name')}} <span class="text-red-600">*</span></label>
                            <input v-model="editForms[index].school_name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="errors.edit[index]?.school_name" class="text-red-500 text-xs mt-1">{{ errors.edit[index].school_name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                                <p v-if="errors.edit[index]?.district" class="text-red-500 text-xs mt-1">{{ errors.edit[index].district }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Field of study')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].field" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Field of Study">
                                <p v-if="errors.edit[index]?.field" class="text-red-500 text-xs mt-1">{{ errors.edit[index].field }}</p>
                            </div>
                        </div>

<!--                        <div class="grid grid-cols-2 gap-4">-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>-->
<!--                                <input v-model="editForms[index].from" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                <p v-if="errors.edit[index]?.from" class="text-red-500 text-xs mt-1">{{ errors.edit[index].from }}</p>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>-->
<!--                                <input v-model="editForms[index].to" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                <p v-if="errors.edit[index]?.to" class="text-red-500 text-xs mt-1">{{ errors.edit[index].to }}</p>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].from" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                                <p v-if="errors.edit[index]?.from" class="text-red-500 text-xs mt-1">{{ errors.edit[index].from }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].to" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                                <p v-if="errors.edit[index]?.to" class="text-red-500 text-xs mt-1">{{ errors.edit[index].to }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Grades (results)')}}</label>
                                <textarea
                                    v-model="editForms[index].results"
                                    class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"
                                    rows="5"
                                    :placeholder="$t('Type your results...')"
                                ></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                                <textarea
                                    v-model="editForms[index].description"
                                    class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"
                                    rows="5"
                                    :placeholder="$t('Description...')"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-1 mt-2 justify-end">
                        <button v-if="!editing[index]" @click="startEditing(index)" class="px-2 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button v-if="!editing[index]" @click="removeEducation(index)" class="px-2 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.680-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>

                        <button v-if="editing[index]" @click="cancelEdit(index)" class="px-2 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button v-if="editing[index]" @click="saveEdit(index)" class="px-2 py-1 bg-primary text-white rounded text-sm hover:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </button>
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
<style scoped>
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
<script>
export default {
    props: {
        educations: {
            type: Array,
            required: true,
            default: () => []
        }
    },

    data() {
        return {
            showAddForm: false,
            newEducation: {
                school_name: '',
                district: '',
                from: '',
                to: '',
                results: '',
                description: '',
                field: '',
            },
            editing: [],
            editForms: [],
            isSaving: false,
            showWarning: false,
            hasUnsavedChanges: false,
            pendingAction: null,
            pendingIndex: null,
            beforeUnloadListener: null,
            errors: {
                add: {
                    school_name: '',
                    district: '',
                    from: '',
                    field: '',
                    to: ''
                },
                edit: []
            }
        };
    },

    watch: {
        educations: {
            handler() {
                this.resetEditingStates();
            },
            deep: true,
            immediate: true
        },
        // Watch for changes in new education form
        newEducation: {
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

                    const original = this.educations[index];
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
            this.editing = new Array(this.educations.length).fill(false);
            this.editForms = this.educations.map(edu => {
                // Chuyển đổi dữ liệu ngày tháng cũ sang định dạng YYYY-MM nếu cần
                let from = edu?.from || '';
                let to = edu?.to || '';

                // Nếu là định dạng date đầy đủ, chuyển sang YYYY-MM
                if (from && from.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    from = from.substring(0, 7); // Lấy YYYY-MM
                }
                if (to && to.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    to = to.substring(0, 7); // Lấy YYYY-MM
                }

                return {
                    school_name: edu?.school_name || '',
                    district: edu?.district || '',
                    from: from,
                    to: to,
                    field: edu?.field || '',
                    results: edu?.results || '',
                    description: edu?.description || '',
                };
            });
            this.errors.edit = new Array(this.educations.length).fill({});
            this.setUnsavedChanges(false);
        },

        // formatDate(dateString) {
        //     if (!dateString) return '';
        //     const date = new Date(dateString);
        //     return date.toLocaleDateString('en-US', {
        //         year: 'numeric',
        //         month: 'short',
        //         day: 'numeric'
        //     });
        // },
        formatDate(dateString) {
            if (!dateString) return '';

            let year, month;

            // Xử lý cả 2 định dạng: YYYY-MM và YYYY-MM-DD
            if (dateString.match(/^\d{4}-\d{2}$/)) {
                // Định dạng mới: YYYY-MM
                [year, month] = dateString.split('-');
            } else if (dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
                // Định dạng cũ: YYYY-MM-DD
                [year, month] = dateString.split('-');
            } else {
                return ''; // Định dạng không hợp lệ
            }

            const date = new Date(year, month - 1);
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            return `${monthNames[parseInt(month) - 1]} ${year}`;
        },

        // validateEducation(education, mode = 'add', index = null) {
        //     let isValid = true;
        //     const newErrors = {
        //         school_name: '',
        //         district: '',
        //         field: '',
        //         from: '',
        //         to: ''
        //     };
        //
        //     if (!education.school_name?.trim()) {
        //         newErrors.school_name = this.$t('School name is required');
        //         isValid = false;
        //     }
        //
        //     if (!education.district?.trim()) {
        //         newErrors.district = this.$t('District is required');
        //         isValid = false;
        //     }
        //
        //     if (!education.field?.trim()) {
        //         newErrors.field = this.$t('Field of Study is required');
        //         isValid = false;
        //     }
        //
        //     const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        //
        //     // Validate Start Date
        //     if (!education.from) {
        //         newErrors.from = this.$t('Start date is required');
        //         isValid = false;
        //     } else if (!dateRegex.test(education.from)) {
        //         newErrors.from = this.$t('Start date must be in YYYY-MM-DD format');
        //         isValid = false;
        //     } else {
        //         const fromDate = new Date(education.from);
        //         const fromYear = fromDate.getFullYear();
        //         const today = new Date();
        //
        //         if (fromYear < 1900) {
        //             newErrors.from = this.$t('Start year must be 1900 or later');
        //             isValid = false;
        //         } else if (fromDate > today) {
        //             newErrors.from = this.$t('Start date cannot be in the future');
        //             isValid = false;
        //         }
        //     }
        //     if (!education.to) {
        //         newErrors.to = this.$t('End date is required');
        //         isValid = false;
        //     } else if (!dateRegex.test(education.to)) {
        //         newErrors.to = this.$t('End date must be in YYYY-MM-DD format');
        //         isValid = false;
        //     } else {
        //         const toDate = new Date(education.to);
        //         const now = new Date();
        //         if (toDate > now) {
        //             newErrors.to = this.$t('End date cannot be in the future');
        //             isValid = false;
        //         }
        //
        //         if (education.from) {
        //             const fromDate = new Date(education.from);
        //             if (fromDate > toDate) {
        //                 newErrors.to = this.$t('End date must be after start date');
        //                 isValid = false;
        //             }
        //         }
        //     }
        //
        //     if (mode === 'add') {
        //         this.errors.add = newErrors;
        //     } else {
        //         if (!Array.isArray(this.errors.edit)) {
        //             this.errors.edit = [];
        //         }
        //         this.errors.edit[index] = newErrors;
        //         this.errors = {...this.errors};
        //     }
        //
        //     return isValid;
        // },
        validateEducation(education, mode = 'add', index = null) {
            let isValid = true;
            const newErrors = {
                school_name: '',
                district: '',
                field: '',
                from: '',
                to: ''
            };

            if (!education.school_name?.trim()) {
                newErrors.school_name = this.$t('School name is required');
                isValid = false;
            }

            if (!education.district?.trim()) {
                newErrors.district = this.$t('District is required');
                isValid = false;
            }

            if (!education.field?.trim()) {
                newErrors.field = this.$t('Field of Study is required');
                isValid = false;
            }

            const monthRegex = /^\d{4}-\d{2}$/;

            // Validate Start Date
            if (!education.from) {
                newErrors.from = this.$t('Start date is required');
                isValid = false;
            } else if (!monthRegex.test(education.from)) {
                newErrors.from = this.$t('Start date must be in YYYY-MM format');
                isValid = false;
            } else {
                const fromDate = new Date(education.from + '-01'); // Thêm ngày 01 để tạo date hợp lệ
                const fromYear = fromDate.getFullYear();
                const today = new Date();

                if (fromYear < 1900) {
                    newErrors.from = this.$t('Start year must be 1900 or later');
                    isValid = false;
                } else if (fromDate > today) {
                    newErrors.from = this.$t('Start date cannot be in the future');
                    isValid = false;
                }
            }

            // Validate End Date
            if (!education.to) {
                newErrors.to = this.$t('End date is required');
                isValid = false;
            } else if (!monthRegex.test(education.to)) {
                newErrors.to = this.$t('End date must be in YYYY-MM format');
                isValid = false;
            } else {
                const toDate = new Date(education.to + '-01'); // Thêm ngày 01 để tạo date hợp lệ
                const now = new Date();

                if (toDate > now) {
                    newErrors.to = this.$t('End date cannot be in the future');
                    isValid = false;
                }

                if (education.from) {
                    const fromDate = new Date(education.from + '-01');
                    if (fromDate > toDate) {
                        newErrors.to = this.$t('End date must be after start date');
                        isValid = false;
                    }
                }
            }

            if (mode === 'add') {
                this.errors.add = newErrors;
            } else {
                if (!Array.isArray(this.errors.edit)) {
                    this.errors.edit = [];
                }
                this.errors.edit[index] = newErrors;
                this.errors = {...this.errors};
            }

            return isValid;
        },

        showAddEducationForm() {
            this.showAddForm = true;
        },

        addEducation() {
            if (!this.validateEducation(this.newEducation, 'add')) return;

            this.$emit('add', {...this.newEducation});
            this.setUnsavedChanges(false);
            this.cancelAdd();
            this.requestSavePortfolio();
        },

        cancelAdd() {
            if (this.hasUnsavedChanges) {
                this.showWarning = true;
                this.pendingAction = 'cancelAdd';
            } else {
                this.doCancelAdd();
            }
        },

        doCancelAdd() {
            this.showAddForm = false;
            this.newEducation = {
                school_name: '',
                district: '',
                from: '',
                field: '',
                results: '',
                description: '',
                to: ''
            };
            this.errors.add = {
                school_name: '',
                from: '',
                district: '',
                field: '',
                to: ''
            };
            this.setUnsavedChanges(false);
        },

        startEditing(index) {
            this.editing = this.editing.map((item, i) => i === index ? true : item);
            this.editErrors[index] = {};
        },

        cancelEdit(index) {
            if (this.hasEditChanges(index)) {
                this.showWarning = true;
                this.pendingAction = 'cancelEdit';
                this.pendingIndex = index;
            } else {
                this.doCancelEdit(index);
            }
        },

        doCancelEdit(index) {
            this.editing[index] = false;
            this.editForms[index] = { ...this.educations[index] };

            if (Array.isArray(this.errors.edit)) {
                this.errors.edit[index] = {};
                this.errors = {...this.errors};
            }

            this.checkUnsavedChangesState();
        },

        saveEdit(index) {
            if (!this.validateEducation(this.editForms[index], 'edit', index)) return;

            this.$emit('update', {
                index,
                education: {...this.editForms[index]}
            });
            this.editing[index] = false;
            this.requestSavePortfolio();
            this.setUnsavedChanges(false);
        },

        removeEducation(index) {
            if (confirm(this.$t('Are you sure you want to remove this education?'))) {
                this.$emit('remove', index);
                this.requestSavePortfolio();
            }
        },

        requestSavePortfolio() {
            this.$emit('save-portfolio');
            this.isSaving = true;
            setTimeout(() => {
                this.isSaving = false;
                this.hasUnsavedChanges = false;
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
                this.addEducation();
            } else if (this.pendingAction === 'cancelEdit') {
                this.saveEdit(this.pendingIndex);
            }

            this.pendingAction = null;
            this.pendingIndex = null;
        },

        // Check if there are changes in a specific edit form
        hasEditChanges(index) {
            if (!this.editing[index]) return false;

            const original = this.educations[index];
            return JSON.stringify(this.editForms[index]) !== JSON.stringify(original);
        },

        // Check overall unsaved changes state
        checkUnsavedChangesState() {
            const hasNewChanges = this.showAddForm && Object.values(this.newEducation).some(
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
<!--    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">-->
<!--        <div class="flex flex-col gap-4 w-full h-full">-->
<!--            <div class="flex justify-between items-center">-->
<!--                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Education</p>-->
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
<!--                <div class="grid grid-cols-1 gap-4">-->
<!--                    <div>-->
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">School Name <span class="text-red-600">*</span></label>-->
<!--                        <input v-model="newEducation.school_name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="School name">-->
<!--                        <p v-if="errors.add.school_name" class="text-red-500 text-xs mt-1">{{ errors.add.school_name }}</p>-->
<!--                    </div>-->
<!--                    <div class="grid grid-cols-2 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">District <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newEducation.district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="District name">-->
<!--                            <p v-if="errors.add.district" class="text-red-500 text-xs mt-1">{{ errors.add.district }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Field of study <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newEducation.field" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Field of Study">-->
<!--                            <p v-if="errors.add.field" class="text-red-500 text-xs mt-1">{{ errors.add.field }}</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="grid grid-cols-2 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Start date <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newEducation.from" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="errors.add.from" class="text-red-500 text-xs mt-1">{{ errors.add.from }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">End date <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newEducation.to" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="errors.add.to" class="text-red-500 text-xs mt-1">{{ errors.add.to }}</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="grid grid-cols-2 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Grades (results)</label>-->
<!--                            <textarea-->
<!--                                v-model="newEducation.results"-->
<!--                                class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                rows="5"-->
<!--                                placeholder="Type your results..."-->
<!--                            ></textarea>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>-->
<!--                            <textarea-->
<!--                                v-model="newEducation.description"-->
<!--                                class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                rows="5"-->
<!--                                placeholder="Description..."-->
<!--                            ></textarea>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="mt-4 flex justify-end gap-2">-->
<!--                    <button @click="cancelAdd" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                    <button @click="addEducation" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->

<!--            &lt;!&ndash; Education List &ndash;&gt;-->
<!--            <div class="flex flex-col gap-4">-->
<!--                <div v-for="(education, index) in educations" :key="index" class="relative group border border-dashed p-2 rounded">-->
<!--                    <div class="flex gap-4 items-baseline">-->
<!--                        <div>-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">-->
<!--                                <circle cx="5" cy="5" r="5" fill="#4984F6" />-->
<!--                            </svg>-->
<!--                        </div>-->
<!--                        <div class="flex flex-col gap-2 w-full">-->
<!--                            <div v-if="!editing[index]">-->
<!--                                <p>-->
<!--                                    <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ education.school_name }}</span>-->
<!--                                    <span v-if="education.district" class="text-[#706F81] dark:text-white">-->
<!--                                        ({{ education.district }})-->
<!--                                    </span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                    <span class="text-[#91919A] dark:text-white text-sm">{{ formatDate(education.from) }} - {{ formatDate(education.to) }}</span>-->
<!--                                </p>-->
<!--                                <p v-if="education.field" class="text-[#464559] dark:text-white"><span class="font-semibold dark:text-white">Field of Study: </span> {{ education.field }}</p>-->
<!--                                <div v-if="education.results" class="my-2">-->
<!--                                    <p class=" font-semibold text-gray-700 dark:text-gray-300">Results:</p>-->
<!--                                    <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2">{{ education.results }}</p>-->
<!--                                </div>-->
<!--                                <div v-if="education.description" class="my-2">-->
<!--                                    <p class=" font-semibold text-gray-700 dark:text-gray-300">Description:</p>-->
<!--                                    <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2">{{ education.description }}</p>-->
<!--                                </div>-->

<!--                            </div>-->

<!--                            &lt;!&ndash; Edit Form &ndash;&gt;-->
<!--                            <div v-else class="grid grid-cols-1 gap-4">-->
<!--                                <div>-->
<!--                                    <label class="block text-sm font-medium text-gray-700 dark:text-white">School Name <span class="text-red-600">*</span></label>-->
<!--                                    <input v-model="editForms[index].school_name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                    <p v-if="errors.edit[index]?.school_name" class="text-red-500 text-xs mt-1">{{ errors.edit[index].school_name }}</p>-->
<!--                                </div>-->
<!--                                <div class="grid grid-cols-2 gap-4">-->
<!--                                    <div>-->
<!--                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">District <span class="text-red-600">*</span></label>-->
<!--                                        <input v-model="editForms[index].district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                        <p v-if="errors.edit[index]?.district" class="text-red-500 text-xs mt-1">{{ errors.edit[index].district }}</p>-->
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Field of study <span class="text-red-600">*</span></label>-->
<!--                                        <input v-model="editForms[index].field" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Field of Study">-->
<!--                                        <p v-if="errors.edit[index]?.field" class="text-red-500 text-xs mt-1">{{ errors.edit[index].field }}</p>-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                                <div class="grid grid-cols-2 gap-4">-->
<!--                                    <div>-->
<!--                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">From <span class="text-red-600">*</span></label>-->
<!--                                        <input v-model="editForms[index].from" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                        <p v-if="errors.edit[index]?.from" class="text-red-500 text-xs mt-1">{{ errors.edit[index].from }}</p>-->
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">To <span class="text-red-600">*</span></label>-->
<!--                                        <input v-model="editForms[index].to" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                        <p v-if="errors.edit[index]?.to" class="text-red-500 text-xs mt-1">{{ errors.edit[index].to }}</p>-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                                <div class="grid grid-cols-2 gap-4">-->
<!--                                    <div>-->
<!--                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Grades (results)</label>-->
<!--                                        <textarea-->
<!--                                            v-model="editForms[index].results"-->
<!--                                            class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                            rows="5"-->
<!--                                            placeholder="Type your results..."-->
<!--                                        ></textarea>-->
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Description</label>-->
<!--                                        <textarea-->
<!--                                            v-model="editForms[index].description"-->
<!--                                            class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                            rows="5"-->
<!--                                            placeholder="Description..."-->
<!--                                        ></textarea>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="flex gap-1 mt-2 justify-end">-->
<!--                                <button v-if="!editing[index]" @click="startEditing(index)" class="p-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 21 20" fill="none">-->
<!--                                        <path d="M11.75 5.41664L15.0833 8.74997M3.83334 16.6666H7.16668L15.9167 7.91663C16.3587 7.47461 16.607 6.87509 16.607 6.24997C16.607 5.62485 16.3587 5.02533 15.9167 4.5833C15.4746 4.14127 14.8751 3.89294 14.25 3.89294C13.6249 3.89294 13.0254 4.14127 12.5833 4.5833L3.83334 13.3333V16.6666Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                                <button v-if="!editing[index]" @click="removeEducation(index)" class="p-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.680-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />-->
<!--                                    </svg>-->
<!--                                </button>-->

<!--                                <button v-if="editing[index]" @click="cancelEdit(index)" class="p-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                                <button v-if="editing[index]" @click="saveEdit(index)" class="p-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                            </div>-->
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
<!--        educations: {-->
<!--            type: Array,-->
<!--            required: true,-->
<!--            default: () => []-->
<!--        }-->
<!--    },-->

<!--    data() {-->
<!--        return {-->
<!--            showAddForm: false,-->
<!--            newEducation: {-->
<!--                school_name: '',-->
<!--                district: '',-->
<!--                from: '',-->
<!--                to: '',-->
<!--                results: '',-->
<!--                description: '',-->
<!--                field: '',-->
<!--            },-->
<!--            editing: [],-->
<!--            editForms: [],-->
<!--            isSaving: false,-->
<!--            hasUnsavedChanges: false,-->
<!--            errors: {-->
<!--                add: {-->
<!--                    school_name: '',-->
<!--                    district: '',-->
<!--                    from: '',-->
<!--                    field: '',-->
<!--                    to: ''-->
<!--                },-->
<!--                edit: []-->
<!--            }-->
<!--        };-->
<!--    },-->

<!--    watch: {-->
<!--        educations: {-->
<!--            handler() {-->
<!--                this.resetEditingStates();-->
<!--            },-->
<!--            deep: true,-->
<!--            immediate: true-->
<!--        }-->
<!--    },-->

<!--    mounted() {-->
<!--        // Add event listener for browser/tab closing-->
<!--        window.addEventListener('beforeunload', this.handleBeforeUnload);-->

<!--        // Add event listener for route changes if using Vue Router-->
<!--        if (this.$router) {-->
<!--            this.$router.beforeEach((to, from, next) => {-->
<!--                if (this.hasUnsavedChanges) {-->
<!--                    if (confirm('You have unsaved changes. Are you sure you want to leave?')) {-->
<!--                        this.hasUnsavedChanges = false;-->
<!--                        next();-->
<!--                    } else {-->
<!--                        next(false);-->
<!--                    }-->
<!--                } else {-->
<!--                    next();-->
<!--                }-->
<!--            });-->
<!--        }-->
<!--    },-->

<!--    beforeUnmount() {-->
<!--        // Clean up event listener when component is destroyed-->
<!--        window.removeEventListener('beforeunload', this.handleBeforeUnload);-->
<!--    },-->

<!--    methods: {-->
<!--        handleBeforeUnload(event) {-->
<!--            if (this.hasUnsavedChanges) {-->
<!--                event.preventDefault();-->
<!--                event.returnValue = 'You have unsaved changes. Are you sure you want to leave?';-->
<!--                return event.returnValue;-->
<!--            }-->
<!--        },-->

<!--        formatDate(dateString) {-->
<!--            if (!dateString) return '';-->
<!--            const date = new Date(dateString);-->
<!--            return date.toLocaleDateString('en-US', {-->
<!--                year: 'numeric',-->
<!--                month: 'short',-->
<!--                day: 'numeric'-->
<!--            });-->
<!--        },-->

<!--        resetEditingStates() {-->
<!--            this.editing = new Array(this.educations.length).fill(false);-->
<!--            this.editForms = this.educations.map(edu => ({-->
<!--                school_name: edu?.school_name || '',-->
<!--                district: edu?.district || '',-->
<!--                from: edu?.from || '',-->
<!--                to: edu?.to || '',-->
<!--                field: edu?.field || '',-->
<!--                results: edu?.results || '',-->
<!--                description: edu?.description || '',-->
<!--            }));-->
<!--            this.errors.edit = new Array(this.educations.length).fill({});-->
<!--        },-->

<!--        validateEducation(education, mode = 'add', index = null) {-->
<!--            let isValid = true;-->
<!--            const newErrors = {-->
<!--                school_name: '',-->
<!--                district: '',-->
<!--                field: '',-->
<!--                from: '',-->
<!--                to: ''-->
<!--            };-->

<!--            if (!education.school_name?.trim()) {-->
<!--                newErrors.school_name = 'School name is required';-->
<!--                isValid = false;-->
<!--            }-->

<!--            if (!education.district?.trim()) {-->
<!--                newErrors.district = 'District is required';-->
<!--                isValid = false;-->
<!--            }-->

<!--            if (!education.field?.trim()) {-->
<!--                newErrors.field = 'Field of Study is required';-->
<!--                isValid = false;-->
<!--            }-->

<!--            if (!education.from) {-->
<!--                newErrors.from = 'Start date is required';-->
<!--                isValid = false;-->
<!--            }-->

<!--            if (!education.to) {-->
<!--                newErrors.to = 'End date is required';-->
<!--                isValid = false;-->
<!--            } else if (education.from && new Date(education.from) > new Date(education.to)) {-->
<!--                newErrors.to = 'End date must be after start date';-->
<!--                isValid = false;-->
<!--            }-->

<!--            if (mode === 'add') {-->
<!--                this.errors.add = newErrors;-->
<!--            } else {-->
<!--                // Đảm bảo errors.edit là một mảng-->
<!--                if (!Array.isArray(this.errors.edit)) {-->
<!--                    this.errors.edit = [];-->
<!--                }-->
<!--                this.errors.edit[index] = newErrors;-->
<!--                // Force reactivity-->
<!--                this.errors = {...this.errors};-->
<!--            }-->

<!--            return isValid;-->
<!--        },-->

<!--        addEducation() {-->
<!--            if (!this.validateEducation(this.newEducation, 'add')) return;-->

<!--            this.$emit('add', {...this.newEducation});-->
<!--            this.hasUnsavedChanges = true;-->
<!--            this.cancelAdd();-->
<!--            this.requestSavePortfolio();-->
<!--        },-->

<!--        cancelAdd() {-->
<!--            this.showAddForm = false;-->
<!--            this.newEducation = {-->
<!--                school_name: '',-->
<!--                district: '',-->
<!--                from: '',-->
<!--                field: '',-->
<!--                results: '',-->
<!--                description: '',-->
<!--                to: ''-->
<!--            };-->
<!--            this.errors.add = {-->
<!--                school_name: '',-->
<!--                from: '',-->
<!--                district: '',-->
<!--                field: '',-->
<!--                to: ''-->
<!--            };-->
<!--        },-->

<!--        startEditing(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index ? true : item);-->
<!--            this.hasUnsavedChanges = true;-->
<!--        },-->

<!--        cancelEdit(index) {-->
<!--            this.editing[index] = false;-->
<!--            this.editForms[index] = { ...this.educations[index] };-->

<!--            // Reset errors for this index-->
<!--            if (Array.isArray(this.errors.edit)) {-->
<!--                this.errors.edit[index] = {};-->
<!--                this.errors = {...this.errors};-->
<!--            }-->

<!--            // Check if any other forms are being edited-->
<!--            this.hasUnsavedChanges = this.showAddForm || this.editing.some(edit => edit === true);-->
<!--        },-->

<!--        saveEdit(index) {-->
<!--            if (!this.validateEducation(this.editForms[index], 'edit', index)) return;-->

<!--            this.$emit('update', {-->
<!--                index,-->
<!--                education: {...this.editForms[index]}-->
<!--            });-->
<!--            this.editing[index] = false;-->
<!--            this.hasUnsavedChanges = this.showAddForm || this.editing.some(edit => edit === true);-->
<!--            this.requestSavePortfolio();-->
<!--        },-->

<!--        removeEducation(index) {-->
<!--            if (confirm('Are you sure you want to remove this education?')) {-->
<!--                this.$emit('remove', index);-->
<!--                this.hasUnsavedChanges = true;-->
<!--                this.requestSavePortfolio();-->
<!--            }-->
<!--        },-->

<!--        requestSavePortfolio() {-->
<!--            this.$emit('save-portfolio');-->
<!--            this.isSaving = true;-->
<!--            setTimeout(() => {-->
<!--                this.isSaving = false;-->
<!--                this.hasUnsavedChanges = false;-->
<!--            }, 2000);-->
<!--        }-->
<!--    }-->
<!--};-->
<!--</script>-->
