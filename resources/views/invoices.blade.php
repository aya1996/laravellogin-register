@extends('layouts.app')

@section('content')


@foreach($invoices as $invoice)
@foreach($invoice->products as $p)

<h1>{{$p->name}}</h1>

@endforeach
@endforeach




@endsection
