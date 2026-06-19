<template>
    <div class="bg-white rounded-xl p-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">
            {{ $t('What kind of goal are you setting?') }}
        </h2>
        <p class="text-gray-500 text-sm mb-8 text-center">{{ $t('You can enter both short-term and long-term goals.') }}</p>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $t('Short-term Goals') }} <span class="text-gray-500 font-normal">(within 1 year)</span>
                </label>
                <textarea 
                    v-model="shortTerm"
                    rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#4984F6]"
                    :placeholder="$t('E.g., Complete my NVQ Level 4 certification...')"
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $t('Long-term Goals') }} <span class="text-gray-500 font-normal">(over 1 year)</span>
                </label>
                <textarea 
                    v-model="longTerm"
                    rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#4984F6]"
                    :placeholder="$t('E.g., Start my own business in 3 years...')"
                ></textarea>
            </div>
        </div>

        <hr class="border-gray-200 my-8" />
        <!-- Navigation -->
        <div class="flex gap-3 justify-end mt-8">
            <button @click="$emit('previous')" class="text-center bg-blue-50 text-[#4984F6] py-2 px-4 rounded-lg font-medium hover:bg-blue-100 transition-colors border border-transparent">
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
            shortTerm: this.portfolio.short_term_goals || '',
            longTerm: this.portfolio.long_term_goals || ''
        };
    },

    methods: {
        handleNext() {
            this.$emit('update', { 
                short_term_goals: this.shortTerm,
                long_term_goals: this.longTerm,
                goal_type: 'both' // Fallback for backwards compatibility if needed
            });
            this.$emit('next');
        }
    }
};
</script>
