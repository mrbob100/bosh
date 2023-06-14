<template> <!-- AppHeader-->



        <div class="wrapper01">


               <header class="alive">


                    <div class="line"> </div>
                          <div class="header_title">

                                <div class="header_logo">

                                            <router-link class="ltitle" :to="`/slider`">
                                                <img :src="`/images/features/Eagle.jpg`">
                                            </router-link>

                                 </div>

                                <div class="menu-call">
                                    <router-link class="ltitle" :to="`/components/Header`">
                                        <p > Заказ обратного звонка</p>
                                    </router-link>



                                    <div class="menu-wrap">           <!-- тег поиска по сайту-->

                                        <div class="menu-search-art">
                                            <input  class="inside"  placeholder="поиск" type="next"  v-model="bName"
                                                    aria-placeholder="поиск по имени"></input>
                                            <span class="search-icon">
                                               <i class="fas fa-search"></i>
                                           </span>
                                        </div>

                                    </div>


                                </div>
                                <div class="menu-tel">
                                    <p>Телефон - (555)6755444</p>
                                    <p>Телефон - (555)6755444</p>
                                    <p>Телефон - (555)6755444</p>
                                </div>


                                <div class="menu-cart">   <!-- корзина-->

                                    <router-link class="ltitle" :to="`/Cart`">   <!-- корзина -->
                                        <img :src="`/images/features/150923s.jpg`" >

                                    </router-link>

                                </div>

                          </div>

                            <div class="header">
                                  <div class="header_body">


                                              <!-- синее меню  и содержимое  левая и правая части-->
                                        <div class="header_menu">
                                            <div class="header_burger"  @click="iconMenu">
                                                <span></span>
                                            </div>
                                                <ul class="header_list" @click="purge($event.target.value)" >
                                                    <router-link v-for="(item, big) in menu"
                                                                 :key="big"
                                                                 :to="item.url"
                                                                 tag="li"
                                                                 class="header_link"
                                                                 active-class="active"
                                                    >                                           <!-- active-class="active"  это подсветка -->
                                                        <a>{{ item.text }}</a>   <!-- Это текст ссылки -->
                                                    </router-link>
                                                </ul>


                                        </div>



                                </div>
                            </div>

                   <app-breadcrumb>  </app-breadcrumb>  <!--Хлебные крошки -->
               </header>

                <div class="wrap1">
                            <div class="wrap01 menu">


                                    <app-left>  </app-left>

                            </div>
                            <div class="wrap02" >

                                <!--app-breadcrumb>  </app-breadcrumb--> <!--Хлебные крошки -->



                                <div class="menu1" >


                                    <transition name="slide" mode="out-in" >



                                        <router-view :key='$route.fullPath'></router-view>



                                    </transition>

                                </div>
                                <div class="jSearch">
                                    <app-search v-if="isSearch"
                                                :bName="bName"
                                    ></app-search>
                                </div>

                            </div>
                        </div>





        </div>






</template>
<script>

    import {mapGetters} from 'vuex';
    import  AppLeft from './AppLeft.vue';
    import  AppBreadcrumb from './AppBreadcrumb.vue';
    import  AppSearch from './AppSearch.vue';

    import { bus } from '../../js/helpers/bus.js'
  //  import AppSlider from './slider';

    export default {

            data () {
                return {
                    bName: '',
                    isSearch: false
                }
            },

        computed: {
            ...mapGetters('menu', {
                menu: 'items'
            }),


    },


        watch: {
            bName() {
                document.querySelector(".menu1").style.display="none";
                return this. isSearch=true;  }
        },


        components:{
            AppLeft,
            AppBreadcrumb,
            AppSearch

        },

        created () {
            bus.$on('finishSearch', this.searchFinished);

        },


         methods : {
             searchFinished()  {
                 document.querySelector(".menu1").style.display="block";
                 return this.isSearch=false;
             },
             iconMenu() {
                 const headerMenu=document.querySelector('.header_menu');
                 const headerBurger=document.querySelector('.header_burger');
                 const wrap= document.querySelector('.wrapper01');
                 headerMenu.classList.toggle('_active');
                 headerBurger.classList.toggle('_active');
                 wrap.classList.toggle('_lock')
             },

             purge(e) {
                 const headerMenu=document.querySelector('.header_menu');
                 const headerBurger=document.querySelector('.header_burger');
                 const wrap= document.querySelector('.wrapper01');
                if(headerMenu.classList.contains('_active')) {
                    headerMenu.classList.remove('_active');
                    headerBurger.classList.remove('_active');
                    wrap.classList.remove('_lock')

                }
             }
         },

       mounted(){


         /*  let w = document.documentElement.clientWidth;
           const wrap1=document.querySelector('.wrap1');
           //   this.Hg=100; this.Wd=130;
           if (w < 980) {

               wrap1.classList.add('_active');
           } else if(w>=980 && wrap1.classList.contains('_active')) {
               wrap1.classList.remove('_active')
           }  */
           this.$router.push('/slider');


        },


    }
</script>

<style scoped>
  /* .wrapper01 .menu{
       display: block;
        border-right: 2px solid #ddd;
       border-radius: 3%;
       min-width: 134px;
    } */
  @media  (min-width: 768px) and (max-width: 979px){
       .wrapper01 .menu{
           min-width: 115px;
       }

   }
   @media  (max-width: 767px) {
       .wrapper01 .menu{
           min-width: 100px;
       }

   }





    .slide-enter{

    }

    .slide-enter-active{
       animation: slideIn 0.8s;

    }

    .slide-enter-to{

    }

    .slide-leave{

    }

    .slide-leave-active{
        animation: slideOut 0.8s;

    }

    .slide-leave-to{

    }

    @keyframes slideIn{
        from{transform: rotateY(90deg);}
        to{transform: rotateY(0deg);}
    }

    @keyframes slideOut{
        from{transform: rotateY(0deg);}
        to{transform: rotateY(90deg);}
    }

    .menu-search-art .inside{
        background: #eee;
    }






</style>
