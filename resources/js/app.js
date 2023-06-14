
import Vue from 'vue'
import App from './App.vue'
//import Adm from './Adm.vue'
import {store} from './store'
import {router} from './router'
import ElementUI from 'element-ui'
import Carousel3d from 'vue-carousel-3d'
import VueAxios from 'vue-axios'
import VueSocialauth from 'vue-social-auth'
import axios from 'axios';
import Paginate from 'vuejs-paginate'





Vue.use(VueAxios, axios);
Vue.use(VueSocialauth, {
    providers: {
        github: {
            clientId: '',
            redirectUri: '/auth/github/callback' // Your client app URL
        }
    }
});

Vue.use(Carousel3d);



Vue.use(ElementUI);
Vue.component('Paginate', Paginate);



const app = new Vue({

    el: '#root',
    //template:  `<app></app>`,

    components:  { App: `app`},
    router,
    store,
    render: h => h(App)

});
// последняя вставка
