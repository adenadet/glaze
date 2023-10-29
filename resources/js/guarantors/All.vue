<template>
<section class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guarantors</h3>
                    <!--div class="card-tools"><button type="button" class="btn btn-sm btn-success" @click="createPolicy">Add New</button></div-->
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table m-b-0 col-md-12">
                        <thead class="thead-dark">
                            <tr>
                                <th>Loan</th>
                                <th>Guarantor Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="request in requests.data" :key="request.id">
                                <td><h6 class="mb-0">{{request.account.name}}</h6><span>{{ request.account.unique_id }}</span></td>
                                <td>{{ request.first_name }} {{ request.last_name }}</td>
                                <td>{{ request.email }}</td>
                                <td>{{ request.phone }}</td>
                                <td>{{ request.status == 0 ? 'Not Guaranteed' : 'Guaranteed'}}</td>
                                <td>
                                    <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu">
                                        <button v-if="request.status > 0" class="btn btn-block dropdown-item"><i class="fa fa-eye mr-1 text-primary"></i> View </button>
                                        <button v-if="request.status == 0" class="btn btn-block dropdown-item" @click="deleteRequest(request.id )"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="requests" @pagination-change-page="getAllInitials">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
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
            form: new Form({}),
            requests: {},
        }
    },
    methods:{
        assignPolicy(policy){
            if (policy.category_id == 0){
                Swal.fire({
                    title: 'This is a General Policy, it can not be assigned to a Department',
                    icon: 'error',
                })
            }
            else{
                this.policy = policy;
                Fire.$emit('policyLoad', policy);
                $('#assignModal').modal('show');
            }
        },
        createPolicy(){
            this.editMode = false;
            this.policy = {};
            Fire.$emit('policyDataFill', this.policy);
            $('#policyModal').modal('show');
        },
        deletePolicy(id){
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
                    this.form.delete('/api/policies/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Policies has been deleted.', 'success');
                    Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!',});});
                }
            }); 
        },
        editPolicy(policy){
            this.editMode = true;
            this.policy = policy;
            Fire.$emit('policyDataFill', policy);
            $('#policyModal').modal('show');
        },
        getAllInitials(page=1){
            this.$Progress.start();
            axios.get('/api/loans/guarantors?page='+page)
            .then(response =>{
                this.reloadGuarantors(response);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Policies loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Policies not loaded successfully',});
            });
        },
        viewPolicy(){

        },
        reloadGuarantors(response){
            this.requests = response.data.requests;
        }
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('reloadPolicy', response =>{this.reset(response); console.log("Updated")});
    }   
}
</script>