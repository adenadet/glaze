<template>
<section class="row">
    <div class="col-md-6">
        <div class="row">
            <form @submit.prevent="editMode ? updateLoan() : createLoan() ">
                <alert-error :form="loanData"></alert-error> 
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Loan Type*</label>
                            <select type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="loanData.loan_type_id" required>
                                <option value=''>---Select Loan Type---</option>
                                <option v-for="(loan_type, index) in loan_types" :value="loan_type.ProductCode" :key="index">{{ loan_type.ProductName }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Purpose</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="loanData.name" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount *" v-model.number="loanData.amount" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Payback Freq.</label>
                            <select class="form-control" id="frequency" name="frequency" placeholder="frequency *" v-model.number="loanData.frequency" required>
                                <option value="">--Select Payback Frequency--</option>
                                <option value="weeks">Weekly</option>
                                <option value="months">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Duration</label>
                            <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration *" v-model.number="loanData.duration" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Bank</label>
                            <select class="form-control" id="bank_id" name="bank_id" placeholder="Name *" v-model="loanData.bank_id" required>
                                <option value=''>--Select Bank To Pay To--</option>
                                <option v-for="(bank, index) in banks" :value="bank.code == null ? bank.BankCode : bank.bank_code" :key="index">{{ bank.bank_name == null ? bank.BankName : bank.bank_code }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Account Name</label>
                            <input type="text" class="form-control" id="acct_name" name="acct_name" placeholder="Account Name *" v-model="loanData.acct_name" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" class="form-control" id="acct_number" name="acct_number" placeholder="Account Number *" v-model="loanData.acct_number" required>
                        </div>
                    </div>
                </div>
                <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Repayment</th>
                    <th>Outstanding Principal</th>
                    <th>Outstanding Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(n, index) in loanData.duration" :key="index">
                    <td>{{ index | addOne }}.</td>
                    <td>{{ emi.toFixed(2) | currency}}</td>
                    <td>{{ totalPayment.toFixed(2) - ((index)*emi.toFixed(2)) | currency}}</td>
                    <td>{{ totalPayment.toFixed(2) - ((index + 1)*emi.toFixed(2)) | currency}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
</template>
<script>
    export default {
        computed:{
            adminInterestRate(){
                let getIndex = this.loan_types.map(object => object.id).indexOf(this.loanData.loan_type_id);
                console.log(getIndex);
                let interest = 36;
            
                //return (1 + (interest/100));
                return 1;
            },
            interestRate(){
                //let getIndex = this.loan_types.map(object => object.id).indexOf(this.loanData.loan_type_id);
                //let interest = this.loanData.frequency == "weeks" ? this.loan_types[getIndex].percentage / 52 / 100 : this.loan_types[getIndex].percentage / 12 / 100;
                let interest = (this.loanData.frequency == "weeks") ? (60 / 52 / 100) : (60 / 12 / 100);
                return Number(interest);
            },
            tenureMonths(){return Number(this.loanData.duration);},
            emi(){
                var x = Math.pow(1 + this.interestRate, this.tenureMonths);
                var emiMonthly =  ((this.loanData.amount * this.adminInterestRate)  * x * this.interestRate) / (x-1);
                return Number(emiMonthly);
            },
            totalPayment(){return Number(this.emi * this.tenureMonths);},
            totalInterest(){return Number(this.totalPayment - this.loanAmount);},
            
        },
        data(){
            return {
                banks: [],
                loan_types: [],
                loanData: new Form({
                    id:'',
                    unique_id: '',
                    amount: '', 
                    loan_type_id: '', 
                    user_id: '', 
                    payable: '', 
                    duration: '', 
                    frequency: '',
                    bank_id: '', 
                    acct_name: '', 
                    acct_number: '',
                    payable: '',
                    emi: '',  
                }),
            }
        },
        methods:{
            createLoan(){
                this.$Progress.start();
                this.loanData.post('/api/loans/accounts')
                .then(response=>{
                    //Fire.$emit('GetCourse', response);
                    this.$Progress.finish();
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                    });
                    Fire.$emit('getGuarantors', response);
                    //this.$route.push('/loans/'+response.data.loan.id+'/guarantor_request');
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Your form was not sent try again later!',
                    });
                });
            },
            getInitials(){
                axios.get('/api/loans/accounts/initials').then(response =>{
                    this.banks = response.data.all_banks;
                    this.loan_types = response.data.loan_types;
                })
                .catch(()=>{
                    toast.fire({icon: 'error', title: 'Loan Form Initialization failed',})
                });
            },
            updateLoan(id){
                this.loanData.put('/api/loans/accounts/'+this.loanData.id)
                .then(response=>{
                    Swal.fire({icon: 'success', title: response.data.message,});
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
                });
            }, 
        },
        mounted() {
            this.getInitials();
            Fire.$on('LoanDataFill', loan =>{
                if (loan != null){
                    this.loanData.id = loan.id;
                    this.loanData.name = loan.name;
                    this.loanData.amount = loan.amount;
                    this.loanData.loan_type_id = loan.type_id;
                    this.loanData.user_id = loan.user_id;
                    this.loanData.duration = loan.duration;

                    this.loanData.bank_id = loan.bank_id;
                    this.loanData.acct_number = loan.acct_number;
                    this.loanData.acct_name = loan.acct_name;
                }
                
            });     
        },
        props: {
            editMode: Boolean,

        },
    }
</script>