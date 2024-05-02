<template>
    <table class="table table-hover text-nowrap" v-if="unverified_addresses.data != null && unverified_addresses.data.length != 0">
        <thead class="bg-dark">
            <tr>
                <th>Guarantor</th>
                <th>Employer Address</th>
                <th>Residential Address</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="guarantor in unverified_addresses.data" :key="address.id">
                <td>{{ guarantor.last_name}}, {{ guarantor.first_name}} {{ guarantor.middle_name != null ? guarantor.middle_name : ''}}</td>
                <td><span class="badge" :class="guarantor.employer_address_status == 1 ? ' bg-success' : (guarantor.employer_address_status == 2 ? 'bg-danger' : 'bg-warning') ">{{ guarantor.employer_address }}</span></td>
                <td><span class="badge" :class="guarantor.residential_address_status == 1 ? ' bg-success' : (guarantor.residential_address_status == 2 ? 'bg-danger' : 'bg-warning') ">{{ guarantor.residential_address }}</span></td>
                <td>
                    <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu">
                        <router-link class="btn btn-block dropdown-item" v-if="guarantor.employer_address_status != 1 || guarantor.employer_address_status != 2" :to="'/staff/confirm/guarantor_address/business/'+guarantor.id"><i class="fa fa-check mr-1 text-primary"></i> Confirm Employer</router-link>
                        <router-link class="btn btn-block dropdown-item" v-if="guarantor.residential_address_status != 1 || guarantor.residential_address_status != 2" :to="'/staff/confirm/guarantor_address/residential/'+guarantor.id"><i class="fa fa-check mr-1 text-info"></i> Confirm Residential</router-link>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="card" v-else>
        <div class="card-body">
                <img class="card-img-top" src="/dist/img/photo2.png" alt="Dist Photo 2">
                <div class="card-img-overlay d-flex flex-column justify-content-center">
                    <h5 class="card-title text-white mt-5 pt-2">No Guarantor Address Yet</h5>
                    <p class="card-text pb-2 pt-1 text-white">Add a new customers <br></p>
                    <button class="btn btn-primary">Add User</button>
                </div>
            </div>
    </div>
    
</template>
<script>
export default {
    data(){
        return {
            address: {},
            unverified_addresses: {},
        }
    },
    methods:{
        getAllInitials(page = 1){
            axios.get('/api/ums/address_verifications?page='+page+'&point=guarantor&specific='+this.specific)
            .then(response =>{
                this.unverified_addresses = response.data.unverified_addresses;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Addresses not loaded successfully',});
            });
        },
        scrollHanle(evt) {
            console.log(evt)
        },
    },
    mounted() {
        this.getAllInitials();
    },
    props:{
        specific: String,
    },
}
</script>