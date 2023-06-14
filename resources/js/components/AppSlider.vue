<template>



            <carousel-3d :height="Hg" :width="Wd" :border="1" class="first s" @after-slide-change="onAfterSlideChange" @before-slide-change="onBeforeSlideChange"
                           @last-slide="onLastSlide">
                <slide  class="slide"  v-for="(slide,i) in sliders" :index="i" :key="i">

                       <div class="bruce">

                           <router-link class="recipe__inner sigma" :to="`/slide/${slide.id}`"  >
                              <p> {{slide.name}} </p>

                           </router-link>
                           <div v-if="widthSign==0">
                               <img :src="`images/${slide.img.max}`" v-if="slide.img.max" style="width: 360px;height: 270px;"  alt="img"/>
                           </div>
                           <div v-else-if="widthSign==1">
                               <img :src="`images/${slide.img.max}`" v-if="slide.img.max" style="width: 150px;height: 100px;"  alt="img"/>
                           </div>
                           <div v-else-if="widthSign==2">
                               <img :src="`images/${slide.img.max}`" v-if="slide.img.max" style="width: 110px;height: 60px;"  alt="img"/>
                           </div>

                       </div>





                </slide>


             </carousel-3d>



</template>

<script>



    import {mapGetters} from 'vuex';

    import { get } from '../../js/helpers/api';
    import { Carousel3d, Slide } from 'vue-carousel-3d';


    export default {

data () {
    return {
        Hg: 270,
        Wd: 360,
        widthSign: 0

    }
},

        computed: {
            ...mapGetters('slider', {
                sliders: 'items'
            }),

        },

        created(){
            get(`/api/`).then((res=>{
                  //  this.mix=res.data.categories;
                this.$store.dispatch('slider/loadItems',  // загрузка слайдера
                    res.data.products
                );

            }));



        },


        components: {
            Carousel3d,
            Slide
        },
        methods: {
            onAfterSlideChange(index) {

            },
            onBeforeSlideChange(index) {

            },
            onLastSlide(index) {

            },
           /* winWidth() {
                setInterval(() => {
                    let w = window.innerWidth;
                    if (w < 768) {
                     //   this.Hg=100; this.Wd=200;
                    } else if (w < 980) {
                        this.Hg=120; this.Wd=160;
                        this.widthSign=2;
                    } else if (w < 1420) {
                        this.Hg=150; this.Wd=200;
                       this.widthSign=1;
                    } else {
                        this.Hg=270; this.Wd=360;
                       // this.Hgm=250;this.Wdm=340;
                        this.widthSign=0;
                    }
                }, 100);
            } */

        },

        mounted() {
            //callback once mounted

            let w = document.documentElement.clientWidth;

               //   this.Hg=100; this.Wd=130;
            if (w < 980) {
                this.Hg=120; this.Wd=160;
                this.widthSign=2;
            } else if (w < 1420 && w>=980) {
                this.Hg=150; this.Wd=200;
                this.widthSign=1;
            } else if(w>=1420) {
                this.Hg=270; this.Wd=360;
                // this.Hgm=250;this.Wdm=340;
                this.widthSign=0;
            }
        }

    }
</script>


<style scoped >

.s{
    height:inherit; width: auto;
}

/*.bruce {
    margin-left: 1.5em;

    width:auto;
    height: 332px;
}

.s {
    width: 360px;
    height: 270px;
} */

.sigma p{
    margin-left: 1.5em;
    color:#D42027 !important;
    font-size: 1.1em;
}

.bruce img{
    width: 340px;
    height: 250px;
}
/*
@media  (min-width: 980px) and (max-width: 1300px) {
    div.carousel-3d-slider .first .s {
        width: 300px;
        height: auto;
    }
    .s .bruce img{
        width: 260px;
        height: 200px;
    }
}*/
@media  (max-width: 767px) {
    .wrap02 .carousel-3d-container {
        display: block;
        min-width: 250px!important;
        width: 100%;

    }
}

</style>
