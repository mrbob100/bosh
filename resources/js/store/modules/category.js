/**
 * Created by vladymir on 17.08.19.
 */
import Vue from 'vue';

export default {     /* left.js */
    namespaced: true,
    state: {

        goods: [],      /* Это продукты категории id*/
        opts:  []         /* это фильтры выбора товаров */

    },
    getters: {
        goods(state) {
            return state.goods;
        },

        opts(state) {
            return state.opts;
        },

        item: (state) => (id) => {
            for(let i = 0; i < state.goods.length; i++){
                let product = state.goods[i];
                if(product.id==id){

                    console.log("id продукта", product);
                    return product;
                    break;
                }
            }



            return getters.itemsMap[id];
        }
    },


    mutations: {
        clearItems(state){
            state.goods = [];

        },
        clearOpts(state){
            state.opts = [];

        },
        loadItems(state, data){
            console.log('Шаг 10 продукты категории');
            state.goods=data;
        },

        loadOpts(state, upload) {
            state.opts=upload;
        },

        add(state, data){

            if(data.id) {

                let pos=state.goods.findIndex(c=>c.id===data.id);
                if(pos!=-1){
                    console.log("продукт слайдера найден", pos);
                    return pos;

                } else

                    state.goods.push(data);
                console.log("продукт слайдера", state.goods);
            }
        }

    },
    actions: {
        loadItems(store, upload){

            store.commit('clearItems');
            store.commit('clearOpts');

            /*  Vue.http.get('products.php')
             .then(response => response.json())
             .then(data => {
             store.commit('loadItems', data);
             }); */
            console.log('upload товары и фильтры', upload);

            store.commit('loadItems', upload.products);
            store.commit('loadOpts', upload.data);

        }


    }
};
