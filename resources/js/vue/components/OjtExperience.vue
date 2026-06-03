<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
        <div class="flex flex-col gap-4 w-full h-full">
            <div class="flex justify-between items-center">
                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('OJT Experience')}}</p>
                <div class="flex gap-2">
                    <button @click="showAddForm = true" class="px-2 py-1 bg-primary text-white rounded hover:bg-blue-600">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('OJT title')}} <span class="text-red-600">*</span></label>
                        <input v-model="newOjt.title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('OJT title')">
                        <p v-if="errors.add.title" class="text-red-500 text-xs mt-1">{{ errors.add.title }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Company or organisation')}} <span class="text-red-600">*</span></label>
                            <input v-model="newOjt.organization" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Company or organisation name')">
                            <p v-if="errors.add.organization" class="text-red-500 text-xs mt-1">{{ errors.add.organization }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}} <span class="text-red-600">*</span></label>
                            <input v-model="newOjt.district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('District name')">
                            <p v-if="errors.add.district" class="text-red-500 text-xs mt-1">{{ errors.add.district }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>
                            <input v-model="newOjt.from" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="errors.add.from" class="text-red-500 text-xs mt-1">{{ errors.add.from }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>
                            <input v-model="newOjt.to" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="errors.add.to" class="text-red-500 text-xs mt-1">{{ errors.add.to }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skills')}}</label>
                            <textarea
                                v-model="newOjt.skills"
                                class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"
                                rows="5"
                                :placeholder="$t('Add your top skills used in this role')"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>
                            <textarea
                                v-model="newOjt.description"
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
                    <button @click="addOJT" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- OJT List -->
            <ol class="relative border-s border-primary">
                <li v-for="(ojt, index) in ojts" :key="index" class="mb-10 border border-dashed p-4 rounded-lg relative group">

                    <div v-if="!editing[index]">
                        <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5"></div>
                        <p>
                            <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ ojt.title }}</span>
                            <span v-if="ojt.district" class="text-[#706F81] dark:text-white">
                                        ({{ ojt.district }})
                                    </span>
                        </p>
                        <p>
                            <span class="text-[#91919A] dark:text-white text-sm">{{ formatDate(ojt.from) }} - {{ formatDate(ojt.to) }}</span>
                        </p>
                        <p v-if="ojt.organization" class="text-[#464559] dark:text-white"><span class="font-semibold dark:text-white">{{$t('Organization')}}: </span> {{ ojt.organization }}</p>
                        <div v-if="ojt.skills" class="my-2">
                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Skills')}}:</p>
                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ ojt.skills }}</p>
                        </div>
                        <div v-if="ojt.description" class="my-2">
                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Description')}}:</p>
                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ ojt.description }}</p>
                        </div>

                    </div>

                    <!-- Edit Form -->
                    <div v-else class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('OJT Title')}} <span class="text-red-600">*</span></label>
                            <input v-model="editForms[index].title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                            <p v-if="errors.edit[index]?.title" class="text-red-500 text-xs mt-1">{{ errors.edit[index].title }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Company or organization')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].organization" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Field of Study">
                                <p v-if="errors.edit[index]?.organization" class="text-red-500 text-xs mt-1">{{ errors.edit[index].organization }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                                <p v-if="errors.edit[index]?.district" class="text-red-500 text-xs mt-1">{{ errors.edit[index].district }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('From')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].from" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                                <p v-if="errors.edit[index]?.from" class="text-red-500 text-xs mt-1">{{ errors.edit[index].from }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('To')}} <span class="text-red-600">*</span></label>
                                <input v-model="editForms[index].to" type="month" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">
                                <p v-if="errors.edit[index]?.to" class="text-red-500 text-xs mt-1">{{ errors.edit[index].to }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skills')}}</label>
                                <textarea
                                    v-model="editForms[index].skills"
                                    class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"
                                    rows="5"
                                    :placeholder="$t('Add your top skills used in this role')"
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
                        <button v-if="!editing[index]" @click="removeOJT(index)" class="px-2 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
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

<script>
export default {
    props: {
        ojts: {
            type: Array,
            required: true,
            default: () => []
        }
    },

    data() {
        return {
            showAddForm: false,
            newOjt: {
                title: '',
                district: '',
                organization: '',
                from: '', // Sẽ lưu dưới dạng 'YYYY-MM'
                to: '',   // Sẽ lưu dưới dạng 'YYYY-MM'
                skills: '',
                description: '',
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
                    title: '',
                    district: '',
                    from: '',
                    organization: '',
                    to: ''
                },
                edit: []
            }
        };
    },

    watch: {
        ojts: {
            handler() {
                this.resetEditingStates();
            },
            deep: true,
            immediate: true
        },
        // Watch for changes in new OJT form
        newOjt: {
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

                    const original = this.ojts[index];
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
            this.editing = new Array(this.ojts.length).fill(false);
            this.editForms = this.ojts.map(ojt => {
                // Xử lý chuyển đổi định dạng date từ YYYY-MM-DD sang YYYY-MM nếu cần
                let from = ojt?.from || '';
                let to = ojt?.to || '';

                // Chuyển đổi từ YYYY-MM-DD sang YYYY-MM nếu cần
                if (from && from.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    from = from.substring(0, 7); // Lấy YYYY-MM
                }
                if (to && to.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    to = to.substring(0, 7); // Lấy YYYY-MM
                }

                return {
                    title: ojt?.title || '',
                    district: ojt?.district || '',
                    from: from,
                    to: to,
                    organization: ojt?.organization || '',
                    skills: ojt?.skills || '',
                    description: ojt?.description || '',
                };
            });

            // Khởi tạo errors.edit với đúng số lượng phần tử
            this.errors.edit = new Array(this.ojts.length).fill(null).map(() => ({}));
            this.setUnsavedChanges(false);
        },

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

        validateOJT(ojt, mode = 'add', index = null) {
            let isValid = true;
            const newErrors = {
                title: '',
                district: '',
                organization: '',
                from: '',
                to: ''
            };

            if (!ojt.title?.trim()) {
                newErrors.title = this.$t('OJT title is required');
                isValid = false;
            }

            if (!ojt.district?.trim()) {
                newErrors.district = this.$t('District is required');
                isValid = false;
            }

            if (!ojt.organization?.trim()) {
                newErrors.organization = this.$t('Organization is required');
                isValid = false;
            }

            const monthRegex = /^\d{4}-\d{2}$/;
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;

            // Validate Start Date - chấp nhận cả 2 định dạng
            if (!ojt.from) {
                newErrors.from = this.$t('Start date is required');
                isValid = false;
            } else if (!monthRegex.test(ojt.from) && !dateRegex.test(ojt.from)) {
                newErrors.from = this.$t('Start date must be in YYYY-MM format');
                isValid = false;
            } else {
                // Chuẩn hóa về YYYY-MM-DD để validation
                let fromDateStr = ojt.from;
                if (monthRegex.test(fromDateStr)) {
                    fromDateStr = ojt.from + '-01'; // Thêm ngày 01
                }

                const fromDate = new Date(fromDateStr);
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

            // Validate End Date - chấp nhận cả 2 định dạng
            if (!ojt.to) {
                newErrors.to = this.$t('End date is required');
                isValid = false;
            } else if (!monthRegex.test(ojt.to) && !dateRegex.test(ojt.to)) {
                newErrors.to = this.$t('End date must be in YYYY-MM format');
                isValid = false;
            } else {
                // Chuẩn hóa về YYYY-MM-DD để validation
                let toDateStr = ojt.to;
                if (monthRegex.test(toDateStr)) {
                    toDateStr = ojt.to + '-01'; // Thêm ngày 01
                }

                const toDate = new Date(toDateStr);
                const now = new Date();

                if (toDate > now) {
                    newErrors.to = this.$t('End date cannot be in the future');
                    isValid = false;
                }

                if (ojt.from) {
                    let fromDateStr = ojt.from;
                    if (monthRegex.test(fromDateStr)) {
                        fromDateStr = ojt.from + '-01';
                    }
                    const fromDate = new Date(fromDateStr);

                    if (fromDate > toDate) {
                        newErrors.to = this.$t('End date must be after start date');
                        isValid = false;
                    }
                }
            }

            // Gán lỗi theo mode
            if (mode === 'add') {
                this.errors.add = newErrors;
            } else if (index !== null && index >= 0 && index < this.errors.edit.length) {
                this.errors.edit[index] = newErrors;
            }

            return isValid;
        },

        addOJT() {
            if (!this.validateOJT(this.newOjt, 'add')) return;

            this.$emit('add', {...this.newOjt});
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
            this.newOjt = {
                title: '',
                district: '',
                from: '',
                organization: '',
                skills: '',
                description: '',
                to: ''
            };
            this.errors.add = {
                title: '',
                from: '',
                district: '',
                organization: '',
                to: ''
            };
            this.setUnsavedChanges(false);
        },

        startEditing(index) {
            this.editing = this.editing.map((item, i) => i === index ? true : item);
            // Đảm bảo errors.edit được khởi tạo cho index này
            if (index >= 0 && index < this.errors.edit.length) {
                this.errors.edit[index] = {};
            }
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
            this.editing = this.editing.map((item, i) => i === index ? false : item);
            this.editForms[index] = { ...this.ojts[index] };

            // Reset errors for this index
            if (index >= 0 && index < this.errors.edit.length) {
                this.errors.edit[index] = {};
            }
            this.checkUnsavedChangesState();
        },

        saveEdit(index) {
            if (!this.validateOJT(this.editForms[index], 'edit', index)) return;

            this.$emit('update', {
                index,
                experience: { ...this.editForms[index] }
            });
            this.editing = this.editing.map((item, i) => i === index ? false : item);
            this.requestSavePortfolio();
            this.setUnsavedChanges(false);
        },

        removeOJT(index) {
            if (confirm(this.$t('Are you sure you want to remove this OJT Experience?'))) {
                this.$emit('remove', index);
                this.requestSavePortfolio();
            }
        },

        requestSavePortfolio() {
            this.$emit('save-portfolio');
            this.isSaving = true;
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
                this.addOJT();
            } else if (this.pendingAction === 'cancelEdit') {
                this.saveEdit(this.pendingIndex);
            }

            this.pendingAction = null;
            this.pendingIndex = null;
        },

        // Check if there are changes in a specific edit form
        hasEditChanges(index) {
            if (!this.editing[index]) return false;

            const original = this.ojts[index];
            return JSON.stringify(this.editForms[index]) !== JSON.stringify(original);
        },

        // Check overall unsaved changes state
        checkUnsavedChangesState() {
            const hasNewChanges = this.showAddForm && Object.values(this.newOjt).some(
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
<!--    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">-->
<!--        <div class="flex flex-col gap-4 w-full h-full">-->
<!--            <div class="flex justify-between items-center">-->
<!--                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('OJT Experience')}}</p>-->
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
<!--                        <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('OJT title')}} <span class="text-red-600">*</span></label>-->
<!--                        <input v-model="newOjt.title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('OJT title')">-->
<!--                        <p v-if="errors.add.title" class="text-red-500 text-xs mt-1">{{ errors.add.title }}</p>-->
<!--                    </div>-->
<!--                    <div class="grid grid-cols-2 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Company or organisation')}} <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newOjt.organization" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('Company or organisation name')">-->
<!--                            <p v-if="errors.add.organization" class="text-red-500 text-xs mt-1">{{ errors.add.organization }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}} <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newOjt.district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" :placeholder="$t('District name')">-->
<!--                            <p v-if="errors.add.district" class="text-red-500 text-xs mt-1">{{ errors.add.district }}</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="grid grid-cols-2 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Start date')}} <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newOjt.from" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="errors.add.from" class="text-red-500 text-xs mt-1">{{ errors.add.from }}</p>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('End date')}} <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="newOjt.to" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="errors.add.to" class="text-red-500 text-xs mt-1">{{ errors.add.to }}</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="grid grid-cols-2 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skills')}}</label>-->
<!--                            <textarea-->
<!--                                v-model="newOjt.skills"-->
<!--                                class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                rows="5"-->
<!--                                :placeholder="$t('Add your top skills used in this role')"-->
<!--                            ></textarea>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>-->
<!--                            <textarea-->
<!--                                v-model="newOjt.description"-->
<!--                                class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                rows="5"-->
<!--                                :placeholder="$t('Description...')"-->
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
<!--                    <button @click="addOJT" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->

