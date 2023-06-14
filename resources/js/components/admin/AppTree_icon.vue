<template>
    <nav class="dws-menu" id="sure"  @mouseover="climb" @mouseout="rump">
        <!--li class="node-tree"-->


            <button   @click="apply(item) ">

                <ul>
                    <li
                        class="list-group-item"


                    >

                        <!--a>   {{item.text}}  </a--><!--вывод родительских категорий в левом меню -->

                        <div class="icon" >
                            <span v-html='item.tag' style="font-size: 30px;" class="sig"> <</span>

                            <div class="noIcon"    >
                                <a > {{item.text}}   </a>
                            </div>
                        </div>

                    </li>   <!-- переход по id категории в AppMainCategories.vue для вывода изображений категорий в правой части-->

                  </ul>
            </button>






        <div class="helloIn"   v-if="isOpen && item.subMenuItems"  >
            <app-tree
                v-for="(child,subIndex) in item.subMenuItems"
                :item="child"
                :index="subIndex"
                :key="child.id"
                :value="value"
            >
            </app-tree>

        </div>

        <!--/li-->

    </nav>
</template>

<script>
   // import * as e from "element-ui";
   // import AppTree from "./AppTree";
    import { bus } from '../../helpers/bus.js'

    export default {
        name: "AppTree",

        props: {
            item: {
                type: Object,
                required: true
            },
            index: Number,
            value: String


        },


        data() {
            return {
                isOpen: false,
                isActive: [],
               myHold: false,
                isNode: false

            }
        },


        methods: {

            activate() {

                bus.$emit('activated', {'Item': this.item, 'myHold': this.myHold, 'isNode': this.isNode});

            },

            /*  Функция начала обработки дерева по выбору пункта меню  */

            apply(item) {
                let rep = this.isFolder(item);

                if (!rep) {
                    //  this.$set(this.isOpen,item.id,9);
                    this.item.url = item.url;
                    this.myHold = false;
                    this.$emit('update:value', item.text);
                    this.isNode = true;
                    this.activate();

                } else {
                    this.myHold = true;
                    this.isNode = false;
                    this.item.url = item.url;
                    this.$emit('update:value', item.text);


                }

            },

            toggle() {
                this.isOpen = !this.isOpen;

            },

            isFolder(item) {
                let er = '', r1 = '', subIt = '';
                if (item.subMenuItems) {
                    er = true;
                    this.toggle();
                    //  this.activatePoint();
                }

                return er;
            },

            closeMenu() {
                /*  let menu=document.getElementById('sure'); */
                let subs = document.getElementsByClassName('noIcon');
                for (let i = 0; i < subs.length; i++) {
                    subs[i].style.display = 'none';
                    subs[i].style.left = '-230px';
                }
            },


            climb(event) {
                let target = event.target;
                if (target.className == 'list-group-item' ) {
                    let s = target.getElementsByClassName('noIcon');
                    setTimeout(this.closeMenu(),2000);
                    s[0].style.display = 'block';
                    s[0].style.left = '50px';

                }

                },



            rump() {
                setTimeout(this.closeMenu(),2000);
            },




        }


    }

</script>

<style scoped>



div.icon{
width: 50px;
    position: relative;
}

.noIcon {
    display: none;
    width: 200px;
    position: absolute;
    top: 0;
    left: 60px;
}

div.icon:hover .noIcon{
    display: block;
    width: 200px;
    position: absolute;
    top: 0;
    left: 60px;
}


 .item {
     cursor: pointer;
 }
 .helloIn {
     padding-left: 1em;
     line-height: 1.5em;
     list-style-type: dot;
 }


</style>
