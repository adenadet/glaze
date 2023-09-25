import Vue from 'vue';
import VueRouter from 'vue-router';

import Profile from '../profile/Profile.vue';
import PMFormAddress from '../profile/forms/Address.vue';
import PMFormBasic from '../profile/forms/Basic.vue';
import PMFormBioData from '../profile/forms/BioData.vue';
import PMFormNOK from '../profile/forms/NextOfKin.vue';
import PMFormPassword from '../profile/forms/Password.vue';
import PMFormSocials from '../profile/forms/Socials.vue';


Vue.component('Profile',        Profile);
Vue.component('PMFormAddress',  PMFormAddress);
Vue.component('PMFormBasic',  PMFormBasic);
Vue.component('PMFormBioData',  PMFormBioData);
Vue.component('PMFormNOK',      PMFormNOK);
Vue.component('PMFormPassword', PMFormPassword);
Vue.component('PMFormSocials', PMFormSocials);
let routes = [
    {path: '/profile', component: Profile},
];

export default routes