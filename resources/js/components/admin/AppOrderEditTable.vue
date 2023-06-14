<template>

        <div>
            <h5> Я в таблице корректировки заказа</h5>
            <table class="table table-striped table-bordered" >

                <thead>
                <tr>
                    <th>№ заказа</th>
                    <th>Покупатель</th>
                    <th>Статус</th>
                    <th>Менеджер</th>
                    <th>Количество</th>
                    <th>Сумма</th>

                    <th>Дата</th>
                    <th>Дата изменения</th>


                </tr>
                </thead>

                <tbody >
                <td>{{ records.id}}</td>
               <td>{{records.users.name}}</td>


               <td>

                <select   class="form-control inside" id="parent" v-model="selected"  >
                    <option value="0">Не выбран</option>
                    <option value="1">В работе</option>
                    <option value="2">Обработан</option>
                    <option value="3">Отправлен</option>


                </select>
               </td>

                <td>

                    <input type="text"
                           class="form-control form-control-sm"
                           v-model="manager"

                    >
                </td>




                <td>{{quantity}}</td>
                <td>{{resultMain}}</td>



                <td>{{records.created_at}}</td>
                <td>{{records.updated_at}}</td>


                </tbody>

   <!-- ________________________________________________________________________________________________________________   -->
                <br/>
                <br/>
                <thead>
                    <tr>
                        <th>Код товара</th>
                        <th> Наименование</th>
                        <th> Количество</th>
                        <th>Цена</th>
                        <th> Сумма</th>
                        <!--th>Удалить</th-->
                    </tr>

                </thead>
                <tbody>

                <tr v-for="(record, idx) in records.order_items" :key="record.id">

                   <td>{{record.code}}</td>
                    <td>{{record.name}}</td>

                    <td>
                        <input type="number"  @click="overCount(idx)" min="0"
                               class="form-control form-control-sm"
                              v-model="qty_item[idx]"

                        >
                    </td>
                    <td>
                        <input type="text"  @click="overCount(idx)" pattern="\d+(\.\d{0,2})?" title="Дробные значения с точкой"
                               class="form-control form-control-sm"
                               v-model="price[idx]"

                        >
                    </td>

                    <td>{{resultSubMain[idx]}}</td>

                    <!--td>
                        <button @click="deleteOrder(record.id)"> <i class="fas fa-trash-alt"></i></button>
                    </td-->

                </tr>

                </tbody>

            </table>
            <button class="btn btn-primary" @click="moveToServer">
                Отправить данные
            </button>
        </div>

</template>

<script>
    import { get, post } from '../../helpers/api';
    import AppInput from "../AppInput";
    import { bus } from '../../helpers/bus.js'


    export default {
        name: "AppOrderEditTable",
        components: {AppInput},

        data() {
            return {
               quantity:0,
                selected:'',
               records: {},
                error: '',
                id: 0,
                status:'',
                qty_item: [],
                price: [],
                manager: '',
                resultMain :'',
                resultSubMain: [],
                    order_items: [],
                server : {
                   id: 0,
                    user_id:0,
                    qty:0,
                    sum: 0,
                    status: '',
                    manager: '',

                }



              /*  info:[
                        {
                            name: 'Цена',
                                nameSql: 'price',
                            value: '',
                            pattern:  /^[\d]*(\.\d{0,2})?$/
                        },
                    {
                        name: 'Количество',
                        nameSql: 'qty_item',
                        value: '',
                        pattern:  /^\d+/
                    },

                    ], */


            }
        },

        computed: {
            overCount(id) {


            let size=this.price.length;
            this.resultMain=0;
            let col=0;
            for(let i=0; i<size; i++) {
                this.resultMain+= this.qty_item[i]* this.price[i];
                this.resultSubMain[i]= this.qty_item[i]* this.price[i];
                 col+=this.qty_item[i]*1;
            }
            this.quantity=col;
            }

        },

        methods: {

            moveToServer(){
               /* let frame=new FormData();
                frame.append('id', this.id);
                frame.append('user_id', this.records.user_id);
                frame.append('qty', this.quantity);
                frame.append('sum', this. resultMain);
                frame.append('status', this.selected);
                frame.append('manager', this.manager);  */
               this.server.id=this.id;
                this.server.user_id=this.records.user_id;
                this.server.qty=this.quantity;
                this.server.sum=this. resultMain;
                this.server.status=this.selected;
                this.server.manager=this.manager;



                let kk=this.order_items.length;
                for(let i=0; i<kk; i++) {
                    this.order_items[i].qty_item = this.qty_item[i];
                    this.order_items[i].price = this.price[i];
                    this.order_items[i].sum_item = this.resultSubMain[i];

                }

               // frame.append('product',this.order_items, Blob);
                let asa={'server': this.server, 'products': this.order_items };
                post(`/api/orderEdit/${this.id}`, asa).then((res=>{
                    if (res.data.status) {

                        this.message='Заказ успешно изменен !';
                        this.$store.commit('optCategories/clearItems');
                        bus.$emit('message', {'message': this.message});

                    }


                })).catch((err) =>{
                    if(err.response.status===422) {
                        this.error=err.response.data
                    }
                    this.message="Измененить заказ не удалось !!!";
                    bus.$emit('message', {'message': this.message});

                });
                this.$router.push('/categories');

                }


        },
         created() {
             this.id= this.$route.params.id;
             get(`/api/orderEdit/${this.id}`).then((res => {

                 if (res.data.status) {
                     this.records = res.data.orders;

                    let kk=this.records.order_items.length;

                     for(let i=0; i<kk; i++){
                         this.order_items.push(false);

                         this.qty_item.push(false);
                         this.price.push(false);
                         this.resultSubMain.push(false);
                         //this.$set(this.qty_item,'i',this.records.order_items[i].qty_item);
                        // this.$set(this.price,'i',this.records.order_items[i].price);

                     }
                     this.resultMain=0;
                     let col=0;

                     for(let i=0; i<kk; i++){
                         this.order_items[i]=this.records.order_items[i];
                         delete this.order_items[i].created_at;
                         delete this.order_items[i].updated_at;
                         this.qty_item[i]=this.records.order_items[i].qty_item;
                         this.price[i]=this.records.order_items[i].price;
                         this.resultSubMain[i]= this.qty_item[i] * this.price[i];
                         this.resultMain+= this.resultSubMain[i];
                         //this.$set(this.qty_item,'i',this.records.order_items[i].qty_item);
                         // this.$set(this.price,'i',this.records.order_items[i].price);
                         col+=this.qty_item[i];
                     }
                     this.quantity= col;
                    this.selected= this.records.status;
                     this.manager=this.records.manager;




                 }
             })).catch((err) => {
                 if (err.response.status === 422) {
                     this.error = err.response.data
                 }

             });

         }
    }
</script>

<style scoped>
.inside{
    background-color: yellow;
    font-size: 90%;
}
</style>
