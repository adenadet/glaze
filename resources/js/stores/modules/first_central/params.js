import Vuex from 'vue';

export default{
    state: {
        username: '',
        password: '',
        DataTicket: '',
    },
    mutations: {
        SET_USERNAME: (state, DataTicket) => {
            state.DataTicket = DataTicket;
        }
    },
    getters: {
        DataTicket: state => {
            return state.DataTicket;
        }
    },
    actions: {
        LOGI
    }
}