<template>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <ApproveDetailsUserCard :user="guarantor" type="guarantor" />
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Confirm Guarantor BVN</div>
                    <div class="card-body"><ApproveFormBvn type="guarantor" :user="guarantor"/></div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    data(){
        return {
            guarantor: {},
        }
    },
    methods:{
        getAllInitials(page = 1){
            axios.get('/api/ums/bvn_verifications/'+this.$route.params.id+'/?point=guarantor')
            .then(response =>{
                this.guarantor = response.data.user;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Bank Verification Numbers not loaded successfully',});
            });
        },

    },
    mounted() {
        this.getAllInitials();
    },
    props:{
        specific: String,
    },
}
</script>