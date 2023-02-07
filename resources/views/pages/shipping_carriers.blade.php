@extends('layouts.app')

@section('content')
    <style>
        label {
            font-weight: bold;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="card-title h4 mb-2 mt-2">{{ __('Shipping Carriers') }}</div>
                        <hr>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if($error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @else
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col">
                                    <label>Validated Address: </label>
                                    <div class="card">
                                        <div class="card-body">
                                            <pre style="font-family: auto,serif">{{$validAddress}}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{route('form.shipping.carrier.submit')}}" method="post">
                                <input name="record_id" type="hidden" value="{{$rec->id}}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label>Packaging Fee: </label>
                                    ${{number_format((float)$rec->weight, 2, '.', '')}}
                                </div>

                                <div class="form-group">
                                    <label>Choose Available Shipping</label>
                                    <ul class="list-group">
                                        @foreach($shippingServices as $key => $shippingService)
                                            <li class="list-group-item">
                                                <label style="display: block" class="form-check-label fw-normal"
                                                       for="{{$key}}-{{$shippingService->service_type}}">
                                                    <input class="form-check-input me-1" type="radio" style="vertical-align: top" name="shipping_service"
                                                           value="{{json_encode($shippingService)}}"
                                                           id="{{$key}}-{{$shippingService->service_type}}">
                                                    <img style="vertical-align: top"
                                                         src="{{\App\Helpers\StampHelper::getShippingLogo($shippingService->carrier)}}"
                                                         class="rounded  mx-2" height="50">
                                                    <div style="display: inline-block">
                                                        <span class="fw-bold">{{\App\Helpers\StampHelper::readableString($shippingService->service_type)}}</span>
                                                        <br> <small class="text-grey">{{\App\Helpers\StampHelper::readableString($shippingService?->packaging_type)}}</small>
                                                        <br><span class="fw-bold"> ${{number_format((float)$shippingService?->shipment_cost?->total_amount, 2, '.', '')}}</span>
                                                        @if($shippingService->estimated_delivery_days )
                                                            <br><small>{{$shippingService->estimated_delivery_days ?? "-"}} days</small>
                                                        @else
                                                            <br><small>Estimate days not available</small>
                                                        @endif
                                                    </div>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="form-group mt-2">
                                    <button class="btn btn-success " type="submit">Submit</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
