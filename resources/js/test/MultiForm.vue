<template>
<div class="card row">
    <div class="card-header justify-content-between">
		<div class="card-title"> Loan Application</div>
	</div>
	<section class="card-body register col-md-12" v-if="!hasSeenCongrats">
		
		<!--div class="register-stepper">
			<div class="step" :class="{'step-active' : step === 1, 'step-done': step > 1}"><span class="step-number">Customer Details</span></div>
			<div class="step" :class="{'step-active' : step === 2, 'step-done': step > 2}"><span class="step-number">Loan Details</span></div>
			<div class="step" :class="{'step-active' : step === 3, 'step-done': step > 3}"><span class="step-number">Guarantors</span></div>
		</div-->

		<transition name="slide-fade" class="row">
			<section v-show="step === 1" class="col-md-12">
				<form class="form" method="post" action="#" @submit.prevent="next">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>First Name *</label>
								<input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="LoanData.customer.first_name" >
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Middle Name</label>
								<input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="LoanData.customer.middle_name"/>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Last Name*</label>
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="LoanData.customer.last_name"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label>Address*</label>
								<input type="text" class="form-control" id="street" name="street" placeholder="Enter Address *" required v-model="LoanData.customer.street"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label>Address2</label>
								<input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Street Desc" v-model="LoanData.customer.street2">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label>City*</label>
								<input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="LoanData.customer.city">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label>State</label>
								<select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="LoanData.customer.state_id">
									<option value="">--Select State--</option>
									<option v-for="state in states" v-bind:key="state.id" :value="state.id" >{{state.name}}</option>
								</select>
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label>LGA</label>
								<select class="form-control" id="area_id" name="area_id" required v-model="LoanData.customer.area_id">
									<option value="">--Select area--</option>
									<option v-for="area in areas" v-bind:key="area.id" :value="area.id" >{{area.name}}</option>
								</select>
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label>Phone Number</label>
								<input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="LoanData.customer.phone">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label>Alternate Phone</label>
								<input type="text" class="form-control" id="alt_phone" name="alt_phone" placeholder="Alternate Phone Number" v-model="LoanData.customer.alt_phone">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label>Email Address</label>
								<input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="LoanData.customer.email">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label>Sex</label>
								<select class="form-control" id="sex" name="sex" required v-model="LoanData.customer.sex">
									<option value="">---Select Sex---</option>
									<option value="Female">Female</option>
									<option value="Male">Male</option>
								</select>
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<label>Date of Birth</label>
							<div class="form-group">
								<input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="LoanData.customer.dob">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<label>Passport Picture</label>
							<div class="form-group">
								<input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
							</div>
						</div>
						<input type="hidden" name="id" id="id" v-model="LoanData.customer.id">
					</div>
					<div class="cta">
							<p class="cta-color">
								<span class="text"></span>
								<span class="link_wrap">
									<button class="btn btn-primary btn-small" type="submit" value="Next">Continue
										<i class="fa fa-right"></i>
									</button>
								</span>
							</p>
						</div>
				</form>
			</section>
		</transition>
		<transition name="slide-fade" class="row">
			<section v-show="step === 2">
				<form class="form" method="post" action="#" @submit.prevent="next">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label>Loan Type</label>
								<select type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="LoanData.type_id" required>
									<option value=''>---Select Loan Type---</option>
									<option v-for="loan_type in loan_types" :value="loan_type.id">{{ loan_type.name }}</option>
								</select>
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="LoanData.name" required>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label>Amount</label>
								<input type="text" class="form-control" id="amount" name="amount" placeholder="Amount *" v-model="LoanData.amount" required>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label>Duration</label>
								<input type="text" class="form-control" id="duration" name="duration" placeholder="Duration *" v-model="LoanData.duration" required>
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label>Bank</label>
								<select class="form-control" id="bank_id" name="bank_id" placeholder="Name *" v-model="LoanData.bank_id" required>
									<option value=''>--Select Bank To Pay To--</option>
									<option v-for="bank in banks" :value="bank.id">{{ bank.bank_name }}</option>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label>Account Name</label>
								<input type="text" class="form-control" id="acct_name" name="acct_name" placeholder="Account Name *" v-model="LoanData.acct_name" required>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label>Account Number</label>
								<input type="text" class="form-control" id="acct_number" name="acct_number" placeholder="Account Number *" v-model="LoanData.acct_number" required>
							</div>
						</div>
					</div>
					<input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
				</form>
			</section>
		</transition>
		<transition name="slide-fade" class="row">
			<section v-show="step === 3">
				<form class="form" action="#" @submit.prevent="customerRegister">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>First Name *</label>
								<input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="LoanData.customer.first_name" >
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Middle Name</label>
								<input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="LoanData.customer.middle_name"/>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Last Name*</label>
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="LoanData.customer.last_name"/>
							</div>
						</div>
					</div>
					
					<div class="form-group cta-step">
						<div class="cta prev">
							<p class="cta-color">
								<span class="link_wrap">
									<a class="link_text" href="#" @click.prevent="prev()"><span class="arrow-prev"></span>Previous
									</a>
								</span>
							</p>
						</div>
					</div>
					<div class="register-btn">
					<input type="submit" value="Créer mon compte" />
						</div>
				</form>
			</section>
		</transition>
	</section>
	<section class="congrats register col-md-12" v-if="hasSeenCongrats">
		
        <h2 class="congrats-title">Thank you !</h2>
        <p class="congrats-subtitle">
            You have successfully created your account and joined the<br/>
            <strong>VueJS<br/>multiple steps form</strong>
        </p>
    </section>
</div> 
</template>
<script>
export default{
	created(){
		this.getInitials();
	},
    data () {
        return {
            steps: {},
            step: 1,
			LoanData: new Form({
				customer:{
					alt_phone:'', 
					area_id:'', 
					branch_id:'', 
					city:'', 
					department_id:'', 
					dob:'', 
					email:'',
					first_name: '', 
					id:'', 
					image:'', 
					joined_at: '',
					unique_id: '',
					last_name:'', 
					middle_name:'', 
					password:'', 
					personal_email: '', 
					phone:'', 
					roles:'',
					sex:'', 
					state_id:'', 
					street:'', 
					street2:'',
					unique_id: '',
				}
			}),
            customer: {
                gender: "1",
                firstName: "",
                lastName: "",
                phoneNumber: "",
                address: "",
                zipCode: "",
                city: "",
                birthDay: "",
                termOfService: "",
                pinCode: "",
                eMail: ""
            },
			loan_types: [],
            hasSeenCongrats: false,
            tempCustomer: {
                gender: "",
                firstName: "",
                lastName: "",
                phoneNumber: "",
                address: "",
                zipCode: "",
                city: "",
                birthDay: "",
                termOfService: "",
                pinCode: "",
                eMail: ""
            },
			loan:{},
			guarantors: [],
			states: [],
			areas: [],
			banks: [],
        };
    },
    methods: {
        prev() {
            this.step--;
        },

        next() {
			alert('Working');
            this.step++;
        },
        customerRegister: function () {
            this.hasSeenCongrats = true;
        },
		getInitials(){
			axios.get('/api/loans/accounts/initials').then(response =>{
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
		refreshPage(response){
			this.areas = response.data.areas;
			this.banks = response.data.all_banks;
			this.loan_types = response.data.loan_types;
			this.states = response.data.states;
		},
		updateProfilePic(){

		},
    } 
}
</script>
