<template>
    <div class="hello">
        <!--li class="node-tree"-->

        <button class="menu-wrap" @click="apply(item) " :class="{ active: isActive }">


            <router-link  :to="item.url"
                          tag="li"
                          class="list-group-item item"
                          active-class="active"


            >

                <a>   {{item.text}}  </a><!--вывод родительских категорий в левом меню -->



            </router-link>   <!-- переход по id категории в AppMainCategories.vue для вывода изображений категорий в правой части-->


        </button>






        <div class="helloIn"   v-if="isOpen && item.subMenuItems"  >
            <app-tree
                v-for="(child,subIndex) in item.subMenuItems"
                :item="child"
                :index="subIndex"
                :key="subIndex"
                :parenItem="item"
                class="item"

            >
            </app-tree>

        </div>
        <!--/li-->

    </div>
</template>

<script>
    export default {
        name: "app-tree",
        props: {
            item: {
                type: Object,
                required: true
            },
            index: Number,
            parentItem: {
                required: false
            }

        },
        data() {
            return {
                isOpen: false,
                isActive: [],








            }
        },


        methods: {



            activatePoint() {
                this.$emit('activatePoint', {'item': this.item ,'isOpen': this.isOpen})
            },

            /*  Функция начала обработки дерева по выбору пункта меню  */

            apply(item) {
                let rep=this.isFolder(item);
                if(rep)  {
                    if(this.isOpen) {
                        item.url=this.$route;
                        return 0;
                    }
                    //  this.$set(this.isOpen,item.id,9);

                }  else {

                   let as=item.url;

                }
            },

            toggle() {

                this.isOpen = !this.isOpen;


            },
            isFolder(item) {
                let er='', r1='', subIt='';
                if(item.subMenuItems) {
                    er=true;
                    this.toggle();
                    //  this.activatePoint();
                }

                return er;
            },


        },

        computed: {
            /* sand(child) {
                 let re=this.item.id;
                 let br=this.item.name;
                 return 0;
               }, */
        }

    }

</script>

<style scoped>
    .item {
        cursor: pointer;
    }
    .helloIn {
        padding-left: 1em;
        line-height: 1.5em;
        list-style-type: dot;
    }
    li.list-group-item.item {
        width: 250px;
    }
</style>

