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
            <LoanDetailGuarantors />
        </div>
        <div class="col-md-6">
            <LoanDetailRepayments />
        </div>
        <div class="col-md-4"> 
            <div class="card custom-card"> 
                <div class="card-header justify-content-between"> 
                    <div class="card-title"> Upcoming Repayment Date </div>
                </div> 
                <div class="card-body"> 
                    <div class="tab-content pt-3 my-3"> 
                        <div class="tab-pane show active border-0 p-0" id="mon" role="tabpanel"> 
                            <ul class="list-unstyled mb-0 upcoming-events-list" style="width:100% !important"> 
                                <li> 
                                    <div class="d-flex align-items-top justify-conent-between"  style="width:100% !important"> 
                                        <div class="flex-fill"> 
                                            <p class="mb-0 fs-14">Meeting with client</p>
                                            <p class="mb-0 text-muted">Video Conference</p>
                                        </div> 
                                        <div> 
                                            <span class="text-muted">
                                                <i class="fa-regular fa-clock align-middle ml-1 mr-1 d-inline-block"></i>9:00am - 10:00am
                                            </span> 
                                        </div>
                                        <div class="text-right border-left ml-5"> &nbsp; &nbsp;
                                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu">
                                                <button class="btn btn-block dropdown-item" @click="makeRepayment({})"><i class="fa fa-money-bill mr-1 text-success"></i> Pay Now</button>
                                                <button class="btn btn-block dropdown-item" @click="deleteLoan(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                                            </div> 
                                        </div> 
                                    </div> 
                                </li>  
                            </ul> 
                        </div>  
                    </div> 
                </div> 
            </div> 
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