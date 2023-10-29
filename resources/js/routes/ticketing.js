import Vue from 'vue';
import VueRouter from 'vue-router';

import TicketAdmin              from '../ticketing/Admin.vue';

import TicketDepartment         from '../ticketing/Department.vue';
import TicketPersonal           from '../ticketing/Personal.vue';
import TicketPersonalSummary    from '../ticketing/PersonalSummary.vue';
import TicketSetting            from '../ticketing/Setting.vue';
import TicketSingle             from '../ticketing/Single.vue';

import TicketStaff              from '../ticketing/Staff.vue';
import TicketStaffSingle        from '../ticketing/StaffSingle.vue';

    import TicketFormAssign     from '../ticketing/forms/Assign.vue';
    import TicketFormAccept     from '../ticketing/forms/Accept.vue';
    import TicketFormComplete   from '../ticketing/forms/Complete.vue';
    import TicketFormNew        from '../ticketing/forms/New.vue';
    import TicketFormReply      from '../ticketing/forms/Reply.vue';

Vue.component('TicketAdmin',            TicketAdmin);
Vue.component('TicketDepartment',       TicketDepartment);
Vue.component('TicketPersonal',         TicketPersonal);
Vue.component('TicketPersonalSummary',  TicketPersonalSummary);
Vue.component('TicketSingle',           TicketSingle);

Vue.component('TicketStaff',            TicketStaff);
Vue.component('TicketStaffSingle',      TicketStaffSingle);

    Vue.component('TicketFormAccept',   TicketFormAccept);
    Vue.component('TicketFormAssign',   TicketFormAssign);
    Vue.component('TicketFormComplete', TicketFormComplete);
    Vue.component('TicketFormNew',      TicketFormNew);
    Vue.component('TicketFormReply',    TicketFormReply);

let routes = [
    {path: '/staff/tickets',          component: TicketStaff},
    {path: '/staff/tickets/:id',      component: TicketStaffSingle},
    {path: '/tickets',                component: TicketPersonal},
    {path: '/tickets/admin',          component: TicketAdmin},
    {path: '/tickets/settings',       component: TicketSetting},
    {path: '/tickets/department',     component: TicketDepartment},
    {path: '/tickets/:id',            component: TicketSingle},
];

export default routes