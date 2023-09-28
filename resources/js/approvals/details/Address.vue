<template>
<section>
    <div class="card">
        <div class="card-header">
            <div class="user-block">
                <img class="img-circle" :src=" address.customer | userImage " :alt="address.customer | FullName" :title="address.customer | FullName">
                <span class="username"><a href="#">{{ address.customer | FullName }}</a></span>
                <span class="description">Add on {{ address.created_at | excelDate }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <th>Type:</th>
                        <td>{{ address.type | firstUp }}</td>
                    </tr>
                    <tr>
                        <th>Street:</th>
                        <td>{{ address.street }}</td>
                    </tr>
                    <tr>
                        <th>Street:</th>
                        <td>{{ address.street2 }}</td>
                    </tr>
                    <tr>
                        <th>City:</th>
                        <td>{{ address.city }}</td>
                    </tr>
                    <tr>
                        <th>LGA:</th>
                        <td>{{ address.area ? address.area.name : 'None Selected' }}</td>
                    </tr>
                    <tr>
                        <th>State:</th>
                        <td>{{ address.state ? address.state.name : 'None Selected' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            user: {},
            address: {},
        }
    },
    methods:{},
    mounted() {
        //this.getInitials();
        Fire.$on('AddressDataFill', address =>{
            this.address = address;
        });     
    },
    props: {
        editMode: Boolean,
    },
}
</script>