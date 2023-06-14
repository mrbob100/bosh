<template>
    <div>
        <h3> {{message}}</h3>
        <div class="wrap">
            <div class="wrap1">
                <button class="btn btn-success" @click="cabinet()"  >В кабинет</button>
            </div>
            <div class="wrap2">
                <button class="btn btn-success" @click="main()"  >На главную</button>
            </div>
        </div>

    </div>
</template>

<script>
    import {post} from '../../js/helpers/api';
    import {mapGetters} from 'vuex';

    export default {
        name: "AppOut",
 data() {
     return  { user_id: null ,
                 message: ''
            }
 },

        computed : {
            ...mapGetters ('cart',['products']),
            cabinet() {
                this.$router.push('/cabinet');
            },

            main() {
                this.$router.push('/slider');
            }


        },

        mounted() {

            this.user_id= parseInt( localStorage.getItem('user_id'));

          let data={ 'user':this.user_id, 'products':this.products };
          // post(`/api/cabinet/${this.user_id}`,this.products).then((res) =>

               post(`/api/cart`,data).then((res) =>
                {


                  if(res.data.status)
                  {
                      this.message='Ваш заказ принят !';
                  }
                });
        }
    }
</script>

<style scoped>
    .wrap{
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
    }

</style>
