<template>
    <nav class="dws-menu" id="sure" >
        <!--li class="node-tree"-->


        <button   @click="apply(item) "  >

            <router-link  :to="item.url"
                          tag="li"
                          class="list-group-item item"
                          active-class="active"

            >
                <!--div class="icon"  @mouseover="climb">
                    <span  class="ten" v-html='item.tag' style="font-size: 30px;" > <</span>

                    <div class="noIcon" @mouseout="bout"-->
                        <a > {{item.text}}   </a>
                    <!--/div>
                </div-->

            </router-link>   <!-- переход по id категории в AppMainCategories.vue для вывода изображений категорий в правой части-->

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
            value: String,



        },


        data() {
            return {
                isOpen: false,
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
               // this.isActive=!this.isActive;
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

            trumped() {
                this.isOpen = !this.isOpen;


            },

            isFolder(item) {
                let er = '', r1 = '', subIt = '';
                if (item.subMenuItems) {
                    er = true;
                    this.trumped();
                    //  this.activatePoint();
                }

                return er;
            },
/*
            climb(event) {
                let target = event.target;

                if (target.className == 'icon' ) {
                    let s = target.getElementsByClassName('noIcon');
                    setTimeout(this.closeMenu(),2000);

                    s[0].style.display = 'block';
                  //  s[0].style.left = '50px';

                } else  setTimeout(this.closeMenu(),2000);

            },

            bout() {
                setTimeout(this.closeMenu(),2000);

            },

            closeMenu() {

                let subs = document.getElementsByClassName('noIcon');
                for (let i = 0; i < subs.length; i++) {
                    subs[i].style.display = 'none';

                }
              //  subs.style.left = '-230px';
            }
                  */

        }


    }

</script>

<style scoped>
    div.icon{
        width: 50px;
        position: relative;
        background-color: #e4b9b9;
    }


    .noIcon {
       display: none;
        width: 200px;
        position: absolute;
        height: 47px;
        top: 0;
        left: 60px;
        background-color: #8fcafe;

    }
    .noIcon  a:hover{
        display: block;
    }

 .item{
    width: 260px;
    cursor: pointer;

}
   /* .item {
        cursor: pointer;

    }*/
    .helloIn {
        padding-left: 2em;
        line-height: 1.5em;
        list-style-type: dot;
        width: 195px ;
      /*  padding-top: -50px;
        z-index: 5; */

    }


</style>
