<template>
    <div>
         <h5> Я в категории admin/category</h5>
        <div v-cloak v-show="!loaded">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>

        </div>
        <transition name="fade">
        <div v-show="loaded" >

        <app-category-table :records="breaks" />

          <Paginate
              v-model="page"
              :page-count="pageCount"
              :click-handler="pageChangeHandler"
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
            <button class="btn btn-success" > <router-link :to="`/admin/categoryAdd`" style="color: white;"> Новая категория</router-link></button>
        </div>
        </transition>

    </div>
</template>

<script>
    import AppCategoryTable from "./AppCategoryTable";
    import paginationMixin from '../../mixins/pagination.mixin'
    import { get } from '../../helpers/api';
    import {mapGetters} from 'vuex';



    export default {
        name: "AppCategories",
        mixins: [paginationMixin],
            data() {
            return {
                loaded :false
            }
            },

        computed: {
            ...mapGetters('categories', {
                categories: 'categories'
            }),

            ...mapGetters('optCategories', {
                optCategories: 'optCategories'
            }),
            ...mapGetters('bread', {breadcrumbList: 'bread'}),
        },

            components: {
                AppCategoryTable
            },

        created() {
            this.$store.commit('optCategories/clearItems');
            get(`/api/categoriesAdmin`).then((res => {


                if (res.data.status) {
                    let categories = res.data.categories;
                  //  mix=valve(categories);

                   let rez=categories.map(function (category) {
                        if(category.parent_id===0) {
                            category.parent_id = 'Самостоятельная категория';
                        }else {
                                category.parent_id=categories.find(c=>c.id===category.parent_id).name;

                        }
                        return category;
                    });

                 /*   let rez=categories.map(category => {

                          return {
                              ...category,
                              category:parent_id = category.parent_id === 0 ? "Самостоятельная категория" :
                                  categories.find(c => c.id === category.parent_id).name

                          }

                    }) ; */

                    this.setupPagination(rez);
                    this.$store.dispatch('categories/loadItems',  // загрузка меню
                       rez
                    );

                }
            }));



        },
            mounted() {
            this.loaded=true;

            }

    }

</script>

<style scoped>
    [v-cloak] {display: none!important;}

    /*  [v-cloak] .v-cloak--block {
          display: block!important;
      }


  */
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
