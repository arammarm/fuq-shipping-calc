@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0 ">
                    <div class="card-body">
                        <div class="card-title h4 mb-2 mt-2">Stamp Configuration</div>
                        <hr>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($config)
                            @if($expireAt < 0)
                                <div class="alert alert-warning">Access Token Expired {{abs($expireAt)}} minutes ago</div>
                            @else
                                <div class="alert alert-info">Access Token will expire in {{$expireAt}} minutes</div>
                            @endif
                        @else
                            <div class="alert alert-warning">You have not authenticated with stamp yet!</div>
                        @endif
                        <a href="{{route('admin.config.stamp.auth')}}" class="btn btn-success"> Authenticate &nbsp;<i class="fas fa-sync"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
