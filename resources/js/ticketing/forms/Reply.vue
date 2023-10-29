<template>
    <div>
        <form> 
        <alert-error :form="updateData"></alert-error> 
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status_id" name="status_id" v-model="updateData.status_id" :class="{'is-invalid' : updateData.errors.has('status_id') }">
                        <option value="">---Select Status---</option>
                        <option v-for="status in statuses" :value="status.id" :key="status.id">{{status.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Update</label>
                    <textarea rows="6" class="form-control" v-model="updateData.content"></textarea>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <input type="submit" name="submit" class="submit btn btn-success" value="Update" @click.prevent="updateTicket"/>
            </div>
        </div>
        </form>
    </div>
</template>
<script>
export default {    
    data(){
        return {  
            updateData: new Form({
                agent_id:'', 
                close: false,
                content: '',
                department_id: '',     
                status_id: '',
                ticket_status: '',
                ticket_id: '',
                user_id: '',
            }),
            departments: [],
            route: '',
            users: [],
        }
    },
    methods:{
        submitUpdate(){
            
        },
        updateTicket(){
            this.$Progress.start();
            this.updateData.ticket_id = this.ticket.id;
            this.updateData.post('/api/tickets/comments')
            .then(response=>{
                Fire.$emit('ticketReload', response);
                Swal.fire({icon: 'success',title: 'Ticket has been updated',});
                this.updateData.clear();
                this.updateData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            })
            
            this.$Progress.finish();
        },       
    },
    mounted() {
    },
    props: {
        'editMode': Boolean,
        'statuses': Array,
        'ticket': Object,
        'source': String,
    },
}
</script>