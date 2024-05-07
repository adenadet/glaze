import Vue from 'vue';
import VueRouter from 'vue-router';

import ApproveAddresses from '../approvals/Addresses.vue';
import ApproveAddress from '../approvals/Address.vue';
import ApproveBVNs from '../approvals/BVNs.vue';
import ApproveCustomerBVN from '../approvals/CustomerBVN.vue';
import ApproveCustomerNIN from '../approvals/CustomerNIN.vue';
import ApproveGuarantorAddress from '../approvals/GuarantorAddress.vue';
import ApproveGuarantorBVN from '../approvals/GuarantorBVN.vue';
import ApproveGuarantorNIN from '../approvals/GuarantorNIN.vue';
import ApproveNINs from '../approvals/NINs.vue';

Vue.component('ApproveAddresses', ApproveAddresses);
Vue.component('ApproveAddress', ApproveAddress);
Vue.component('ApproveBVNs', ApproveBVNs);
Vue.component('ApproveCustomerBVN', ApproveCustomerBVN);
Vue.component('ApproveCustomerNIN', ApproveCustomerNIN);
Vue.component('ApproveGuarantorAddress', ApproveGuarantorAddress);
Vue.component('ApproveGuarantorBVN', ApproveGuarantorBVN);
Vue.component('ApproveGuarantorNIN', ApproveGuarantorNIN);
Vue.component('ApproveNINs', ApproveNINs);
    
    import ApproveDetailsAddress from '../approvals/details/Address.vue';
    //import ApproveDetailsBvn from '../approvals/details/Bvn.vue';
    import ApproveDetailsCustomerAddressLists from '../approvals/details/CustomerAddressLists.vue';
    import ApproveDetailsCustomerBVNLists from '../approvals/details/CustomerBVNLists.vue';
    import ApproveDetailsCustomerNINLists from '../approvals/details/CustomerNINLists.vue';
    import ApproveDetailsGuarantorAddressLists from '../approvals/details/GuarantorAddressLists.vue';
    import ApproveDetailsGuarantorBVNLists from '../approvals/details/GuarantorBVNLists.vue';
    import ApproveDetailsGuarantorNINLists from '../approvals/details/GuarantorNINLists.vue';
    import ApproveDetailsUserCard from '../approvals/details/UserCard.vue';
    
    Vue.component('ApproveDetailsAddress', ApproveDetailsAddress);
    Vue.component('ApproveDetailsCustomerAddressLists', ApproveDetailsCustomerAddressLists);
    Vue.component('ApproveDetailsCustomerBVNLists', ApproveDetailsCustomerBVNLists);
    Vue.component('ApproveDetailsCustomerNINLists', ApproveDetailsCustomerNINLists);
    Vue.component('ApproveDetailsGuarantorAddressLists', ApproveDetailsGuarantorAddressLists);
    Vue.component('ApproveDetailsGuarantorBVNLists', ApproveDetailsGuarantorBVNLists);
    Vue.component('ApproveDetailsGuarantorNINLists', ApproveDetailsGuarantorNINLists);
    Vue.component('ApproveDetailsUserCard', ApproveDetailsUserCard);


    import ApproveFormAddress from '../approvals/forms/Address.vue';
    import ApproveFormBvn from '../approvals/forms/Bvn.vue';

    Vue.component('ApproveFormAddress', ApproveFormAddress);
    Vue.component('ApproveFormBvn', ApproveFormBvn);


let routes = [
    {path: '/staff/confirm/addresses', component: ApproveAddresses},
    {path: '/staff/confirm/address/:id', component: ApproveAddress},
    {path: '/staff/confirm/bvns', component: ApproveBVNs},
    {path: '/staff/confirm/bvn/:id', component: ApproveCustomerBVN},
    {path: '/staff/confirm/nins', component: ApproveNINs},
    {path: '/staff/confirm/nin/:id', component: ApproveCustomerNIN},
    {path: '/staff/confirm/guarantor_address/:type/:id', component: ApproveGuarantorAddress},
    {path: '/staff/confirm/guarantor_bvn/:id', component: ApproveGuarantorBVN},
    
];

export default routes