@extends('website.master')
@section('title', 'Checkout Page')
@section('body')


    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">checkout</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="index.html">Shop</a></li>
                        <li>checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-steps-form-style-1">
                        <ul class="nav nav-pills">
                            <li><a href="" class="nav-link active" data-bs-target="#cash" data-bs-toggle="pill">Cash On Delivery</a></li>
                            <li><a href="" class="nav-link" data-bs-target="#online" data-bs-toggle="pill">Online Payment</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="cash">
                                <form action="{{route('new-cash-order')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Full Name</label>
                                                    <div class="col-md-12 form-input form">
                                                        @if (isset($customer->id))
                                                        <input type="text" required name="name" value="{{$customer->name}}" readonly placeholder="Full Name">
                                                        @else
                                                        <input type="text" required name="name" placeholder="Full Name">
                                                        <span class="text-danger">{{$errors->has('name') ? $errors->first('name') : ''}}</span>
                                                        @endif
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Email Address</label>
                                                <div class="form-input form">
                                                    @if (isset($customer->id))
                                                    <input type="email" name="email" value="{{$customer->email}}" readonly required placeholder="Email Address">
                                                    @else
                                                    <input type="email" name="email" required placeholder="Email Address">
                                                    <span class="text-danger">{{$errors->has('email') ? $errors->first('email') : ''}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Phone Number</label>
                                                <div class="form-input form">
                                                    @if (isset($customer->id))
                                                    <input type="number" name="mobile" value="{{$customer->mobile}}" readonly required placeholder="Phone Number">
                                                    @else
                                                    <input type="number" name="mobile" required placeholder="Phone Number">
                                                    <span class="text-danger">{{$errors->has('mobile') ? $errors->first('mobile') : ''}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Delivery Address</label>
                                                <div class="form-input form">
                                                    <textarea name="delivery_address" style="height: 100px; padding-top: 10px" placeholder="Delivery Address"></textarea>
                                                    <span class="text-danger">{{$errors->has('delivery_address') ? $errors->first('delivery_address') : ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Payment Type</label>
                                                <div class="input-group">
                                                    <label><input type="radio" name="payment_type" value="1" checked> Cash On Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-checkbox checkbox-style-3">
                                                <input type="checkbox" id="checkbox-3" checked>
                                                <label for="checkbox-3"><span></span></label>
                                                <p>I accept all terms and conditions</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form button">
                                                <button class="btn" type="submit">Confirm Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade show active" id="online">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-price-table">
                            <h5 class="title">Shopping Cart Summary</h5>
                            <div class="sub-total-price">
                                @php($total = 0)
                                @foreach (ShoppingCart::all() as $cart_product)
                                <div class="total-price">
                                    <p class="value">{{$cart_product->name}} ({{$cart_product->qty}}x - TK. {{$cart_product->price}}):</p>
                                    <p class="price">TK. {{$cart_product->total}}</p>
                                </div>
                                @php($total += $cart_product->total)
                                @endforeach
                            </div>
                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Subtotal Price:</p>
                                    <p class="price">TK. {{$total}}</p>
                                </div>
                                <div class="payable-price">
                                    <p class="value">Tax (15%):</p>
                                    <p class="price">TK. {{$tax = round($total*0.15)}}</p>
                                </div>
                                <div class="payable-price">
                                    <p class="value">Shipping Cost(100):</p>
                                    <p class="price">TK. {{$shipping = 100}}</p>
                                </div>
                            </div>
                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Total Payable:</p>
                                    <p class="price">TK. {{$orderTotal = $total + $tax + $shipping}}</p>
                                </div>
                                <?php
                                    Session::put('order_total', $orderTotal);
                                    Session::put('tax_total', $tax);
                                    Session::put('shipping_total', $shipping);
                                ?>
                            </div>
                            <div class="price-table-btn button">
                                <a href="javascript:void(0)" class="btn btn-alt">Checkout</a>
                            </div>
                        </div>
                        <div class="checkout-sidebar-banner mt-30">
                            <a href="product-grids.html">
                                <img src="{{ asset('/') }}website/assets/images/banner/banner.jpg" alt="#">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
