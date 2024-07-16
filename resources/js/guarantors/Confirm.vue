<template>
    <section class="container-fluid overlay-wrapper">
        <div class="overlay dark" v-if="loading"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Loan Summary</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered table-hover table-stripped">
                            <tbody>
                                <tr>
                                    <td >Loan Name</td>
                                    <td colspan="3"><strong>{{ account.name }} [{{ account.unique_id }}]</strong></td>
                                    <td>Loan Type</td>
                                    <td><strong>{{ account.type ? account.type.name : 'Old Type' }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Requested By</td>
                                    <td colspan="3"><strong>{{ account.user | fullName }}</strong></td>
                                    <td>Requested On</td>
                                    <td><strong>{{ account.created_at | excelDate }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Amount</td>
                                    <td colspan="2"><strong>{{ account.amount | currency }}</strong></td>
                                    <td>Estimated Monthly Installment</td>
                                    <td><strong>{{ account.emi | currency }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <GuarantorFormConfirm v-if="guarantor_request.status == 0 && guarantor == null" :nations="nations" :status="status"/>
        <GuarantorFormConfirmFiles v-else-if="guarantor_request != null && guarantor_request.status == 1 && guarantor != null && status == 'upload'" />
        <GuarantorDetailThanks v-else/>
    </section>
</template>
<script>
export default {
    data(){
        return  {
            account: {},
            editMode: false,
            guarantor: {},
            guarantor_request: {},
            loading: false,
            message: '',
            nations: [],
            options:{
				penColor:"rgb(0,0,255)",
				backgroundColor:"rgb(255,255,255)",
			},
            pad: 0,
            reject: false,
            request: {},
            status: '',
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('reloadGuarantorConfirm', response => {
            this.loadPage(response);
        });
    },
    methods:{
        getInitials(){
            this.loading = true;
            axios.get('/api/guarantor_requests/'+this.$route.params.id)
            .then(response => {
                this.loadPage(response);
                this.loading = false;
                toast.fire({ icon: 'success', title: 'Loan Accounts loaded successfully', });
            })
            .catch(() => {
                this.$Progress.fail();
                this.loading = false;
                toast.fire({ icon: 'error', title: 'Loan Accounts not loaded successfully', });
            });
        },
        loadPage(response){
            this.account = response.data.account;
            this.nations = response.data.nations;
            this.status = response.data.status;
            this.message = response.data.message;
            this.guarantor_request = response.data.guarantor_request;
            this.guarantor = response.data.guarantor;
        },

    },
    props:{},
}
</script>