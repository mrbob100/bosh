<template>
    <div>

        <table class="table table-striped table-bordered" >

            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Изображение</th>
                <th>Категория</th>
                <th>Название</th>
                <th>Цена</th>
                <th> Удалить</th>
            </tr>
            </thead>

            <tbody >

            <tr v-for="(record, idx) in records" :key="record.id">
                <td>{{ record.id}}</td>
                <td> <img :src="`/images/${record.img.mini}`" ></td>
                <td> {{record.categories.name}}</td>
                <td><router-link :to="`/admin/productEdit/${record.id}`"> {{record.name}}</router-link>
                <td>{{record.price}}</td>
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
        name: "AppProductsTable",
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
                        this.$router.push('/goods');
                    }

                }).catch((err)=>{
                    if(err.response.status===422) {
                        this.error=err.response.data
                    }
                    this.message="Удалить продукт не удалось !!!"
                    bus.$emit('message', {'message': this.message});
                    this.$router.push('/goods');
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
