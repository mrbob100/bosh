<template>
<div>


    <!--div class="modal" v-if="out">
        <div class="modal-background" ></div>
           <div class="modal-content">
                    <button class="bfr" @click="modalClose">x</button>
                        <div class="swirl">

                            <div class="panel" v-for="(item, key, index) in goods"  :key="key">
                                <router-link class="recipe__inner sigma" :to="`/product/${item.id}`"  >
                                    <img :src="`/images/${item.img.max}`" v-if="item.img.max"  alt="img"/>

                                    <p>{{item.name}}</p>
                                    <div class="out">{{item.price}}</div>
                                    <div class="dopContent" v-for="(item1, key1) in  item.exactlyType1 " :key="key1">
                                        {{item1}}
                                    </div>

                                    <div class="dopContent"  v-html="item.exactlyType1" >

                                    </div>


                                </router-link>

                            </div>


                        </div>
           </div>
    </div-->

    <div class="home" v-if="out">


                <button class="bfr" @click="toggleModal">x</button>
                <div class="swirl">

                    <div class="panel" v-for="(item, key, index) in goods"  :key="key">
                        <router-link class="recipe__inner sigma"  :to="`/search/${item.id}`"  >
                            <img :src="`/images/${item.img.max}`" v-if="item.img.max" @click="toggleModal" alt="img"/>

                            <p>{{item.name}}</p>
                            <div class="out">{{item.price}}</div>
                            <div class="dopContent"  v-html="item.exactlyType1" >

                            </div>


                        </router-link>

                    </div>


                </div>


        <!--button @click="toggleModal">
            Open Modal
        </button-->
    </div>

    <!--div class="out-search" v-if="out"
    v-for="(item, index) in  optProducts"
    :key="index"
    >
       {{item.img}} {{item.code}} {{item.name}}
    </div-->

</div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import { post } from  '../../js/helpers/api';
    import SimpleModel from './simple-modal';
    import { bus } from '../helpers/bus.js'


    export default {
name: "Search",

    props: {
    bName:  {
        type: String,
        required: true,
        default: null,
           }
    },

        data() {
    return{
       products: [],
        out: false,
        modelOpened: true,
        sign: 0,
        bName: '',
        isShowModal: false,
        optProducts: []
    }
        },

        components: {
    SimpleModel
        },

        computed: {
            ...mapGetters('search', {
                textSearch: 'textSearch',
                goods: 'goods',
            }),
            ...mapGetters('bread',  {breadcrumbList: 'bread' }),

        },

        methods: {

    addToText() {
       if(this.bName.length<3) this.sign=false;
      if(this.bName.length>2) {
          this.$store.commit('search/ clearer');
          this.$store.commit('search/textSearch',this.bName);

      }
        if(this.bName.length>=3 && this.bName.length<6) {

          let data={'nominate':this.bName};
            post(`/api/productSearch`, data).then((res => {
                if (res.data.status) {
                    let rezult=[];
                        rezult= res.data.products;
                 //    this.products= res.data.products;
                 //    this.optProducts=res.data.products;
                     this.out=true;
                    this.isShowModal=true;
                    this.$store.commit('search/ clearItems');
                    this.$store.commit('search/loadItems',rezult);
                }


            })).catch((err) => {
                if (err.response.status >400) {
                    this.error = err.response.data
                }

            });
            }
        if(this.bName.length>3) {
            this.out=true;
            let code='', bCode="";
            this.isShowModal=true;
            this.optProducts=this.goods.filter(function(items){
                return items.name.toLowerCase().includes(this.bName.toLowerCase());

            });
            code=this.goods.filter(function(items){
                return items.code.toLowerCase().includes(this.bName.toLowerCase());

            });
            bCode=this.optProducts.concat(code.filter(function(item){
                return this.optProducts.indexOf(item) < 0;
            }));
            this.optProducts=bCode;
        }

        },

            toggleModal() {
                this.isShowModal = !this.isShowModal;
                if(!this.isShowModal) {

                    this.bName='';
                    bus.$emit('finishSearch');
                }
            },

    },
        watch: {
            bName() {  return this. addToText();  }
        },





    }
</script>
<style scoped>


    .modal, .modal-background {
        position: fixed; left: 0;  top: 0;
        width: 100%; height: 100vh;
        z-index: 50;

    }


    .modal{
        display: flex; align-items: center;
        justify-content: center;
    }
    .modal-content{
        background-color: white; padding: 2em;
        /*width: 50vw; */  max-width: 70em;
        position: absolute;
        z-index: 50;

    }

    .modal-background {
        background-color: rgba(10,10,10,0.8);
        z-index: 40;
    }
    .bfr {
        color: red; position: absolute;
        right: 2.1em; top: 2.1em;
    }


    .swirl {
        display: flex;
        flex: inherit;
        flex-wrap: wrap;
        flex-direction: row;

    }


    .swirl .sigma img {
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

    .panel p {
        font-size: 0.8em;
        color:#816263;
    }

    .panel:hover {

        border: 3px solid red;
        overflow: hidden;
        background-color: rgba(0,0,0,.5);


    }



    .panel:hover  img {
        transform: scale(1.4);



    }
    .panel:hover p{
        color: white;
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
        font-size: 0.99em;
        color: white;
        width: 100%; max-width: 194px!important;
        top:47%;
    }
</style>
