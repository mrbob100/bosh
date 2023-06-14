<template>
<div>
   <app-breadcrumb/>

        <h1 class="icon">Welcome to administrator page</h1>
        <div style="background-color: yellow;"   v-if="this.message" >
            <h5>{{this.message}}</h5>
        </div>


        <!--i class="fas fa-tachometer-alt"></i> <br/>
        <i class="fa fa-ident fa-lg"></i>  <br/>
        <i class="fa fa-tags fw"></i>  <br/>
        <i class="fa fa-book fw"></i>  <br/>
        <i class="fa fa-puzzle-piece fw"></i>  <br/>
       <i class="fas fa-tv"></i> <br/>
        <i class="fal fa-image-polaroid"></i>
        <i class="fa fa-shopping-cart fw"></i>  <br/>
        <i class="fa fa-user fw"></i>  <br/>
        <i class="fa fa-share-alt fw"></i>  <br/>
        <i class="fa fa-cog fw"></i>  <br/>
        <i class="far fa-analytics"></i> <br/>

        <i class="far fa-comment"></i>  <br/>
        <i class="fal fa-analytics"></i>
        <i class="fad fa-analytics"></i>
        <i class="fas fa-chart-line"></i>
        <i class="fas fa-chart-pie"></i>
        <i class="fa fa-tasks fw"></i>  <br/>


<i class="fas fa-trash-alt"></i>

            <i class="fas fa-pen-fancy"></i>
         <i class="far fa-edit"></i>
        <i class="fa fa-cubes fw"></i>  <br/-->


        <div class="row">

            <div class="col col-sm-3 artist">
                <div class="artistInside">
                <template >

                    <app-tree v-for="(item,index) in menuList "

                        :item="item"
                        :key="item.id"
                        :index="index"
                        :value.sync="item.text"
                          >

                    </app-tree>

                </template>
                </div>
                <div v-if="optCategories">



                    <table class="table table-striped table-bordered " >

                        <tbody class=" sumo">
                            <tr class="out" v-for="(sample,ind) in optCategories"
                                :key="ind"
                            >
                                <td class="sumo1">{{sample.parentTitle}}</td>
                                <td class="sumo2"> {{sample.value}}</td>
                                <td class="sumo3" @click="deleteItem(sample.parentTitle)"> <i class="fas fa-trash-alt"></i> </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
          </div>

                <div class="col col-sm-9 menu" >

                    <app-chart></app-chart>


                        <div v-if="isRun&& isNode"  >



                            <router-view :key='$route.fullPath'></router-view>

                        </div>
                 </div>

            <button class="button" @click="main()"  >Перейти На сайт</button>

        </div>
    </div>
</template>
<script>
    import { bus } from '../../helpers/bus.js'
    import {mapGetters} from 'vuex';
  //  import Auth from '../../store/modules/auth'
import  AppChart  from './AppChart'
    import AppBreadcrumb from "../AppBreadcrumb";

    export default {
        name: "AppAdmin",

        components: {
            AppBreadcrumb,
            AppTree : () => import('./AppTree'),
            AppChart

        },


        data () {
            return {
               lux: {},
                isRun: false,
                isHold: false,
                isNode: false,
                dana: '',
                isActive: false,
                message: ''
            }
        },
        computed: {
            ...mapGetters('adminMenu', {
                menuList: 'items'
            }),
            ...mapGetters('bread', {breadcrumbList: 'bread'}),

            ...mapGetters('optCategories', {
                optCategories: 'optCategories'
            }),

        },
        methods: {
           activatePoint(data){
                this.isRun= true;
                this.isHold= data.myHold;
                this.lux=data.Item;
                this.isNode=data.isNode;
          //  this.isActive= true;
                this.$router.push(this.lux.url);


            },

            activateMessage(data){
               this.message=data.message;
               setTimeout(()=>{this.message=''},2000);
            },

            deleteItem(e){
                this.$store.dispatch('optCategories/deleteSingle',  // загрузка справочников под категорию option
                    e
                );
            },


                main() {
                    this.$root.$emit('changeStatus', false);

                }

        },


     created() {
         bus.$on('activated', this.activatePoint);
         bus.$on('message', this.activateMessage);
     },
        /* Обнуление */



    }
</script>

<style scoped>
    .artist .artistInside{
        display:block;
        margin-bottom: 20px;
    }
   .artist .sumo {
        font-size: 83%;
        color: darkred;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    tr.list-group-item.out {
        padding: 0;
    }

    .sumo1 {
        width: 20%;
    }
    .sumo2 {
        width: 75%;
    }
    .sumo3 {
        width: 5%;
        cursor: pointer;
    }
    .icon{
        padding-bottom: 20px;
    }

    .button{
       margin: 30px;
        background-color: #0c7fd7;
        color: white;
        width: 150px; height: 42px;
        text-align: center;
        border-radius: 8px;
    }

</style>
