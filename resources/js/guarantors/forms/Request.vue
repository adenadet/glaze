<template>
<section>
    <form class="form" action="#" @submit.prevent="createGuarantor()">
        <input type="hidden" name="loan_id" id="loan_id" v-model="requestData.loan_id" />
        <div class="card">
            <div class="card-header">
                <div class="card-title">Guarantors</div>
                <div class="card-tools"><button class="btn btn-sm btn-success" type="button" @click="addGuarantor()">Add Another</button></div>
            </div>
            <div class="card-body">
                <div class="row" v-for="(guarantor, index) in requestData.guarantors" :key="index">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>First Name *</label>
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
            guarantor: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                status: 0,
            },
            loan: {},
            requestData: new Form({
                id: '',
                loan_id: '',
                guarantors: [],
            }),
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('GuarantorDataFill', loan =>{
            this.loan = loan;
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
        createGuarantor(){
            this.$Progress.start();
            this.requestData.loan_id = this.loan.id;
            this.requestData.post('/api/loans/guarantors/add')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({icon: 'success', title: 'The Guarantors details has been created', showConfirmButton: false, timer: 1500});
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });           
        },
        deleteGuarantor(guarantor){this.requestData.guarantors.pop(guarantor);},
        getInitials(){
            this.$Progress.start();
            axios.get('/api/loans/accounts/'+this.$route.params.id)
            .then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Loan Account details were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Loan Account details were not loaded successfully',
                })
            });
        },
        refresh(response){
            this.loan = response.data.account;
        },
    },
    props:{
        continue_to: String,
    },
}
</script>