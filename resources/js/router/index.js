/**
 * Created by Vladymir on 04.02.2019.
 * router/index.js
 */

import Vue from 'vue'

import VueRouter from 'vue-router'


import Register from '../../views/Auth/Register.vue'
import Login from '../../views/Auth/Login.vue'
import Main from '../components/AppMainCategories.vue'
import Slider from '../components/AppSlider'
import Category from '../components/AppCategoryGoods'
import Product from '../components/AppProduct'
import Left from '../components/AppLeft'
import Cart from '../components/AppCart'
import Order from '../components/AppOrder'
import Out from '../components/AppOut'
import Cabinet from '../components/AppCabinet'
import Search from '../components/AppSearch'
import Tactics from '../components/AppTactics'
import Payment from '../components/AppPayment'
import Delivery from '../components/AppDelivery'
import Guarantee from '../components/AppGuarantee'


/* Административная часть */
import Admin from '../components/admin/AppAdmin'
import Categories from '../components/admin/AppCategories'
import Undergo from '../components/admin/AppUndergo'
import Filters from '../components/admin/AppFilters'
import FiltersOcf from '../components/admin/AppFiltersOcf'
import Goods from '../components/admin/AppGoods'
import Characters from '../components/admin/AppCharacters'
import Profiles from '../components/admin/AppProfiles'
import Miscue from '../components/admin/AppMiscue'
import Empty from '../components/admin/AppEmpty'
import Clearer from'../components/admin/AppClear'
import CategoryEdit from '../components/admin/AppCategoryEdit'
import CategoryDelete from '../components/admin/AppCategoryDelete'
import CategoryAdd from '../components/admin/AppCategoryAdd'

import ProductEdit from '../components/admin/AppProductEdit'
import ProductDelete from '../components/admin/AppProductDelete'
import ProductAdd from '../components/admin/AppProductsAdd'
import OrdersList from '../components/admin/AppOrdersList'
import OrderEdit from '../components/admin/AppOrderEditTable'

