<template>
    <section>
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <ChatMessages :user="user"/>
                <div class="direct-chat-contacts">
                    <ChatList />
                </div>
            </div>
            <div class="card-footer"><ChatFormInput :user="user"/></div> 
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