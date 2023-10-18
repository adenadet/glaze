<template>
<section >
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Loan Credit Score</h3>
        </div>
        <div class="card-body">
            <div v-if="credit_score != null && credit_score.id != null">
                <div class="info-box">
                    <span class="info-box-icon"><i class="fa fa-check"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Matching Rate</span>
                        <span class="info-box-number">{{credit_score}}</span>
                    </div>
                </div>
            </div>
            <LoanFormCreditScore :editMode="editMode" :account="account" :bureaus="bureaus" :bureau_products="bureau_products" v-else/>
        </div>
    </div>
</section>
</template>
<script>
export default {
    computed:{

    },
    data(){
        return  {
            account: {},
            bureaus: [],
            bureau_products: [],
            credit_score: {},
            checkData: new Form({
                DataTicket: "",
                EnquiryReason:"",
                ConsumerName:"",
                DateOfBirth:"",
                Identification:"22471069115",
                Accountno:"",
                ProductID:"45",
            }),
            editMode: false,
            loader: null,
            loan: {},
            products: [],
        }
    },
    mounted(){
        this.getInitials();
        Fire.$on('AddressDataFill', base =>{
            this.address = base;
            base != null ? this.AddressData.fill(base) : this.AddressData.clear();
        });
    },
    methods:{
        loginToFirstCentral(){
            this.$store.dispatch('FCCLogin');
        },
        getCreditScore(){},
        getInitials(){
            this.$Progress.start();
            this.showLoader();
            axios.get('/api/loans/accounts/credit_scores/'+this.$route.params.id).
            then(response =>{
                this.reloadPage(response);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Accounts was not loaded successfully',
                })
            });
        },
        hideLoader(){
            loader.close();
        },
        reloadPage(response){
            this.account = response.data.account;
            this.bureaus = response.data.bureaus;
            this.bureau_products = response.data.bureau_products;
            this.credit_score = response.data.credit_score;
            this.editMode = response.data.credit_score.id != null ? false : true;
        },
        showLoader(text="Loading"){
            /*loader = Vue.prototype.$loading({
                lock: true,
                text: text,
                spinner: 'fa fa-loading',
                background: 'rgba(255, 255, 255, 0.85)',
            });*/
        }

    },  
    props:{

    },
}
</script>