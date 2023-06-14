/* js/App.vue  */
<template>
  <div>
    <div v-cloak v-if="!spinner">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>

    </div>
        <span v-cloak v-else>
              <app-header v-if="!admin"

              ></app-header>
             <app-admin v-else></app-admin>
        </span>

  </div>


</template>



<script>
   import AppHeader from './components/AppHeader'
   import AppAdmin from './components/admin/AppAdmin'


export default {
    components: {
        AppHeader,
        AppAdmin
    },
    data() {
        return {
            admin: false,
            spinner: false
        }
    },
    methods: {
       /* onChangeData(a) {

            this.admin=true;
        },*/

    },
    created(){
        this.$store.commit('auth/remove');
    },
    mounted() {
      //  this.$root.$on('changeStatus', this.onChangeData(a));
        this.$root.$on('changeStatus', a=>{this.admin=a;});

        document.onreadystatechange = () => {
            if (document.readyState == "complete") {
                setTimeout(()=>(this.spinner=true), 300)

            }
        }

    }


}
</script>
<style scoped>

    [v-cloak] {display: none!important;}

  /*  [v-cloak] .v-cloak--block {
        display: block!important;
    }


*/
i {
    color: #843534;
   margin: 0 auto;
   /* height: 100vh; */
    width: 100%;
}
</style>
