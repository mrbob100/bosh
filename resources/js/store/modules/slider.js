/**
 * Created by Vladymir on 12.02.2019.
 * slider.js
 */
export default {
    namespaced: true,
    state: {
        items: []
    },
    getters: {
        items(state){
            return state.items;
        },
        itemsMap(state){
            let itemsMap = {};

            for(let i = 0; i < state.items.length; i++){
                let product = state.items[i];
                itemsMap[product.id] = product;
            }

            return itemsMap;
        },
        item: (state, getters) => (id) => {
            return getters.itemsMap[id];
        }
    },
    mutations: {
        clearItems(state){
            state.items = [];
        },
        loadItems(state, data){
            state.items = data;
        }
    },
    actions: {
        loadItems(store, upload){
            store.commit('clearItems');

            /*  Vue.http.get('products.php')
             .then(response => response.json())
             .then(data => {
             store.commit('loadItems', data);
             }); */
            store.commit('loadItems', upload);
        }
    }
};
