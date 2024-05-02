<template>
<section class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#customer" data-toggle="tab">Customer Addresses</a></li>
                        <li class="nav-item"><a class="nav-link" href="#guarantor" data-toggle="tab">Guarantor Addresses</a></li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content p-0">
                        <div class="tab-pane active p-0" id="customer">
                            <ApproveDetailsCustomerAddressLists specific="unconfirmed" /> 
                        </div>
                        <div class="tab-pane" id="guarantor">
                            <ApproveDetailsGuarantorAddressLists specific="unconfirmed" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>