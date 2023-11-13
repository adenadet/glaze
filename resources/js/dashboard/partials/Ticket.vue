<template>
<div class="card custom-card">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-ticket mr-1"></i>Tickets</div>
        <div> 
            <a href="/ticketing" class="btn btn-light btn-wave btn-sm waves-effect waves-light">Add New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Created By</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="ticket in tickets.data" :key="ticket.id">
                        <td>{{ticket.subject}}</td>
                        <td>{{ticket.user_id !== null ? ticket.creator.first_name+' '+ticket.creator.last_name : ''}}</td>
                        <td>{{ticket.category.name}}</td>
                        <td :title="ticket.content">{{ticket.content | readMore(25, '...')}}</td>
                        <td>{{ticket.status.name}}</td>
                        <td>{{ticket.priority.name}}</td>
                        <td>
                            <div class="btn-group">
                                <a :href="'/staff/tickets/'+ticket.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            </div>          
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>   
    </div>
    <div class="card-footer text-center"><a href="/ticketing">See More</a></div>
</div>
</template>
<script>
export default {
    data(){
        return {}
    },
    props:{'tickets': Object}
}
</script>
<style scoped>

</style>