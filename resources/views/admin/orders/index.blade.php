@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Order Management</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a class="btn btn-sm btn-outline-success" href="{{ route('admin.orders.create') }}"> Create New Order</a>
    </div>
  </div>
</div>
<x-alert/>
<table class="table table-bordered res data-table">
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>total_amount</th>
<th>status</th>
<th width="100px">Action</th>
</tr>
</thead>
  <tbody>
  </tbody>

</table>

@endsection
@section('js')

<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.orders.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection