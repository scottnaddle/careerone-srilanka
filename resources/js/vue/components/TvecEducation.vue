<template>
    <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
        <div class="flex flex-col gap-4 w-full h-full">
            <div class="flex justify-between items-center">
                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{$t('NVQ Education')}}</p>
<!--                <button-->
<!--                    @click="showAddForm = true"-->
<!--                    class="px-2 py-1 bg-primary text-white rounded-xl hover:bg-blue-600"-->
<!--                >-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">-->
<!--                        <path d="M9.99999 4.16666V15.8333M4.16666 9.99999H15.8333" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                    </svg>-->
<!--                </button>-->
            </div>

            <!-- Add Form -->
            <div v-if="showAddForm" class="p-4 border border-gray-300 rounded-lg mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Institute</label>
                        <input v-model="newEducation.institute" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Industry Sector</label>
                        <input v-model="newEducation.industry_sector" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white">Course Name</label>
                        <input v-model="newEducation.course_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">From</label>
                            <input v-model="newEducation.from" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">To</label>
                            <input v-model="newEducation.to" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button
                        @click="showAddForm = false"
                        class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                    <button
                        @click="addEducation"
                        class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                    >
                        Save
                    </button>
                </div>
            </div>

            <!-- Education List -->
            <div class="flex flex-col gap-4  cursor-not-allowed">
                <div v-for="(education, index) in educations" :key="index" class="relative group">
                    <div class="flex gap-4 items-baseline">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                <circle cx="5" cy="5" r="5" fill="#4984F6" />
                            </svg>
                        </div>

                        <div class="flex flex-col gap-2 w-full">
                            <div v-if="!editing[index]">
                                <p>
                                    <span class="text-[#464559] text-xl font-semibold dark:text-white">{{ education.institute }}</span>
                                    <span class="text-[#706F81] dark:text-white"> ({{$t('Industry sector')}}: {{ education.industry_sector }})</span>
                                </p>
                                <p class="dark:text-white">
                                    <span class="font-semibold">{{$t('Course name')}}: {{ education.course_name }}</span>
                                    <span class="text-sm"> ({{ formatDate(education.from) }} - {{ formatDate(education.to) }}</span>
                                </p>
                            </div>

                            <!-- Edit Form -->
                            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Institute</label>
                                    <input v-model="editForms[index].institute" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Industry Sector</label>
                                    <input v-model="editForms[index].industry_sector" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-white">Course Name</label>
                                    <input v-model="editForms[index].course_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">From</label>
                                        <input v-model="editForms[index].from" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-white">To</label>
                                        <input v-model="editForms[index].to" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                </div>
                            </div>

<!--                            <div class="flex gap-2 mt-2">-->
<!--                                <button-->
<!--                                    v-if="!editing[index]"-->
<!--                                    @click="startEditing(index)"-->
<!--                                    class="px-2 py-1 bg-gray-500 text-white rounded-xl text-sm hover:bg-gray-600"-->
<!--                                >-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 21 20" fill="none">-->
<!--                                        <path d="M11.75 5.41664L15.0833 8.74997M3.83334 16.6666H7.16668L15.9167 7.91663C16.3587 7.47461 16.607 6.87509 16.607 6.24997C16.607 5.62485 16.3587 5.02533 15.9167 4.5833C15.4746 4.14127 14.8751 3.89294 14.25 3.89294C13.6249 3.89294 13.0254 4.14127 12.5833 4.5833L3.83334 13.3333V16.6666Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                                <button-->
<!--                                    v-if="!editing[index]"-->
<!--                                    @click="removeEducation(index)"-->
<!--                                    class="px-2 py-1 bg-red-500 text-white rounded-xl text-sm hover:bg-red-600"-->
<!--                                >-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">-->
<!--                                        <path stroke-linecap="round" class="" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />-->
<!--                                    </svg>-->
<!--                                </button>-->
<!--                                <button-->
<!--                                    v-if="editing[index]"-->
<!--                                    @click="saveEdit(index)"-->
<!--                                    class="px-2 py-1 bg-green-500 text-white rounded-xl text-sm hover:bg-green-600"-->
<!--                                >-->
<!--                                    Save-->
<!--                                </button>-->
<!--                                <button-->
<!--                                    v-if="editing[index]"-->
<!--                                    @click="cancelEdit(index)"-->
<!--                                    class="px-2 py-1 bg-gray-500 text-white rounded-xl text-sm hover:bg-gray-600"-->
<!--                                >-->
<!--                                    Cancel-->
<!--                                </button>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        educations: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            showAddForm: false,
            newEducation: {
                institute: '',
                industry_sector: '',
                course_name: '',
                from: '',
                to: ''
            },
            editing: [],
            editForms: []
        };
    },

    created() {
        this.resetEditingStates();
    },

    watch: {
        educations() {
            this.resetEditingStates();
        }
    },

    methods: {
        resetEditingStates() {
            this.editing = this.educations.map(() => false);
            this.editForms = JSON.parse(JSON.stringify(this.educations));
        },
        formatDate(dateString) {
            if (!dateString) return '';

            const date = new Date(dateString);

            // Luôn sử dụng locale 'en-US' để hiển thị tiếng Anh
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },
        addEducation() {
            this.$emit('add', {...this.newEducation});
            this.showAddForm = false;
            this.newEducation = {
                institute: '',
                industry_sector: '',
                course_name: '',
                from: '',
                to: ''
            };
        },

        startEditing(index) {
            this.editing.splice(index, 1, true);
        },

        cancelEdit(index) {
            this.editing.splice(index, 1, false);
            this.editForms[index] = JSON.parse(JSON.stringify(this.educations[index]));
        },

        saveEdit(index) {
            this.$emit('update', {
                index,
                education: {...this.editForms[index]}
            });
            this.editing.splice(index, 1, false);
        },

        removeEducation(index) {
            if (confirm('Are you sure you want to remove this education?')) {
                this.$emit('remove', index);
            }
        }
    }
};
</script>
