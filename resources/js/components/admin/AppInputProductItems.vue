<template>
    <div>
        <div v-if="this.message" >
            <h5>{{this.message}}</h5>
        </div>

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
            <div class="wrapper">
                    <div class="form-check form-check-inline">
                        <input type="checkbox"  class="form-check-input" id="checkbox1" v-model="product.new">
                        <label for="checkbox1">Новый</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox"  class="form-check-input" id="checkbox2" v-model="product.hit">
                        <label for="checkbox2">Хит продаж</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox"  class="form-check-input" id="checkbox3" v-model="product.sale">
                        <label for="checkbox3">Распродажа</label>
                    </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox"  class="form-check-input" id="checkbox4" v-model="product.wareHouse">
                    <label for="checkbox4">Наличие на складе</label>
                </div>

            </div>


            <div class="wrapper1">

                <div class="form-group " >
                    <label for="parent4">Тип изделия</label>
                    <select   class="form-control form-control-sm inside" id="parent4" v-model="product.groupTools"   >
                        <option v-for="(category, index) in lists.grouptool"
                                :value="category.id"
                                :key="index"
                                :index="category.id"

                        >
                            {{category.name}}
                        </option>
                    </select>

                </div>

                <div class="form-group " >
                    <label for="parent">Класс изделия</label>
                    <select   class="form-control form-control-sm inside" id="parent" v-model="product.classMod"   >
                        <option v-for="(category, index) in lists.class "
                                :value="category.name"
                                :key="index"
                                :index="category.id"

                        >
                            {{category.name}}
                        </option>
                    </select>

                </div>
                <div class="form-group " >
                    <label for="parent1">Компания</label>
                    <select   class="form-control form-control form-control-sm inside" id="parent1" v-model="product.company"   >
                        <option v-for="(category, index) in lists.company"
                                :value="category.name"
                                :key="index"
                                :index="category.id"

                        >
                            {{category.name}}
                        </option>
                    </select>

                </div>

                <div class="form-group " >
                    <label for="parent2">Страна</label>
                    <select   class="form-control form-control form-control-sm inside" id="parent2" v-model="product.country"   >
                        <option v-for="(category, index) in lists.country"
                                :value="category.name"
                                :key="index"
                                :index="category.id"

                        >
                            {{category.name}}
                        </option>
                    </select>

                </div>
                <div class="form-group " >
                    <label for="parent5">Тип  привода</label>
                    <select   class="form-control form-control form-control-sm inside" id="parent5" v-model="product.typeTool"   >
                        <option v-for="(category, index) in lists.typetools"
                                :value="category.id"
                                :key="index"
                                :index="category.id"

                        >
                            {{category.name}}
                        </option>
                    </select>

                </div>


                <div class="form-group " >
                    <label for="parent3">Упаковка</label>
                    <select   class="form-control form-control form-control-sm inside" id="parent3" v-model="product.packing"  >
                        <option v-for="(category, index) in lists.packing"
                                :value="category.name"
                                :key="index"
                                :index="category.id"

                        >
                            {{category.name}}
                        </option>
                    </select>

                </div>
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
        name: "AppInputProductItems",
        components: {
            appInput,
            VueEditor,

        },

     props: {
            lists: '',
            file: '',
         codeCategory:'',
     },


        computed : {
            ...mapGetters('optCategories', {
                optCategories: 'optCategories'
            }),
            progressWidth(){
                return {
                    width: (this.done / this.info.length * 100) + '%'
                }
            }
        },

        data() {
            return {
                formSubmitted: false,
                controls: [],
                done: 0,
                message: '',
                error: '',


                product: {
                    description: null,
                    img: null,
                    new: 0,
                    hit: 0,
                    sale: 0,
                    classMod:'профессиональный',
                    company: 'BOSCH',
                    packing: 'Картон',
                    wareHouse: true,
                    country: 'Китай',
                    groupTools: '',
                    typeTool: ''
                },


                info: [
                    {
                        name: 'Код продукта',
                        nameSql: 'code',
                        value: '',
                        pattern: /(?=(^([\w]){10}$))/
                    },
                    {
                        name: 'Имя продукта',
                        nameSql: 'name',
                        value: '',
                        pattern: /^[А-Яа-яЁёa-zA-Z0-9,\s]{3,255}$/
                    },
                    {
                        name: 'Краткое описание продукта',
                        nameSql: 'text',
                        value: '',
                        pattern: /^[А-Яа-яЁёa-zA-Z0-9-\.\(\),\s]{3,3000}$/
                    },

                    {
                        name: 'Цена',
                        nameSql: 'price',
                        value: '',
                        pattern:  /^[\d]*(\.\d{0,2})?$/
                    },
                    {
                        name: 'Цена дилера 1',
                        nameSql: 'pricedealer1',
                        value: '',
                        pattern: /^[\d]*(\.\d{0,2})?$/
                    },
                    {
                        name: 'Цена дилера 2',
                        nameSql: 'pricedealer2',
                        value: '',
                        pattern: /^[\d]*(\.\d{0,2})?$/
                    },

                    {
                        name: 'Вес брутто',
                        nameSql: 'weightbrutto',
                        value: '',
                        pattern:  /^[\d]*(\.\d{0,3})?$/
                    },
                    {
                        name: 'Вес нетто',
                        nameSql: 'weightnetto',
                        value: '',
                        pattern:  /^[\d]*(\.\d{0,3})?$/
                    },
                    {
                        name: 'Ширина',
                        nameSql: 'width',
                        value: '',
                        pattern: /^[\d]*(\.\d{0,3})?$/
                    },
                    {
                        name: 'Длина',
                        nameSql: 'length',
                        value: '',
                        pattern: /^[\d]*(\.\d{0,3})?$/
                    },
                    {
                        name: 'Высота',
                        nameSql: 'height',
                        value: '',
                        pattern: /^[\d]*(\.\d{0,3})?$/
                    },
                    {
                        name: 'Гарантийный срок',
                        nameSql: 'termGuarantee',
                        value: '',
                        pattern: /^[А-Яа-яЁёa-zA-Z0-9,\s]{2,50}$/
                    },

                    {
                        name: 'Код UKVD',
                        nameSql: 'ukvd',
                        value: '',
                        pattern:  /(?=(^([\w]){8,10}$))/
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


        methods:{
            onChangeData(index, status){
                this.controls[index] = status;

                let done = 0;

                for(let i = 0; i < this.controls.length; i++){
                    if(this.controls[i]){
                        done++;
                    }
                }

                this.done = done;

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
                     if(this.optCategories.length) {

                         let sa1='', sa2='';
                             for(let t=this.optCategories.length-1; t>=0; t--) {
                             sa1=this.optCategories[t].parentTitle;
                             sa2=this.optCategories[t].value;

                             if(!sec) {
                                 sec=`${sa1}":" ${sa2}`;
                                  } else

                            {
                                sec=`${sa1}":" ${sa2}","${sec}`;
                            }


                         }
                         isis1=`{" ${sec} "}`;

                        isis1.slice(1, -1);


                     } else {
                         isis1="";
                     }

                        let frame=new FormData();

                        frame.append('category_id',this.codeCategory);
                        frame.append('img',this.file);
                        frame.append('description', this.product.description.trim());

                        frame.append('new', this.product.new);
                        frame.append('hit', this.product.hit);
                        frame.append('sale', this.product.sale);
                        frame.append('class', this.product.classMod.trim());
                        frame.append('company', this.product.company.trim());
                        frame.append('packing', this.product.packing.trim());
                        frame.append('sclad', this.product.wareHouse);
                        frame.append('country', this.product.country.trim());
                        frame.append('type', this.product.typeTool);
                        frame.append('country', this.product.country.trim());
                        frame.append('groupTools', this.product.groupTools);
                         frame.append('exactlyType1', isis1);

                        for (let i = 0; i < this.info.length; i++) {
                         frame.append(this.info[i].nameSql,this.info[i].value.trim());
                        }


                        post(`/api/productAdd`, frame).then((res=>{
                            if (res.data.status) {

                                this.message='Новый продукт  успешно создан !';
                                this.$store.commit('optCategories/clearItems');
                                bus.$emit('message', {'message': this.message});
                                this.$router.push('/goods');
                            }


                        })).catch((err) =>{
                            if(err.response.status===422) {
                                this.error=err.response.data
                            }
                           this.message="Сохранить продукт не удалось !!!";
                            bus.$emit('message', {'message': this.message});
                            this.$router.push('/goods');
                        });

                }

            },








        },


        created() {
            for (let i = 0; i < this.info.length; i++) {
                this.controls.push(false);

            }

        }
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
