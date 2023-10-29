<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8"><ChatPrivate :user="user"/></div>
            <div class="col-md-4"><ChatList /></div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            chats: {},
            chat: {
                id: 1,
                to: {
                    id: 3,
                    first_name: 'Stella',
                    middle_name: 'N.',
                    last_name: 'Nwagbo',
                },
            }, 
            user: {},
        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    created() {
        this.getInitials();
        Fire.$on('changeChatRoom', response =>{
            this.chats = response.data.chats;
            this.user = response.data.user;
        });
    },
    methods:{
        addNew(){},
        getInitials(){
            axios.get('/api/chats/messenger/private').then(response =>{
                this.chats = response.data.chats;
                this.user = response.data.user; 
                this.chat = response.data.chats.data[0];                
                Fire.$emit('chatsReload', this.chats);
                Fire.$emit('chatReload', this.chat);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Chat not loaded successfully',});
            });
        },
    },
    props:{
        //'chat': Object,
    },
}
</script>