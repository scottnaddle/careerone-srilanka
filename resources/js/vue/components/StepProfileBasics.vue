<template>
    <div class="bg-white rounded-xl p-8 max-w-4xl mx-auto flex flex-col md:flex-row gap-8 items-center md:items-start">
        <!-- Illustration Left -->
        <div class="w-full md:w-1/3 flex flex-col items-center justify-center pt-4">
            <div class="w-48 h-48 bg-blue-50 rounded-full flex items-center justify-center relative mb-4 group cursor-pointer overflow-hidden" @click="triggerFileInput">
                <img v-if="localData.avatar" :src="localData.avatar" class="w-full h-full object-cover rounded-full" />
                <span v-else class="text-6xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">👋</span>
                
                <!-- Edit overlay on hover -->
                <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                    <svg class="w-8 h-8 text-white mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-white text-xs font-medium">{{ $t('Change Photo') }}</span>
                </div>
                
                <!-- If uploading -->
                <div v-if="isUploading" class="absolute inset-0 bg-white bg-opacity-75 rounded-full flex items-center justify-center z-20">
                    <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="handleFileUpload">
            </div>
            <h3 class="text-xl font-bold text-gray-900 text-center">{{ $t('Let\'s get started!') }}</h3>
            <p class="text-gray-500 text-sm text-center mt-2">{{ $t('Build your portfolio in a few simple steps.') }}</p>
        </div>

        <!-- Form Right -->
        <div class="w-full md:w-2/3">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $t('Profile Basics') }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Fullname -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Fullname') }}</label>
                    <input v-model="localData.fullname" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. John Doe">
                </div>

                <!-- D.O.B -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('D.O.B') }}</label>
                    <flowbite-datepicker v-model="localData.dob" type="date" placeholder="Select Date of Birth"></flowbite-datepicker>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Gender') }}</label>
                    <select v-model="localData.gender" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ $t('Select Gender') }}</option>
                        <option v-for="gender in genders" :key="gender.code_id" :value="gender.code_id">
                            {{ gender.code_name }}
                        </option>
                    </select>
                </div>

                <!-- District -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('District') }}</label>
                    <select v-model="localData.district" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">{{ $t('Select District') }}</option>
                        <option v-for="district in districts" :key="district.id" :value="district.name">
                            {{ district.name }}
                        </option>
                    </select>
                </div>

                <!-- Contact -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Contact Number') }}</label>
                    <input v-model="localData.phone" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. 0712345678">
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('Email Address') }}</label>
                    <input v-model="localData.email" type="email" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="E.g. john@example.com">
                </div>

                <!-- About You -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $t('About you') }}</label>
                    <textarea v-model="localData.about" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="A short bio about yourself..."></textarea>
                </div>
            </div>


            <hr class="border-gray-200 my-8" />
        <!-- Navigation -->
            <div class="flex gap-3 mt-8 justify-end">
                <button @click="handleNext" class="text-center bg-[#4984F6] text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                    {{ $t('Next') }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
    props: {
        portfolio: { type: Object, required: true },
        districts: { type: Array, default: () => [] },
        genders: { type: Array, default: () => [] }
    },
    data() {
        const basic = this.portfolio.basic_information || {};
        return {
            isUploading: false,
            localData: {
                avatar: this.portfolio.avatar || '',
                fullname: basic.fullname || this.portfolio.fullname || '',
                dob: basic.dob || '',
                gender: basic.gender ? String(basic.gender) : '',
                district: basic.district || '',
                phone: basic.phone || '',
                email: basic.email || '',
                about: this.portfolio.about_me || ''
            }
        };
    },
    computed: {},
    methods: {
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        async handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                useToast().error(this.$t('Please upload a valid image file'));
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) {
                useToast().error(this.$t('Image size must be less than 2MB'));
                return;
            }

            this.isUploading = true;
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', 'avatar');

            try {
                const response = await axios.post('/trainee/career-guidance/portfolios/upload-image', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                
                if (response.data && response.data.success) {
                    this.localData.avatar = response.data.url;
                    useToast().success(this.$t('Avatar updated successfully!'));
                } else {
                    useToast().error(response.data.message || this.$t('Failed to upload image.'));
                }
            } catch (error) {
                console.error(error);
                useToast().error(this.$t('An error occurred during upload.'));
            } finally {
                this.isUploading = false;
                event.target.value = ''; // Reset input
            }
        },
        handleNext() {
            this.$emit('update', { 
                avatar: this.localData.avatar,
                basic_information: {
                    fullname: this.localData.fullname,
                    dob: this.localData.dob,
                    gender: this.localData.gender,
                    district: this.localData.district,
                    phone: this.localData.phone,
                    email: this.localData.email
                },
                fullname: this.localData.fullname,
                about_me: this.localData.about
            });
            this.$emit('next');
        }
    }
};
</script>
