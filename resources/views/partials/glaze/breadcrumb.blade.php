<!--div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb"> 
    <h1 class="page-title fw-semibold fs-18 mb-0">{{$page_title}}</h1> 
    <div class="ms-md-1 ms-0"> 
        <nav> 
            <ol class="breadcrumb mb-0"> 
                <li class="breadcrumb-item"><a href="#">Pages</a></li> 
                <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li> 
            </ol> 
        </nav> 
    </div> 
</div-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">{{ $page_title}}</h1></div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">{{ $page_title}}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>