<template>
    <div>
        <h3> Я в категории AppProductEdit</h3>
        <div v-cloak v-show="!loaded">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>

        </div>
        <form>
            <div class="twice">
                <div class="single1">

                    <div class="form-group " >           <!-- Ввод категории -->
                        <label for="parent">Изменить категорию !</label>
                        <select   class="form-control inside" id="parent" v-model="selected"   @change="changeCategory" >
                            <option >Без категории</option>
                            <option v-for="(category, index) in categories "
                                    :value="category.name"
                                    :key="index"
                                    :index="category.id"

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



                    <!--вывод строк продукта - имя, описание, цена ... -->
                    <hr>
                    <app-edit-product-out :lists="lists"
                                             :file="file"
                                             :codeCategory="codeCategory"
                                          :id="id"
                                          :picture="picture"
                                          @myEvent="changeCategory"
                    />



                </div>


                <!--________________________________________________разделитель второй колонки____________________________________-->
                <!--   вывод атрибутов power, idle ...            -->
                <div class="single2">
                    <div class=" charactersList ">
                        <div v-for="(item,ind) in optionMain"
                             :key="ind" v-if="priznak"
                             class="listInside"
                        >
                            <app-edit-substitute :cartworries="item"
                                                      :soname="massive[ind]"


                            />


                        </div>
                    </div>
                </div>
                <!--______________________________________________________________________________________________________________-->
            </div>
        </form>
    </div>
</template>

