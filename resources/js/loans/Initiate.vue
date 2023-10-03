<template>
<section class="col-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Loan Application
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4 col-sm-3 m-0">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="customer-tab" data-toggle="pill" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Customer <span class="badge badge-primary right"><i class="fas fa-check-circle"></i></span></a>
                        <a class="nav-link" id="customer-tab" data-toggle="pill" href="#address" role="tab" aria-controls="address" aria-selected="true">Address <span class="badge badge-primary right"><i class="fas fa-check-circle"></i></span></a>
                        <a class="nav-link" id="kyc-tab" data-toggle="pill" href="#kyc" role="tab" aria-controls="kyc" aria-disabled="true">KYC</a>
                        <a class="nav-link" id="loan-details-tab" data-toggle="pill" href="#loan" role="tab" aria-controls="loan" aria-selected="false" aria-disabled="true">Loan Details <span class="badge badge-primary right" v-if="current_loan != null && current_loan.status >= 3"><i class="fas fa-check-circle"></i></span></a>
                        <a class="nav-link" :class="current_loan != null && current_loan.status == 3 ? '' : 'disabled'" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false" aria-disabled="true">Guarantors</a>
                    </div>
                </div>
                <div class="col-8 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade show active" id="customer" role="tabpanel" aria-labelledby="customer">
                            <PMFormBasic :editMode="editMode" :user="user" />
                        </div>
                        <div class="tab-pane text-left fade" id="address" role="tabpanel" aria-labelledby="address">
                            <PMFormAddress :editMode="editMode" :user="user" :areas="areas" :states="states" />
                        </div>
                        <div class="tab-pane text-left fade" id="loan" role="tabpanel" aria-labelledby="loan">
                            <LoanForm :loan="current_loan" :user="user" :loan_types="loan_types" :banks="banks"/>
                        </div>
                        <div class="tab-pane fade" id="kyc" role="tabpanel" aria-labelledby="kyc">
                            <UserFormKYC :user="user"/>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                            <GuarantorFormRequest :loan="current_loan" />    
                        </div>
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
            areas: [],
            states: [],
            banks: [],
            loan_types: [],
            current_loan: {},
            user: {},

        }
    },
    methods:{
        createLoan(){
            this.loanData.post('/api/loans/accounts')
            .then(response=>{
                Fire.$emit('GetCourse', response);
                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                });
                this.courseData.reset();
                Fire.emit('')
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
                this.reloadPage(response);
            })
            .catch(()=>{
                toast.fire({
                    icon: 'error',
                    title: 'Loan Form Initialization failed',
                })
            });
        },
        reloadPage(response){
            this.areas = response.data.areas;
            this.banks = response.data.all_banks;
            this.current_loan = response.data.current_loan;
            this.loan_types = response.data.loan_types;
            this.states = response.data.states;
            this.user = response.data.user;
            this.kyc_items = response.data.kyc_items;

            Fire.$emit('BioDataFill', this.user);
            Fire.$emit('NextOfKinFill', this.nok); 
            Fire.$emit('AddressDataFill', this.user.customer_address);
            Fire.$emit('LoanDataFill', this.current_loan);
            Fire.$emit('UserKYCDataFill', {user_id: this.user.id, kyc_items: this.kyc_items});
            if (this.current_loan != null){Fire.$emit('GuarantorDataFill', this.current_loan)}
        },
        updateLoan(id){
            this.loanData.put('/api/loans/accounts/'+this.loanData.id)
            .then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Your form was not sent try again later!',
                });
            });
        }, 
    },
    mounted() {
        this.getInitials();
        Fire.$on('CourseDataFill', course =>{
            this.courseData.reset();
            this.courseData.fill(course);
            if ((course.category_id !== null)&&(typeof course.category !== 'undefined')){
                this.prev_category = course.category;
                this.sub_categories = course.category.sub_categories;
                
                }
            else{
                this.courseData.category_id = "";
                this.courseData.sub_category_id = "";
                this.courseData.certificate_type_id = "";
                this.courseData.exam_type_id = "";
            }
        });     
    },
    props: {
        editMode: Boolean,
        loan: Object,
    },
}
</script>