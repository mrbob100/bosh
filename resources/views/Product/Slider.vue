<template>
    <div class="product__list">
        <div class="product__item" v-for="product in products">
            <router-link class="product__inner" :to="`/products/${product.id}`">
                <img :src="`/images/${product.img.max}`" v-if="product.img.max">
                <p class="product__name">{{product.name}}</p>
            </router-link>

        </div>

    </div>
</template>

<script type="text/javascript">

import { get } from '../../js/helpers/api'

    export default {
      data(){
          return {
              products:[]
          }
      },
        created(){
          get(`/api/`).then((res=>{
              this.products=res.data.products;
              this.$store.slider.dispatch('loadItems', {
                 products: this.products
              });
          }))
        }
    }

</script>