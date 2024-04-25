@extends('layouts.lte')
@section('content')
<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning"> 401</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! You are not authorized to view this page.</h3>
            
            <p>You do not have the necessary rights to view this page. You can contact the administrator or your team lead to adjust your rights.
            <br />Meanwhile, you may <a href="{{route('staff.dashboard')}}">return to dashboard</a>.
            </p>
        </div>
    </div>
</section>
@endsection
