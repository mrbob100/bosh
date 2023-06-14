export default {

    namespaced: true,
    state: {

     orders: [],
        intervals: [],

    },

   getters: {
        orders(state)
       {
           return state.orders
       },


       intervals(state)
       {
           return state.intervals
       },


   } ,

    mutations: {
        clearIntervals(state)
        {
            state.intervals=[];
        },


        clearOrders(state)
        {
            state.orders=[];
        },


        loadOrders(state, upload)
        {
            state.orders=upload
        },


        loadIntervals(state, upload)
        {
            state.intervals=upload
        },


    },

    actions: {
        loadItems(store, upload){


            store.commit('clearIntervals');
            store.commit('clearOrders');

            let str=upload[0];
            let str1=upload[1];
            store.commit('loadOrders', upload[0]);
            store.commit('loadIntervals', upload[1]);
        }

    }



}