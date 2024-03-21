@extends('layouts.app')

@section('content')
    <section class="policypart">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="Convecol_box  my-5">
                        <div class="card-header text-center border-0">
                            <h3>{{ __('Faqs') }}</h3>
                        </div>
                        <div class="card-body pt-0 text-dark">
                            <div class="pdescription">

                                <div class="accordion">
                                    @foreach ($fqu as $value)
                                        <div class="accordion-item">
                                            <input type="checkbox" id="{{ $value->id }}">
                                            <label for="{{ $value->id }}" class="accordion-item-title"><span
                                                    class="icon"></span><b>{{ ucwords($value->name) }}</b></label>
                                            <div class="accordion-item-desc">{{ $value->question }}</div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
