@extends('layouts.admin')
@section('page-title')
    {{__('Billing')}}
@endsection
@section('title')
        <div class="page-header-title">
            {{__('Billing')}}
        </div>
@endsection

@section('action-btn')
@endsection
@section('filter')
@endsection
@php
$labels =
    [ 
        'venue_rental' => 'Venue Rental',
        'hotel_rooms'=>'Hotel Rooms',
        'equipment'=>'Tent, Tables, Chairs, AV Equipment',
        'setup' =>'Setup',
        'gold_2hrs'=>'Bar Package',
        'special_req' =>'Special Requests /Other',
        'classic_brunch'=>'Brunch/Lunch/Dinner Package',
    ]; 
@endphp 

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                {{Form::open(array('route'=>'billing.details','method'=>'post','enctype'=>'multipart/form-data'))}}
                    <!-- <div class= "row"> -->
                        <div class = "col-md-12">
                            <div class="form-group">
                                <label class="form-label">Select Customer :</label>
                                <select class="form-select" id = "userinfo" name = "user" required>
                                    <option value= '-1' disabled selected>Select Customer</option>
                                    @foreach($assigned_user as $user)
                                        <option value="{{$user->id}}" {{ $user->id == $billing->id ? 'selected' : '' }}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{{__('Description')}} </th>
                                                <th>{{__('Cost')}} </th>
                                                <th>{{__('Quantity')}} </th>
                                                <th>{{__('Notes')}} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($labels as $key=> $label)
                                                <tr>
                                                    <td>{{ucfirst($label)}}</td>
                                                    <td>
                                                        <input type = "number" name ="billing[{{$key}}][cost]" value="{{$billing->$key}}" class= "form-control" readonly></td>
                                                    <td> 
                                                    <input type = "number" name ="billing[{{$key}}][quantity]" min = '0' class= "form-control" required>
                                                    </td>
                                                    <td><input type = "text" name ="billing[{{$key}}][notes]" class= "form-control"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class= "form-group">
                                    <label class = "form-label"> Deposit on file: </label>
                                    <input type = "number" name = "deposits" min = '0'  class= "form-control" required>
                                    </div>
                            </div>
                        </div>
                    <!-- </div> -->
                    {{Form::submit(__('Save'),array('class'=>'btn btn-primary '))}}
                    {{ Form::close() }}    
            </div>
        </div>
    </div>
@endsection