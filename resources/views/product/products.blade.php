@extends('layouts.welcome')

@section('content')
<div class="panel panel-info">
  <div class="panel-heading">your Products</div>
    <div class="panel-body">
        <div class="list-group">
  @foreach ($userProducts as $product)

  <a href="{{url('/productDashboard/'.$product->id)}} " class="list-group-item">{{$product->name}}</a>
@endforeach
  </div>
</div>
</div>
@endsection
