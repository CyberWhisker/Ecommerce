
@if (session('success'))
<div class="alert alert-success" role="alert" id="alertSuccess">
    {{session('success')}} 
    <a href="" role="button" id="closeAlertSuccess">
        <i class="bi bi-x-lg" style="color: red; float:right"></i>
    </a>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger" role="alert" id="alertDanger">
    {{session('error')}}
    <a href="" role="button" id="closeAlertDanger">
        <i class="bi bi-x-lg" style="color: red ;float: right"></i>
    </a>
</div>
@endif