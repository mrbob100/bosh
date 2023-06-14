export default {

    namespaced: true,
    state: {

        bread: [],



    },

    getters: {
        bread(state)
        {

            return state.bread;
        },


    } ,

    mutations: {
          add(state,upl)
        {
            let str={};
             if(state.bread.length>0)
          {
              let b2b=false, b3b=0, a2=[], a3=[];

              for(let i=0; i<state.bread.length; i++)
              {
                  let a1=upl.link;
                  let b1=state.bread[i].link;
                  a2=a1.split('/');
                  a3=b1.split('/');
                  if(a2[1]==='admin') a2[1]=a2[2];
                  if(a3[1]==='admin') a3[1]=a3[2];
                  if(a2[1]=== a3[1]) {
                      b2b=true;
                      b3b=i;
                      break;
                  }
              }

             if(b2b) {
                 for(let j=state.bread.length; j>b3b; j--)
                 {
                    str= state.bread.pop();
                 }

                     }
              state.bread.push(upl);
          }
               else {

                  state.bread.push(upl);
              }

        },

     minus(state,upload)
     {
          let ala=state.bread.pop();
         ala.name=upload;
         state.bread.push(ala);

     },

    clear(state) {

        state.bread= []
    }

    },

    actions: {
        loadItems(store, upload){


            let str=upload;
       //     let str1=upload[1];
            store.commit('add', str);
        //    store.commit('loadIntervals', upload[1]);
        }

    }



}
