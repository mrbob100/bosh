<template>
    <div>
        <h3>я категории AppOrderLst</h3>

        <div v-cloak v-show="!loaded">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>

        </div>

        <transition name="fade">
            <div v-show="loaded" >

                <app-orders-table :records="breaks" ></app-orders-table>

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

            </div>
        </transition>
    </div>
</template>

<script>
    import AppOrdersTable from "./AppOrdersTable";
    import {mapGetters } from 'vuex';
    import { get } from '../../helpers/api';


    export default {
        name: "AppOrderList",

        data() {
            return {
                loaded: false,
                page: +this.$route.query.page || 1,
                pageSize: 6,
                pageCount: 0,
                pagination: {},
                breaks: [],
                posts:'',
                error:'',
            }
        },

         computed: {

             ...mapGetters('bread', {breadcrumbList: 'bread'}),


          },


        components: {
            AppOrdersTable
        },

        methods: {

            getPosts(page){

                page=`${`/api/orderListAdmin`}?page=${page}`|| 1 ;

                get(page).then(res=>{

                    let sas=res.data.orders;
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

        },

        created() {

            get(`/api/orderListAdmin`).then((res => {

                if (res.data.status) {
                    let orders = res.data.orders;
                    this.makePagination(orders);
                  //  this.$store.dispatch('orders/loadItems',  // загрузка меню
                  //      orders
                  //  );

                }
            })).catch((err) => {
                if (err.response.status === 422) {
                    this.error = err.response.data
                }

            });



        },
        mounted() {

            this.loaded=true;
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
