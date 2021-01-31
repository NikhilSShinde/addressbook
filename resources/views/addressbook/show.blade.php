@extends('layouts.master')
@section('title') List @endsection
@section('content')

<div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-address-book-o" aria-hidden="true"></i> Address Information <a href="{{url('/list-address')}}" class="btn btn-warning btn-sm pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Go Back</a></h4>
                    
                </div>
                <div class="panel-body">
                    <style>
                        .card {
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                            max-width: 300px;
                            margin: auto;
                            text-align: center;
                            font-family: arial;
                        }

                        .title {
                            color: grey;
                            font-size: 18px;
                        }

                        button {
                            border: none;
                            outline: 0;
                            display: inline-block;
                            padding: 8px;
                            color: white;
                            background-color: #000;
                            text-align: center;
                            cursor: pointer;
                            width: 100%;
                            font-size: 18px;
                        }

                        a {
                            text-decoration: none;
                            font-size: 22px;
                            color: black;
                        }

                        button:hover, a:hover {
                            opacity: 0.7;
                        }
                    </style>

                    <div class="card">
                    <img src="{{asset('/public/'.$address['profile_pic'])}}" alt="John" style="width:100%">
                    <h1>{{$address['first_name']}} {{$address['last_name']}}</h1>
                    <p class="title">{{$address['street']}}</p>
                    <p>{{$address->City->city}} - {{$address['zip_code']}}</p>
                    <div style="margin: 10px 0;">
                        <p><a href="#"><i class="fa fa-phone"></i></a> {{$address['phone']}}</p> 
                        <p><a href="#"><i class="fa fa-envelope"></i></a> {{$address['email']}}</p> 
                    </div>
                    <p><button>Contact</button></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@parent
@endsection('script')