<template>
<div class="card card-widget widget-user-2">
    <div class="widget-user-header bg-dark text-white">
        <div class="widget-user-image">
            <img class="img-circle elevation-2" :src="user | userImage" alt="User Avatar">
        </div>
        <h3 class="widget-user-username">{{user | FullName}}</h3>
        <h5 class="widget-user-desc">Lead Developer</h5>
    </div>
    <div class="card-footer p-0">
        <ul class="nav flex-column">
            <li class="nav-item">
                <router-link :to="'/staff/loans/customer/'+user.id" class="nav-link">
                    Loans <span class="float-right badge bg-primary">3/4</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="#" class="nav-link">
                    KYC <span class="float-right badge bg-info">100</span>
                </router-link>
            </li>
            <li class="nav-item">
            <a href="#" class="nav-link">
                Missed Payments <span class="float-right badge bg-success">12</span>
            </a>
            </li>
            <li class="nav-item">
            <a href="#" class="nav-link">
                Followers <span class="float-right badge bg-danger">842</span>
            </a>
            </li>
        </ul>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            areas:[],
            branches:[],
            departments:[],
            editMode: false,
            role: {},
            roles:{},
            savings:{},
            states:[],
            users:{},
            form: new Form({}),
        }
    },
    methods:{
        add(){
            this.editMode = false;
            this.user = {};
            Fire.$emit('BioDataFill', this.user);
            $('#userModal').modal('show');

            this.$Progress.finish();
        },
        deleteRole(id){
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
                    this.form.delete('/api/ums/roles/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                    Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        editRole(role){
            this.$Progress.start();
            this.editMode = true;
            this.role = role;
            Fire.$emit('RoleDataFill', role);
            $('#roleModal').modal('show');

            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/roles').then(response =>{
                this.roles = response.data.roles
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Roles loaded successfully',
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
        getRoles(page=1){
            axios.get('/api/ums/roles?page='+page)
            .then(response=>{
                this.roles = response.data.roles;   
            });
        },
    },
    mounted() {
        //this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/roles/search?q='+query)
            .then((response ) => {
                this.users = response.data.users;
            })
            .catch(()=>{

            });
        });
    },
    props:{
        user: Object
    }
}
</script>