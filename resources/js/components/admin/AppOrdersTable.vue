<template>
    <div>
        <table class="table table-striped table-bordered" >

            <thead>
            <tr>
                <th>№ заказа</th>
                <th>Покупатель</th>
                <th>№ телефона</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
                <th> Удалить</th>
            </tr>
            </thead>

            <tbody >

                    <tr v-for="(record, idx) in records" :key="record.id">
                        <td>{{ record.id}}</td>
                        <td><router-link :to="`/admin/orderEdit/${record.id}`"> {{record.users.name}}</router-link>
                        <td> {{record.users.phone}}</td>
                        <td> {{record.qty}}</td>
                        <td> {{record.sum}}</td>
                        <td> {{record.users.status}}</td>
                        <td> {{record.created_at}}</td>
                        <td>
                            <button @click="deleteProduct(record.id)"> <i class="fas fa-trash-alt"></i></button>
                        </td>

                    </tr>

            </tbody>

        </table>
    </div>
</template>

<script>
    import  {post} from '../../helpers/api'
    import { bus } from '../../helpers/bus.js'

    export default {
        name: "AppOrdersTable",

        props: {
            records: {
                required: true,
                type: Array
            }
        },

        data() {
            return {
                message: ''
            }
        },


        methods: {

            deleteProduct(id) {
                let del= 'true';
                let frame=new FormData();
                frame.append('delete',del);
                post(`/api/productEdit/${id}`,frame).then(res=>{
                    if(res.data.status) {
                        this.message='Продукт успешно удален !';
                        bus.$emit('message', {'message': this.message});
                    }

                }).catch((err)=>{
                    if(err.response.status===422) {
                        this.error=err.response.data
                    }
                    this.message="Удалить продукт не удалось !!!"
                    bus.$emit('message', {'message': this.message});
                });

            }
        }
    }
</script>

<style scoped>
    th{
        margin-left:  25px;
        padding: 15px;
    }
    td {
        margin-left:  25px;
        padding: 15px;
    }
    td img {
        height: 50px; width: 50px;
    }
</style>
