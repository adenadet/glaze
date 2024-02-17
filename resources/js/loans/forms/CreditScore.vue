<template>
<section>
    <form @submit.prevent="createConfirmation()">
        <alert-error :form="ScoreRequestData"></alert-error>
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <label class="control-label">Customer Name</label>
                    <div class="form-control">{{ account.user | FullName }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="bvn" class="control-label">BVN</label>
                    <div class="form-control">{{ account.user != null ? account.user.bvn : 'No User Supplied'}}</div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Credit Bureau</label>
                    <select class="form-control" id="bureau_id" name="bureau_id" v-model="ScoreRequestData.bureau_id" required>
                        <option value="">--Select Credit Bureau--</option>
                        <option v-for="(bureau,index) in bureaus" :value="index">{{ bureau.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Check Type</label>
                    <select class="form-control" id="product_id" name="product_id" v-model="ScoreRequestData.product_id" required>
                        <option value="">--Select Search Type--</option>
                        <option v-for="product in bureau_products" :value="product.id">{{ product.name }}</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-sm btn-success" type="submit">Get Score</button>
        </div>
    </form>
</section>
</template>
<script>
export default{
	created(){
        this.$store.dispatch('firstCentral/loginUser');
	},
    computed:{
        firstCentralUser: {
            get(){
                return this.$store.state.firstCentral.user;
            }
        }
    },
    data () {
        return {
            ScoreRequestData: new Form({
                EnquiryReason:"",
                ConsumerName:"",
                DateOfBirth:"",
                Identification:"",
                Accountno:"",
                bureau_id: "",
                product_id: "",
                loan_id: "",
                DataTicket: "",
            }),
        };
    },
    methods: {
        createConfirmation(){
            this.$Progress.start();
            this.ScoreRequestData.DataTicket = this.firstCentralUser.DataTicket;
            this.ScoreRequestData.loan_id = this.$route.params.id;
            this.ScoreRequestData.Identification = this.account.user.bvn;
            this.ScoreRequestData.post("/api/servers/first_central/getCreditScore")
            .then(response =>{
                this.$Progress.finish();
                console.log(response.data);
                Fire.$emit('refreshRepayment', response);
                this.ScoreRequestData.reset();
                Swal.fire({icon: 'success', title: 'The Checklist has been saved', showConfirmButton: false, timer: 1500});
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
            this.$Progress.fail();
            });
        },
        checkValidity(){
            this.$store.dispatch('firstCentral/login');
        },
        createCheckList(){
            this.$Progress.start();
            this.loanCheckData.loan_id = this.account.id;
            this.loanCheckData.post('/api/loans/checklists')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refreshRepayment', response);
                this.RescheduleData.reset();
                Swal.fire({icon: 'success', title: 'The Checklist has been saved', showConfirmButton: false, timer: 1500});
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
            this.$Progress.fail();
            });
        },
    },
    props:{
        account: Object,
        bureau_products: Array,
        bureaus: Array,
        editMode: Boolean,    
    }
}
</script>