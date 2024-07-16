
import Vue from 'vue';
import VueRouter from 'vue-router';

import GuarantorAll from '../guarantors/All.vue';

Vue.component('GuarantorAll', GuarantorAll);

    import GuarantorDetailDone from '../guarantors/details/Done.vue';
    import GuarantorDetailGuarantee from '../guarantors/details/View.vue';
    import GuarantorDetailThanks from '../guarantors/details/Thanks.vue';


    Vue.component('GuarantorDetailDone', GuarantorDetailDone);
    Vue.component('GuarantorDetailGuarantee', GuarantorDetailGuarantee);
    Vue.component('GuarantorDetailThanks', GuarantorDetailThanks);

    import GuarantorFormConfirm from '../guarantors/forms/Confirm.vue';
    import GuarantorFormConfirmFiles from '../guarantors/forms/ConfirmFiles.vue';
    import GuarantorFormRequest from '../guarantors/forms/Request.vue';


    Vue.component('GuarantorFormConfirm', GuarantorFormConfirm);
    Vue.component('GuarantorFormConfirmFiles', GuarantorFormConfirmFiles);
    Vue.component('GuarantorFormRequest', GuarantorFormRequest);

let routes = [

    { path: '/guarantors',                              component: GuarantorAll },
    { path: '/loans/:id/guarantor_request/',            component: GuarantorFormRequest},
];


export default routes