<template>
<section class="col-md-12">
    <div class="modal fade" id="repaymentModal" tabindex="-1" aria-labelledby="repaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="repaymentModalLabel">Modal title</h5>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close" @click="closeModal()"><i class="fa fa-times text-success"></i></button>
                </div>
                <div class="modal-body">
                    <LoanFormRepayment />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">   
            <LoanDetailSummary />
        </div>
        <div class="col-md-6">
            <LoanDetailGuarantors source="Customer"/>
        </div>
        <div class="col-md-6">
            <LoanDetailFiles source="Customer" :account="account" :files="account.files"/>
        </div>
        <div class="col-md-12">
            <LoanDetailRepayments />
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            account: {},
            repayments: {},
            editMode: false,
            form: new Form({}),
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/loans/accounts/'+this.$route.params.id).then(response =>{
                this.reloadPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Account was loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Accounts was not loaded successfully',
                })
            });
        },
        makeRepayment(repayment){
            Fire.$emit('RepaymentDataFill', repayment);
            $('#repaymentModal').modal('show');
            this.$Progress.finish();
        },
        getPolicy(page=1){
            axios.get('/api/policies/all/departmental?page='+page)
            .then(response=>{
                this.Policys = response.data.Policys;   
            });
        },
        reloadPage(response){
            this.account = response.data.account;
            this.repayments = response.data.repayments;
        }
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/Policys/search?q='+query)
            .then((response ) => {
                this.Policys = response.data.Policys;
            })
            .catch(()=>{

            });
        });
        Fire.$on('Reload', response =>{
            $('#PolicyModal').modal('hide');
            this.Policys = response.data.Policys;
        });
    },
}
</script>