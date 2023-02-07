@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="card-title h4 mb-2 mt-2">{{ __('Address Configuration') }}</div>
                        <hr>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.config.address') }}" method="post">
                            @csrf
                            <div id="info-body">
                                <div class="mb-3 row">
                                    <label for="staticName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input required type="text" name="name" value="{{ old('name', $address['admin_name']) }}"
                                               class="form-control" id="staticName">
                                        <div class="invalid-feedback">
                                            Name is required
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input required type="email" value="{{ old('email', $address['admin_email']) }}" name="email"
                                               class="form-control" id="staticEmail">
                                        <div class="invalid-feedback">
                                            Email is required and must be email format
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="staticPhone" class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input required type="tel" value="{{ old('phone', $address['admin_phone']) }}" name="phone"
                                               class="form-control" id="staticPhone">
                                        <div class="invalid-feedback">
                                            Phone number is required
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="address_line_1" class="col-sm-3 col-form-label">Address Line 1</label>
                                    <div class="col-sm-9">
                                        <input required type="text" value="{{ old('address_line_1', $address['admin_address_line_1']) }}" name="address_line_1"
                                               class="form-control" id="address_line_1">
                                        <div class="invalid-feedback">
                                            Address line 1 is required
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="address_line_2" class="col-sm-3 col-form-label">Address Line 2</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ old('address_line_2', $address['admin_address_line_2']) }}" name="address_line_2"
                                               class="form-control" id="address_line_2">

                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="address_line_3" class="col-sm-3 col-form-label">Address Line 3</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ old('address_line_3', $address['admin_address_line_3']) }}" name="address_line_3"
                                               class="form-control" id="address_line_3">

                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="city" class="col-sm-3 col-form-label">City</label>
                                    <div class="col-sm-9">
                                        <input required type="text" value="{{ old('city',$address['admin_city']) }}" name="city"
                                               class="form-control" id="city">
                                        <div class="invalid-feedback">
                                            City is required
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="state_province" class="col-sm-3 col-form-label">State Province</label>
                                    <div class="col-sm-9">
                                        <input required type="text" value="{{ old('state_province', $address['admin_state_province']) }}" name="state_province"
                                               class="form-control" id="state_province">
                                        <div class="invalid-feedback">
                                            State Province is required
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="postal_code" class="col-sm-3 col-form-label">Postal Code</label>
                                    <div class="col-sm-9">
                                        <input required type="text" value="{{ old('postal_code', $address['admin_postal_code']) }}" name="postal_code"
                                               class="form-control" id="postal_code">
                                        <div class="invalid-feedback">
                                            Postal Code is required
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="country" class="col-sm-3 col-form-label">Country</label>
                                    <div class="col-sm-9">
                                        <select id="country" name="country_code" class="select2_ form-control ">
                                            @foreach($countries as $country)
                                                <option @if(old('country_code', $address['admin_country_code']) == $country['code']) selected
                                                        @endif value="{{$country['code']}}">{{$country['name']}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Country is required
                                        </div>
                                    </div>
                                </div>
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
        $('select').trigger('change');
    </script>
@stop
