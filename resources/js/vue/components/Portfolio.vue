<template>
    <div class="bg-white min-h-screen rounded-xl">
        <portfolio-wizard
            v-if="initialPortfolio"
            :initial-portfolio="initialPortfolio"
            :districts="initialDistricts"
            :genders="initialGenders"
            :save-url="saveUrl"
            :redirect-url="redirectUrl"
        />
    </div>
</template>

<script>
import PortfolioWizard from './PortfolioWizard.vue';

export default {
    props: {
        initialPortfolio: {
            type: Object,
            default: () => ({})
        },
        initialDistricts: {
            type: Array,
            default: () => []
        },
        initialGenders: {
            type: Array,
            default: () => []
        }
    },
    components: {
        PortfolioWizard
    },
    data() {
        return {
            saveUrl: '/trainee/career-guidance/portfolio/save-portfolio',
            redirectUrl: '/trainee/career-guidance/portfolio/my-portfolio'
        };
    }
};
</script>
