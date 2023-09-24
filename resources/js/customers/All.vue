<template>
<section class="content">
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row" v-if="customers != null && customers.data != null && customers.data.length > 0">
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column" v-for="customer in customers.data" :key="customer.id">
                    <CustomerMiniCard :customer="customer" />
                </div>
            </div>
            <div class="row" v-else>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="card mb-2">
                        <img class="card-img-top" src="/dist/img/photo2.png" alt="Dist Photo 2">
                        <div class="card-img-overlay d-flex flex-column justify-content-center">
                            <h5 class="card-title text-white mt-5 pt-2">No Customer Added Yet</h5>
                            <p class="card-text pb-2 pt-1 text-white">
                            Add a new customers <br>
                            
                            </p>
                            <button class="btn btn-primary">Add User</button>
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
            customers: {},
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/ums/customers')
            .then(response =>{
                this.customers = response.data.customers;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Customers not loaded successfully',});
            });
        },
        scrollHanle(evt) {
            console.log(evt)
        },
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>