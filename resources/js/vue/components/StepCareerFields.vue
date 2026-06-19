<template>
    <div class="bg-white rounded-xl p-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-1 text-center">{{ $t('Career Fields of Interest') }}</h2>
        <p class="text-gray-500 text-sm mb-6 text-center">{{ $t('You can select multiple options.') }}</p>

        <!-- Career Field Cards Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-8">
            <div
                v-for="field in careerFields"
                :key="field.code"
                @click="toggleField(field.code)"
                :class="[
                    'relative flex flex-col items-center justify-center p-4 rounded-xl border-2 cursor-pointer transition-all text-center h-32',
                    selectedFields.includes(field.code)
                        ? 'border-[#4984F6] bg-blue-50'
                        : 'border-gray-200 bg-white hover:border-gray-300'
                ]"
            >
                <!-- Checkmark -->
                <div v-if="selectedFields.includes(field.code)" class="absolute top-2 right-2 w-5 h-5 bg-[#4984F6] rounded-full flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <!-- Icon -->
                <span class="text-3xl mb-2">{{ field.icon }}</span>

                <!-- Name -->
                <span :class="['text-xs font-medium leading-tight', selectedFields.includes(field.code) ? 'text-[#4984F6]' : 'text-gray-700']">
                    {{ field.name }}
                </span>
            </div>
        </div>

        <hr class="border-gray-200 my-8" />
        <!-- Navigation -->
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
        const ci = this.portfolio.career_interests || {};
        return {
            selectedFields: ci.career_fields || [],
            careerFields: [
                { code: 'A', name: '(A) Agriculture, Hunting & Forestry', icon: '🌾' },
                { code: 'B', name: '(B) Fishing', icon: '🎣' },
                { code: 'C', name: '(C) Mining & Quarrying', icon: '⛏️' },
                { code: 'D', name: '(D) Manufacturing', icon: '🏭' },
                { code: 'E', name: '(E) Electricity, Gas & Water', icon: '⚡' },
                { code: 'F', name: '(F) Construction', icon: '🏗️' },
                { code: 'G', name: '(G) Wholesale & Retail Trade', icon: '🛒' },
                { code: 'H', name: '(H) Hotels & Restaurants', icon: '🏨' },
                { code: 'I', name: '(I) Transport, Storage & Communication', icon: '🚚' },
                { code: 'J', name: '(J) Financial Intermediation', icon: '💰' },
                { code: 'K', name: '(K) Real Estate & Business Activities', icon: '🏢' },
                { code: 'L', name: '(L) Public Administration', icon: '🏛️' },
                { code: 'M', name: '(M) Education', icon: '📚' },
                { code: 'N', name: '(N) Health & Social Work', icon: '🏥' },
                { code: 'O', name: '(O) Other Community Services', icon: '🤝' },
                { code: 'P', name: '(P) Private Households', icon: '🏠' },
                { code: 'Q', name: '(Q) Extra-territorial Organizations', icon: '🌐' },
                { code: 'ICT', name: 'Information & Communication Technology', icon: '💻' },
            ]
        };
    },

    methods: {
        toggleField(code) {
            const idx = this.selectedFields.indexOf(code);
            if (idx === -1) {
                this.selectedFields.push(code);
            } else {
                this.selectedFields.splice(idx, 1);
            }
        },
        handleNext() {
            const ci = {
                ...(this.portfolio.career_interests || {}),
                career_fields: this.selectedFields
            };
            this.$emit('update', { career_interests: ci });
            this.$emit('next');
        }
    }
};
</script>
