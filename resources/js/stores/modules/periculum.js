const state = {
    domain: "https://insightsb2b.auth-periculum.app/realms/prod/protocol/openid-connect/token",
    user:{
        client_id: 'insights-glazecredit-api',
        client_secret: 'anewSQqfl9X1eMda4OUVGUHeqbm7bQ2X',
        grant_type: 'client_credentials',
        et: null, 
    }
};
const getters = {};
const actions = {
    loginUser({state, commit}){
        if (state.user.et == '' || state.user.et == null){
            //console.log(state.user.grant_type);
            axios.post('/api/servers/periculum')
            .then(response => {
                console.log(response);
                if (response.data.access_token != null ){
                    commit('setUserToken', response.data);   
                }
            })
        }
        else{
            axios.post('/api/servers/periculum/validate', {
                'token': state.user.dataTicket,
            })
            .then(response => {
                if (response.data.IsTicketValidResult != "True"){
                    axios.get('/api/servers/periculum')
                    .then(response => {
                        console.log(response.data)
                        if (response.data.access_token){
                            //localStorage.set("userToken", response.data.access_token);
                            commit('setUserToken', response.data);   
                        }
                    })              
                }
            })
        }
    },
    getNewDataTicket({state, commit}){
        axios.post('/api/servers/periculum/login', {})
        .then(response => {
            if (response.data[0].IsTicketValidResult == "False"){
                axios.get('/api/servers/periculum/login')
                .then(response => {
                    //console.log(response.data)
                    if (response.data.access_token){
                        commit('setUserToken', response.data);   
                    }
                })              
            }
        })
    },
};
const mutations = {
    setUserToken(state, data){
        //console.log(data.access_token);
        state.user.et = data.access_token;
    }
};

export default{
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}