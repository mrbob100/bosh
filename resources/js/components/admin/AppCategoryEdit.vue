<template>
    <div>
        <div class="form-group " >           <!-- Ввод категории -->
            <label for="parent">Родительская категория !</label>
            <select   class="form-control" id="parent" v-model="selected">
                <option >Самостоятельная категория</option>
                <option v-for="(category, index) in categories "
                        :value="category.name"
                        :key="index"
                >
                    {{category.name}}
                </option>
            </select>

        </div>


        <!--Загрузка картинки -->
        <hr>
        <div >

            <img :src="`/images/${article.img}`" >
        </div>
        <div>
            <app-upload @input="changeFile($event)"></app-upload>
        </div>
        <hr>

        <app-edit-category-out  :file="file"
                              :codeCategory="codeCategory"
                              :id="id"
                                :picture="picture"

        />




    </div>




</template>

<script>

    import { get } from '../../helpers/api';
    import appUpload from './AppUpload';
    import AppEditCategoryOut from './AppEditCategoryOut'
    import {mapGetters} from 'vuex';

    export default {
        name: "AppCategoryEdit",

        data() {
           return {
               selected:'Самостоятельная категория',
               name: '',
               massive:[],
               priznak: false,
               optionMain: [],
               loaded :false,
               file: {},
               codeCategory: 0,
               id: 0,
               picture: false,
               baseSelected: [],
               category: {}

           }

        },

        components: {
            AppEditCategoryOut,
            appUpload
        },

        computed: {
            ...mapGetters('categories', {
                categories: 'categories'
            }),
            ...mapGetters('article', {
                article: 'article'
            }),
            ...mapGetters('bread', {breadcrumbList: 'bread'}),
        },

        methods: {

            changeFile(e){

                this.file=e;

            },

            changeImage(){
                this.picture=true;
            }

        },

        created() {
            this.id= this.$route.params.id;
            get(`/api/categoryEdit/${this.id}`).then((res => {

                if (res.data.status) {

                   this.category=res.data.category;  //вывод конкретной категории
                    this.$store.dispatch('article/loadItems', this.category);

                    this.file= this.category.img;
                        let deb=this.category.img;

                    let categories=res.data.categories;
                    let rez=categories.map(function (category) {
                        if(category.parent_id===0) {
                            category.parent_id = 'Самостоятельная категория';
                        }else {
                            category.parent_id=categories.find(c=>c.id===category.parent_id).name;

                        }
                        return category;
                    });

                    this.$store.dispatch('categories/loadItems',  // загрузка категорий
                        rez
                    );


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

</style>
