<template>
    <div>

        <div class="home" v-if="modelOpened">
            <SimpleModel
                v-show="isShowModal"
                :show="isShowModal"
                :scrollable="true"
                header-id="modalHeader"
                body-id="modalBody"
                @close="toggleModal"
            >
                <template #header>
                   Содержимое корзины
                </template>

                <template #body>

                    <button class="bfr" @click="toggleModal">x</button>
                    <hr/>

                    <ul class="cart" >

                        <li v-for="(lit,  key, index) in products" :key="key">
                            <div class="wrapper">
                                <div class="left">
                                    <img :src="`/images/${lit.product.img.max}`" v-if="lit.product.img.max"  alt="img"/>
                                </div>
                                <div class="right" >
                                    <h6>{{ lit.product.name}} </h6>
                                </div>
                                <div class="right01">
                                    <button class="btn btn-warning"  @click="minus(key)"  style="width: 4em;" >-1</button>
                                </div>

                                <div class="right05" >
                                    <input type="text" v-model="name=lit.cnt" >

                                </div>
                                <div class="right02" >
                                    <button class="btn btn-success" @click="plus(key)" style="width: 4em;" >+1</button>
                                </div>
                                <div class="right03" v-if="lit.cnt>1"  >
                                    {{lit.cnt}} * {{lit.product.price}} гр.
                                </div>
                                <div class="right06" v-else >
                                    {{lit.product.price}} гр.
                                </div>
                                <div class="right04">
                                    <button class="bfr02" @click="onDelete">x</button>
                                </div>

                            </div>
                            <hr/>
                        </li>
                        <div class="total"><h5> Итого: {{sum}} гр.</h5>
                        </div>
                    </ul>


                </template>

                <template #footer>
                    <div class="threebuttons">
                        <div class="button1">

                            <button class="btn " @click="contin()" >Продолжить покупки</button>
                        </div>
                        <div class="button2">
                            <button class="btn btn-success" @click="ordered()"  >Оформить заказ</button>
                        </div>
                        <div class="button3">
                            <button class="btn btn-danger" @click="clearer()"  >Очистить корзину</button>
                        </div>

                    </div>

                </template>

            </SimpleModel>
        </div>

    </div>
</template>

<script>

import {mapGetters} from 'vuex';
import {mapMutations} from 'vuex';
import SimpleModel from './simple-modal';

    export default {
        name: "AppProduct",

props: {
      data: ''
},


        data(){
            return {
                modelOpened: true,
                isShowModal: true,
                name: ''


            }
        },

        components: {
            SimpleModel
        },

        methods: {

           minus(ind){

               this.$store.commit('cart/minus', ind);
           },
            plus(ind){

                this.$store.commit('cart/plus', ind);
            },

            modalClose(){
                this.modelOpened=false;
               this.$router.push('/main/1');


            },
            onDelete(){
                this.$store.commit('cart/remove', this.id);
            },
            sum(){
                this.$store.commit('cart/sum', this.id);
            },
            contin(){
                this.$router.push('/main/1');
            },
           ordered() {
               this.$router.push('/order');
           },
            clearer() {

            },

            toggleModal() {
                this.isShowModal = !this.isShowModal;

            },


        },
        computed: {

            ...mapGetters('cart',['products']

            ),

          ...mapMutations('cart',['clearer']
          ),

            id(){

                return this.$route.params.id;
            },
            prod(){
                let b=this.data;
              if(b==="Выбор") {
                  return  this.$store.getters['search/item'](this.id);
              }
              else
              {     return this.$store.getters['category/item'](this.id); }

            },
            sum(){
                let as=0;
                this.products.forEach( function(el){
                  as += el.product.price * el.cnt ;
                });
                return as;
            }

        },

        mounted() {
        this.cnt=1;
        let y=this.prod;
            this.$store.commit('cart/add', this.prod);
        }


    }



</script>

<style scoped>



    .modal, .modal-background {
        position: fixed; left: 0;  top: 0;
        width: 100%; height: 100vh;
        z-index: 1000;

    }


    .modal{
        display: flex; align-items: center;
        justify-content: center;
    }
    .modal-content{
        background-color: white; padding: 2em;
        /*width: 50vw; */  max-width: 90em;
        position: absolute;
        z-index: 50;
       min-width: 700px;
    }

    .modal-background {
        background-color: rgba(10,10,10,0.8);
        z-index: 40;
    }
    .bfr {
        color: red; position: absolute;
        right: 2.1em; top: 2.1em;
    }

    .wrapper{
        display: flex; align-items: center; /*  контроль высоты*/
        justify-content: space-between;            /*  контроль ширины*/

    }
    .right, .right01, .right02, .right03, .right04,  .right06 {
        padding-left: 2%;
    }
    .right {
        font-size: 0.8em; max-width: 21.8em;

    }
   /* .a1{
        background-color: #E1E1E2;
    }

    .a2{
        line-height: 1.5em;
    }
    .right-inner {
        height: 257px; overflow-y: scroll;
    } */
.right01 , .right02,  .right04{
display: block; width:6em;
}

.right03,.right06 {
    display: block; width:15%;
min-width: 100px;
    }
    .left{
        max-width: 180px;
    }
    .left img{
     width:60%; height: auto;
     min-width: 6em;
 }
   .right04 .bfr02{
       color: red; width: 5%;
    }
   .total{
       padding-left: 80%;
   }

   .right05 {
       display: block;  padding:1em 0 0 2em;
       margin-left: 2em;
       background-color: #E1E1E2; height: 3em;
       width: 20%;
       min-width:34px ;
   }

ul li {
    list-style-type: none;
}

 .threebuttons{
     display: flex;
 }
    .button1{
       /* margin-left: 29em;*/ background-color: #E1E1E2;

    }
    @media  (max-width: 767px) {
        .wrapper{
            display: flex; align-items: center; /*  контроль высоты*/
            justify-content: space-between;            /*  контроль ширины*/
                flex-wrap: wrap;
        }
        .left img{
            width:100px; height: auto;

        }
    }


</style>
