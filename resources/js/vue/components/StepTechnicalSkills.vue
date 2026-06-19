<template>
    <div class="bg-white rounded-xl p-8 max-w-2xl mx-auto shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 mb-1 text-center">{{ $t('Skills & Competencies') }}</h2>
        <p class="text-gray-500 text-sm mb-8 text-center">{{ $t('Rate your skills and select languages') }}</p>

        <!-- Technical Skills -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $t('Technical Skills') }}</label>
            
            <div v-for="(skill, index) in skills" :key="'skill-'+index" class="flex flex-col sm:flex-row items-center gap-3 mb-3">
                <div class="flex-1 w-full relative">
                    <input 
                        v-model="skill.name" 
                        type="text" 
                        @focus="activeInputIndex = index"
                        @blur="hideSuggestions"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4984F6]"
                        placeholder="E.g. JavaScript"
                        autocomplete="off"
                    />
                    
                    <div v-if="activeInputIndex === index && getSuggestions(skill.name).length > 0" 
                         class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="py-1 max-h-48 overflow-y-auto">
                            <li v-for="suggestion in getSuggestions(skill.name)" 
                                :key="suggestion"
                                @mousedown.prevent="selectSuggestion(index, suggestion)"
                                class="px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#4984F6] cursor-pointer">
                                {{ suggestion }}
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <div class="flex gap-1">
                        <button 
                            v-for="star in 5" 
                            :key="star"
                            @click="skill.proficiency = star"
                            class="focus:outline-none"
                        >
                            <svg 
                                :class="star <= skill.proficiency ? 'text-[#4984F6]' : 'text-gray-300'"
                                class="w-6 h-6 hover:scale-110 transition-transform cursor-pointer" 
                                fill="currentColor" viewBox="0 0 20 20"
                            >
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    </div>
                    <button @click="removeSkill(index)" class="text-gray-400 hover:text-red-500 p-2 ml-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button @click="addSkill" class="w-full border-2 border-dashed border-[#4984F6] text-[#4984F6] rounded-lg py-2.5 flex items-center justify-center gap-2 hover:bg-blue-50 transition-colors mt-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ $t('Add Skill') }}
            </button>
        </div>

        <!-- Languages -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $t('Language') }}</label>
            
            <div class="flex flex-wrap gap-2 mb-3">
                <div v-for="(lang, index) in languages" :key="'lang-'+index" class="bg-blue-50 border border-[#4984F6] text-[#4984F6] px-3 py-1.5 rounded-full flex items-center gap-2 text-sm">
                    {{ lang }}
                    <button @click="removeLanguage(index)" class="hover:text-red-500 focus:outline-none">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <input 
                        v-model="newLanguage" 
                        type="text" 
                        @focus="languageInputActive = true"
                        @blur="hideLanguageSuggestions"
                        @keydown.enter.prevent="addLanguage"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#4984F6] bg-white"
                        :placeholder="$t('Type or select a language')"
                        autocomplete="off"
                    />
                    <div v-if="languageInputActive && getLanguageSuggestions(newLanguage).length > 0" 
                         class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="py-1 max-h-48 overflow-y-auto">
                            <li v-for="suggestion in getLanguageSuggestions(newLanguage)" 
                                :key="suggestion"
                                @mousedown.prevent="selectLanguageSuggestion(suggestion)"
                                class="px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#4984F6] cursor-pointer">
                                {{ suggestion }}
                            </li>
                        </ul>
                    </div>
                </div>
                <button @click="addLanguage" class="px-6 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    {{ $t('Add') }}
                </button>
            </div>
        </div>

        <hr class="border-gray-200 my-8" />
        <div class="flex gap-3 justify-end">
            <button @click="$emit('previous')" class="text-center bg-blue-50 text-[#4984F6] py-2 px-4 rounded-lg font-medium hover:bg-blue-100 transition-colors">
                {{ $t('Previous') }}
            </button>
            <button @click="handleNext" class="text-center bg-[#4984F6] text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                {{ $t('Next') }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        portfolio: { type: Object, required: true }
    },

    data() {
        return {
            skills: JSON.parse(JSON.stringify(this.portfolio.technical_skills || [{ name: '', proficiency: 0 }])),
            languages: JSON.parse(JSON.stringify(this.portfolio.languages || [])),
            newLanguage: '',
            activeInputIndex: null,
            languageInputActive: false,
            availableLanguages: [
                "English", "Sinhala", "Tamil", "Arabic", "Bengali", "Chinese (Mandarin)", 
                "French", "German", "Hindi", "Italian", "Japanese", "Korean", "Malay", 
                "Portuguese", "Russian", "Spanish", "Urdu", "Vietnamese"
            ],
            availableSkills: [
                // Information & Communication Technology (ICT)
                "Android Development", "Computer Hardware Servicing", "Cybersecurity", "Data Entry",
                "Database Administration", "Graphic Design", "IT Support", "Java", "JavaScript",
                "Network Administration", "PHP", "Python", "Software Engineering", "UI/UX Design", "Web Development",
                
                // Agriculture & Plantation
                "Agribusiness", "Cinnamon Peeling", "Coconut Cultivation", "Crop Production", "Dairy Farming",
                "Greenhouse Management", "Horticulture", "Poultry Farming", "Rubber Tapping", "Tea Plucking",
                "Tea Processing",
                
                // Textile & Garments (Apparel)
                "Apparel Merchandising", "Fabric Cutting", "Garment Quality Control", "Industrial Sewing",
                "Machine Embroidery", "Pattern Making", "Tailoring", "Textile Technology",
                
                // Hotel & Tourism
                "Baking and Pastry", "Bartending", "Cookery (Culinary Arts)", "Food and Beverage Service",
                "Front Office Operations", "Housekeeping (Room Attendant)", "Restaurant Management", "Tour Guiding",
                
                // Building & Construction
                "Bar Bending", "Bricklaying", "Building Painting", "Carpentry", "Construction Site Supervision",
                "Masonry", "Plumbing", "Scaffolding", "Tile Laying", "Welding",
                
                // Electrical, Electronics & Telecommunication
                "Air Conditioning & Refrigeration", "CCTV Installation", "Domestic Electrical Installation",
                "Electrical Engineering", "Electronics Repair", "Industrial Wiring", "Mobile Phone Repair",
                "Solar Panel Installation",
                
                // Automobile Repair & Maintenance
                "Auto Electrical Servicing", "Automobile Air Conditioning", "Automobile Mechanics",
                "Motorcycle Repair", "Panel Beating", "Vehicle Painting", "Wheel Alignment",
                
                // Gem & Jewellery
                "Gem Cutting", "Gem Polishing", "Gemology", "Jewellery Designing", "Jewellery Manufacturing",
                
                // Hair Care & Beauty Therapy
                "Beauty Therapy", "Bridal Dressing", "Cosmetology", "Hairdressing", "Makeup Artistry", "Nail Technology",
                
                // Light Engineering & Manufacturing
                "CNC Machining", "Fitter Mechanics", "Lathe Machine Operation", "Sheet Metal Work",
                
                // Woodworking & Furniture
                "Cabinet Making", "Furniture Polishing", "Wood Carving",
                
                // Healthcare & Social Services
                "Ayurvedic Therapy", "Caregiving", "Dispensing (Pharmacy Assistant)", "First Aid",
                "Nursing Assisting", "Phlebotomy",
                
                // Business, Finance & BPO
                "Accounting", "BPO Customer Service", "Bookkeeping", "Digital Marketing", "Human Resources",
                "Office Management", "Secretarial Practice"
            ]
        };
    },

    methods: {
        getLanguageSuggestions(query) {
            if (!query) return this.availableLanguages.filter(l => !this.languages.includes(l)).slice(0, 5);
            return this.availableLanguages.filter(l => 
                l.toLowerCase().includes(query.toLowerCase()) && 
                l.toLowerCase() !== query.toLowerCase() &&
                !this.languages.includes(l)
            ).slice(0, 5);
        },
        selectLanguageSuggestion(suggestion) {
            this.newLanguage = suggestion;
            this.languageInputActive = false;
        },
        hideLanguageSuggestions() {
            this.languageInputActive = false;
        },
        getSuggestions(query) {
            if (!query) return [];
            return this.availableSkills.filter(s => s.toLowerCase().includes(query.toLowerCase()) && s.toLowerCase() !== query.toLowerCase()).slice(0, 5);
        },
        selectSuggestion(index, suggestion) {
            this.skills[index].name = suggestion;
            this.activeInputIndex = null;
        },
        hideSuggestions() {
            this.activeInputIndex = null;
        },
        addSkill() {
            this.skills.push({ name: '', proficiency: 0 });
        },
        removeSkill(index) {
            this.skills.splice(index, 1);
        },
        addLanguage() {
            if (this.newLanguage && !this.languages.includes(this.newLanguage)) {
                this.languages.push(this.newLanguage);
                this.newLanguage = '';
            }
        },
        removeLanguage(index) {
            this.languages.splice(index, 1);
        },
        handleNext() {
            const validSkills = this.skills.filter(s => s.name.trim() !== '');
            this.$emit('update', { 
                technical_skills: validSkills,
                languages: this.languages
            });
            this.$emit('next');
        }
    }
};
</script>
