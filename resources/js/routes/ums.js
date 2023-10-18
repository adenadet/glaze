import Vue from 'vue';
import VueRouter from 'vue-router';

import UserAdmin                from '../users/Admin.vue';    
import UserAll                  from '../users/All.vue';
import UserCard                 from '../users/Card.vue';
import UserRoles                from '../users/Roles.vue';  
import UserStaffs               from '../users/Staffs.vue';  

    import UserDetailAddress    from '../users/details/Address.vue';
    import UserDetailBasic      from '../users/details/Basic.vue';
    import UserDetailKYC        from '../users/details/KYC.vue';
    import UserDetailNOK        from '../users/details/NOK.vue';
    import UserDetailSocial     from '../users/details/Social.vue';

    import UserFormAddress      from '../users/forms/Address.vue';    
    import UserFormAssignRole   from '../users/forms/AssignRole.vue';    
    import UserFormBasic        from '../users/forms/Basic.vue'; 
    import UserFormKYC          from '../users/forms/KYC.vue';
    import UserFormNOK          from '../users/forms/NextOfKin.vue'; 
    import UserFormRole         from '../users/forms/Role.vue';    
    import UserFormStaff        from '../users/forms/Staff.vue';
    import UserFormUser         from '../users/forms/BioData.vue'; 
    
Vue.component('UserRoles',              UserRoles);
Vue.component('UserAll',                UserAll);
Vue.component('UserCard',               UserCard);
Vue.component('UserStaffs',             UserStaffs);

    Vue.component('UserDetailAddress',  UserDetailAddress);
    Vue.component('UserDetailBasic',    UserDetailBasic);
    Vue.component('UserDetailKYC',      UserDetailKYC);
    Vue.component('UserDetailNOK',      UserDetailNOK);
    Vue.component('UserDetailSocial',   UserDetailSocial);

    Vue.component('UserFormAddress',    UserFormAddress);
    Vue.component('UserFormAssignRole', UserFormAssignRole);
    Vue.component('UserFormBasic',      UserFormBasic);
    Vue.component('UserFormKYC',        UserFormKYC);
    Vue.component('UserFormNOK',        UserFormNOK);
    Vue.component('UserFormRole',       UserFormRole);
    Vue.component('UserFormStaff',      UserFormStaff);
    Vue.component('UserFormUser',       UserFormUser);


let routes = [
    {path: '/admin/users',          component: UserAdmin},
    {path: '/users',                component: UserAll},
    {path: '/users/all',            component: UserAll},
    {path: '/users/roles',          component: UserRoles},
];

export default routes