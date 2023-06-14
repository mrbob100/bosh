export default {     /* left.js */
    namespaced: true,
    state: {

        optCategories: [],      /* Это продукты категории id*/


    },
    getters: {
        optCategories(state) {
            return state.optCategories;
        },



    },


    mutations: {
        clearItems(state) {
            state.optCategories = [];

        },

        optCategories(state, data) {
            if(data.value!= 'не выбран') {

            let pos=state.optCategories.findIndex(c=>c.parentTitle.trim()===data.parentTitle.trim());
            if(pos!=-1){
               state.optCategories.splice(pos,1,data);

                       } else

            state.optCategories.push(data);

            }
        },

        deleteSingle(state, index) {
            let i=0;
            state.optCategories.forEach((e)=>{
               if(e.parentTitle==index) {
                   state.optCategories.splice(i, 1);

               }
               i++;
            });


        }

    },
    actions: {
        loadItems(store, upload='') {

            store.commit('optCategories', upload);

        },
        deleteSingle(store, upload='') {

            store.commit('deleteSingle', upload);

        },


    }
}