<!--            &lt;!&ndash; OJT List &ndash;&gt;-->
<!--            <ol class="relative border-s border-primary">-->
<!--                <li v-for="(ojt, index) in ojts" :key="index" class="mb-10 border border-dashed p-4 rounded-lg relative group">-->

<!--                    <div v-if="!editing[index]">-->
<!--                        <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5"></div>-->
<!--                        <p>-->
<!--                            <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ ojt.title }}</span>-->
<!--                            <span v-if="ojt.district" class="text-[#706F81] dark:text-white">-->
<!--                                        ({{ ojt.district }})-->
<!--                                    </span>-->
<!--                        </p>-->
<!--                        <p>-->
<!--                            <span class="text-[#91919A] dark:text-white text-sm">{{ formatDate(ojt.from) }} - {{ formatDate(ojt.to) }}</span>-->
<!--                        </p>-->
<!--                        <p v-if="ojt.organization" class="text-[#464559] dark:text-white"><span class="font-semibold dark:text-white">{{$t('Organization')}}: </span> {{ ojt.organization }}</p>-->
<!--                        <div v-if="ojt.skills" class="my-2">-->
<!--                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Skills')}}:</p>-->
<!--                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ ojt.skills }}</p>-->
<!--                        </div>-->
<!--                        <div v-if="ojt.description" class="my-2">-->
<!--                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{$t('Description')}}:</p>-->
<!--                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ ojt.description }}</p>-->
<!--                        </div>-->

