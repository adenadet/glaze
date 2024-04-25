import Vue from 'vue';
import VueRouter from 'vue-router';

import LoanAll              from '../loans/All.vue';
import LoanAdmin            from '../loans/Admin.vue';
import LoanAdvert           from '../loans/Advert.vue';
import LoanAssigned         from '../loans/Assigned.vue';
import LoanAssignedSingle   from '../loans/AssignedSingle.vue';
import LoanConfirm          from '../loans/Confirm.vue';
import LoanConfirmAll       from '../loans/Confirms.vue';
import LoanCustomer         from '../loans/Customer.vue';
import LoanInitiate         from '../loans/Initiate.vue';
import LoanNew              from '../loans/Initiate.vue';
import LoanPending          from '../loans/Pending.vue';
import LoanRequirements     from '../loans/Requirements.vue';
import LoanUndisbursed      from '../loans/Undisbursed.vue';
import LoanSingle           from '../loans/Single.vue';
import LoanStaff            from '../loans/Staff.vue';
import LoanStaffSingle      from '../loans/StaffSingle.vue';
import LoanType             from '../loans/Type.vue';
import LoanTypes            from '../loans/Types.vue';

Vue.component('LoanAll',            LoanAll);
Vue.component('LoanAdmin',          LoanAdmin);
Vue.component('LoanAdvert',         LoanAdvert);
Vue.component('LoanAssigned',       LoanAssigned);
Vue.component('LoanAssignedSingle', LoanAssignedSingle);
Vue.component('LoanConfirms',       LoanConfirmAll);
Vue.component('LoanConfirm',        LoanConfirm);
Vue.component('LoanCustomer',       LoanCustomer)
Vue.component('LoanInitiate',       LoanInitiate);
Vue.component('LoanNew',            LoanNew);
Vue.component('LoanPending',        LoanPending);
Vue.component('LoanRequirements',   LoanRequirements);
Vue.component('LoanUndisbursed',    LoanUndisbursed);
Vue.component('LoanSingle',         LoanSingle);
Vue.component('LoanStaff',          LoanStaff);
Vue.component('LoanStaffSingle',    LoanStaffSingle);
Vue.component('LoanTypes',          LoanTypes);

    import LoanDetailCheckList      from '../loans/details/CheckList.vue';  
    import LoanDetailCreditScore    from '../loans/details/CreditScore.vue';   
    import LoanDetailCPM            from '../loans/details/CPM.vue';   
    import LoanDetailConfirmations  from '../loans/details/Confirmations.vue';
    import LoanDetailFiles          from '../loans/details/Files.vue';
    import LoanDetailGuarantors     from '../loans/details/Guarantors.vue';
    import LoanDetailOthers         from '../loans/details/Others.vue';
    import LoanDetailRepayments     from '../loans/details/Repayments.vue';
    import LoanDetailSummary        from '../loans/details/Summary.vue';
    //import LoanDetailSummary        from '../loans/details/Summary.vue';

    Vue.component('LoanDetailCheckList', LoanDetailCheckList);
    Vue.component('LoanDetailCreditScore', LoanDetailCreditScore);
    Vue.component('LoanDetailCPM', LoanDetailCPM);
    Vue.component('LoanDetailConfirmations', LoanDetailConfirmations);
    Vue.component('LoanDetailFiles', LoanDetailFiles);
    Vue.component('LoanDetailGuarantors', LoanDetailGuarantors);
    Vue.component('LoanDetailOthers', LoanDetailOthers);
    Vue.component('LoanDetailRepayments', LoanDetailRepayments);
    Vue.component('LoanDetailSummary', LoanDetailSummary);

    import LoanFormAssign           from '../loans/forms/Assign.vue';
    import LoanFormClose            from '../loans/forms/Close.vue';
    import LoanForm                 from '../loans/forms/Loan.vue';
    import LoanFormCheckList        from '../loans/forms/CheckList.vue';
    import LoanFormCheckListSingle from '../loans/forms/CheckListSingle.vue';  
    import LoanFormCreditScore      from '../loans/forms/CreditScore.vue';
    import LoanFormCPM              from '../loans/forms/CPM.vue';
    import LoanFormConfirm          from '../loans/forms/Confirm.vue';
    import LoanFormConfirmFile      from '../loans/forms/ConfirmFile.vue';
    import LoanFormDisbursement     from '../loans/forms/Disbursement.vue';
    import LoanFormFile             from '../loans/forms/File.vue';
    import LoanFormInitial          from '../loans/forms/Initial.vue';
    import LoanFormOthers           from '../loans/forms/Others.vue';
    import LoanFormRepayment        from '../loans/forms/Repayment.vue';
    import LoanFormRequirement      from '../loans/forms/Requirement.vue';
    import LoanFormType             from '../loans/forms/Type.vue';

    Vue.component('LoanFormAssign',         LoanFormAssign);
    Vue.component('LoanFormClose',          LoanFormClose);
    Vue.component('LoanForm',               LoanForm);
    Vue.component('LoanFormCheckList',      LoanFormCheckList);
    Vue.component('LoanFormCheckListSingle',LoanFormCheckListSingle);
    Vue.component('LoanFormCreditScore',    LoanFormCreditScore);
    Vue.component('LoanFormCPM',            LoanFormCPM);
    Vue.component('LoanFormConfirm',        LoanFormConfirm);
    Vue.component('LoanFormConfirmFile',    LoanFormConfirmFile);
    Vue.component('LoanFormDisbursement',   LoanFormDisbursement);
    Vue.component('LoanFormFile',           LoanFormFile);
    Vue.component('LoanFormInitial',        LoanFormInitial);
    Vue.component('LoanFormOthers',         LoanFormOthers); 
    Vue.component('LoanFormRepayment',      LoanFormRepayment);
    Vue.component('LoanFormRequirement',    LoanFormRequirement);
    Vue.component('LoanFormType',           LoanFormType);

let routes = [
    {path: '/admin/loan_requirement_items',         component: LoanRequirements},
    {path: '/admin/loan_types',                     component: LoanTypes},
    {path: '/admin/loan_types/:id',                 component: LoanType},
    
    {path: '/loans',                                component: LoanAll},
    {path: '/loans/new',                            component: LoanInitiate},
    {path: '/loans/admin',                          component: LoanAdmin},
    {path: '/loans/:id',                            component: LoanSingle},
    //{path: '/loans/:id/guarantor_request',          component: GuarantorFormRequest},
    
    {path: '/staff/loans',                          component: LoanStaff},
    {path: '/staff/loans/create_cpm/:id',           component: LoanDetailCPM},
    {path: '/staff/loans/pending',                  component: LoanPending},
    {path: '/staff/loans/undisbursed',              component: LoanUndisbursed},
    {path: '/staff/loans/:id',                      component: LoanStaffSingle},
    {path: '/staff/accounts/assigned',              component: LoanAssigned},
    {path: '/staff/accounts/assigned/:id',          component: LoanAssignedSingle},
    {path: '/staff/confirm/loans',                  component: LoanConfirmAll},
    {path: '/staff/confirm/loans/:id',              component: LoanConfirm},
];

export default routes