<template>
<section class="container-fluid">
    <div class="row mt-2">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner"><h3>150</h3><p>New Loan Requests</p></div>
                <div class="icon"><i class="fa fa-file"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner"><h3>53</h3><p>Approved Loans</p></div>
                <div class="icon"><i class="fa fa-handshake"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner"><h3>44</h3><p>New Customers</p></div>
                <div class="icon"><i class="fa fa-user"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner"><h3>65</h3><p>Missed Repayments</p></div>
                <div class="icon"><i class="fa fa-money-bill"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            All Repayments in Card Form
            <!--AdminRepayments /-->
        </div>
        <div class="col-md-6">
            <LoanStaff />
        </div>
    </div>
</section>
</template>