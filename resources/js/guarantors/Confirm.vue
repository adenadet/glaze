<template>
    <section>
        <GuarantorFormConfirm />
        <GuarantorFormConfirmFiles />
        <GuarantorDetailThanks />
        <GuarantorDetailDone />
    </section>
</template>
<script>
export default {
    data(){
        return  {
            account: {},
            editMode: false,
            guarantor: {},
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
    },
    methods:{
        getInitials(){
            axios.get('/api/guarantor_requests/'+this.$route.params.id)
            .then(response => {
                this.loadPage(response);
                toast.fire({ icon: 'success', title: 'Loan Accounts loaded successfully', });
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({ icon: 'error', title: 'Loan Accounts not loaded successfully', });
            });
        },
        loadPage(response){
            this.account = response.data.account;
            this.nations = response.data.nations;
            this.status = response.data.status;
            this.message = response.data.message;
        },

    },
    props:{},
}
</script>