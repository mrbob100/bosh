/**
 * Created by Vladymir on 07.12.2018.
 */
/* srore/auth.js */
export default {
    namespaced: true,
    state: {
        api_token: null,
        user_id: null,
        role_id: null
    },

    getters: {
        api_token(state){
          return state.api_token;
        },

        user_id(state){
            return state.user_id;
        },

        role_id(state){
            return state.role_id;
        }
    },
    mutations: {
        api_token(state,data){
            state.api_token=data[0];
            state.user_id= data[1];
            state.role_id=data[2];
        },

        user_id (state, data) {
            state.user_id=data.user_id;
        },
         role_id(state, data)  {
             state.role_id=data.role_id;
         },



    set(state, data)
    {
        localStorage.setItem('api_token',data[0]);
        localStorage.setItem('user_id',data[1]);
        localStorage.setItem('role_id',data[2]);
        state.api_token= localStorage.getItem('api_token');
        state.user_id= parseInt( localStorage.getItem('user_id'));
        state.role_id=parseInt( localStorage.getItem('role_id'));
    },

    remove(state)
    {
        localStorage.removeItem('api_token');
        localStorage.removeItem('user_id');
        localStorage.removeItem('role_id');
        state.api_token=null;
        state.user_id=null;
        state.role_id=null;
    }
    }
}
