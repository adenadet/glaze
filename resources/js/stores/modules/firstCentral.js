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
    checkValidLogin({state, commit}){
        axios.post(state.domain+'/ValidateTicket', {
            DataTicket: state.user.dataTicket,
        })
        .then(response => {
            if (response.data.IsTicketValidResult == "False"){
                this.getNewDataTicket();                
            }
        })
    },
    loginUser({state, commit}){
        if (state.user.dataTicket == '' || state.user.dataTicket == null){
            axios.get('/api/servers/first_central')
            .then(response => {
                console.log(response.data[0])
                if (response.data[0].DataTicket){
                    //localStorage.set("userToken", response.data.access_token);
                    commit('setUser', response.data[0]);   
                }
            })
        }
        else{
            axios.post('/api/servers/first_central/validate', {
                'token': state.user.dataTicket,
            })
            .then(response => {
                if (response.data.IsTicketValidResult != "True"){
                    axios.get('/api/servers/first_central')
                    .then(response => {
                        console.log(response.data[0])
                        if (response.data[0].DataTicket){
                            //localStorage.set("userToken", response.data.access_token);
                            commit('setUser', response.data[0]);   
                        }
                    })              
                }
            })
        }
    },
    getNewDataTicket({state, commit}){
        axios.post('/api/servers/first_central/validate', {
            'token': state.user.dataTicket,
        })
        .then(response => {
            if (response.data[0].IsTicketValidResult == "False"){
                axios.get('/api/servers/first_central')
                .then(response => {
                    console.log(response.data[0])
                    if (response.data[0].DataTicket){
                        commit('setUser', response.data[0]);   
                    }
                })              
            }
        })
    },
};
const mutations = {
    setUser(state, data){
        state.user.dataTicket = data.dataTicket;
    }
};

export default{
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}