<template>
<section class="col-md-12">
    <div class="modal fade" id="loanCPMModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
        <div class="modal-xl modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h6 class="modal-title">{{editMode ? 'Update Loan CPM' : 'Create New Loan CPM'}} </h6> 
                    <button type="button" class="btn-default btn btn-sm" data-bs-dismiss="modal" aria-label="Close" @click="closeModal()">
                        <i class="text-danger fa fa-times"></i>
                    </button> 
                </div> 
                <div class="modal-body p-3"> 
                    <LoanFormCPM :editMode="editMode" :account="account"/>
                </div> 
            </div>
        </div> 
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Assigned Loan Accounts</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="th-dark">
                    <tr>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Loan Name</th>
                        <th scope="col">Loan Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Created On</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr> 
                </thead> 
                <tbody>
                    <tr v-for="account in accounts.data" :key="account.id">
                        <td>{{ account.user | FullName }}</td>
                        <th scope="row">{{account.name}} <br /><span class="text-muted">{{ account.unique_id }}</span></th>
                        <td>{{ account.type ? account.type.name : 'Old Type' }}</td>
                        <td>{{ account.amount}}</td>
                        <td class="text-warning">{{ account.balance}}</td>
                        <td>{{ account.created_at | excelDate }}</td>
                        <td>{{ account.duration }} weeeks</td>
                        <td><span class="badge bg-outline-primary">{{ account.status }}</span></td>
                        <td>
                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                            <div class="dropdown-menu">
                                <router-link class="btn btn-block dropdown-item" :to="'/staff/loans/'+account.id"><i class="fa fa-eye mr-1 text-primary"></i> View Loan Account</router-link>
                                <router-link class="btn btn-block dropdown-item" :to="'/staff/confirm/loans/'+account.id"><i class="fa fa-check mr-1"></i> Confirmation</router-link>
                                <button v-show="account.cpm != null" class="btn btn-block dropdown-item" @click="updateCPM(account)"><i class="fa fa-file mr-1"></i> Update Proposal Memo</button>
                                <button v-show="account.cpm == null" class="btn btn-block dropdown-item" @click="createCPM(account)"><i class="fa fa-file mr-1"></i> Create Proposal Memo</button>
                                <router-link class="btn btn-block dropdown-item" :to="'/staff/customers/'+account.user_id"><i class="fa fa-user mr-1 text-success"></i> View Customer</router-link>
                                <button v-if="account.status > 13" class="btn btn-block dropdown-item" @click="closeLoan()"><i class="fa fa-times mr-1 text-danger"></i> Close Loan</button>
                                <button v-else class="btn btn-block dropdown-item" @click="deleteLoan(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                            </div>
                        </td>
                    </tr> 
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <pagination :data="accounts" @pagination-change-page="getInitials"><span slot="prev-nav">&lt; Previous </span><span slot="next-nav">Next &gt;</span></pagination>
        </div>
    </div>      
</section>
</template>
<script>
export default {
    data(){
        return  {
            editMode: false,
            accounts: {},
            account: {},
            all_banks: [],
            loan_types: [],
            option_mode: '',
            initial_route: '',
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshCPM', response => {this.getInitials();});
    },
    methods:{
        addNew(){
            console.log("Working");
            this.$Progress.start();
            this.editMode = false;
            this.loan = {};
            Fire.$emit('LoanDataFill', {});
            $('#loanModal').modal('show');
            this.$Progress.finish();
        },
        closeLoan(){

        },
        closeModal(){
            $('#loanModal').modal('hide');
            $('#loanCPMModal').modal('hide');
        },
        createCPM(account){
            this.account = account;
            this.editMode = false;
            Fire.$emit('hidePreCPM', account.cpm);
            $('#loanCPMModal').modal('show');
        },
        deleteLoan(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                if(result.value){
                    this.form.delete('/api/loans/account_officers/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Loan Account has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        getInitials(page=1){
            axios.get('/api/loans/account_officers?page='+page).then(response =>{
                this.reloadPage(response);
                //toast.fire({icon: 'success', title: 'Assigned Loan Accounts loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Assigned Loan Accounts not loaded successfully',});
            });
        },
        reloadPage(response){
            this.accounts = response.data.accounts;
            this.all_banks = response.data.all_banks;
            this.loan_types = response.data.loan_types;
            this.closeModal();
        },
        updateCPM(account){
            this.editMode = true;
            this.account = account; 
            Fire.$emit('hidePreCPM', account.cpm);
            $('#loanCPMModal').modal('show');   
        },
    },
    props:{
        mode: String,
        user: Object,
    },
}
</script>