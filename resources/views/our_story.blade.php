@extends('layouts.app')

@section('content')
<section class="policypart">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="Convecol_box  my-5">
                <div class="card-header text-center border-0"><h3>{{ __('Our Story') }}</h3></div>
                    <div class="card-body pt-0 text-dark">
                         <div class="pdescription">
                       <p class="text-dark">{!!$product->description!!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
