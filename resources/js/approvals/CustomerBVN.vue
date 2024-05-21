<template>
<section class="container-fluid overlay-wrapper">
    <div class="overlay" v-if="loading"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
    <div class="row">
        <div class="col-md-4">
            <ApproveDetailsUserCard :user="user" type="customer" />
        </div>
        <div class="col-md-8">
            <ApproveFormBvn type="customer" :user="user" verify="BVN"/>
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
            loading: true,
            type: 'customer',
            user: {},
        }
    },
    methods:{
        getInitials(){
            this.$Progress.start();
            this.loading = true;
            axios.get('/api/ums/bvn_verifications/'+this.$route.params.id+'?point=customer')
            .then(response =>{
                this.reloadPage(response);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Accounts was not loaded successfully',});
            });
        },
        reloadPage(response){
            this.user = response.data.user;
            this.loading = false;
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