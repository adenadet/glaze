<template>
<section class="container-fluid">
    <div class="row clearfix mt-3">
        <div class="modal fade" id="userModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="editMode">Edit Staff: {{staff.unique_id}}</h4>
                        <h4 class="modal-title" v-show="!editMode">New Staff</h4>
                        <button type="button" class="close" @click="closeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <UserFormStaff :areas="areas" :branches="branches" :departments="departments" :editMode="editMode" :states="states" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="roleModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign User Roles</h4>
                        <button type="button" class="close" @click="closeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <UserFormAssignRole :user="user"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card custom-card"> 
                <div class="card-header justify-content-between"> 
                    <div class="card-title">Staffs</div>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary float-sm-right" @click="addUser()">Add New Staff <i class="fa fa-user-add"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 d-flex align-items-stretch" v-for="user in users.data" :key="user.id">
                            <div class="card bg-light">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{user.user | FullName}}</b></h2>
                                        </div>
                                        <div class="col-5 text-center">
                                            <img style="height: 100px;" :src="(user.user.image) ? '/img/profile/'+user.user.image : '/img/profile/default.png'" alt="" class="img-circle img-fluid">
                                        </div>
                                        <div class="col-12">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{user.user.email}}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dept: {{((typeof user.department != 'undefined') && (user.department !== null))? user.department.name: ''}}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{user.user.phone}} {{user.alt_phone != null ? ', '+staff.alt_phone : ''}} </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <div class="btn-group">
                                            <router-link class="btn btn-sm btn-default" :to="'/admin/staffs/'+user.id" title="View Staff"><i class="fa fa-eye"></i></router-link>
                                            <button class="btn btn-sm btn-success" @click="setUserRole(user.user)" title="Set Staff Role"><i class="fa fa-user-cog"></i></button>
                                            <button class="btn btn-sm btn-primary" @click="editUser(user)" title="Edit Staff"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" @click="deleteStaff(user.id)" title="Delete Staff"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card-footer">
                        <pagination :data="users" @pagination-change-page="getUser">
                            <span slot="prev-nav">&lt; Previous </span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
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
            areas:[],
            branches:[],
            departments:[],
            editMode: false,
            savings:{},
            states:[],
            staff:{},
            user: {},
            users:{},
            form: new Form({}),
        }
    },
    methods:{
        addUser(){
            this.editMode = false;
            Fire.$emit('StaffDataFill', {});
            $('#userModal').modal('show');
            this.$Progress.finish();
        },
        closeModal(){
            $('#roleModal').modal('hide');
            $('#userModal').modal('hide');
        },
        deleteStaff(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                //Send Delete request
                if(result.value){
                    this.form.delete('/api/ums/staffs/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', response.data.message, 'success');
                        this.refreshPage(response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        editUser(user){
            this.$Progress.start();
            this.editMode = true;
            this.staff = user;
            Fire.$emit('StaffDataFill', user); 
            $('#userModal').modal('show');

            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/staffs').then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Users loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Users not loaded successfully',
                })
            });
        },
        getUser(page=1){
            axios.get('/api/ums/staffs?page='+page)
            .then(response=>{
                this.users = response.data.users;   
            });
        },
        refreshPage(response){
            this.areas = response.data.areas;
            this.branches = response.data.branches;
            this.departments = response.data.departments;
            this.states = response.data.states;
            this.users = response.data.users;
        },
        setUserRole(user){
            this.$Progress.start();
            this.user = user;
            Fire.$emit('userRoleUpdate', user);
            $('#roleModal').modal('show');
            this.$Progress.finish();
        },
    },
    mounted(){ 
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/users/search?q='+query)
            .then((response ) => {this.users = response.data.users;})
            .catch(()=>{});
        });
        Fire.$on('userRoleReload', response =>{});
        Fire.$on('Reload', response =>{
            $('#userModal').modal('hide'); 
            $('#roleModal').modal('hide');
            this.users = response.data.users;
        });
    },
}
</script>