<template>
    <div>
        <h3>Ваш заказ</h3>
     <table>
         <thead>
         <tr>
             <th>Фото</th>
             <th>Код товара</th>
             <th>Наименование</th>
             <th>Кол-во</th>
             <th>Цена</th>
             <th>Сумма</th>
             <th>Х</th>
         </tr>
         </thead>
         <tbody>


                 <tr v-for="(lit,  key) in products" :key="key" >
                     <td class="left"> <img :src="`/images/${lit.product.img.max}`" v-if="lit.product.img.max"  alt="img"/></td>
                     <td>{{lit.product.code}}</td>
                     <td>{{ lit.product.name}}</td>
                    <td> {{lit.cnt}}</td>
                     <td>{{lit.product.price}}</td>
                     <td>{{sum}}</td>
                     <td>X</td>
                 </tr>


         </tbody>
     </table>

        <div class="mount"> Итого: <span> </span> </div>  <!-- Общее количество-->
        <div class="mountsum">На сумму:<span>{{sum}} </span></div>    <!-- Общея сумма-->


        <div class="share-buttons">
            <div class="linkedin share-block">
                <button @click="AuthProvider('github')"> <i class="fa fa-linkedin" aria-hidden="true"></i></button>
            </div>
            <div class="linkedin share-block">
                <button @click="AuthProvider('facebook')"><i class="fa fa-facebook" aria-hidden="true"></i></button>
            </div>
            <div class="linkedin share-block">
                <button @click="AuthProvider('google')"> <i class="fa fa-google-plus" aria-hidden="true"></i></button>
            </div>
            <div class="linkedin share-block">
                <button @click="AuthProvider('twitter')"> <i class="fa fa-twitter" aria-hidden="true"></i></button>
            </div>
        </div>

        <div class="wrapper">
            <div class="sample">
                <form @submit.prevent="register" v-if="!formSubmited">
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
                    <button class="btn btn-primary" :disabled="done < info.length">
                        Send Data
                    </button>
                </form>
                <div v-else>
                    {{form.name}}
                    {{form.email}}
                    {{form.password}}
                    {{form.phone}}
                   user: {{user_id}}
                   role: {{role_id}}

                    <!--table class="table table-bordered">
                        <tbody>
                        <tr v-for="(item, index) in  info">
                            <td>{{ item.name }}</td>
                            <td>{{ item.value }}</td>
                        </tr>
                        </tbody>
                    </table-->

                </div>
            </div>
        </div>


    </div>

</template>

<script>
    import appInput from './AppInput';
    import {mapGetters} from 'vuex';
    import Flash from '../../js/helpers/flash'
    import { post } from '../../js/helpers/api'
    import Auth from '../../js/store/modules/auth'

    export default {
        name: "AppOrder",



        data(){
            return {
                info: [
                    {
                        name: 'Name',
                        value: '',
                        pattern: /^[a-zA-Z ]{2,30}$/
                    },
                    {
                        name: 'Phone',
                        value: '',
                        pattern: /^[0-9]{7,14}$/
                    },
                    {
                        name: 'Email',
                        value: '',
                        pattern: /.+@.+\..+/i
                    },
                   /* {
                        name: 'Адрес',
                        value: '',
                        pattern: /[A-Za-z0-9'\.\-\s\,]/
                    }, */
                    {
                        name: 'Пароль',
                        value: '',
                        pattern: /.+/
                    }
                ],
                controls: [],
                done: 0,
                formSubmited: false,
                isProcessing: false,
                error : {},
                user_id: null,
                role_id: null,
                form : {
                    name: '',
                    phone: '',
                    email: '',
                    password: ''
                }
            }
        },        computed: {

            ...mapGetters ('cart',['products']),


            sum(){
                let as=0;
                this.products.forEach( function(el){
                    as += el.product.price * el.cnt ;
                });
                return as;
            },
            progressWidth(){
                return {
                    width: (this.done / this.info.length * 100) + '%'
                }
            }

        },
        created() {
            for (let i = 0; i < this.info.length; i++) {
                this.controls.push(false);
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
            AuthProvider(provider) {

                let self = this;

                this.$auth.authenticate(provider).then(response =>{

                    self.SocialLogin(provider,response)
                }).catch(err => {

                })
            },

            SocialLogin(provider,response){
                this.$http.post('/sociallogin/'+provider,response).then(response => {

                }).catch(err => {
                    if(err.response.status===422) {
                        this.error=err.response.data
                    }
                })
            },

            register() {

                this.formSubmited =true;
                this.form.name=this.info[0]['value'];
                this.form.phone=this.info[1]['value'];
                this.form.email=this.info[2]['value'];
                this.form.password=this.info[3]['value'];

                    this.error ={};

                    post(`/api/register`,this.form).then((res) =>
                    {



                        if(res.data.status)
                        {

                            this.role_id=res.data.role_id;
                            this.user_id=res.data.user_id;
                           localStorage.setItem('api_token',res.data.token);
                            localStorage.setItem('user_id',this.user_id);
                            localStorage.setItem('role_id',this.role_id);
                            let tet =[res.data.token, this.user_id, this.role_id];
                            this.$store.commit('auth/api_token',tet);

                        //    Auth.set(res.data.token, res.data.user_id, res.data.role_id);
                           Flash.setSuccess('You have successfully created an Account!');
                            this.$router.push('/out');

                        /*    if(res.data.name!=='admin' || res.data.role_id!==2)

                            {
                                this.$router.push('/cart')
                            }
                            */
                        }

                    })
                        .catch((err) =>{
                            if(err.response.status===422) {
                                this.error=err.response.data
                            }
                            this.isProcessing=false
                        })


            }
        },

components : {
            appInput
},

    }

</script>





<style scoped>

    .wrapper{
        max-width: 600px;
        margin: 20px auto;
    }
    table {
        width: 100%; /* Ширина таблицы */
        background: white; /* Цвет фона таблицы */
        color: black; /* Цвет текста */
        border-spacing: 1px; /* Расстояние между ячейками */
    }
    td, th {
        background-color: #E1E1E2;/* Цвет фона ячеек */
        padding: 5px; /* Поля вокруг текста */
    }
    .left img{
        width:6em; height: auto;

    }
    .share-buttons{
        max-width: 300px;
        margin:0 auto;
    }
    .share-block{
        display: inline-block;
        background: #fff;
        width: 30px;
        height: 30px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        text-align: center;
        transition: 0.5s;
    }
    .share-block:hover{
        animation: share-animation 0.82s cubic-bezier(.36,.07,.19,.97) both;
        border-color: #0c7fd7;
    }


    .share-block i{
        font-size: 12px;
        position: relative;
        top: 5px;
    }

    .fa-linkedin {
        color: #0976b4;
    }
    .fa-facebook {
        color: #3b5998;
    }
    .fa-google-plus {
        color: #d73925;
    }
    .fa-twitter {
        color: #55acee;
    }



</style>
