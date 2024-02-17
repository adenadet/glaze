<template>
<div class="col-md-12">
    <div class="modal fade" id="loanModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ editMode ? 'Edit Loan Request: '+ loan.name : 'Create New Loan Request'}}</h4>
                    <button type="button" class="close" data-dismiss="modal" @click="closeModal()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <LoanForm :editMode="editMode" :loan="loan"/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="GuarantorModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ editMode ? 'Edit Guarantor Request: '+ loan.name : 'Create New Guarantor Request'}}</h4>
                    <button type="button" class="close" data-dismiss="modal" @click="closeModal()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <GuarantorFormRequest :editMode="editMode" :guarantor="guarantor"/>
                </div>
            </div>
        </div>
    </div>
    <div class="card custom-card"> 
        <div class="card-header justify-content-between"> 
            <div class="card-title"> Loans </div> 
            <div class="card-tools"> 
                <button class="btn btn-sm btn-primary" @click="addNew()"><i class="fa fa-plus mr-1"></i> Request New</button> 
            </div> 
        </div> 
        <div class="card-body"> 
            <div class="table-responsive"> 
                <table class="table" v-if="accounts != null && accounts.data != null && accounts.data.length != 0 "> 
                    <thead>
                        <tr>
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
                            <th scope="row">{{account.name}} <br /><span class="text-muted">{{ account.unique_id }}</span></th>
                            <td>{{ account.type ? account.type.name : 'Old Type' }}</td>
                            <td>{{ account.amount | currency}}</td>
                            <td class="text-warning">{{ account.balance | currency}}</td>
                            <td>{{ account.created_at | excelDate }}</td>
                            <td>{{ account.duration }} {{ account.frequency }}</td>
                            <td><span class="badge bg-outline-primary">{{ account.status < 3 ? 'Awaiting Guarantors' : (account.status > 16 ? 'Ongoing' : 'Processing') }}</span></td>
                            <td>
                                <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu">
                                    <router-link class="btn btn-block dropdown-item" :to="'/loans/'+account.id"><i class="fa fa-eye mr-1 text-primary"></i> View </router-link>
                                    <button v-if="account.status < 5" class="btn btn-block dropdown-item" @click="addGuarantors(account)"><i class="fa fa-user-friends mr-1 text-primary"></i> Add Guarantor </button>
                                    <button v-if="account.status > 13" class="btn btn-block dropdown-item" @click="closeLoan()"><i class="fa fa-times mr-1 text-danger"></i> Liquidate Loan</button>
                                    <button v-else class="btn btn-block dropdown-item" @click="deleteLoan(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                                </div>
                            </td>
                        </tr> 
                    </tbody>
                </table>
                <div v-else>
                    No Loan Has been created
                </div>
            </div> 
        </div>    
    </div> 
</div>
</template>
<script>
export default {
    data(){
        return  {
            accounts: {},
            account: {},
            all_banks: [],
            editMode: false,
            form: new Form({}),
            guarantor: {},
            loan: {},
            loan_types: [],
            option_mode: '',
            initial_route: '',
        }
    },
    created() {
        this.getInitials();
        Fire.$on('reloadLoans', response =>{
            this.reloadPage(response);
            this.closeModal();
        });
        Fire.$on('reload', response =>{
            this.getInitials();
            this.closeModal();
        });
        Fire.$on('getGuarantors', response => {
            this.closeModal();
            this.account = response.data.current_loan;
            this.addGuarantors(response.data.current_loan);
        });
    },
    methods:{
        addGuarantors(account){
            this.$Progress.start();
            Fire.$emit('GuarantorDataFill', account);
            $('#GuarantorModal').modal('show');
            this.$Progress.finish();
        },
        addNew(){
            this.$Progress.start();
            this.editMode = false;
            this.loan = {};
            Fire.$emit('LoanDataFill', {});
            $('#loanModal').modal('show');
            this.$Progress.finish();
        },
        assignLoan(loan){

        },
        closeLoan(){

        },
        closeModal(){
            $('#loanModal').modal('hide');
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
                //Send Delete request
                if(result.value){
                    this.form.delete('/api/loans/accounts/'+id)
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
        getInitials(){
            this.initial_route = '/api/loans/accounts';
            this.option_mode = "customer";
            axios.get(this.initial_route).then(response =>{
                this.reloadPage(response);
                toast.fire({icon: 'success', title: 'Loan Accounts loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Loan Accounts not loaded successfully',});
            });
        },
        reloadPage(response){
            this.accounts = response.data.accounts;
            this.all_banks = response.data.all_banks;
            this.loan_types = response.data.loan_types;
        },
    },
    props:{
        mode: String,
        user: Object,
    },
}
</script>