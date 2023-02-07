@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __($title) }}</div>
                    <div class="card-body">
                        @if($message != null)
                            <div
                                class="alert alert-@if($type=='error'){{'danger'}}@elseif($type=='warning'){{'warning'}}@elseif($type =='success'){{"success"}}@else{{'info'}}@endif"
                                role="alert">
                                {{ __($message) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
