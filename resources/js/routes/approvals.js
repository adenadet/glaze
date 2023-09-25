import Vue from 'vue';
import VueRouter from 'vue-router';

import ApproveAddresses from '../approvals/Addresses.vue';
import ApproveAddress from '../approvals/Address.vue';
import ApproveBVNs from '../approvals/BVNs.vue';


Vue.component('ApproveAddresses', ApproveAddresses);
Vue.component('ApproveAddress', ApproveAddress);
Vue.component('ApproveBVNs', ApproveBVNs);

let routes = [
    {path: '/staff/confirm/addresses', component: ApproveAddresses},
    {path: '/staff/confirm/address/:id', component: ApproveAddress},
];

export default routes