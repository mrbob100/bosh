export default {     /* left.js */
    namespaced: true,
    state: {

        categories: [],      /* Это продукты категории id*/


    },
    getters: {
        categories(state) {
            return state.categories;
        },


        item: (state) => (id) => {
            for (let i = 0; i < state.categories.length; i++) {
                let category = state.categories[i];
                if (category.id == id) {

                    console.log("id категории", category);
                    return category;
                    break;
                }
            }


            return getters.itemsMap[id];
        }
    },


    mutations: {
        clearItems(state) {
            state.categories = [];

        },

        loadItems(state, data) {
            console.log('Шаг 10 продукты категории');
            state.categories = data;
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
