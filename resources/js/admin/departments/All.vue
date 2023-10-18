<template>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Departments</h3>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>HOD</th>
                                    <th>Email</th>
                                    <th>Phone Ext.</th>
                                    <th>Number</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="department in departments.data" :key="department.id">
                                    <td>{{department.name}}</td>
                                    <td>{{department.hod | FullName}}</td>
                                    <td>{{department.email}}</td>
                                    <td>{{department.ext}}</td>
                                    <td>{{department.users.length}}</td>
                                    <td :title="department.description">{{department.description | readMore(25, '...')}}</td>
                                    <td>
                                        <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu">
                                            <router-link class="btn btn-block dropdown-item" :to="'/admin/departments/'+department.id"><i class="fa fa-eye mr-1 text-primary"></i> View </router-link>
                                            <button class="btn btn-block dropdown-item" @click="deleteDepartment(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="departments" @pagination-change-page="getDepartments">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
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
            departments: {},
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/departments').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Departments were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Departments were not loaded successfully',
                })
            });
        },
        getDepartments(page=1){
            axios.get('/api/ums/departments?page='+page)
            .then(response=>{
                this.departments = response.data.departments;   
            });
        },
        refresh(response){
            this.departments = response.data.departments;
            this.users = response.data.users;
            //Fire.$emit('LecturerFill', this.users);
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('DepartmentRefresh', response =>{
            this.refresh(response);
            $('#DepartmentModal').modal('hide');
        });
        Fire.$on('DepartmentUpdate', Department=>{
            this.Department = Department;
        });
        Fire.$on('GetDepartment', response =>{
            this.refresh(response);
            $('#DepartmentModal').modal('hide');
        });
    }
}
</script>