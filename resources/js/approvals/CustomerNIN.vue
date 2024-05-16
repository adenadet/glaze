<template>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <ApproveDetailsUserCard :user="user" type="customer" />
        </div>
        <div class="col-md-8">
            <ApproveFormNin :user="user" type="customer"/>
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
            axios.get('/api/ums/nin_verifications/'+this.$route.params.id+'/?point=customer')
            .then(response =>{
                this.reloadPage(response);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'NIN Number was not loaded successfully',});
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