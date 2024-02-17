const state = {
    domain: "http://online.firstcentralcreditbureau.com/firstcentralrestv2",
    user:{
        username: 'GLAZE-CREDITAPI',
        password: 'glazecredit@100&',
        dataTicket: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImRlbW8iLCJwYXNzd29yZCI6ImRlbW9AMTIzIiwiaWF0IjoxNzAwMzA5MDA3LCJleHAiOjE3MTgzMDkwMDd9.vtRpG3o-K40zr25UXfYhfSTqb5clQ5Ou1TgHFxR3T0o', 
    }
};
const getters = {};
const actions = {
    loginUser({state, commit}){
        if (state.user.dataTicket == '' || state.user.dataTicket == null){
            axios.get('/api/servers/periculum/login')
            .then(response => {
                console.log(response.data[0])
                if (response.data[0].DataTicket){
                    //localStorage.set("userToken", response.data.access_token);
                    commit('setUser', response.data);   
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
                            commit('setUser', response.data);   
                        }
                    })              
                }
            })
        }
    },
    getNewDataTicket({state, commit}){
        axios.post('/api/servers/periculum/login', {
            'token': state.user.dataTicket,
        })
        .then(response => {
            if (response.data[0].IsTicketValidResult == "False"){
                axios.get('/api/servers/periculum/login')
                .then(response => {
                    console.log(response.data)
                    if (response.data.access_token){
                        commit('setUser', response.data);   
                    }
                })              
            }
        })
    },
};
const mutations = {
    setUser(state, data){
        state.user.dataTicket = data.access_token;
    }
};

export default{
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}