<!--                    </div>-->

<!--                    &lt;!&ndash; Edit Form &ndash;&gt;-->
<!--                    <div v-else class="grid grid-cols-1 gap-4">-->
<!--                        <div>-->
<!--                            <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('OJT Title')}} <span class="text-red-600">*</span></label>-->
<!--                            <input v-model="editForms[index].title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                            <p v-if="errors.edit[index]?.title" class="text-red-500 text-xs mt-1">{{ errors.edit[index].title }}</p>-->
<!--                        </div>-->
<!--                        <div class="grid grid-cols-2 gap-4">-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Company or organization')}} <span class="text-red-600">*</span></label>-->
<!--                                <input v-model="editForms[index].organization" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm" placeholder="Field of Study">-->
<!--                                <p v-if="errors.edit[index]?.organization" class="text-red-500 text-xs mt-1">{{ errors.edit[index].organization }}</p>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('District')}} <span class="text-red-600">*</span></label>-->
<!--                                <input v-model="editForms[index].district" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                <p v-if="errors.edit[index]?.district" class="text-red-500 text-xs mt-1">{{ errors.edit[index].district }}</p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="grid grid-cols-2 gap-4">-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('From')}} <span class="text-red-600">*</span></label>-->
<!--                                <input v-model="editForms[index].from" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                <p v-if="errors.edit[index]?.from" class="text-red-500 text-xs mt-1">{{ errors.edit[index].from }}</p>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('To')}} <span class="text-red-600">*</span></label>-->
<!--                                <input v-model="editForms[index].to" type="date" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm">-->
<!--                                <p v-if="errors.edit[index]?.to" class="text-red-500 text-xs mt-1">{{ errors.edit[index].to }}</p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="grid grid-cols-2 gap-4">-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Skills')}}</label>-->
<!--                                <textarea-->
<!--                                    v-model="editForms[index].skills"-->
<!--                                    class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                    rows="5"-->
<!--                                    :placeholder="$t('Add your top skills used in this role')"-->
<!--                                ></textarea>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <label class="block text-sm font-medium text-gray-700 dark:text-white">{{$t('Description')}}</label>-->
<!--                                <textarea-->
<!--                                    v-model="editForms[index].description"-->
<!--                                    class="w-full text-[#706F81] dark:text-white bg-transparent border border-gray-300 rounded-xl p-2 focus:outline-none"-->
<!--                                    rows="5"-->
<!--                                    :placeholder="$t('Description...')"-->
<!--                                ></textarea>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="flex gap-1 mt-2 justify-end">-->
<!--                        <button v-if="!editing[index]" @click="startEditing(index)" class="px-2 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />-->
<!--                            </svg>-->
<!--                        </button>-->
<!--                        <button v-if="!editing[index]" @click="removeOJT(index)" class="px-2 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.680-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />-->
<!--                            </svg>-->
<!--                        </button>-->

