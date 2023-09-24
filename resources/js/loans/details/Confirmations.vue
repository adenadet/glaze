<template>
    <div class="timeline timeline-inverse" v-for="action in actions.data">
        <div>
            <i class="fas fa-envelope bg-primary"></i>

            <div class="timeline-item">
                <span class="time"><i class="far fa-clock"></i> 12:05</span>

                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            account: {},
            checklists: {},
            editMode: false,
            form: new Form({}),
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/loans/confirmations/'+this.$route.params.id).then(response =>{
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
            this.checklists = response.data.checklists;
        }
    },
    mounted() {
        this.getAllInitials();
    },
}
</script>