Vue.use(VueRouter);
import {store} from '../store';
import {Header} from "element-ui";
import id from "element-ui/src/locale/lang/id";





 const routes = [


        {
             path: '/slider',
            component: Slider,
            name: 'Главная',
            meta: {
                 breadcrumb: [
                     {  name: 'Главная', link: '/slider' }
                 ]
            }
        },


      {
          path: '/search',
          component: Search,
          name: 'Поиск',
          meta: {
              breadcrumb: [
                  {  name: 'Поиск', link: '/search' }
              ]
          }
      },

     {
         path: '/search/:id',
         component: Product,
         name: 'Выбор',
         meta: {
             breadcrumb: [
                 {  name: 'В корзину', link: '/cart' }
             ]
         }
     },


        {
            path: '/left',
            component: Left,
        },
        {
            path: '/register',
            component: Register,
            meta: {
                guest: true
            }

        },

        {
            path: '/login',
            component: Login,
            name: 'login',
            meta: {
              // guest: true,
                breadcrumb: [
                    {  name: 'Login'}
                ]

            }
        },
        {
            path: '/main/:id',
            component: Main,
            name: 'Категория',
            exact: true,
            meta: {
                breadcrumb: [
                    {  name: 'Категория', link: 'Категория'}




                ]
            }

        },

        {
            path: '/category/:id',
            component: Category,
            name: 'Продукты',
            meta: {
                breadcrumb: [
                    {  name: 'Продукты',link: 'Продукты'}
                ]


                  //  function() {
                  //      return `${this.$route}`;
                  //  }

            }
        },

        {
            path: '/product/:id',
            component: Product,
            name: 'Набор',
            meta: {
                breadcrumb: [
                    {  name: 'Набор',link: 'Набор'}
                ]


            }

        },
        {
            path: '/slide/:id',
            component: Product,
            name: 'Продукт',
            meta: {
                breadcrumb:[
                    {  name: 'Продукт' ,link: 'Продукт'}
                ]

            }

        },
        {
            path: '/cart',
            component: Cart,
            name: 'cart',
            meta: {
                breadcrumb: [
                    {  name: 'Корзина', link: 'Корзина'}
                ]
            }

        },

        {
            path: '/cart/:id',
            component: Cart,
            name:'cartInto',
            props: true,
            meta: {
                breadcrumb: [
                    {  name: 'В корзину', link: 'В корзину' }
                ]
            }

        },
        {
            path: '/order',
            component:Order,
            name: 'Заказ',
            meta: {

                breadcrumb: [
                    {  name: 'Заказ', link: 'Заказ'}
                ]
            }
        },

        {
            path: '/out',
            component: Out,
            name: 'Оформление',
            meta: {

                breadcrumb: [
                    {  name: 'Оформление' , link: 'Оформление'}
                ]
            }
        },

    {
        path: '/cabinet',
        component: Cabinet,
        name: 'Cabinet',
        meta: {
            guest: true,
            breadcrumb: [
                {  name: 'Cabinet' , link:'Cabinet'}
            ]
        }

    },

     {
         path: '/tactics',
         component:Tactics,
         name: 'Tactics',
         meta: {
             breadcrumb: [
                 {  name: 'Tactics' , link:'Tactics'}
             ]
         }

     },

     {
         path: '/payment',
         component: Payment,
         name: 'Payment',
         meta: {
             breadcrumb: [
                 {  name: 'Payment' , link:'Payment'}
             ]
         }

     },

     {
         path: '/delivery',
         component: Delivery,
         name: 'Delivery',
         meta: {
             breadcrumb: [
                 {  name: 'Delivery' , link:'Delivery'}
             ]
         }

     },

     {
         path: '/guarantee',
         component: Guarantee,
         name: 'Guarantee',
         meta: {
             breadcrumb: [
                 {  name: 'Guarantee' , link:'Guarantee'}
             ]
         }

     },


//_____________________________ Административная часть___________________________________//
     {
         path: '/admin',
         name: 'admin',
         component: Clearer,
         meta: {
             requiresAuth: true,
             is_admin : true

         }
     },

     {
         path: '/admin/categories',
         name: 'Categories',
         component: Categories,
        meta: {
            breadcrumb: [
                {  name: 'Categories' , link: 'Categories'}
            ],
            requiresAuth: true,
            is_admin : true
         },

     },
  //  Категории
     {
         path: '/admin/categoryEdit/:id',
         name: 'CategoryEdit',
         component: CategoryEdit,
         meta: {
             breadcrumb: [
                 {  name: 'CategoryEdit' , link: 'CategoryEdit'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/categoryDelete/:id',
         name: 'CategoryDelete',
         component: CategoryDelete,
         meta: {
             breadcrumb: [
                 {  name: 'CategoryDelete' , link: 'CategoryDelete'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/categoryAdd',
         name: 'CategoryAdd',
         component: CategoryAdd,
         meta: {
             breadcrumb: [
                 {  name: 'CategoryAdd' , link: 'CategoryAdd'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },



     {
         path: '/admin/productAdd',
         name: 'ProductAdd',
         component: ProductAdd,
         meta: {
             breadcrumb: [
                 {  name: 'ProductAdd' , link: 'ProductAdd'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/productDelete/:id',
         name: 'ProductDelete',
         component: ProductDelete,
         meta: {
             breadcrumb: [
                 {  name: 'ProductDelete' , link: 'ProductDelete'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/productEdit/:id',
         name: 'ProductEdit',
         component: ProductEdit,
         meta: {
             breadcrumb: [
                 {  name: 'ProductEdit' , link: 'ProductEdit'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/filters',
         name: 'Filters',
         component: Filters,
         meta: {
             breadcrumb: [
                 {  name: 'Filters' , link: 'Filters'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/orders',
         name: 'Orders',
         component: OrdersList,
         meta: {
             breadcrumb: [
                 {  name: 'Orders' , link: 'Orders'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/orderEdit/:id',
         name: 'OrderEdit',
         component: OrderEdit,
         meta: {
             breadcrumb: [
                 {  name: 'OrderEdit' , link: 'OrderEdit'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/filtersOcf',
         name: 'FiltersOcf',
         component: FiltersOcf,
         meta: {
             breadcrumb: [
                 {  name: 'FiltersOcf' , link: 'FiltersOcf'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/characters',
         name: 'Characters',
         component: Characters ,
         meta: {
             breadcrumb: [
                 {  name: 'Characters' , link: 'Characters'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/goods',
         name: 'Goods',
         component: Goods,
         meta: {
             breadcrumb: [
                 {  name: 'Goods' , link: 'Goods'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/profiles',
         name: 'Profiles',
         component: Profiles,
         meta: {
             breadcrumb: [
                 {  name: 'Profiles' , link: 'Profiles'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/miscue',
         name: 'Miscue',
         component: Miscue,
         meta: {
             breadcrumb: [
                 {  name: 'Miscue' , link: 'Miscue'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/undergo',
         name: 'Undergo',
         component: Undergo,
         meta: {
             breadcrumb: [
                 {  name: 'Undergo' , link: 'Undergo'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },
     {
         path: '/admin/empty',
         name: 'Empty',
         component: Empty,
         meta: {
             requiresAuth: true,
             is_admin : true
         },

     },

     {
         path: '/admin/orders',
         name: 'OrdersList',
         component: OrdersList,
         meta: {
             breadcrumb: [
                 {  name: 'OrdersList' , link: 'OrdersList'}
             ],
             requiresAuth: true,
             is_admin : true
         },

     },



];

export const router = new VueRouter({
    routes,
    mode: 'history'
});


router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('api_token') == null) {

           next({
                path: '/login',
               params: { nextUrl: to.fullPath }
            })

        } else {
            let role_id = JSON.parse(localStorage.getItem('role_id'));
            if(to.matched.some(record => record.meta.is_admin)) {
                if(role_id == 13){
                    next();
                }
                else{
                  next({ name: 'Главная'})


                }
            }else {
                next();
            }
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        if(localStorage.getItem('api_token') == null){
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        }
        else{
         //
            //   next(false);
            next()

        }
    }else {
        next()
    }
});
