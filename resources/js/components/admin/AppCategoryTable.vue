<template>
  <div>

    <table class="table table-striped table-bordered">

         <thead>
         <tr>
             <th>№ п/п</th>
             <th>Родительская категория</th>
             <th>Категория</th>
             <th>Изображение</th>
             <th>Коректировка</th>
             <th>Удалить </th>
         </tr>
         </thead>

           <tbody >

               <tr v-for="(record, idx) in records" :key="record.id">
                   <td>{{ record.id}}</td>
                   <td> {{record.parent_id}}</td>
                    <td> {{record.name}}</td>
                    <td>  <img :src="`/images/${record.img}`" ></td>
                    <td>
                        <router-link :to="`/admin/categoryEdit/${record.id}`">  <i class="fa fa-book fw">  </i></router-link>
                    </td>
                   <td>

                       <button @click="deleteCategory(record.id)"> <i class="fas fa-trash-alt"></i></button>
                   </td>
               </tr>

           </tbody>

       </table>


  </div>

</template>

<script>

    import {del, post} from '../../helpers/api';
    import { bus } from '../../helpers/bus.js';
    import  {mapGetters} from 'vuex';


    export default {
        name: "AppCategoryTable",

        props: {
            records: {
                required: true,
                type: Array
            }

        },

        computed: {
            ...mapGetters('bread', {breadcrumbList: 'bread'}),
        },

        methods: {
            deleteCategory(id) {
                let del= 'true';
                let frame=new FormData();
                frame.append('delete',del);
                post(`/api/categoryEdit/${id}`,frame).then(res=>{
                    if(res.data.status) {
                        this.message='Категория успешно удалена !';
                        bus.$emit('message', {'message': this.message});
                        this.$router.push('/categories');
                    }

                }).catch((err)=>{
                    if(err.response.status===422) {
                        this.error=err.response.data
                    }
                    this.message="Удалить категорию не удалось !!!";
                    bus.$emit('message', {'message': this.message});
                    this.$router.push('/categories');
                });

             }

        }


    }
</script>

<style scoped>
  /* th{
        margin-left:  25px;
        padding: 15px;
    }
    td {
        margin-left:  25px;
        padding: 15px;
    } */
td img {
   height: 50px; width: 50px;
}

</style>
