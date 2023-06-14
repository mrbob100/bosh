<template>  <!-- AppLeft -->
    <!-- lesson2   2object-reactive.html-->

    <div >

        <div class="form-group siema a"
             v-for="(item, key) in sections"
             :key="key">      <!-- родитедьские категории -->

            <button class="accordion" @click="accWork(key,item)" :class="{ active: isActive }">


                    <router-link class="recipe__inner sigma" :to="`/main/${item.id}`"  >

                      <a>   {{item.name}}  </a><!--вывод родительских категорий в левом меню -->

                    </router-link>   <!-- переход по id категории в AppMainCategories.vue для вывода изображений категорий в правой части-->


            </button>

                            <div v-if="isActive[key]">


                                    <ul class="lpanel">
                                        <router-link v-for="(category,  dig) in categories" :key="dig"

                                                     :to="`/category/${category.id}`"
                                                     tag="li"
                                                     class="list-group-item menu211"
                                                     active-class="active"
                                                      v-if="item.id===category.parent_id"
                                        >                                           <!-- active-class="active"  это подсветка -->
                                            <a>{{ category.name }} </a>   <!-- Это текст ссылки -->
                                        </router-link>
                                    </ul>

                            </div>



        </div>

    </div>


</template>

<script>

    import {mapGetters} from 'vuex';

    import { get } from '../../js/helpers/api';

    export default {
     //   props: {
      //      itembread : null
     //   },

        data(){
             return {
                 isActive : [],     // массив по всем категориям, узнать какая категория выбрана
                 prIsActive: false,
                 catId: '0',
                 bread: []

             }

        },


        methods:{
          accWork( index, item){

               if(!this.isActive[index])
               {
                  // this.isActive[index].push('true')
                   if(this.prIsActive=='true')   //  если категория выбрана раньше
                   {

                       for(let i=0; i<this.isActive.length; i++)
                       {
                           if(this.isActive[i]=='true'){
                               this.$set(this.isActive,i,'');  //  обнуление активной категории
                               this.prIsActive='false';
                           }
                       }
                   }

                   this.$set(this.isActive,index,'true'); // если категоря выбирается

                   this.prIsActive='true';
    //________________________________________________________________________________________
                   // ввод breacrumb
   //_________________________________________________________________________________________

                  this.$store.commit('bread/minus', item.name);


               }
               else
                   {
                        this.$set(this.isActive,index,'');
                       this.prIsActive='false';

                   }

                this.$emit('changeId',item.id);  // изменилась категория


          },

        },

        computed: {
            ...mapGetters('left', {
                sections:'sections',
                categories:'categories'
            }),

            ...mapGetters('bread', {breadcrumbList: 'bread'})
        },


        created(){



            get(`/api/left`).then((res=> {
                let mix=[], tet;

                 mix = res.data.categories;
              tet = accordeon(mix);

                this.$store.dispatch('left/loadItems',  // загрузка меню
                  tet
                );

            }));

            function accordeon( mix='')
            {
              let  highCategories=[],
                    childObject=[],
                    categoriesResult = [];

                for (let i = 0; i < mix.length; i++) {
                    if (mix[i].parent_id =='0') {
                        highCategories.push(mix[i]);

                    } else {
                        childObject.push(mix[i]);
                    }
                }


                   mix='';
                for(let i=0; i<highCategories.length; i++)
                {
                    for (let j = 0; j < childObject.length; j++)
                    {

                        if (childObject[j].parent_id === highCategories[i].id)
                        {
                            categoriesResult.push(childObject[j]);


                        }


                    }
                }


               return { highCategories, categoriesResult };



                /*  mapActions('left',{
                 closes: 'loadItems',
                   categories: 'loadCategories'
                  })*/
             //  mix= [ highCategories, categoriesResult] ;
             //   return mix;


            }

        }

}


</script>


<style scoped>
  /*  .siema {
        z-index: 1000;
    } */

    .accordion a{
      /*  margin-left: 8px; */
       padding-left: 5px;
        color:black !important;
        font-size: 1.1em;

    }
  @media  (min-width: 768px) and (max-width: 979px) {
      .accordion a {
          font-size: 1em;
      }
  }
    @media  (max-width: 767px) {
        .accordion a {
            font-size: 0.95em;
        }

    }
 .menu211{
   /* margin-left: 0.5em; */
    color:#005691 !important;
    font-size: 1em;
     padding: 5px 20px!important;
     min-width: 120px;


}
  .lpanel a{
      color:#005691;
      padding: 0;
  }
    .fade-enter{
        opacity: 0;
    }

    .fade-enter-active{
        animation: slideIn 2.5s;
    }

    .fade-enter-to{

    }

    .fade-leave{

    }

    .fade-leave-active{
        animation: slideOut 2.5s;
    }

    .fade-leave-active{

    }

</style>
