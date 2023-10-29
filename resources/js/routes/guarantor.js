
import Vue from 'vue';
import VueRouter from 'vue-router';

import GuarantorAll from '../guarantors/All.vue';

Vue.component('GuarantorAll', GuarantorAll);

    import GuarantorFormConfirm from '../guarantors/forms/Confirm.vue';
    import GuarantorFormRequest from '../guarantors/forms/Request.vue';

    Vue.component('GuarantorFormConfirm', GuarantorFormConfirm);
    Vue.component('GuarantorFormRequest', GuarantorFormRequest);

let routes = [

    { path: '/guarantors', component: GuarantorAll },
    //{path: '/guarantors/',            component: GuarantorAll},
];


export default routes