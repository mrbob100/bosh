<template>
    <div>
        <div class="slider-top">

                <!--div class="product__item" v-for="product in menuList">
                    <router-link class="product__inner" :to="`/products/${product.id}`">
                        <img :src="`/images/${product.img.max}`" v-if="product.img.max">
                    </router-link>

                </div-->


            <!-- слайдер Vuetify -->
            <v-app id="inspire">
                <v-content>
                    <v-container>Карусель с vuetify</v-container>

                    <v-carousel
                                delimiter-icon="stop"
                                prev-icon="mdi-arrow-left"
                                next-icon="mdi-arrow-right"
                    >
                        <v-carousel-item

                                v-for="(item,i) in products"
                                :key="i"
                                :src="`/images/${item.img.max}`"
                                transition="fade-transition"

                        >

                        </v-carousel-item>
                    </v-carousel>

                </v-content>
            </v-app>


        </div>
    </div>
</template>

<script>



    import {mapGetters} from 'vuex';
    import { get } from '../../js/helpers/api'
    export default {


        data() {
            return {
                loading: true,
                slickOptions: {
                    slidesToShow: 3,
                    // Any other options that can be got from plugin documentation
                },
                products: []
            }
        },
       /* mounted() {
            setTimeout(() => {this.loading= false}, 1000)
        }, */

        created(){
            get(`/api/`).then((res=>{
                this.products=res.data.products;
                this.$store.dispatch('slider/loadItems',  // загрузка слайдера
                     this.products
                );
            }))
        }
    }
</script>


<style >
#inspire {
    height:300px;width: auto;

}

</style>