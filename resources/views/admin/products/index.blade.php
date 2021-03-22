@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Product Management</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
      <a class="btn btn-sm btn-outline-success" href="{{ route('admin.products.create') }}"> Create New Product</a>
    </div>
  </div>
</div>
<x-alert/>
<table class="table table-bordered res data-table">
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>Price</th>
<th>is_stock</th>
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
        ajax: "{{ route('admin.products.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'is_stock', name: 'is_stock'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection