import Vue from 'vue';
import VueRouter from 'vue-router';

import CustomerAll       from '../customers/All.vue';
import CustomerSingle    from '../customers/Single.vue';
//import CustomerStaff     from '../customers/Staff.vue';
import CustomerMiniCard  from '../customers/MiniCard.vue';

Vue.component('CustomerAll',     CustomerAll);
Vue.component('CustomerMiniCard',   CustomerMiniCard);
Vue.component('CustomerSingle',  CustomerSingle);
//Vue.component('CustomerStaff',   CustomerStaff);

let routes = [
    {path: '/staff/customers',           component:CustomerAll},
    {path: '/staff/customers/:id',       component:CustomerSingle},
    //{path: '/customers/staff/:id', component:CustomerStaff},
];

export default routes