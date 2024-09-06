<template>
<section class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card">
               
                <div class="card-footer">
                    Edit Button Here
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Staffs in Branch</div>           
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" v-for="staff in staffs.data" :key="staff.id" >
                            <div class="card">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{staff.user | FullName}}</b></h2>
                                        </div>
                                        <div class="col-5 text-center">
                                            <img style="height: 100px;" :src="staff.user | profilePicture" alt="" class="img-circle img-fluid">
                                        </div>
                                        <div class="col-12">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{staff.user.email}}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dept: {{((typeof staff.department != 'undefined') && (staff.department !== null))? staff.department.name: ''}}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{staff.user.phone}} {{staff.alt_phone != null ? ', '+staff.alt_phone : ''}} </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> 
                                <div class="card-footer">
                                    Edit Button Here
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="card-footer">
                    Put pagination here
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            editMode: false,
            branch: {},
            staffs: {},
            form: new Form({}),
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/branches/'+this.$route.params.id).then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Branches were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Branches were not loaded successfully',
                })
            });
        },
        refresh(response){
            this.branch = response.data.branch;
            this.staffs = response.data.staffs;
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('DepartmentRefresh', response =>{
            this.refresh(response);
            $('#DepartmentModal').modal('hide');
        });
    }
}
</script>
