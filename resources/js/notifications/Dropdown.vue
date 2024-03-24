<template>

</template>
<script>
export default {
    data(){
        return  {
            notifications: {},
        }
    },
    created() {
        this.getInitials();
        Fire.$on('reloadLoans', response =>{
            this.reloadPage(response);
            this.closeModal();
        });
        Fire.$on('reload', () =>{this.closeModal(); this.getInitials(); });
        Fire.$on('getGuarantors', response => {
            this.closeModal();
            this.account = response.data.current_loan;
            this.continue_to = "AccountStatement";
            this.addGuarantors(response.data.current_loan);
        });
        Fire.$emit('addAccountStatement', id => {
            this.closeModal();
            this.continue_to = "";
            this.addFiles("account_statement", id);
        })
    },
    methods:{
        addFiles(type = null , id){
            this.$Progress.start();
            this.file_type = type,
            Fire.$emit('FileDataFill', id);
            $('#fileModal').modal('show');
            this.$Progress.finish();
        },
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
            $('#collateralModal').modal('hide');
            $('#fileModal').modal('hide');
            $('#GuarantorModal').modal('hide');
            $('#loanModal').modal('hide');
            $('#statementModal').modal('hide');
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
        getInitials(page=1){
            axios.get('/api/ums/notifications?page='+page+'&limit=4').then(response =>{
                this.closeModal();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Loan Accounts not loaded successfully',});
            });
        },
        reloadPage(response){
            this.closeModal();
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
