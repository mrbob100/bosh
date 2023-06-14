<template>
<h3>Очистка !</h3>
</template>

<script>
    export default {
        name: "AppClear",
        mounted() {
            this.$store.commit('auth/remove');
            this.$store.commit('cabinet/clearIntervals');
            this.$store.commit('cabinet/clearOrders');
            this.$store.commit('cart/clearer');
            this.$store.commit('category/clearItems');
            this.$store.commit('category/clearOpts');
            this.$store.commit('left/clearItems');
            this.$store.commit('left/clearCategories');
            this.$store.commit('products/clearItems');
            this.$store.commit('slider/clearItems');
           this.$store.commit('bread/clear');
            this.$router.push('login');
        }
    }
</script>

<style scoped>

</style>
