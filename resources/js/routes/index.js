import Vue from 'vue';
import VueRouter from 'vue-router';

//import applicant from './applicant';
import approvals from './approvals';
import chats from './chats';
import customers from './customers';
import contacts from './contacts';
import dashboard from './dashboard';
//import domiciliary from './domiciliary';
//import eservices from './eservices';
//import external from './external';
//import hims from './hims';
//import hr from './hr';
import guarantor from './guarantor';
//import learn from './learn';
import loans from './loans';
import notices from './notices';

//import operations from './operations';
import policies from './policies';
import profile from './profile';
import settings from './settings';
import som from './som';
import test from './test';
import ticketing from './ticketing';
import ums from './ums';

const baseRoutes = [];
const routes = baseRoutes.concat(
    approvals,
    chats,
    contacts,
    customers,
    dashboard,
    //eservices,
    //external,
    //hims, 
    guarantor,
    //hr, 
    //learn,
    loans,
    notices, 
    policies,
    profile,
    settings,
    som,
    test,
    ticketing,
    ums,
    );

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router