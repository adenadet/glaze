import Vue from 'vue';
import VueRouter from 'vue-router';

import ApproveAddresses from '../approvals/Addresses.vue';
import ApproveAddress from '../approvals/Address.vue';
import ApproveBVNs from '../approvals/BVNs.vue';
import ApproveBvn from '../approvals/BVN.vue';

Vue.component('ApproveAddresses', ApproveAddresses);
Vue.component('ApproveAddress', ApproveAddress);
Vue.component('ApproveBVNs', ApproveBVNs);
Vue.component('ApproveBVN', ApproveBvn);

    
    import ApproveDetailsAddress from '../approvals/details/Address.vue';
    import ApproveDetailsBvn from '../approvals/details/Bvn.vue';
    import ApproveDetailsCustomerAddressLists from '../approvals/details/CustomerAddressLists.vue';
    
    Vue.component('ApproveDetailsAddress', ApproveDetailsAddress);
    Vue.component('ApproveDetailsCustomerAddressLists', ApproveDetailsCustomerAddressLists);
    Vue.component('ApproveDetailsBvn', ApproveDetailsBvn);

    import ApproveFormAddress from '../approvals/forms/Address.vue';
    import ApproveFormBvn from '../approvals/forms/Bvn.vue';

    Vue.component('ApproveFormAddress', ApproveFormAddress);
    Vue.component('ApproveFormBvn', ApproveFormBvn);


let routes = [
    {path: '/staff/confirm/addresses', component: ApproveAddresses},
    {path: '/staff/confirm/address/:id', component: ApproveAddress},
    {path: '/staff/confirm/bvns', component: ApproveBVNs},
    {path: '/staff/confirm/bvns/:id', component: ApproveBvn},
];

export default routes