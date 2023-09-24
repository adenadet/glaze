import Vue from 'vue';
import VueRouter from 'vue-router';

import TestMultiForm        from '../test/MultiForm.vue';


Vue.component('TestMultiForm', TestMultiForm);


let routes = [
    {path: '/test',          component: TestMultiForm},

];

export default routes