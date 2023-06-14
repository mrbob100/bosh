<template>
    <div class="swirl">

        <div class="panel" v-for="(item, key, index) in goods"  :key="key">
            <router-link class="recipe__inner sigma" :to="`/product/${item.id}`"  >
                <img :src="`/images/${item.img.max}`" v-if="item.img.max"  alt="img"/>

                <p>{{item.name}}</p>
                <div class="out">{{item.price}}</div>
                <!--div class="dopContent" v-for="(item1, key1) in  item.exactlyType1 " :key="key1">
                    {{item1}}
                </div-->

                <div class="dopContent"  v-html="item.exactlyType1" >

                </div>


            </router-link>

        </div>


    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import { get } from '../../js/helpers/api';
    export default {
        name: "AppCategoryGoods",

        created(){

            this.id=this.$route.params.id;
            get(`/api/category/${this.$route.params.id}`).then((res=> {
                let mix=[], vibor=[];

                mix = res.data.products;
                vibor=res.data.data;

                this.$store.dispatch('category/loadItems',  // загрузка меню
                   res.data
                );

                //________________________________________________________________________________________
                // ввод breacrumb
                //_________________________________________________________________________________________
              let am=this.$store.getters['left/item'](this.id); // изменение категории в route index.js на текущую
                this.$store.commit('bread/minus', am.name)
           //    let ala= this.breadcrumbList.pop();
           //     ala.name=am.name;
           //     this.breadcrumbList.push(ala);


            }));

        },
        data () {
            return {
                id: 0,


            }
        },
        computed: {
            ...mapGetters('category', {
                goods:'goods',
                opts:'opts'
            }),
            ...mapGetters('bread',  {breadcrumbList: 'bread' })

        },
    }
</script>

<style scoped>

    .swirl {
        display: flex;
        flex: inherit;
        flex-wrap: wrap;
        flex-direction: row;

    }


    .sigma img {
        margin: 20px;
        height: 95px;
        width: auto;
    }


    .panel {
        overflow: hidden;
        min-height: 260px;
        padding: 10px 5px 10px 5px;
        align-items: center;
        width: 210px;
        text-align: center;
        -moz-border-radius: 10px; /* закругление для старых Mozilla Firefox */
        -webkit-border-radius: 10px; /* закругление для старых Chrome и Safari */
        -khtml-border-radius:10px; /* закругл. для браузера Konquerer системы Linux */
        border-radius: 10px;  /* закругление углов для всех, кто понимает */
        border: 3px solid #EAEAEA;
        position: relative;
        transform: scale(1);

    }

   .panel .sigma p {
        font-size: 0.8em;
        color: darkred;

    }

    .panel:hover {

        border: 3px solid red;
        overflow: hidden;
background-color: rgba(0,0,0,.5);

    }



    .panel:hover  img {
        transform: scale(1.4);



    }
    .panel:hover p {
        color: white;

    }

    .panel:hover .sigma p{
        color: yellow;
    }

    .panel .dopContent {
        -webkit-transform: translateX(-100vw);
        -moz-transform: translateX(-100vw);
        -ms-transform: translateX(-100vw);
        -o-transform: translateX(-100vw);
        transform: translateX(-100vw);
        position: absolute;
        color: #816263;
    }

    .panel:hover  .dopContent {

        position: absolute;
        -webkit-transform: translateX(0);
        -moz-transform: translateX(0);
        -ms-transform: translateX(0);
        -o-transform: translateX(0);
        transform: translateX(0);
        -webkit-transition: 0.5s;
        -moz-transition: 0.5s;
        -ms-transition: 0.5s;
        -o-transition: 0.5s;
        transition: 0.5s;
        font-size: 0.7em;
        color: white;
        width: 100%; max-width: 194px!important;
        top: 67%;
    }
   .panel .out {
       -webkit-transform: translateX(-100vw);
       -moz-transform: translateX(-100vw);
       -ms-transform: translateX(-100vw);
       -o-transform: translateX(-100vw);
       transform: translateX(-100vw);
       position: absolute;
       color: #816263;
   }

    .panel:hover .out {
        position: absolute;
        -webkit-transform: translateX(0);
        -moz-transform: translateX(0);
        -ms-transform: translateX(0);
        -o-transform: translateX(0);
        transform: translateX(0);
        -webkit-transition: 0.5s;
        -moz-transition: 0.5s;
        -ms-transition: 0.5s;
        -o-transition: 0.5s;
        transition: 0.5s;
        font-size: 1.1em;
        color: white;
        mix-blend-mode: difference;

        width: 100%; max-width: 194px!important;
        top:47%;

    }

    @media  (max-width: 979px) {

        .panel {
            min-height: 220px;
            width: 180px;

        }
        .sigma img {
height: 65px; width: auto;

        }
        .panel .sigma p {
            font-size: 0.7em;
        }
    }
</style>
