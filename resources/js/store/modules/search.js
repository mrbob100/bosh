export default {
    namespaced: true,
    state: {
        textSearch: '',
        goods: [],

    },
    getters: {
        textSearch(state) {

            return state.textSearch;
        },

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
        textSearch(state,upload) {

             state.textSearch=upload;
        },

        clearer (state) {
            state.textSearch='';
        },
        clearItems(state){
            state.goods = [];

        },
        loadItems(state, data){
            state.goods=data;
        },
    }

}
