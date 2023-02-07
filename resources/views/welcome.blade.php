@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="card-title h4 mb-2 mt-2">Calculate Shipping</div>
                        <hr>
                        <nav class="nav nav-pills nav-fill">
                            <a class="nav-link" id="agreement-pill" aria-current="page" href="javascript:void(0)">Terms</a>
                            <a class="nav-link" id="info-pill" href="javascript:void(0)">Info</a>
                        </nav>

                        <div class="nav-body mt-3  p-3 pt-4">
                            <form action="{{ route('form.shipping') }}" method="POST" class="needs-validation" novalidate>
                                @csrf

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div id="agreement-body" style="display: none">
                                    {!! $agreement?->content !!}
                                    <div class="d-grid gap-2 col-6 mx-auto mt-3">
                                        <button id="agree-btn" class="btn btn-success" type="button">Agree</button>
                                    </div>
                                </div>
                                <div id="info-body" style="display: none">

                                    <div class="mb-3 row">
                                        <label for="staticName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input required type="text" name="name" value="{{ old('name') }}"
                                                   class="form-control" id="staticName">
                                            <div class="invalid-feedback">
                                                Name is required
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input required type="email" value="{{ old('email') }}" name="email"
                                                   class="form-control" id="staticEmail">
                                            <div class="invalid-feedback">
                                                Email is required and must be email format
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticPhone" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10">
                                            <input required type="tel" value="{{ old('phone') }}" name="phone"
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
                                            <input required type="text" value="{{ old('address_line_1') }}" name="address_line_1"
                                                   class="form-control" id="address_line_1">
                                            <div class="invalid-feedback">
                                                Address line 1 is required
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="address_line_2" class="col-sm-3 col-form-label">Address Line 2</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="{{ old('address_line_2') }}" name="address_line_2"
                                                   class="form-control" id="address_line_2">

                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="address_line_3" class="col-sm-3 col-form-label">Address Line 3</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="{{ old('address_line_3') }}" name="address_line_3"
                                                   class="form-control" id="address_line_3">

                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="city" class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9">
                                            <input required type="text" value="{{ old('city') }}" name="city"
                                                   class="form-control" id="city">
                                            <div class="invalid-feedback">
                                                City is required
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="state_province" class="col-sm-3 col-form-label">State Province</label>
                                        <div class="col-sm-9">
                                            <input required type="text" value="{{ old('state_province') }}" name="state_province"
                                                   class="form-control" id="state_province">
                                            <div class="invalid-feedback">
                                                State Province is required
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="postal_code" class="col-sm-3 col-form-label">Postal Code</label>
                                        <div class="col-sm-9">
                                            <input required type="text" value="{{ old('postal_code') }}" name="postal_code"
                                                   class="form-control" id="postal_code">
                                            <div class="invalid-feedback">
                                                Postal Code is required
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="country" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <select id="country" name="country_code" disabled class="select2_ form-control ">
                                                <option class="us">United States</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Country is required
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 row">
                                        <label for="staticAddress" class="col-sm-3 col-form-label">Package Weight</label>
                                        <div class="col-sm-9">

                                            <div class="input-group mb-3">
                                                <input type="number" step="0.01" value="{{ old('weight') }}" required name="weight"
                                                       class="form-control" id="staticPhone">
                                                <span class="input-group-text">lbs</span>
                                                <div class="invalid-feedback">
                                                    Package weight is required and must be number format
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="d-grid gap-2">
                                                <button id="info-back-btn" class="btn btn-outline-dark"
                                                        type="button">Back
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-grid gap-2">
                                                <button id="info-next-btn" class="btn btn-success"
                                                        type="submit">Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            let agreementPill = $('#agreement-pill');
            let agreementBody = $('#agreement-body');
            let infoPill = $('#info-pill');
            let infoBody = $('#info-body');

            agreementPill.addClass('active');
            agreementBody.show();

            $(document).on('click', '#agree-btn', function () {
                hideAll();
                infoBody.show();
                infoPill.addClass('active')
            });

            $(document).on('click', '#info-back-btn', function () {
                hideAll();
                agreementPill.addClass('active');
                agreementBody.show();
            });

            @if(old('name', null) != null)
            $('#agree-btn').click();

            @endif

            function hideAll() {
                agreementPill.removeClass('active');
                agreementBody.hide();
                infoPill.removeClass('active');
                infoBody.hide();
            }

        });
    </script>
    <script>
        $(function () {
            $('select').trigger('change');
            (() => {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                const forms = document.querySelectorAll('.needs-validation')
                // Loop over them and prevent submission
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false);


                })
            })();

        });
    </script>
@stop
