<template>
 <div>
     <form @submit.prevent="register" v-if="!formSubmitted">

         <div class="progress">
             <div class="progress-bar" :style="progressWidth"></div>
         </div>
         <div class="form-group" >
             <label >Полное описание продукта</label>
             <!--ckeditor :editor="editor" v-model="editorData" :config="editorConfig" style="height: 400px;"></ckeditor-->
             <!--textarea class="form-control inside" id="editorData" v-model="editorData" ></textarea-->
             <vue-editor v-model="product.description" ></vue-editor>
         </div>

         <div>
             <app-input v-for="(item, index) in  info"
                        :name="item.name"
                        :value.sync="item.value"
                        :pattern="item.pattern"
                        :key="index"
                        @changeStatus="onChangeData(index, $event)"

             >
             </app-input>
         </div>
         <button class="btn btn-primary" :disabled="done < info.length">
             Отправить данные
         </button>

     </form>

 </div>
</template>

<script>
    import appInput from '../AppInput';
    import { bus } from '../../helpers/bus.js'

    import { VueEditor, Quill } from 'vue2-editor'
    import {mapGetters} from 'vuex'
    import { post } from '../../helpers/api';




    export default {
        name: "AppEditCategoryOut",
        components: {
            appInput,
            VueEditor,

        },

        props: {
            file: '',
            codeCategory:'',
            id: 0,
            picture: false
        },


        computed : {
            ...mapGetters('categories', {
                categories: 'categories'
            }),
            ...mapGetters('article', {
                article: 'article'
            }),


            progressWidth(){
                return {
                    width: (this.done / this.info.length * 100) + '%'
                }
            },


        },

        data() {
            return {
                formSubmitted: false,
                controls: [],
                done: 0,
                message: '',

                product: {
                    description: null,
                    img: null,
                },


                info: [

                    {
                        name: 'Имя категории',
                        nameSql: 'name',
                        value: '',
                        pattern: /^[А-Яа-яЁёa-zA-Z0-9,\s]{3,255}$/
                    },

                    {
                        name: 'Ключевые слова',
                        nameSql: 'keywords',
                        value: '',
                        pattern: /^[А-Яа-яЁёa-zA-Z0-9,\s]{3,255}$/
                    },
                    {
                        name: 'Мета-тег описание',
                        nameSql: 'meta_desc',
                        value: '',
                        pattern: /^[А-Яа-яЁёa-zA-Z0-9,\s]{3,255}$/
                    },


                ],

            }

        },

        watch: {
            file(){
                this.getPoints()
            }
        },

        methods:{
            onChangeData(index, status){
                this.controls[index] = status;
                //    if(this.item.value==='Краткое описание продукта') {

                //   }
                let done = 0;

                for(let i = 0; i < this.controls.length; i++){
                    if(this.controls[i]){
                        done++;
                    }
                }

                this.done = done;
                //this.done += status ? 1 : -1;
            },

            getPoints(){
                this.product.description=this.article.text;
                let aa=this.article.text;
                this.info[0].value=this.article.name;
                this.info[1].value=this.article.keywords;
                this.info[2].value=this.article.description;
               // this.$emit('myEvent');
            },

            register() {
                let j=0, sec='',m='' , isis1='';

                for (let i = 0; i < this.info.length; i++) {
                    if (this.info[i].value) {
                        j++;
                    }
                }
                if(j===this.info.length) {
                    // Flash.setSuccess('Валидация данных прошла успешно !');
                    this.formSubmitted=true;


                    let frame=new FormData();
                    frame.append('category_id',this.codeCategory);
                    if(!this.picture) {
                        frame.append('old_images',this.file);
                    }
                    frame.append('img',this.file);
                    frame.append('text', this.product.description);

                    for (let i = 0; i < this.info.length; i++) {
                        frame.append(this.info[i].nameSql,this.info[i].value);
                    }

                    post(`/api/categoryEdit/${this.id}`, frame).then((res=>{
                        if (res.data.status) {

                            this.message='Категория успешно изменена !';
                            this.$store.commit('optCategories/clearItems');
                            bus.$emit('message', {'message': this.message});
                            this.$router.push('/categories');
                        }


                    })).catch((err) =>{
                        if(err.response.status===422) {
                            this.error=err.response.data
                        }
                        this.message="Измененить категорию не удалось !!!"
                        bus.$emit('message', {'message': this.message});
                        this.$router.push('/categories');
                    });

                }

            },








        },


        created() {
            for (let i = 0; i < this.info.length; i++) {
                this.controls.push(false);

            }

        },

    }
</script>

<style scoped>
    .wrapper {
        margin: 30px 30px;
    }
    .inside{ background-color: #e4b9b9}
    @import '~quill/dist/quill.core.css';
    @import '~quill/dist/quill.bubble.css';
    @import '~quill/dist/quill.snow.css';
    #checkbox1, #checkbox2, #checkbox3{

    }
</style>


