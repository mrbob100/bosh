 <template>
    <div>


        <form @submit.prevent="register" v-if="!lefty">
                   <div class="progress">
                        <div class="progress-bar" :style="progressWidth"></div>
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



            <hr>
            <!--input  type="file" name="image" multiple="" @change="fileInputChange"></input-->
                <app-upload @input="changeFile($event)"></app-upload>
            <hr>



                    <div class="form-group">
                        <label for="parent">Выберите родительскую категорию</label>
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

            <div class="form-group" >
                <label >Описание категории</label>
                <!--ckeditor :editor="editor" v-model="editorData" :config="editorConfig" style="height: 400px;"></ckeditor-->
                <!--textarea class="form-control inside" id="editorData" v-model="editorData" ></textarea-->
                <vue-editor v-model="report" ></vue-editor>
            </div>

                    <button class="btn btn-primary" :disabled="(this.done < info.length) ">
                        Сохранить
                    </button>
        </form>



    </div>


</template>

<script>
    import appInput from '../AppInput';
    import appUpload from './AppUpload';
    import {mapGetters} from 'vuex';
    import { VueEditor, Quill } from 'vue2-editor'
    import { post } from '../../helpers/api';
    import { bus } from '../../helpers/bus.js'

    export default {
        name: "AppCategoryAdd",

        components : {
            appUpload,
            appInput,
            VueEditor
        },

        data() {
            return {
                report: null,
                controls: [],
                done: 0,
                lefty: false,
                message: '',

                selected:'Самостоятельная категория',

                info: [
                    {
                        name: 'Название категории',
                        value: '',
                        pattern: /^[А-Яа-яЁё,\s]{2,60}$/
                    },
                    {
                        name: 'Ключевые слова',
                        value: '',
                        pattern: /^[А-Яа-яЁё,\s]{3,255}$/
                    },
                    {
                        name: 'Мета теги',
                        value: '',
                        pattern: /^[А-Яа-яЁё,\s]{3,255}$/
                    },
                    /* {
                         name: 'Адрес',
                         value: '',
                         pattern: /[A-Za-z0-9'\.\-\s\,]/
                     }, */

                ],

                form: {
                    name: '',
                    keywords: '',
                    description: '',
                    parent_id: '',
                    img: '',
                    file:''
                },





                }

        },
        computed: {
            ...mapGetters('categories', {
                categories: 'categories'
            }),
            ...mapGetters('bread', {breadcrumbList: 'bread'}),

            progressWidth(){
                return {
                    width: (this.done / this.info.length * 100) + '%'
                }
            }
        },

            methods: {

                onChangeData(index, status){
                    this.controls[index] = status;

                    let done = 0;

                    for(let i = 0; i < this.controls.length; i++){
                        if(this.controls[i]){
                            done++;
                        }
                    }

                  this.done = done;
                    //this.done += status ? 1 : -1;
                },


                changeFile(e){

                    this.form.file=e;

                },

                register(){

                     this.form.name=this.info[0]['value'];

                     this.form.keywords=this.info[1]['value'];

                     this.form.description=this.info[2]['value'];
                      if (this.selected !='Самостоятельная категория'){
                          let idv=this.categories.find(c=>c.name===this.selected).id;
                          this.form.parent_id=this.categories.find(c=>c.name===this.selected).id;

                      } else this.parent_id=0;

                    let frame=new FormData();
                    frame.append('img',this.form.file);
                    frame.append('parent_id',this.form.parent_id);
                    frame.append('name',this.form.name);
                    frame.append('text',this.report);
                    frame.append('keywords',this.form.keywords);
                    frame.append('description',this.form.description);

                    post(`/api/categoryAdd/`,frame).then((res => {

                        if(res.data.status) {
                           this.message='Новая категория успешно создана !';
                            bus.$emit('message', {'message': this.message});
                            this.$router.push('/categories');
                        }


                    })).catch((err) =>{
                        if(err.response.status===422) {
                            this.error=err.response.data
                        }
                            this.message="Сохранить категорию не удалось !!!"
                        bus.$emit('message', {'message': this.message});
                        this.$router.push('/categories');
                    });


                 },

                fileInputChange() {
                    let files=Array.from($event.target.files);
                    this.form.img=files.slice();
                }

            },
        created() {
            for (let i = 0; i < this.info.length; i++) {
                this.controls.push(false);
            }

        },


    }
</script>

<style scoped>

</style>
