<template>
<section>
    <form class="form" action="#" @submit.prevent="editMode ? updateMatrix() : createMatrix() ">
        <input type="hidden" name="loan_id" id="loan_id" v-model="requestData.loan_id" />
        <div class="card">
            <div class="card-header">
                <div class="card-title">Guarantors</div>
                <div class="card-tools"><button class="btn btn-sm btn-success" type="button" @click="addLayer()">Add Another</button></div>
            </div>
            <div class="card-body">
                <div class="row" v-for="(guarantor, index) in requestData.guarantors" :key="index">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Index *</label>
                            <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="requestData.guarantors[index].first_name" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Role Name *</label>
                            <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="requestData.guarantors[index].first_name" >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Last Name*</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="requestData.guarantors[index].last_name"/>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" v-model="requestData.guarantors[index].email"/>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" v-model="requestData.guarantors[index].phone"/>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>&nbsp;<br /></label>
                            <button v-if="requestData.guarantors[index].status == 0" class="btn btn-danger" type="button" title="Delete" v-on:click="deleteGuarantor(requestData.guarantors[index])"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer"><div class="text-right"><button class="btn btn-sm btn-primary">Submit</button></div></div>
        </div>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            editMode: false,
            loan: {},
            requestData: new Form({
                id: '',
                name: '',
                items: [],
            }),
        }
    },
    mounted() {
        Fire.$on('GuarantorDataFill', loan =>{
            this.requestData.loan_id = loan.id;
            if (loan.guarantor_requests != null){this.requestData.guarantors = loan.guarantor_requests; this.editMode = true;}
            else{this.addGuarantor(); this.editMode = false;}
        });
    },
    methods:{
        addGuarantor(){
            this.requestData.guarantors.push({
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
            });
        },
        deleteGuarantor(guarantor){this.requestData.guarantors.pop(guarantor);},
        createGuarantor(){
            this.$Progress.start();
            this.requestData.post('/api/loans/guarantors/add')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Guarantors details has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });           
        },
        updateGuarantor(){
            this.$Progress.start();
            this.requestData.put('/api/loans/guarantors/reset/'+this.requestData.loan_id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Guarantors list has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });            
        },
    },
    props:{
        areas: Array,
        states: Array,
        nations: Array,
        user: Object,
        source: String,
    },
}
</script>