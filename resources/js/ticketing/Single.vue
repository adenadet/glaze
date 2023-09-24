<template>
<div class="row">
    <div class="modal fade" id="reassignModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reassign Ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <TicketFormAssign :ticket="ticket" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="replyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reply Ticket: {{ticket ? ticket.subject: "Ticket"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <TicketFormReply :ticket="ticket"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-widget widget-user-2">
            <div class="widget-user-header" :class="ticket.status_id == 1 ? 'bg-warning': (ticket.status_id == 2 ? 'bg-yellow' : (ticket.status_id == 3 ? 'bg-purple': 'bg-success'))">
                <div class="widget-user-image">
                    <img class="img-circle elevation-2" :src="(ticket.creator != null) && (ticket.creator.image) ? '/img/profile/'+ticket.creator.image : '/img/profile/default.png'" alt="User Avatar">
                </div>
                <h4 class="widget-user-username">{{ticket.creator ? ticket.creator.first_name+' '+ticket.creator.last_name : 'Undefined User'}}</h4>
                <h5 class="widget-user-desc">{{ticket.subject !== null ? ticket.subject : 'No Subject'}}</h5>
                <h6 class="widget-user-desc">{{ticket.priority !== null && typeof ticket.priority != 'undefined' ? ticket.priority.name : 'No Priority'}}</h6>
            </div>
            <div class="card-footer p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Comments: <span class="float-right badge bg-primary">{{updates.length}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Status: 
                            <span class="float-right badge bg-info">{{ticket.status != null ? ticket.status.name : 'No Status'}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Department Head: <span class="float-right">{{typeof ticket.category != 'undefined' && typeof ticket.category.hod != 'undefined' && ticket.category !== null && ticket.category.hod !== null ? ticket.category.hod.first_name+' '+ticket.category.hod.last_name : 'Not Yet Assigned'}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Assigned To: <span class="float-right">{{typeof ticket.agent != 'undefined' && ticket.agent !== null ? ticket.agent.first_name+' '+ticket.agent.last_name:'Not Yet Assigned'}}</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="timeline">
                    <div v-for="update in updates" :key="update.id">
                        <i class="fas" :class="'bg-'+update.stat.color+' fa-'+update.stat.icon"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{update.created_at | FullDate}}</span>
                            <h3 class="timeline-header"><a href="#">{{update.user !== null ? update.user.first_name+' '+update.user.last_name: 'System Administrator'}} </a> {{update.subject}}</h3>
                            <div class="timeline-body" v-show="update.stat.id < '2' || update.stat.id > '3'">{{update.content}}</div>
                        </div>
                    </div>
                    <div>
                        <i class="fa fa-question bg-yellow"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="#"> </a> Add Update</h3>
                            <div class="card-body"><TicketFormReply :ticket="ticket" :statuses="statuses" /></div>
                        </div>
                    </div>
                    <div>
                        <i class="fa fa-question bg-yellow"></i>
                        <div class="timeline-item">
                            <div class="timeline-footer">
                                <button @click="reassign" class="btn btn-warning btn-sm">Reassign</button>
                                <button @click="closeTicket(ticket.id)" class="btn btn-danger btn-sm">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card custom-card"> 
            <div class="card-header justify-content-between"> 
                <div class="card-title">Ticket Summary</div> 
                <!--div class="btn-list">
                    <button class="btn btn-success btn-sm btn-wave me-0 waves-effect waves-light"><i class="fa fa-edit me-1 align-middle"></i>Edit Ticket</button> 
                </div--> 
            </div> 
            <div class="card-body"> 
                <h5 class="fw-semibold mb-4 task-title" v-html="title.subject"> </h5> 
                <div class="fs-15 fw-semibold mb-2">Task Description :</div> 
                <div class="" v-html="ticket.content"></div> 
            </div> 
            <div class="card-footer"> 
                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap"> 
                    <div> 
                        <span class="d-block text-muted fs-12">Created By</span> 
                        <div class="d-flex align-items-center"> 
                            <div class="me-2 lh-1"> 
                                <span class="avatar avatar-xs avatar-rounded"> 
                                    <img src="/assets/images/faces/15.jpg" alt=""> 
                                </span> 
                            </div> 
                            <span class="d-block fs-14 fw-semibold">{{ ticket.creator != null ? ticket.creator.first_name+' '+ticket.creator.last_name: 'Guest' }}</span> 
                        </div> 
                    </div> 
                    <div> 
                        <span class="d-block text-muted fs-12">Assigned Date</span> 
                        <span class="d-block fs-14 fw-semibold">24,June 2023</span> 
                    </div> 
                    <div> 
                        <span class="d-block text-muted fs-12">Due Date</span> 
                        <span class="d-block fs-14 fw-semibold">05,July 2023</span> 
                    </div> 
                    <div class="task-details-progress"> 
                        <span class="d-block text-muted fs-12 mb-1">Progress</span> 
                        <div class="d-flex align-items-center"> 
                            <div class="progress progress-xs progress-animate flex-fill me-2" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"> <div class="progress-bar bg-primary" style="width: 70%"></div> 
                            </div> 
                            <div class="text-muted fs-11">70%</div> 
                        </div> 
                    </div> 
                    <div> 
                        <span class="d-block text-muted fs-12">Efforts</span> 
                        <span class="d-block fs-14 fw-semibold">45H : 35M : 45S</span> 
                    </div> 
                </div> 
            </div> 
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            form: new Form({}),
            statuses: [],
            ticket: {},   
            updates: [],
        }
    },
    methods:{
        closeTicket(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it!'
                })
            .then((result) => {
                //Send Delete request
                if(result.value){
                    this.form.delete('/api/tickets/ticket/'+id)
                    .then(response=>{
                        this.ticketReload(response);
                        this.$Progress.finish();
                        Swal.fire('Closed!', 'Ticket has been closed.', 'success');   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/tickets/ticket/'+this.$route.params.id)
            .then(response =>{
                this.ticketReload(response);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Ticket was loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Ticket was not loaded successfully',})
            });
        },
        reassign(){
            $('#reassignModal').modal('show');
        },
        replyTicket(){

        },
        ticketReload(response){
            this.ticket     = response.data.ticket;
            this.updates    = response.data.updates;
            this.statuses   = response.data.statuses;
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('ticketReload', response =>{
            this.ticketReload(response);
            $('#reassignModal').modal('hide');
        });
    }
}
</script>