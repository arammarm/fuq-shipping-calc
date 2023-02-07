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
                <div class="card shadow border-0 ">
                    <div class="card-body">
                        <div class="card-title h4 mb-2 mt-2">Summary</div>
                        <hr>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="post" action="{{route('form.shipping.checkout')}}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label>Address: </label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <pre style="font-family: auto,serif">{{$verifiedAddress}}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label>Package Weight: </label>
                                            <span>{{$rec->weight}}.00 lbs (rounded)</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="table ">
                                        @foreach($paylist as $item)
                                            <tr>
                                                <td>{{$item['name']}}</td>
                                                <td>{{$item['description']}}</td>
                                                <td class="text-end">${{number_format((float)$item['value'], 2, '.', '')}}</td>
                                            </tr>
                                        @endforeach
                                        <tfoot>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td></td>
                                            <td class="text-end"><strong>${{number_format((float)$total, 2, '.', '')}}</strong></td>
                                        </tr>
                                        </tfoot>

                                    </table>
                                    <input type="hidden" name="id" value="{{$rec->id}}">
                                    <input type="hidden" name="total" value="{{$total}}">
                                    <div class="form-group">
                                        <button class="btn btn-success">Checkout</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://js.stripe.com/v3/"></script>

@stop