<!--                        <button v-if="editing[index]" @click="cancelEdit(index)" class="px-2 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />-->
<!--                            </svg>-->
<!--                        </button>-->
<!--                        <button v-if="editing[index]" @click="saveEdit(index)" class="px-2 py-1 bg-primary text-white rounded text-sm hover:bg-blue-600">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />-->
<!--                            </svg>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </li>-->
<!--            </ol>-->

<!--            &lt;!&ndash; Warning Modal &ndash;&gt;-->
<!--            <div v-if="showWarning" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">-->
<!--                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full mx-4">-->
<!--                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{$t('Unsaved Changes')}}</h3>-->
<!--                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">-->
<!--                        {{$t('You have unsaved changes. If you leave now, your changes will be lost.')}}-->
<!--                    </p>-->
<!--                    <div class="flex justify-end gap-3">-->
<!--                        <button-->
<!--                            @click="continueWithoutSaving"-->
<!--                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm"-->
<!--                        >-->
<!--                            {{$t('Leave Anyway')}}-->
<!--                        </button>-->
<!--                        <button-->
<!--                            @click="saveAndContinue"-->
<!--                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"-->
<!--                        >-->
<!--                            {{$t('Save and Continue')}}-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--    props: {-->
<!--        ojts: {-->
<!--            type: Array,-->
<!--            required: true,-->
<!--            default: () => []-->
<!--        }-->
<!--    },-->

