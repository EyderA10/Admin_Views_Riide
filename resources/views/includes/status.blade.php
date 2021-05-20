@if (session('message'))
<div class="alert alert-success">
    <strong><i class="fas fa-check text-success" style="font-size: 18px;" aria-hidden="true"></i> {{session('message')}}</strong>
</div>
@endif

@if (session('deleted'))
<div class="alert alert-success w-25 mx-auto alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-check text-success" style="font-size: 18px;" aria-hidden="true"></i> {{session('deleted')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif