import Vue from 'vue';
import VueRouter from 'vue-router';

import LoanAll              from '../loans/All.vue';
import LoanAdmin            from '../loans/Admin.vue';
import LoanAdvert           from '../loans/Advert.vue';
import LoanAssigned         from '../loans/Assigned.vue';
import LoanConfirm          from '../loans/Confirm.vue';
import LoanConfirmAll       from '../loans/Confirms.vue';
import LoanInitiate         from '../loans/Initiate.vue';
import LoanNew              from '../loans/Initiate.vue';
import LoanPending          from '../loans/Pending.vue';
import LoanRequirements     from '../loans/Requirements.vue';
import LoanSingle           from '../loans/Single.vue';
import LoanStaff            from '../loans/Staff.vue';
import LoanStaffSingle      from '../loans/StaffSingle.vue';
import LoanTypes            from '../loans/Types.vue';

Vue.component('LoanAll',            LoanAll);
Vue.component('LoanAdmin',          LoanAdmin);
Vue.component('LoanAdvert',         LoanAdvert);
Vue.component('LoanAssigned',       LoanAssigned);
Vue.component('LoanConfirm',        LoanConfirm);
Vue.component('LoanInitiate',       LoanInitiate);
Vue.component('LoanNew',            LoanNew);
Vue.component('LoanPending',        LoanPending);
Vue.component('LoanRequirements',   LoanRequirements);
Vue.component('LoanSingle',         LoanSingle);
Vue.component('LoanStaff',          LoanStaff);
Vue.component('LoanStaffSingle',    LoanStaffSingle);
Vue.component('LoanTypes',          LoanTypes);

    import LoanDetailCheckList     from '../loans/details/CheckList.vue';
    import LoanDetailGuarantors     from '../loans/details/Guarantors.vue';
    import LoanDetailRepayments     from '../loans/details/Repayments.vue';
    import LoanDetailSummary        from '../loans/details/Summary.vue';

    Vue.component('LoanDetailCheckList', LoanDetailCheckList);
    Vue.component('LoanDetailGuarantors', LoanDetailGuarantors);
    Vue.component('LoanDetailRepayments', LoanDetailRepayments);
    Vue.component('LoanDetailSummary', LoanDetailSummary);

    import LoanClose                from '../loans/forms/Close.vue';
    import LoanForm                 from '../loans/forms/Loan.vue';
    import LoanFormCheckList        from '../loans/forms/CheckList.vue';
    import LoanFormInitial          from '../loans/forms/Initial.vue';
    import LoanFormRepayment        from '../loans/forms/Repayment.vue';
    import LoanFormRequirement      from '../loans/forms/Requirement.vue';
    import LoanFormType             from '../loans/forms/Type.vue';

    Vue.component('LoanClose',              LoanClose);
    Vue.component('LoanForm',               LoanForm);
    Vue.component('LoanFormCheckList',      LoanFormCheckList);
    Vue.component('LoanFormInitial',        LoanFormInitial);
    Vue.component('LoanFormRepayment',      LoanFormRepayment);
    Vue.component('LoanFormRequirement',    LoanFormRequirement);
    Vue.component('LoanFormType',           LoanFormType);

let routes = [
    {path: '/admin/loan_requirement_items',         component: LoanRequirements},
    {path: '/admin/loan_types',                     component: LoanTypes},
    
    {path: '/loans',                                component: LoanAll},
    {path: '/loans/new',                            component: LoanInitiate},
    {path: '/loans/admin',                          component: LoanAdmin},
    {path: '/loans/:id',                            component: LoanSingle},
    
    {path: '/staff/loans',                          component: LoanStaff},
    {path: '/staff/loans/pending',                  component: LoanPending},
    {path: '/staff/accounts/assigned',              component: LoanAssigned},
    {path: '/staff/confirm/loans',                  component: LoanConfirmAll},
    {path: '/staff/confirm/loans/:id',              component: LoanConfirm},
];

export default routes