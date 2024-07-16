import Vue from 'vue';
import VueRouter from 'vue-router';

import RequestGuarantorConfirm           from '../guarantors/Confirm.vue';


Vue.component('RequestGuarantorConfirm', RequestGuarantorConfirm);

let routes = [
    {path:'/requests/guarantors/:id/confirm',      component: RequestGuarantorConfirm},
];


export default routes