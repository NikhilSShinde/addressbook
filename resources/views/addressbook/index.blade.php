@extends('layouts.master')
@section('title') List @endsection
@section('content')

                <h3> <i class="fa fa-list" aria-hidden="true"></i> Address List </h3> 
                <hr>
                <a href="{{url('add-address')}}" class="btn btn-sm btn-info text-center"> Add New Address</a>
                <hr>
                @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">
                        <strong>{{ $message }}</strong>
                    </div>
                        
                    @php Session::forget('success') @endphp
                
                @endif

                <table class="table table-striped table-bordered" id="products" style="width:100%">
                    <thead>
                    <tr>
                        <th>Profile</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Street</tthd>
                        <th>Zip</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($address as $key => $value)
                        <tr>
                            <td><img src="{{asset('/public/'.$value->profile_pic)}}" width="100px"></td>
                            <td>{{ $value->first_name }}</td>
                            <td>{{ $value->last_name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ $value->street }}</td>
                            <td>{{ $value->zip_code }}</td>
                            <td>{{ $value->City->city }}</td>
                            <!-- we will also add show, edit, and delete buttons -->
                            <td>
                                <a class="btn btn-sm btn-success" href="{{ url('show-address/' . $value->slug) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-sm btn-info" href="{{ url('edit-address/' . $value->slug) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a class="btn btn-sm btn-danger" href="{{ url('delete-address/' . $value->slug) }}" onclick="return confirm('Are you sure want to delete the record?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                        {{-- $address->links() --}}
@endsection
@section('scripts')
@parent
@endsection('script')