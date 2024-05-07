<template>
<section class="container-fluid">
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="customers-tab" data-toggle="pill" href="#customers" role="tab" aria-controls="customers" aria-selected="true">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="guarantors-tab" data-toggle="pill" href="#guarantors" role="tab" aria-controls="guarantors" aria-selected="false">Guarantors</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                    <ApproveDetailsCustomerBVNLists  specific="unconfirmed" />
                </div>
                <div class="tab-pane fade" id="guarantors" role="tabpanel" aria-labelledby="guarantors-tab">
                    <ApproveDetailsGuarantorBVNLists specific="unconfirmed" />
                </div>
            </div>
        </div>
    </div>
</section>
</template>