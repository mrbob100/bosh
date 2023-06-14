/**
 * Created by Vladymir on 11.02.2019.
 * menu.js
 */
export default {
    namespaced: true,
    state: {
        items: [
            {
               id: 0,
                url: '/admin/categories',
                text: 'Категории',
                tag: ' <i class="fas fa-tachometer-alt"></i> '

            },
            {
                id: 1,
                url: '/admin/goods',
                text: 'Товары',
                tag: '<i class="fa fa-tags fw"></i>'
            },

            {
                id:2,
                url: '/admin/orders',
                text: 'Заказы',
                tag: ' <i class="fas fa-tv"></i>'
            },
            {
                id: 3,
                url: '/admin/profiles',
                text: 'Профили',
                tag: '<i class="fa fa-book fw"></i>'
            },
            {
                id: 4,
                url: '/admin/filtersOcf',
                text: 'Фильтр товаров OCFilter',
                tag: '<i class="fa fa-puzzle-piece fw"></i>'
            },

            {
                id:5,
                url: '/admin/filters',
                text: 'фильтры',
                tag: ' <i class="fas fa-tv"></i>'
            },

            {
               id:6,
                url: '/admin/empty',
                text: 'Общие характеристики',
                tag: '<i class="fa fa-shopping-cart fw"></i>',
                     subMenuItems :
                      [
                         {
                          id: 7,
                           url: '/admin/miscue',
                             text: 'Характеристики'

                         },
                         {
                            id: 8,
                             url: '/admin/empty1',
                             text: 'Группы характеристик',
                        tag: '<i class="far fa-comment"></i>',
                             subMenuItems : [
                                 {
                                     id: 9,
                                     url: '/admin/undergo',
                                     text: 'Подгруппы характеристик'
                                 },

                                           ]

                          },
                     ]
            },
        ]
    },
    getters: {
        items(state){
            return state.items;
        }
    }
};
