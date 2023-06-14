export default {
    namespaced : true,

    state: {

        article: {}
    },

    getters: {
        article(state) {
            return state.article;
        }
    },

    mutations: {
        loadItems(state,data){

            state.article=data;
        },

        clearArticle(state) {
            state.article={};
        }

    },
    actions: {
        loadItems(store, upload) {
            store.commit('clearArticle');
            store.commit('loadItems', upload);


        }

    }

}
