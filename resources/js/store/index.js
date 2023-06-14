/**
 * Created by Vladymir on 11.02.2019.
 * store/index.js
 */
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import auth from './modules/auth';
import menu from './modules/menu';
import products from './modules/products';
import cart from './modules/cart';
import slider from './modules/slider';
import left from './modules/left';
import category from './modules/category';
import cabinet from './modules/cabinet';
import bread from './modules/bread';
import adminMenu from './modules/adminmodules/adminmenu'
import categories from './modules/adminmodules/categories'
import lists from './modules/adminmodules/lists'
import optCategories from './modules/adminmodules/optcategories'
import article from './modules/adminmodules/article'
import orders from './modules/adminmodules/orders'
import search from './modules/search';

export const store = new Vuex.Store({
    modules: {
        menu,
        products,
        cart,
        auth,
        slider,
        left,
        category,
        cabinet,
        bread,
        adminMenu,
        categories,
        lists,
        optCategories,
        article,
        orders,
        search

    },
    strict: process.env.NODE_ENV !== 'production'
});
