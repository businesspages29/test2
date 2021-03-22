@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Show Order</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
        <a class="btn btn-sm btn-outline-danger" href="{{ url()->previous() }}">Back</a>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>
            Customer Name:</strong>
            {{ $order->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Invoice Number:</strong>
            {{ $order->invoice_number }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Total Amount:</strong>
            {{ $order->total_amount }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Product:</strong>
            <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Price</th>
      <th scope="col">is_stock</th>
      <th scope="col">Quantity</th>
    </tr>
  </thead>
  <tbody>
  @foreach($item as $i)
    <tr>
      <th scope="row">{{ $i->id }}</th>
      <td>{{ $i->product_name }}</td>
      <td>{{ $i->price }}</td>
      <td>{{ $i->is_stock }}</td>
      <td>{{ $i->quantity }}</td>
      
      
    </tr>
   @endforeach 
  </tbody>
</table>
        </div>
    </div>
</div>
@endsection
