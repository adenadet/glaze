import Vue from 'vue';
import VueRouter from 'vue-router';

import AdminDashboard       from '../dashboard/Admin.vue';

Vue.component('AdminDashboard',         AdminDashboard);

import BranchAdmin          from '../admin/branches/Admin.vue';
import BranchAll            from '../admin/branches/All.vue';
import BranchForm           from '../admin/branches/Form.vue';
import BranchSingle         from '../admin/branches/Single.vue';

Vue.component('BranchAdmin',            BranchAdmin);
Vue.component('BranchAll',              BranchAll);
Vue.component('BranchForm',             BranchForm);
Vue.component('BranchSingle',           BranchSingle);

import AdminCPMModuleAll        from '../admin/CPMModules.vue';
import AdminCPMModuleSingle     from '../admin/CPMModule.vue';

Vue.component('AdminCPMModuleAll',            AdminCPMModuleAll);
Vue.component('AdminCPMModuleSingle',         AdminCPMModuleSingle);

    import AdminFormCPMModule       from '../admin/forms/CPMModule.vue';
    import AdminFormCPMTemplate     from '../admin/forms/CPMTemplate.vue';

    Vue.component('AdminFormCPMModuleAll',            AdminFormCPMModule);
    Vue.component('AdminFormCPMTemplate',       AdminFormCPMTemplate);

import DepartmentAdmin     from '../admin/departments/Admin.vue';
import DepartmentAll       from '../admin/departments/All.vue';
import DepartmentForm      from '../admin/departments/Form.vue';
import DepartmentSingle    from '../admin/departments/Single.vue';

Vue.component('DepartmentAdmin',        DepartmentAdmin);
Vue.component('DepartmentAll',          DepartmentAll);
Vue.component('DepartmentForm',         DepartmentForm);
Vue.component('DepartmentSingle',       DepartmentSingle);

import LoanTypes from '../loans/Types.vue';
import LoanRequirements from '../loans/Requirements.vue';

Vue.component('LoanTypes',              LoanTypes);
Vue.component('LoanRequirements',       LoanRequirements);

import UserStaff        from '../users/Staff.vue';
import UserStaffs       from '../users/Staffs.vue';


Vue.component('UserStaff',              UserStaff);
Vue.component('UserStaffs',             UserStaffs);


let routes = [
    {path: '/admin',                        component: AdminDashboard},
    {path: '/admin/dashboard',              component: AdminDashboard},

    {path: '/admin/branches',               component: BranchAll},
    {path: '/admin/branches/:id',           component: BranchSingle},

    {path: '/admin/cpm_modules',            component: AdminCPMModuleAll},
    {path: '/admin/cpm_modules/:id',        component: AdminCPMModuleSingle},

    {path: '/admin/departments',            component:DepartmentAll},
    {path: '/admin/departments/:id',        component:DepartmentSingle},

    {path: '/admin/loan_requirements',      component: LoanRequirements},
    {path: '/admin/loan_types',             component: LoanTypes},

    {path: '/admin/staffs',                 component: UserStaffs},
    {path: '/admin/staffs/:id',             component: UserStaff},

];

export default routes