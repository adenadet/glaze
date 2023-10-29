<template>
<section class="col-md-12">
    <div class="modal fade" id="loanAssignModal"  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
        <div class="modal-xl modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h6 class="modal-title">Assign Loan Officer</h6> 
                    <button type="button" class="btn-default btn btn-sm" data-bs-dismiss="modal" aria-label="Close" @click="closeModal()">
                        <i class="text-danger fa fa-times"></i>
                    </button> 
                </div> 
                <div class="modal-body p-3"> 
                    <LoanFormAssign :loan="loan"/>
                </div> 
            </div>
        </div> 
    </div>
    <div class="card custom-card"> 
        <div class="card-header justify-content-between"> 
            <div class="card-title">All Loans </div> 
        </div> 
        <div class="card-body"> 
            <div class="table-responsive"> 
                <table class="table text-nowrap"> 
                    <thead>
                        <tr>
                            <th scope="col">Customer </th>
                            <th scope="col">Loan Name/ID </th>
                            <th scope="col">Loan Account Number</th>
                            <th scope="col">Loan Type</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Created On</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr> 
                    </thead> 
                    <tbody v-if="loans.data != null && loans.data.length != 0">
                        <tr v-for="loan in loans.data" :key="loan.id">
                            <th>{{ loan.user | FullName}}</th>
                            <td>{{ loan.name}} <br /><span class="text-muted">{{ loan.unique_id }}</span></td>
                            <td>{{ loan.bank ? loan.bank.name : ''}} | {{ loan.acct_name }} ( {{ loan.acct_number }})</td>
                            <td>{{ loan.type ? loan.type.name : 'Old Type' }}</td>
                            <td>{{ loan.amount | currency }}</td>
                            <td>{{ loan.total_paid | currency }} / {{ loan.payable | currency }}</td>
                            <td>{{loan.created_at | excelDate}}</td>
                            <td><span class="badge bg-outline-primary">{{loan.status}}</span></td>
                            <td>
                                <button type="button" class="btn btn-default-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu">
                                    <router-link class="btn btn-block dropdown-item" :to="'/staff/loans/'+loan.id"><i class="fa fa-eye mr-1 text-primary"></i> View </router-link>
                                    <!--router-link class="btn btn-block dropdown-item" :to="'/staff/loans/1'"><i class="fa fa-file mr-1 text-primary"></i> Add Files </router-link-->
                                    <button class="btn btn-block dropdown-item" @click="assignLoan(loan)"><i class="fa fa-user-cog mr-1 text-success"></i> Assign Loan</button>
                                    <button class="btn btn-block dropdown-item" @click="closeLoan()"><i class="fa fa-times mr-1 text-danger"></i> Close Loan</button>
                                    <button class="btn btn-block dropdown-item" @click="deleteLoan(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                                </div>
                            </td>
                        </tr> 
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="9">There are no loan request currently, kindly create one<br />
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div> 
        </div>    
    </div> 
</section>
</template>
<script>
export default {
    data(){
        return  {
            editMode: false,
            loans: {},
            loan: {},
        }
    },
    mounted() {},assignLoan(loan){

},
    created() {
        this.getInitials();
        Fire.$on('Reload', response =>{
            this.loans = response.data.accounts;
            this.closeModal();
        });
    },
    methods:{
        addNew(){
            this.editMode = false;
            this.loan = {};
            Fire.$emit('LoanDataFill', {});
            $('#loanModal').modal('show');
            this.$Progress.finish();
        },
        assignLoan(loan){
            this.loan = loan;
            alert(loan.id);
            Fire.$emit('LoanAssignDataFill', loan);
            $('#loanAssignModal').modal('show');
            this.$Progress.finish();
        },
        closeLoan(){

        },
        closeModal(){
            $('#loanModal').modal('hide');
            $('#loanAssignModal').modal('hide');
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
                    this.form.delete('/api/loans/accounts/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                    Fire.$emit('CatRefresh', response);
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        getInitials(){
            axios.get('/api/loans/accounts/staffs').then(response =>{
                this.loans = response.data.accounts;
                toast.fire({icon: 'success', title: 'Loan Accounts loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Loan Accounts not loaded successfully',});
            });
        },
    },
    props:{
        //'chat': Object,
    },
}
</script>