<template>
  <div>
        <div class="modal" v-if="modelOpened">
            <div class="modal-background" ></div>
                <div class="modal-content">
                    <button class="bfr" @click="modalClose">x</button>

                    <br/>

                       <div class="wrapper">
                            <div class="left">
                                  <img :src="`/images/${product.img.max}`" v-if="product.img.max"  alt="img"/>
                            </div>
                            <div class="right" >
                                  <h4>{{ product.name}}</h4>
                                <div class="right-inner">
                                        <p class="a1">Тип товара - {{exact2[0]}}</p>
                                        <p>Вид товара - {{exact2[1]}}</p>
                                        <p class="a1">Страна производства - {{product.country}}</p>
                                        <p>Класс - {{product.class}}</p>
                                        <!--p v-html="product.exactlyType1"></p-->
                                        <p class="a2" v-html="exact"></p>
                                        <br/> <br/>

                                        <h5>Функции:</h5>
                                        <h5>Преимущества:</h5>
                                      <p>{{product.description}}</p>
                                </div>
                                <div class="wrap1">
                                    <div class="wrap01">
                                        <!--router-link  :to="`/cart/${product.id}` " -->
                                        <router-link :to="{name:'cartInto', params:{id: product.id, data: propRoute}}">
                                            <img :src="`/images/features/add.png`" style="width:100px; height:auto;"  alt="img"/>
                                        </router-link>
                                    </div>
                                    <div class="wrap02">
                                          <h4>Цена {{product.price}}</h4>
                                    </div>
                                </div>
                            </div>
                       </div>
                </div>


        </div>
  </div>
</template>

<script>

    import {mapGetters } from 'vuex';
    import {router} from "../router";

    export default {
        name: "AppProduct",
        data(){
           return {
               modelOpened: true,
              exact:    '',
               exact2:  '',
               propRoute : ''
           }
        },

        methods: {
            modalClose(){
                this.modelOpened=false;
                this.$router.push('/slider');

            }

        },
        computed: {

            id(){
                return this.$route.params.id;
            },
            product(){
                let are=this.$route;
                let a= this.id;
                let erba='';

                if(are.name==="Продукт") {
                    this.propRoute="Продукт";
                    erba =this.$store.getters['slider/item'](this.id);
                    this.$store.commit('category/add',
                        erba
                    );
                } else if(are.name==="Набор"){
                    this.propRoute="Набор";
                    erba =this.$store.getters['category/item'](this.id);
                } else if(are.name==="Выбор") {
                    this.propRoute="Выбор";
                    erba =this.$store.getters['search/item'](this.id);
                }

              let pro=erba.exactlyType2;
                this.exact2=pro.split('!');
                this.exact=erba.exactlyType1;


                return erba;
            }


        },
    mounted() {
        let j=0;
        let  navEl=document.querySelector('.menu1 .modal .modal-content .wrapper .right .right-inner p  ul');

        [].slice.call(navEl.querySelectorAll('li')).forEach(function(e){
            if(j % 2===0){
                e.style.backgroundColor="#E1E1E2";
               e.style.fontSize='1em';
                e.style.lineHeight='1.5em';
               // e.target.style.backgroundColor="#E1E1E2";

            } else {
                e.style.backgroundColor = "white";
                e.style.fontSize='1em';
                e.style.lineHeight='1.5em';

            }
            j++;
        });

    }

    }



</script>

<style scoped>

.left{
    margin-top: -300px;
    width: 20%;
}

    .modal, .modal-background {
        position: fixed; left: 0;  top: 0;
        width: 100%; height: 100vh;
        z-index: 1000;
        font-family: 'Times New Roman', Times, serif; /* Гарнитура текста */
        font-size: 100%;
    }


    .modal{
        display: flex; /*align-items: center; */
        justify-content: center;
    }
    .modal-content{
        background-color: white; padding: 2em;
        width: 50vw;
        position: absolute;
        z-index: 50;

    }

    .modal-background {
        background-color: rgba(10,10,10,0.8);
        z-index: 40;
    }
    .bfr {
        color: red; position: absolute;
        right: 20px; top: 20px;
    }

    .wrapper{
        display: flex; align-items: center; /*  контроль высоты*/
        justify-content: center;            /*  контроль ширины*/

    }
.right {
    font-size: 1.1em;
width: 80%;
   /* margin-left: 20px; */
}

.right h4 {
    padding-left: 2.8em;
    padding-bottom: 1em;
    font-size: 1.2em;
}
    .a1{
        background-color: #E1E1E2;
    }


    .right-inner {
        height: 257px; overflow-y: scroll;
        line-height: 1.5em;
        padding-left: 5em;
    }

   .wrap1  {
       display: flex; align-items: center; /*  контроль высоты*/
       justify-content: center;            /*  контроль ширины*/
   }
    .wrap02 h4 {
        margin-left: 10px;
    }

   .a2{
       line-height: 30px;
   }

@media  (max-width: 1419px) {
    .modal-content{

    }
    .left img{
        width: 100%; height: auto;
        min-width: 130px;
    }

}
</style>
