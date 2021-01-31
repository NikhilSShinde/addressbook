@extends('layouts.master')
@section('title') List @endsection
@section('content')

<div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Address</h3>
                </div>
                <div class="panel-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/update-address/'.$address['slug']) }}" method="POST" role="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name <b><span style="color:red;">*</span></b></label>
                                <input type="text" class="form-control" name="first_name" value="{{ $address['first_name'] }}">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name <b><span style="color:red;">*</span></b></label>
                                <input type="text" class="form-control"  name="last_name" value="{{ $address['last_name'] }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email <b><span style="color:red;">*</span></b></label>
                                <input type="email" class="form-control" name="email" value="{{ $address['email'] }}">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone <b><span style="color:red;">*</span></b></label>
                                <input type="text" class="form-control" name="phone" value="{{ $address['phone'] }}">
                            </div>
                            <div class="form-group">
                                <label for="zip_code">Zip <b><span style="color:red;">*</span></b></label>
                                <input type="text" class="form-control" name="zip_code" value="{{ $address['zip_code'] }}">
                            </div>

                            <div class="form-group">
                                <label for="street">Street <b><span style="color:red;">*</span></b></label>
                                <input type="text" class="form-control" name="street" value="{{ $address['street'] }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City <b><span style="color:red;">*</span></b></label>
                                <select id="city" name="city" class="form-control">
                                    @if(count($cities))
                                        @foreach($cities as $city)
                                            <option @if( $city['id'] == $address['city']) value="{{ $city->id }}" selected="selected" @endif> {{ $city->city }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug <b><span style="color:red;">*</span></b></label>
                                <input type="text" name="slug" class="form-control" value="{{ $address['slug'] }}" placeholder="address-slug">
                            </div>

                            <div class="form-group">
                                <div class="profile-header-container">
                                    <div class="profile-header-img">
                                        <img class="rounded-circle" width="155" height="155" src="{{asset('/public/'.$address['profile_pic'])}}" id="product_image"/>
                                        <!-- badge -->
                                        <div class="rank-label-container">
                                            <span class="label label-default rank-label"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="stret">Profile Image <b><span style="color:red;">*</span></b></label>
                                <input type="file" class="form-control" name="profile_image" id="file">
                                <small id="fileHelp" class="form-text text-muted">Format allowed: jpg, png, jpeg, gif, webp, svg | Size: not be more than 300KB | Dimension: 150 x 150 size allowed only</small>
                            </div>
                            <div class="">
                                <a href="{{url('/list-address')}}" class="btn btn-warning pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                <input type="submit"value="Update" class="btn btn-primary">
                                <input type="hidden" value="{{$address['id']}}" name="id">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@parent
@endsection('script')