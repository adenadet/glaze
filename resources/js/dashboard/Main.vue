<template>
<section class="content">
    <div class="container-fluid">            
        <div class="row">
            <section class="col-lg-8 connectedSortable">
                <div class="row">
                    <div class="col-md-6">
                        <DashboardCustomerKYC />
                    </div>
                    <div class="col-md-6">
                        <DashboardTicket :tickets="tickets" />
                    </div>
                    <div class="col-md-12">
                        <LoanAll />
                    </div>
                </div>
            </section>
            <section class="col-lg-4 connectedSortable">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Recent Activities</h3>
                        <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                        </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Activity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="activity in activities" :key="activity.id">
                                    <td>
                                        <img class="img-circle img-size-32 mr-2" :src="(activity.user.image) ? '/img/profile/'+activity.user.image : '/img/profile/default.png'" :alt="activity.user ? activity.user.first_name+' '+activity.user.middle_name+' '+activity.user.last_name : 'Default Image' " :title="activity.user ? activity.user.first_name+' '+activity.user.middle_name+' '+activity.user.last_name : 'User\'s  Image' ">
                                        {{activity.user | FullName}}
                                    </td>
                                    <td>{{activity.subject}}</td>
                                    <td><span class="fs-14">{{ activity.created_at | excelDate }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
</template>
<script>
import moment from 'moment'
export default {
    data(){
        return {
            activities: [],
            birthdays: [],
            contacts: [],
            editMode: false,
            loans: {},
            messages: [],
            message_rooms: [],
            month: '',
            new_staffs: [],
            notices: {},
            staff_months: [],
            tickets: {},   
            settings: {
                suppressScrollY: false,
                suppressScrollX: false,
                wheelPropagation: false
            },
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/dashboard')
            .then(response =>{
                this.birthdays      = response.data.birthdays;
                this.contacts       = response.data.contacts;
                this.chats          = response.data.chats;
                this.messages       = response.data.messages;
                this.message_rooms  = response.data.chats;
                this.notices        = response.data.notices;
                this.new_staffs     = response.data.new_staffs;
                this.tickets        = response.data.tickets;
                this.staff_months   = response.data.staff_months;
                this.loans          = response.data.loans;
                this.activities     = response.data.activities;

            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Dashboard not loaded successfully',});
            });
        },
        scrollHanle(evt) {
            console.log(evt)
        },
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>
<style >
.scroll-area {
  position: relative;
  margin: auto;
  width: 600px;
  height: 400px;
}
</style>