/**
 * Created by Vladymir on 11.02.2019.
 * cart.js
 */
export default {
    namespaced: true,
    state: {
        products: [],


    },
    getters: {
        products(state) {

            return state.products;
        },


        product(state, id) {
            state.products.forEach(function (el) {
                if (el.product.id === id) {


                    return el.product;
                }

            });

        },
         cnt(state,id) {
             state.products.forEach(function (el) {
                 if (el.product.id === id) {


                     return el.cnt;
                 }

             });
         },



    },
    mutations: {

        add( state,prod ){
            let vibor=false;
            if (state.products.length> 0) {
                state.products.forEach(function (el) {
                    if (el.product.id == prod.id) {
                        el.cnt++;
                        vibor=true;
                    }

                });
                if (vibor === false) {
                    let a={product:prod,cnt:1};
                    state.products.push(a);

                }
            } else {
                let a={product:prod,cnt:1};
                state.products.push(a);
            }

        },
        remove(state, id){

            state.products.forEach(function (el) {
                if(el.product.id==id) {
                    let pos=state.products.indexOf(el);
                    if(pos!==-1) {
                        state.products.splice(pos,1);

                    }

                }

            });

        },
        plus(state,index) {

            state.products.forEach(function (el) {
                let pos=state.products.indexOf(el);

                if(pos==index){

                    el.cnt++;

                }

            });

        },
        minus(state,index) {
            state.products.forEach(function (el) {
                /*if(el.product.id==id){
                    if(el.cnt>1)
                    {
                    el.cnt--;
                    }
                } */
                let pos=state.products.indexOf(el);

                if(pos==index){

                  if(el.cnt>1)  el.cnt--;

                }


            });

        },
        clearer (state) {
            state.products=[];
        }

    },
   /* actions: {
        add(store, id_product){
            store.commit('add', id_product);
        },
        remove(store, id_product){
            store.commit('remove', id_product);
        }
    } */
};