import Vue from 'vue';

let loader = null;
function hideLoader(){
    loader.close();
}

function showLoader(text="Loading"){
    loader = Vue.prototype.$loading({
        lock: true,
        text: text,
        spinner: 'fa fa-loading',
        background: 'rgba(255, 255, 255, 0.85)',
    });
}

export const FCCLogin = ({commit}, payload = {"username":"demo", "password":"demo@123"}) => {

    let url = 'https://uat.firstcentralcreditbureau.com/firstcentralrestv2/login';
    showLoader('Login to First  ')
    axios.post(url, payload)
    .then (response =>{
        Vue.prototype.$notify({
            title: "Success",
            message: 'Login Successful',
        })
        hideLoader();
    })
    .close(()=>{

    });

}