<template>
    <div class="breadcrumb">
        <ul>
            <li v-for="(breadcrumb, idx) in breadcrumbList"
                :key=idx
                @click="routeTo(idx)"
                :class="{'linked': !! breadcrumb.link }">

                <p> {{ breadcrumb.name }} </p>

            </li>

        </ul>


    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "AppBreadcrumb",
        data() {
            return  {
                changeId: 0,
                message: '',
                perk: false,
                widthScreen: false

            }

        },
        computed: {

            ...mapGetters('bread', {
                breadcrumbList: 'bread'
            }),

        },

        methods: {
            onChange(data){
                this.changeid=data
            },


            routeTo(pRouteTo){

                if(this.breadcrumbList[pRouteTo].link)
                {
                    this.perk=true;
                    let upl=this.breadcrumbList[pRouteTo];
                    if(upl.name ==='Главная'&& this.widthScreen) {
                        this.defWidth();
                    }
                    if(upl.name !=='Главная'&& this.widthScreen) {
                        const wrap1=document.querySelector('.wrap1');
                        wrap1.classList.add('_active');
                    }
                    this.$store.dispatch('bread/loadItems', upl);

                    this.$router.push(this.breadcrumbList[pRouteTo].link)
                }

            },

            updateList ()
            {
                if(this.perk===false)
                {

                    let str={}, str1, a1, a2, a3;
                    this.priza=0;

                    // str 1-й элемент имя крошек, второй- id в адресной строке
                    str1= this.$route;
                    a1=this.$route.name;
                    a2=this.$route.path;
                    if(a1 ==='Главная'&& this.widthScreen) {
                      this.defWidth();
                    }
                    if(a1 !=='Главная'&& this.widthScreen) {
                        const wrap1=document.querySelector('.wrap1');
                        wrap1.classList.add('_active');
                    }
                    str={'name': this.$route.name, 'link':this.$route.path}; // имя  и путь
                    this.$store.dispatch('bread/loadItems', str);
                }
                this.perk=false;
            },

            defWidth() {

                const wrap1=document.querySelector('.wrap1');
               if(wrap1.classList.contains('_active')) {
                   wrap1.classList.remove('_active');
               }
            }

        },

        watch: {
            '$route'() {  return this.updateList();  }
        },

        mounted() {
            let w = document.documentElement.clientWidth;
            if (w < 980) {
                this.widthScreen=true;
            }
        }

    }
</script>

<style scoped>
    .breadcrumb ul{
        /*  display:flex ;
          flex-wrap: nowrap;
          justify-content: flex-start;

          font-size: 0.9em; color: blue;
          width: 100%;
          height: 10px;   */


        margin: 0;padding: 0;
        list-style: none;
    }
    .breadcrumb {

        background: #eee;
        border-width: 1px;
        border-style: solid;
        border-color: #f5f5f5 #e5e5e5 #ccc;
        border-radius: 5px;
        box-shadow: 0 0 2px rgba(0, 0, 0, .2);
        overflow: hidden;
        width: 100%;


    }
    .breadcrumb li{
        float: left;

    }

    .breadcrumb p{
        padding: 0 0.5em 0 1.7em !important;
        float: left;
        text-decoration: none;
        color: #444;
        position: relative;
        text-shadow: 0 1px 0 rgba(255,255,255,.5);
        background-color: #ddd;
        background-image: linear-gradient(to right, #f5f5f5, #ddd);
        margin: 0;
    }

    .breadcrumb li:first-child p{
        padding-left: 1em;
        border-radius: 5px 0 0 5px;
    }

    .breadcrumb p:hover{
        background: #fff;
        cursor: pointer;
    }
    .breadcrumb p::after,
    .breadcrumb p::before {
        content: "";
        position: absolute;
        top: 50%;
       margin-top: -1em;
        margin-bottom: -1em;
        border-top: 1em solid transparent;
        border-bottom: 1em solid transparent;
        border-left: 1em solid;
        right: -1em;
    }

    .breadcrumb p::after{
        z-index: 2;
        border-left-color: #ddd;
    }

    .breadcrumb p::before{
        border-left-color: #ccc;
        right: -1.1em;
        z-index: 1;
    }

    .breadcrumb p:hover::after{
        border-left-color: #fff;
    }
</style>
