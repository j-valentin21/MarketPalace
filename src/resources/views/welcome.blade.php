@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="panel panel-default">
                    <div class="">Welcome to MarketPalace</div>
                </div>
                <div class="image-container">
                    <img class="img-responsive" src="{{ asset('img/shipping.jpg') }}" alt="shipping"/>
                    <img class="img-responsive" src="{{ asset('img/sold.jpg') }}" alt="sold"/>
                    <img class="img-responsive" src="{{ asset('img/buying-products.jpg') }}" alt="buying products"/>
                    <img class="img-responsive" src="{{ asset('img/transaction.jpg') }}" alt="money transaction"/>
                    <img class="img-responsive" src="{{ asset('img/mall-products.jpg') }}" alt="mall products"/>
                </div>
            </div>
        </div>
    </div>
@endsection
