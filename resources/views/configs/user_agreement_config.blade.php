@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="card-title h4 mb-2 mt-2">{{ __('User Agreement') }}</div>
                        <hr>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->has('agreement'))
                            <div class="alert alert-success" role="alert">
                                {{ $errors->first('agreement') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.config.user_agreement') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <textarea style="visibility: hidden;" id="editor" name="agreement">{{ $agreement?->content }}</textarea>
                            </div>
                            <div class="form-group mt-2">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor',
            skin: 'bootstrap',
            menubar: false,
        });
        $(function () {
            setTimeout(() => {
                $('.tox.tox-silver-sink').remove();
            }, 500);
        })
    </script>
@stop
