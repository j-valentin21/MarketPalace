@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>You are now logged in!</p>
                    <p class="mb-2 font-weight-bold">You must create a personal access token to get access to this API.</p>
                    <div>
                      <h5>Scopes</h5>
                        <ul>
                            <li>purchase-product: Create a new transaction for a specific product</li>
                            <li>manage-product: Create, reade, update, and delete products (CRUD)</li>
                            <li>manage-account: Read your account data, id, name, email, if verified, and if admin (cannot read password).
                                Modify your account data (email, and password). Cannot delete your account
                            </li>
                            <li>read-general:Read general information like purchasing categories, purchased products, selling products,
                                selling categories, your transactions (purchases and sales
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h5>Using PAT</h5>
                        <p>Once the PAT has been created, you can use them in two different ways:</p>
                        <p>Accessing the API with the ModHeaded installation allows you access through the browser.</p>
                        <p>If you use Postman installation you will have to manually access resource URL's</p>
                    </div>
                    <ol>
                        <li> You can download Postman to add the PAT to the request header.
                            <ul>
                                <li>Download <a href="https://www.postman.com/">Postman</a></li>
                                <li>Once you have registered and installed Postman open up a new tab by
                                    clicking the + next to default launchpad tab.
                                </li>
                                <li>Under the URL request box, click on headers.</li>
                                <li>At the bottom of all the default headers, click Key and enter "authorization" then click Value and enter
                                    "Bearer (PAT token)" given to you through the API.
                                </li>
                                <p>OR</p>
                                <li>Once you open a new tab, click on the authorization tab, click TYPE, and choose bearer token.</li>
                                <li>Adjacent to the TYPE box, is a token box where you will input your PAT without "Bearer " in front of the token.</li>
                            </ul>
                        </li>
                        <li class="mb2">You can download the google extension ModHeader to add the PAT to the request header.
                            <ul>
                                <li>Download
                                    <a href="https://chrome.google.com/webstore/detail/modheader/idgpnmonknjnojddfkpgkljpfnnfcklj?hl=en">ModHeader.</a>
                                </li>
                                <li>Once installed click on "extensions" found on the right of the URL text box in Google Chrome browser.</li>
                                <li>Click on ModHeaders.</li>
                                <li>Once the extension is opened click on + and choose "Request headers".</li>
                                <li>click on Name and add "Authorization".</li>
                                <li>click on Value and add "Bearer (PAT)".</li>
                                <li>You now have access to the API through the browser.</li>
                            </ul>
                        </li>
                    </ol>
                    <div>
                        <p>The links provided below can only be accessed with the ModHeader installation</p>
                        <ul>
                            <li><a href="{{ config('app.url') }}/users">Users</a></li>
                            <li><a href="{{ config('app.url') }}/products">Products</a></li>
                            <li><a href="{{ config('app.url') }}/buyers">Buyers</a></li>
                            <li><a href="{{ config('app.url') }}/sellers">Sellers</a></li>
                            <li><a href="{{ config('app.url') }}/categories">Categories</a></li>
                            <li><a href="{{ config('app.url') }}/transactions">Transactions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
