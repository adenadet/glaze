<template>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <ApproveDetailsUserCard :user="user" type="customer" />
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Confirm {{ type | firstUp }} BVN</h3>
                </div>
                <div class="card-body">
                    <ApproveFormBvn :user="user" type="customer"/>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    computed:{
        periculumUser: {
            get(){
                return this.$store.state.periculum.user;
            }
        }
    },
    data(){
        return {
            type: 'customer',
            user: {},
        }
    },
    methods:{
        getInitials(){
            this.$Progress.start();
            axios.get('/api/ums/bvn_verifications/'+this.$route.params.id+'/?point=customer')
            .then(response =>{
                this.reloadPage(response);
                this.$Progress.finish();
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
            this.user = response.data.user;
        },
    },
    mounted() {
        this.getInitials();
        Fire.$on('BasicDataFill', user => {
            this.user = user;
        });
    },
}
</script>