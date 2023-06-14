export default {     /* left.js */
    namespaced: true,
    state: {

        lists: [],      /* Это продукты категории id*/


    },
    getters: {
        lists(state) {
            return state.lists;
        },


      /*  item: (state) => (id) => {
            for (let i = 0; i < state.lists.length; i++) {
                let category = state.lists[i];
                if (category.id == id) {

                    console.log("id категории", category);
                    return category;
                    break;
                }
            }


            return getters.itemsMap[id];
        } */
    },


    mutations: {
        clearItems(state) {
            state.lists = [];

        },

        loadItems(state, data) {
            console.log('Шаг 10 продукты категории');
            state.lists = data;
        },


    },
    actions: {
        loadItems(store, upload) {
            let ded=upload;
            store.commit('clearItems');

            console.log('upload товары и фильтры', upload);

            store.commit('loadItems', upload);


        }


    }
}
