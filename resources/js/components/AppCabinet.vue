<template>
    <div>
      <div class="split">
        <template  class="prune" v-if="sign">
             <div class="pig">
                     <div> <h1 > Вывод данных  личного кабинета  user: {{(orders[0].users.name)}}</h1></div>

                     <div class="pg">

                            <div class="inner">
                                <P>№ заказа</P>
                            </div>

                            <div class="inner">
                                <p>Количество</p>
                            </div>
                            <div class="inner">
                                <p>Сумма</p>
                            </div>

                            <div class="inner">
                                <p>Статус</p>
                            </div>

                            <div class="inner">
                                <p>Дата заказа</p>
                            </div>

                      </div>
             </div>


                    <div class="panel" v-for="(it, key) in orders"  :key="key">
                        <div class="first">

                            <div class="class fd">
                                {{ it.id}}
                            </div>

                            <div class="class fd">
                                {{ it.qty}}
                            </div>

                            <div class="class fd">
                                {{ it.sum}} гр.
                            </div>

                            <div class="class fd">
                                {{it.status}}
                            </div>

                            <div class="class fd" >
                                {{ it.created_at.slice(0,10)}}

                            </div>
                        </div>
                        <div class="second">
                             <div class="panel2" v-for="(str, gt) in it.order_items" :key="gt">

                                 <div class="lank"> {{str.name }}</div>
                                 <div class="lank">{{str.price }} гр.</div>

                                 <div class="lank">{{str.qty_item}} ед.</div>



                                 <hr/>
                             </div>
                        </div>
                    </div>

        </template>

       </div>

     </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import { post } from '../../js/helpers/api'

    export default {
        name: "AppCabinet",
        data () {
            return {
                user_id: null,
                message: '',
                sign: false
            }
        },

        computed: {
           ...mapGetters('cabinet',['orders','intervals'])

       },

        created() {

            this.user_id= parseInt( localStorage.getItem('user_id'));

            let data={ 'user':this.user_id};


           post(`/api/cabinet/`,data).then((res) =>
            {
                let mix=[];
                console.log('возврат', res.data);
                if(res.data.success)
                {
                     if(res.data.records) this.sign=true;
                    this.message='Ваш заказ принят !';
                     mix=[res.data.records, res.data.data];
                    this.$store.dispatch('cabinet/loadItems',  mix );
                }

                const war=document.querySelector('.wrap1 .wrap01');
                war.setAttribute('style', 'display: none');
                const war1=document.querySelector('.wrap02');
                war1.setAttribute('style', 'width: 100%');

            });
        },



    }
</script>

<style scoped>

    .prune {
        display: flex;
        flex-direction: column;
    }

   .pig{
        position: fixed;
        top: 191px;
        width: 80%;
        font-size: 1em;
        z-index: 10;
        height:auto;
        background-color: #0c7fd7;
       display: flex;
       flex-direction: column;
       color: white;

    }
   .pg {
       display: flex;
      flex-direction: row;
       justify-content: space-around;
       width: 100%;
       flex-wrap: wrap;
   }
     .pig h1{
         font-size: 1.4em;
         padding: 10px 20px;
         text-align: center;
     }

     .panel{
         display: flex;
         flex-direction: column;
         margin-top: 70px;
         margin-left: 30px;
     }
      .first{
          display: flex;
          flex-direction: row;
          justify-content: space-around;
          width: 100%;
          flex-wrap: wrap;
      }

     .second .panel2{
         display: flex;
         justify-content: space-around;
         width: 60%;
         flex-wrap: wrap;
        background: #e4b9b9;

     }
    .second .panel2 .lank {
        width: 30%;
    }



</style>
