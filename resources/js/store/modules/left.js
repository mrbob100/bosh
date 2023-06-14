export default {     /* left.js */
    namespaced: true,
    state: {
        sections: [],      /* Это категории родительские*/
        categories: [],      /* Это категории дочерние*/

    },
    getters: {
       sections(state){
            return state.sections;
        },
        categories(state){
           return state.categories;
        },


        item: (state) => (id) => {
            for(let i = 0; i < state.categories.length; i++){
                let category = state.categories[i];
                if(category.id==id){

                    console.log("id категории", category);
                    return category;
                    break;
                }
            }



            return getters.itemsMap[id];
        },


    },

    mutations: {
        clearItems(state){
            state.sections = [];
        },
        loadItems(state, data){
            console.log('Шаг 1');
            state.sections=data;
        },
           clearCategories(state){
            state.categories=[];
           },
        loadCategories(state, upload) {
            state.categories=upload;
        }

    },
    actions: {
        loadItems(store, upload){

            store.commit('clearItems');
            store.commit('clearCategories');
            let ded =upload.highCategories,
                dedcat=upload.categoriesResult;

            /*  Vue.http.get('products.php')
                  .then(response => response.json())
                  .then(data => {
                      store.commit('loadItems', data);
                  }); */
            console.log('upload 1', upload);

            store.commit('loadItems', upload.highCategories);
            store.commit("loadCategories", upload.categoriesResult);
        }


    }
};
