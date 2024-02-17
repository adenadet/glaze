import Vue from 'vue';
import Vuex from 'vuex';

import getters from './getters.js';
import * as actions from './actions.js';
import mutations from './mutations.js';

import firstCentral from "./modules/firstCentral.js";
import periculum from "./modules/periculum.js";
Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        firstCentral, periculum
    },
    state: {

    },
    mutations, actions, getters,

});