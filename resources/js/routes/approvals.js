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

    import ApproveDetailAddress from '../approvals/details/Address.vue';
    import ApproveDetailBvn from '../approvals/details/Bvn.vue';

    import ApproveDetailCustomerAddressConfirmed        from '../approvals/details/CustomerAddressConfirmed.vue';
    import ApproveDetailCustomerAddressRejected         from '../approvals/details/CustomerAddressRejected.vue';
    import ApproveDetailCustomerAddressUnconfirmed      from '../approvals/details/CustomerAddressUnconfirmed.vue';
    import ApproveDetailCustomerBVNConfirmed            from '../approvals/details/CustomerBVNConfirmed.vue';
    import ApproveDetailCustomerBVNRejected             from '../approvals/details/CustomerBVNRejected.vue';
    import ApproveDetailCustomerBVNUnconfirmed          from '../approvals/details/CustomerBVNUnconfirmed.vue';

    import ApproveDetailGuarantorAddressConfirmed       from '../approvals/details/GuarantorAddressConfirmed.vue';
    import ApproveDetailGuarantorAddressRejected        from '../approvals/details/GuarantorAddressRejected.vue';
    import ApproveDetailGuarantorAddressUnconfirmed     from '../approvals/details/GuarantorAddressUnconfirmed.vue';
    import ApproveDetailGuarantorBVNConfirmed           from '../approvals/details/GuarantorBVNConfirmed.vue';
    import ApproveDetailGuarantorBVNRejected            from '../approvals/details/GuarantorBVNRejected.vue';
    import ApproveDetailGuarantorBVNUnconfirmed         from '../approvals/details/GuarantorBVNUnconfirmed.vue';

    Vue.component('ApproveDetailAddress',                       ApproveDetailAddress);
    Vue.component('ApproveDetailBvn',                           ApproveDetailBvn);

    Vue.component('ApproveDetailCustomerAddressConfirmed',      ApproveDetailCustomerAddressConfirmed);
    Vue.component('ApproveDetailCustomerAddressRejected',       ApproveDetailCustomerAddressRejected);
    Vue.component('ApproveDetailCustomerAddressUnconfirmed',    ApproveDetailCustomerAddressUnconfirmed);
    Vue.component('ApproveDetailCustomerBVNConfirmed',          ApproveDetailCustomerBVNConfirmed);
    Vue.component('ApproveDetailCustomerBVNRejected',           ApproveDetailCustomerBVNRejected);
    Vue.component('ApproveDetailCustomerBVNUnconfirmed',        ApproveDetailCustomerBVNUnconfirmed);

    Vue.component('ApproveDetailGuarantorAddressConfirmed',     ApproveDetailGuarantorAddressConfirmed);
    Vue.component('ApproveDetailGuarantorAddressRejected',      ApproveDetailGuarantorAddressRejected);
    Vue.component('ApproveDetailGuarantorAddressUnconfirmed',   ApproveDetailGuarantorAddressUnconfirmed);
    Vue.component('ApproveDetailGuarantorBVNConfirmed',         ApproveDetailGuarantorBVNConfirmed);
    Vue.component('ApproveDetailGuarantorBVNRejected',          ApproveDetailGuarantorBVNRejected);
    Vue.component('ApproveDetailGuarantorBVNUnconfirmed',       ApproveDetailGuarantorBVNUnconfirmed);


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