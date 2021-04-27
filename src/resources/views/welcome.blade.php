@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="panel panel-default">
                    <div class="header mb-5">Welcome to MarketPalace</div>
                </div>
                <div class="image-container">
                    <img class="img-responsive" src="{{ asset('img/shipping.jpg') }}" alt="shipping"/>
                    <img class="img-responsive" src="{{ asset('img/sold.jpg') }}" alt="sold"/>
                    <img class="img-responsive" src="{{ asset('img/buying-products.jpg') }}" alt="buying products"/>
                    <img class="img-responsive" src="{{ asset('img/transaction.jpg') }}" alt="money transaction"/>
                    <img class="img-responsive" src="{{ asset('img/mall-products.jpg') }}" alt="mall products"/>
                </div>
                <div>
                    <p class="section__text">This extensive API keeps track of all data related to buyers and sellers of all products.
                        You can also view all transactions from buyers/sellers and create categories for new products.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
