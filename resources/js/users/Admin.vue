<template>
<section class="col-md-12">
    <div class="d-flex align-items-start">
        <div class="col-md-3 nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All Users</button>
            <button class="nav-link" id="staff-tab" data-bs-toggle="pill" data-bs-target="#staff" type="button" role="tab" aria-controls="staff" aria-selected="false">Staffs</button>
            <button class="nav-link" id="customer-tab" data-bs-toggle="pill" data-bs-target="#customer" type="button" role="tab" aria-controls="customer" aria-selected="false">Customers </button>
        </div>
        <div class="col-md-9 tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <UserAll />
            </div>
            <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                <UserStaffs />
            </div>
            <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                <UserCustomers />
            </div>
        </div>
    </div>
</section>
</template>