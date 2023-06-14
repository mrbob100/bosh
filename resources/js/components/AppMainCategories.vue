<template>


    <div class="swirl">

            <div class="panel" v-for="(category,  dig) in categories" :key="dig">
                <div v-if="id==category.parent_id" >
                    <router-link class="recipe__inner sigma" :to="`/category/${category.id}`"  >
                        <img :src="`/images/${category.img}`" v-if="category.img"  alt="img"/>

                    </router-link>
                    <p>   {{category.name }}  </p>  <!-- вывод правой части наеменований  категорий продуктов -->
                </div>
            </div>

    </div>


</template>
<script>

    import { mapGetters } from 'vuex'

    export default {

        computed: {
            ...mapGetters('left', {
                categories: 'categories'
            }),
            id(){
                return this.$route.params.id;
            }
        },
    }
</script>
<style scoped>
.swirl {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
    text-align: center;
}

/*.panel {
    display: flex;
    flex-wrap: wrap;


} */
.panel   .sigma img {
        margin: 2em;
        height: 8em;
        width: auto;

    }
.panel p {
    margin: 20px;

}
@media  (max-width: 979px) {
    .panel .sigma img {
        margin: 2em;
        height: 6em;
        width: auto;

    }
    .panel p{
        font-size: 0.7em;
    }
}

</style>
