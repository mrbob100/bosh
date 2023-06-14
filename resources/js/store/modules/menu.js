/**
 * Created by Vladymir on 11.02.2019.
 * menu.js
 */
export default {
    namespaced: true,
    state: {
        items: [
            {
                url: '/slider',
                text: 'Категории'

            },
            {
                url: '/tactics',
                text: 'Акция'
            },
            {
                url: '/payment',
                text: 'Оплата'
            },
            {
                url: '/delivery',
                text: 'Доставка'
            },

            {
                url: '/guarantee',
                text: 'Гарантия'
            },
            {
                url: '/cabinet',
                text: 'В кабинет'
            },
            {
                url: '/admin',
                text: 'Админпанель'
            },
        ]
    },
    getters: {
        items(state){
            return state.items;
        }
    }
};
