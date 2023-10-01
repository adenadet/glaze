<template>
    <div class="card custom-card">
        <div class="modal fade" id="repaymentModal" tabindex="-1" aria-labelledby="repaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repaymentModalLabel">New Loan Repayment</h5>
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close" @click="closeModal()"><i class="fa fa-times text-success"></i></button>
                    </div>
                    <div class="modal-body">
                        <LoanFormRepayment :loan="account"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header">
            <h3 class="card-title">Repayments </h3> 
        </div>
        <div class="card-body"> 
            <div class="table-responsive" v-if="repayments != null && repayments.data != null && repayments.data.length != 0">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Details</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="repayment in repayments.data" :key="repayment.id">
                            <td>{{ repayment.date | excelDate }}</td>
                            <td>{{ repayment.payment_mode_id }}</td>
                            <td>{{ repayment.description }}</td>
                            <td>{{ repayment.amount | currency }}</td>
                            <td v-if="repayment.status == 3"><span class="badge bg-outline-primary">Confirmed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" v-else>
                <div class="col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">No Repayments Yet</span>
                            <span class="info-box-number">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            account: {},
            editMode: false,
            form: new Form({}),
            repayments: {},
            repayment: {},
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