<!--    data() {-->
<!--        return {-->
<!--            showAddForm: false,-->
<!--            newOjt: {-->
<!--                title: '',-->
<!--                district: '',-->
<!--                organization: '',-->
<!--                from: '',-->
<!--                to: '',-->
<!--                skills: '',-->
<!--                description: '',-->
<!--            },-->
<!--            editing: [],-->
<!--            editForms: [],-->
<!--            isSaving: false,-->
<!--            showWarning: false,-->
<!--            hasUnsavedChanges: false,-->
<!--            pendingAction: null,-->
<!--            pendingIndex: null,-->
<!--            beforeUnloadListener: null,-->
<!--            errors: {-->
<!--                add: {-->
<!--                    title: '',-->
<!--                    district: '',-->
<!--                    from: '',-->
<!--                    organization: '',-->
<!--                    to: ''-->
<!--                },-->
<!--                edit: []-->
<!--            }-->
<!--        };-->
<!--    },-->

<!--    watch: {-->
<!--        ojts: {-->
<!--            handler() {-->
<!--                this.resetEditingStates();-->
<!--            },-->
<!--            deep: true,-->
<!--            immediate: true-->
<!--        },-->
<!--        // Watch for changes in new OJT form-->
<!--        newOjt: {-->
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

<!--                    const original = this.ojts[index];-->
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
<!--        resetEditingStates() {-->
<!--            this.editing = new Array(this.ojts.length).fill(false);-->
<!--            this.editForms = this.ojts.map(ojt => ({-->
<!--                title: ojt?.title || '',-->
<!--                district: ojt?.district || '',-->
<!--                from: ojt?.from || '',-->
<!--                to: ojt?.to || '',-->
<!--                organization: ojt?.organization || '',-->
<!--                skills: ojt?.skills || '',-->
<!--                description: ojt?.description || '',-->
<!--            }));-->

<!--            // Khởi tạo errors.edit với đúng số lượng phần tử-->
<!--            this.errors.edit = new Array(this.ojts.length).fill(null).map(() => ({}));-->
<!--            this.setUnsavedChanges(false);-->
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

<!--        validateOJT(ojt, mode = 'add', index = null) {-->
<!--            let isValid = true;-->
<!--            const newErrors = {-->
<!--                title: '',-->
<!--                district: '',-->
<!--                organization: '',-->
<!--                from: '',-->
<!--                to: ''-->
<!--            };-->

<!--            if (!ojt.title?.trim()) {-->
<!--                newErrors.title = this.$t('OJT title is required');-->
<!--                isValid = false;-->
<!--            }-->

<!--            if (!ojt.district?.trim()) {-->
<!--                newErrors.district = this.$t('District is required');-->
<!--                isValid = false;-->
<!--            }-->

<!--            if (!ojt.organization?.trim()) {-->
<!--                newErrors.organization = this.$t('Organization is required');-->
<!--                isValid = false;-->
<!--            }-->

<!--            const today = new Date();-->
<!--            const fromDate = ojt.from ? new Date(ojt.from) : null;-->
<!--            const toDate = ojt.to ? new Date(ojt.to) : null;-->

<!--            // Kiểm tra From-->
<!--            if (!ojt.from) {-->
<!--                newErrors.from = this.$t('Start date is required');-->
<!--                isValid = false;-->
<!--            } else if (!/^\d{4}-\d{2}-\d{2}$/.test(ojt.from)) {-->
<!--                newErrors.from = this.$t('Invalid start date format (YYYY-MM-DD)');-->
<!--                isValid = false;-->
<!--            } else if (fromDate.getFullYear() < 1900) {-->
<!--                newErrors.from = this.$t('Start year must be 1900 or later');-->
<!--                isValid = false;-->
<!--            } else if (fromDate > new Date()) {-->
<!--                newErrors.from = this.$t('Start date cannot be in the future');-->
<!--                isValid = false;-->
<!--            }-->

<!--            // Kiểm tra To-->
<!--            if (!ojt.to) {-->
<!--                newErrors.to = this.$t('End date is required');-->
<!--                isValid = false;-->
<!--            } else if (!/^\d{4}-\d{2}-\d{2}$/.test(ojt.to)) {-->
<!--                newErrors.to = this.$t('Invalid end date format (YYYY-MM-DD)');-->
<!--                isValid = false;-->
<!--            } else if (toDate > today) {-->
<!--                newErrors.to = this.$t('End date cannot be in the future');-->
<!--                isValid = false;-->
<!--            }-->

<!--            // So sánh From < To-->
<!--            if (fromDate && toDate && fromDate > toDate) {-->
<!--                newErrors.to = this.$t('End date must be after start date');-->
<!--                isValid = false;-->
<!--            }-->

<!--            // Gán lỗi theo mode-->
<!--            if (mode === 'add') {-->
<!--                this.errors.add = newErrors;-->
<!--            } else if (index !== null && index >= 0 && index < this.errors.edit.length) {-->
<!--                this.errors.edit[index] = newErrors;-->
<!--            }-->

<!--            return isValid;-->
<!--        },-->

<!--        addOJT() {-->
<!--            if (!this.validateOJT(this.newOjt, 'add')) return;-->

<!--            this.$emit('add', {...this.newOjt});-->
<!--            this.setUnsavedChanges(false);-->
<!--            this.cancelAdd();-->
<!--            this.requestSavePortfolio();-->
<!--        },-->

<!--        cancelAdd() {-->
<!--            if (this.hasUnsavedChanges) {-->
<!--                this.showWarning = true;-->
<!--                this.pendingAction = 'cancelAdd';-->
<!--            } else {-->
<!--                this.doCancelAdd();-->
<!--            }-->
<!--        },-->

<!--        doCancelAdd() {-->
<!--            this.showAddForm = false;-->
<!--            this.newOjt = {-->
<!--                title: '',-->
<!--                district: '',-->
<!--                from: '',-->
<!--                organization: '',-->
<!--                skills: '',-->
<!--                description: '',-->
<!--                to: ''-->
<!--            };-->
<!--            this.errors.add = {-->
<!--                title: '',-->
<!--                from: '',-->
<!--                district: '',-->
<!--                organization: '',-->
<!--                to: ''-->
<!--            };-->
<!--            this.setUnsavedChanges(false);-->
<!--        },-->

<!--        startEditing(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index ? true : item);-->
<!--            // Đảm bảo errors.edit được khởi tạo cho index này-->
<!--            if (index >= 0 && index < this.errors.edit.length) {-->
<!--                this.errors.edit[index] = {};-->
<!--            }-->
<!--        },-->

<!--        cancelEdit(index) {-->
<!--            if (this.hasEditChanges(index)) {-->
<!--                this.showWarning = true;-->
<!--                this.pendingAction = 'cancelEdit';-->
<!--                this.pendingIndex = index;-->
<!--            } else {-->
<!--                this.doCancelEdit(index);-->
<!--            }-->
<!--        },-->

<!--        doCancelEdit(index) {-->
<!--            this.editing = this.editing.map((item, i) => i === index ? false : item);-->
<!--            this.editForms[index] = { ...this.ojts[index] };-->

<!--            // Reset errors for this index-->
<!--            if (index >= 0 && index < this.errors.edit.length) {-->
<!--                this.errors.edit[index] = {};-->
<!--            }-->
<!--            this.checkUnsavedChangesState();-->
<!--        },-->

<!--        saveEdit(index) {-->
<!--            if (!this.validateOJT(this.editForms[index], 'edit', index)) return;-->

<!--            this.$emit('update', {-->
<!--                index,-->
<!--                experience: { ...this.editForms[index] }-->
<!--            });-->
<!--            this.editing = this.editing.map((item, i) => i === index ? false : item);-->
<!--            this.requestSavePortfolio();-->
<!--            this.setUnsavedChanges(false);-->
<!--        },-->

<!--        removeOJT(index) {-->
<!--            if (confirm(this.$t('Are you sure you want to remove this OJT Experience?'))) {-->
<!--                this.$emit('remove', index);-->
<!--                this.requestSavePortfolio();-->
<!--            }-->
<!--        },-->

<!--        requestSavePortfolio() {-->
<!--            this.$emit('save-portfolio');-->
<!--            this.isSaving = true;-->
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
<!--                this.addOJT();-->
<!--            } else if (this.pendingAction === 'cancelEdit') {-->
<!--                this.saveEdit(this.pendingIndex);-->
<!--            }-->

<!--            this.pendingAction = null;-->
<!--            this.pendingIndex = null;-->
<!--        },-->

<!--        // Check if there are changes in a specific edit form-->
<!--        hasEditChanges(index) {-->
<!--            if (!this.editing[index]) return false;-->

<!--            const original = this.ojts[index];-->
<!--            return JSON.stringify(this.editForms[index]) !== JSON.stringify(original);-->
<!--        },-->

<!--        // Check overall unsaved changes state-->
<!--        checkUnsavedChangesState() {-->
<!--            const hasNewChanges = this.showAddForm && Object.values(this.newOjt).some(-->
<!--                value => value !== '' && value !== null && value !== undefined-->
<!--            );-->

<!--            const hasEditChanges = this.editForms.some((form, index) => this.hasEditChanges(index));-->

<!--            this.setUnsavedChanges(hasNewChanges || hasEditChanges);-->
<!--        },-->

<!--        // Set unsaved changes state-->
<!--        setUnsavedChanges(hasChanges) {-->
<!--            this.hasUnsavedChanges = hasChanges;-->
<!--        },-->

<!--        // Set up beforeunload listener to warn user when leaving page-->
<!--        setupBeforeUnloadListener() {-->
<!--            this.beforeUnloadListener = (e) => {-->
<!--                if (this.hasUnsavedChanges) {-->
<!--                    e.preventDefault();-->
<!--                    e.returnValue = this.$t('You have unsaved changes. Are you sure you want to leave?');-->
<!--                    return e.returnValue;-->
<!--                }-->
<!--            };-->

<!--            window.addEventListener('beforeunload', this.beforeUnloadListener);-->
<!--        },-->

<!--        // Remove beforeunload listener-->
<!--        removeBeforeUnloadListener() {-->
<!--            if (this.beforeUnloadListener) {-->
<!--                window.removeEventListener('beforeunload', this.beforeUnloadListener);-->
<!--            }-->
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
<!--};-->
<!--</script>-->
