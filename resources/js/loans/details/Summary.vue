<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Loan Summary</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-bordered table-hover table-stripped">
                <tbody>
                    <tr>
                        <td >Loan Name/ID</td>
                        <td colspan="3"><strong>{{ account.name }} [{{ account.unique_id }}]</strong></td>
                        <td>Loan Type</td>
                        <td><strong>{{ account.type ? account.type.name : 'Old Type' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Request Date</td>
                        <td><strong>{{ account.request_date | excelDate }}</strong></td>
                        <td>Guaranteed On</td>
                        <td><strong>{{ account.guaranteed_at | excelDate }}</strong></td>
                        <td>Approved On</td>
                        <td><strong>{{ account.created_at | excelDate }}</strong></td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td colspan="2"><strong>{{ account.created_at | excelDate }}</strong></td>
                        <td>Guaranteed On</td>
                        <td colspan="2"><strong>{{ account.created_at | excelDate }}</strong></td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td><strong>{{ account.amount | currency }}</strong></td>
                        <td>Estimated Monthly Installment</td>
                        <td><strong>{{ account.emi | currency }}</strong></td>
                        <td>Payment Summary</td>
                        <td><strong>{{ account.balance | currency }} / {{ account.payable | currency }}</strong></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><strong>{{ account.status < 4 ? 'Filing' : (account.status == 4 ? 'Awaiting Guarantors' : (account.status > 4 && account.status <= 13 ? 'Processing' : (account.status == 14 ? 'Ongoing' : 'Closed')))}}</strong></td>
                        <td>Closed Date</td>
                        <td><strong>{{ (account.status == 14 ? account.updated_at | excelDate : 'N/A') }}</strong></td>
                        <td>Account Officer</td>
                        <td><strong>{{ account.account_officer | FullName }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            account: {},
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
        reloadPage(response){
            this.account = response.data.account;
            //this.repayments = response.data.repayments;
        }
    },
    mounted() {
        this.getAllInitials();
    },
}
</script>