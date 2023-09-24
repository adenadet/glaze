import Vue from 'vue';
import VueRouter from 'vue-router';

import DashboardAdmin       from '../dashboard/Admin.vue';
import DashboardMain        from '../dashboard/Main.vue';
import DashboardStaff       from '../dashboard/Staff.vue';


import DashboardBirthday    from '../dashboard/partials/Birthday.vue';
import DashboardChat        from '../dashboard/partials/Chat.vue';
import DashboardNewStaff    from '../dashboard/partials/NewStaff.vue';
import DashboardNotice      from '../dashboard/partials/Notice.vue';
import DashboardStaffMonth  from '../dashboard/partials/StaffMonth.vue';
import DashboardSummary     from '../dashboard/partials/Summary.vue';
import DashboardTicket      from '../dashboard/partials/Ticket.vue';

Vue.component('DashboardMain',          DashboardMain);
Vue.component('DashboardBirthday',      DashboardBirthday);
Vue.component('DashboardChat',          DashboardChat);
Vue.component('DashboardNewStaff',      DashboardNewStaff);
Vue.component('DashboardNotice',        DashboardNotice);
Vue.component('DashboardStaff',         DashboardStaff);
Vue.component('DashboardStaffMonth',    DashboardStaffMonth);
Vue.component('DashboardSummary',       DashboardSummary);
Vue.component('DashboardTicket',        DashboardTicket);


let routes = [
    {path: '/admin-dashboard',  component: DashboardAdmin}, 
    {path: '/home',             component: DashboardMain},
    {path: '/dashboard',        component: DashboardMain},
    {path: '/staff/dashboard',  component: DashboardStaff},
];


export default routes