<script>
    import { get } from '../../helpers/api';
    import appUpload from './AppUpload';
    import AppEditProductOut from './AppEditProductOut'
    import {mapGetters} from 'vuex';
    import category from "../../store/modules/category";
   // import AppEditSelectAttr from "./AppEditSelectAttr";
   // import AppSelectionCategories from './AppSelectionCategories'
    import AppEditSubstitute from './AppEditSubstitute'


    export default {
        name: "AppProductsAdd",

        components: {
           // AppEditSelectAttr,
           // AppSelectionCategories,
            AppEditSubstitute,
            AppEditProductOut,
            appUpload
        },

        data() {
            return {
                selected:'Самостоятельная категория',
                name: '',
                massive:[],
                priznak: false,
                optionMain: [],
                loaded :false,
                file: '',
                codeCategory: 0,
                category: '',
                id: 0,
                picture: false,
                exactlyType1 : '',
                baseSelected: [],
                error: '',

                info:  [
                    { id:7, categories:['power', 'rotationspeed','diametrdisk','spindle' ]},
                    { id:9, categories:['power', 'rotationspeed','diametrdisk','holediameter' ]},
                    {  id: 10, categories:[ 'power', 'voltage', 'capacity','impact', 'idle', 'spindle','cartridge', 'rotationspeed',
                            'maxhole', 'qntimpact']},
                    {  id: 12, categories:[ 'power', 'voltage', 'capacity','impact', 'idle', 'spindle','cartridge', 'rotationspeed',
                            'maxhole', 'qntimpact']},
                    { id:13, categories:['power', 'rotationSpeed','cartridge','holediameter' ]},
                    { id:15, categories:['power', 'strokeLength', 'cutmatdepth', 'workingwidth', 'idle']},
                    { id:16, categories:['voltage', 'idle']},
                    { id:18, categories:['power', 'idle','steel', 'oscillationangle','rotationspeed','diametrdisk','performance' ]},
                    { id:19, categories:['power', 'impact', 'qntimpact']},
                    {  id: 20, categories:['power', 'voltage', 'capacity','impact', 'idle', 'spindle','cartridge', 'rotationspeed',
                            'maxhole', 'qntimpact']},
                    { id:21, categories:['power','rotationspeed', 'diametrsisk', 'spindle', 'performance']},
                    { id:22, categories:['power','rotationspeed', 'diametrdisk', 'spindle', 'performance']},
                    { id:23, categories:['power', 'rotationSpeed','cutmatDepth','cutEdgeWidth' ]},
                    { id:24, categories:[  'power','rotationspeed', 'strokelength', 'grindplate', 'idle',  'capacity','holestand',
                            'diametrdisk', 'cutmatdepth']},
                    { id:26, categories:['power', 'voltage','airflow','turbinpower', 'containervol','maxdischarge' ]},
                    { id:27, categories:['power', 'rotationspeed', 'diametrdisk','spindle']},
                    { id:28, categories:['power', 'airflow', 'temperature']},
                    { id:30, categories:['power','rotationspeed', 'diametrdisk', 'spindle', 'performance']},
                    { id:31, categories:[  'power', 'rotationspeed', 'strokeLength']},
                    {  id: 32, categories:[ 'power', 'voltage', 'capacity','impact', 'idle', 'spindle','cartridge', 'rotationspeed',
                            'maxhole', 'qntimpact']},


                    { id:33, categories:['power','rotationSpeed', 'diametrdisk', 'spindle', 'performance']},
                    { id:34, categories:['power', 'diametrdisk','cutdepth','strokelength', 'grindplate', 'workingwidth', 'holestand']},
                    { id:37, categories:['calculation', 'measurange', 'accuracy', 'accuracyslope', 'goaldistance', 'defence',
                            'measurenumber', 'typeaccuracy', 'display', 'unit', 'android','iphone']},
                    { id:38, categories:['functional', 'measurange', 'accuracy', 'display', 'goaldistance', 'defence','powersupply' ]},
                    { id:39, categories:[ 'measurange', 'accuracy']},
                    { id:40, categories:[ 'display', 'accuracy','wheeldiameter']},
                    { id:41, categories:[ 'defence', 'measurange','display', 'accuracy','angle', 'shankrange', 'powersupply']},
                    { id:42, categories:[  'measurange','accuracy']},
                    { id:46, categories:[  'thread']},
                    { id:54, categories:[  'qntimpact','gluediameter']},
                    { id:55, categories:['power', 'airflow']},
                    { id:56, categories:[  'power', 'idle','voltage', 'rotationspeed', 'oscillationangle']},
                    { id:57, categories:[  'capacity', 'idle', 'voltage', 'diametrdisk','oscillationangle','spindle','vibration']},
                    { id:59, categories:[  'ignition','temperature', 'rotationspeed']},
                    { id:60, categories:[  'power', 'rotationspeed']},
                    { id:62, categories:[  'voltage', 'capacity','chargetime']},
                    { id:74, categories:[  'power', 'rotationspeed']},

                    { id:78, categories:[  'power','containerVol', 'powersupply','turbinpower', 'chargetime']},
                    { id:86, categories:[  'containervol', 'glueLength', 'gluediameter']},
                    { id:99, categories:['power', 'voltage', 'capacity']},
                    { id:102, categories:['power', 'rotationspeed']},
                    { id:103, categories:[  'power','holestand']},
                    { id:106, categories:[  'measurange','accuracy']},
                    { id:100, categories:['power', 'voltage', 'capacity', 'brightness']},
                    { id:230, categories:[ 'voltage', 'capacity', 'diametrdisk', 'spindle','rotationspeed', 'idle']},
                    { id:235, categories:[ 'voltage', 'capacity', 'diametrdisk', 'spindle','rotationspeed', 'idle']},
                    { id:302, categories:[ 'power','impact', 'capacity', 'qntimpact','frequency','cartridge','vibration',
                            'holediametr', 'idle']},
                    { id:305, categories:['power', 'rotationspeed','screw', 'cartridge', 'spindle']},
                    { id:315, categories:[  'power','rotationspeed', 'voltage','containervol','gluelength','accumulatortype', 'temperature',
                            'performance']},

                ]
            }
        },

        computed: {
            ...mapGetters('lists', {
                lists: 'lists'
            }),
            ...mapGetters('bread', {breadcrumbList: 'bread'}),

            ...mapGetters('categories', {
                categories: 'categories'
            }),

            ...mapGetters('article', {
               article: 'article'
            }),


        },

        methods: {
            changeCategory() {

               this.priznak=!this.priznak;
                let a1=this.categories.find(c=>c.name===this.selected).id;
                let a, inv=[],j=0,rez='', lus='';
                inv=this.info.find(c=>c.id===a1).categories;
                this.codeCategory=a1;
                a=this.selected;
                inv.forEach((category)=>{
                    lus={'id':j, 'name': category};
                    this.massive.push(lus);


                    rez=this.lists[category];
                    this.optionMain.push(rez);

                    j++;

                });



            },


            changeFile(e){

                this.file=e;

            },

            changeImage(){
                this.picture=true
            },

            changeLetters(res) {
                let mass=[], sas='', promNick='',promName='',out=[];
                res.forEach((spr,i)=>{

                   let long=spr.length ;
                    for(let k=0; k<long; k++) {
                        mass[k]=false;
                    }
                   for(let j=0; j<long; j++){
                       promNick=spr.nick.trim().toLowerCase();
                       promName=spr.name.trim().toLowerCase();
                       sas={'nick': promNick, 'name':promName};
                       mass[j]=sas;
                   }
                   this.$set(out,i, mass);
                });
                return out;
            }

        },

        created() {
           this.id= this.$route.params.id;
            get(`/api/productEdit/${this.id}`).then((res => {

                if (res.data.status) {

                    let product=res.data.product;  //вывод продукции

                    this.$store.dispatch('article/loadItems', product);
                    this.selected=res.data.picture;
                    this.file=product.img;
                    let a3=product.exactlyType1;
                    this.exactlyType1=product.exactlyType1;
                    let a1=[], a2='', sa='', sas='';
                    let name='',value='';
                    sa=a3;
                    sa=JSON.parse(a3);
                   a2=Object.entries(sa);

                    this.$store.commit('optCategories/clearItems');
                    for(let i=0; i<a2.length; i++) {
                        name=a2[i][0]; value=a2[i][1];
                        sas={'parentTitle': name, 'value':value};
                        this.$store.dispatch('optCategories/loadItems', sas);


                    }

                    let lists1 = '', lists=res.data.data;
                   // lists1=this.changeLetters(res.data.data);

                    this.$store.dispatch('lists/loadItems',  // загрузка справочников под категорию option
                        lists
                    );

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
                if (err.response.status>400) {
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
    .twice{
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        /*font-size: 99%; */

    }
    .single1 {
        width:600px;

    }
    .single2 {
        width:300px;
        /*font-size: inherit; */
    }
    .single1{
        font-size: inherit;
    }
    .single2{
        font-size: 110%;
    }
    .inside{ font-size: 99%}
    .charactersList{
        background: none;
        outline: none;
    }

</style>

