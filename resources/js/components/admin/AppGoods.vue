<template>
    <div>
        <h3>я в категории AppGoods</h3>

        <div v-cloak v-show="!loaded">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>

        </div>
        <transition name="fade">
            <div v-show="loaded" >

                <app-products-table :records="breaks" />

                <Paginate
                    v-model="page"
                    :page-count="pageCount"
                    :click-handler="getPosts"
                    :prev-text="'Назад'"
                    :next-text="'Вперед'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"
                    :page-link-class="'page-link'"
                    :prev-class="'page-item'"
                    :next-class="'page-item'"
                    :prev-link-class="'page-link'"
                    :next-link-class="'page-link'"
                    :active-class="'active'"
                />

                <!--ul class="pagination">
                    <li :class="{disabled: !pagination.prev_page_url}"
                        @click.prevent="getPosts(pagination.prev_page_url)" class="page-item">
                        <a class="page-link" href="#">
                       Назад
                        </a>


                    </li>

                    <li class="page-item disabled">
                        <a class="page-link" href="#">
                            Страница {{pagination.current_page}} из {{ pagination.last_page}}
                        </a>
                    </li>


                    <li :class="{disabled: !pagination.next_page_url}"
                        @click.prevent="getPosts(pagination.next_page_url)"
                        class="page-item">
                        <a class="page-link" href="#">Следующая
                        </a>
                    </li>

                </ul-->




                <button class="btn btn-success"> <router-link :to="`/admin/productAdd`" style="color: white;"> Новый продукт</router-link></button>
            </div>
        </transition>
    </div>
</template>

<script>
    import AppProductsTable from "./AppProductsTable";
    import { get } from '../../helpers/api';
    import {mapGetters } from 'vuex';

    export default {
        name: "AppGoods",

        data() {
            return {
                loaded :false,
                page: +this.$route.query.page || 1,
                pageSize: 6,
                pageCount: 0,
                allItems: [],
                breaks: [],
                posts:'',
                error:'',
                pagination: {},
            }
        },

       computed: {

           ...mapGetters('bread', {breadcrumbList: 'bread'}),


        },


        components: {
            AppProductsTable
        },

        created() {

            get(`/api/productsAdmin`).then((res => {

                if (res.data.status) {
                    let products = res.data.products;


                   // this.setupPagination(products);
                    this.makePagination(products);
                  //  this.$store.dispatch('products/loadItems',  // загрузка меню
                  //      products
                  //  );

                }
            })).catch((err) => {
                if (err.response.status === 422) {
                    this.error = err.response.data
                }

            });



        },
        mounted() {

            this.loaded=true
        },

        methods: {

            getPosts(page){

                page=`${'/api/productsAdmin'}?page=${page}`|| 1 ;

                get(page).then(res=>{

                    let sas=res.data.products;
                    this.makePagination(sas);

                }). catch(err=>{
                    this.error = err.res.data;
                })

            },
            makePagination(response) {

                let pagination={
                    current_page: response.current_page,
                    last_page: response.last_page,
                    prev_page_url: response.prev_page_url,
                    next_page_url: response.next_page_url,

                };
                this.pagination=pagination;
                this.page=response.current_page;
                this.pageCount=response.last_page;
                this.breaks=response.data;

            }

        }
    }
</script>

<style scoped>
    i {
        color: #843534;
        margin: 0 auto;
        /* height: 100vh; */
        width: 100%;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity 2s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
        opacity: 0;
    }
</style>

