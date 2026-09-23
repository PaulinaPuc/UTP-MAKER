@extends('layouts.main')
@section('content')
<!--------------- cart-section---------------->
    <section class="blog about-blog footer-padding">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="/">Home</a></span>
                <span class="devider">/</span>
                <span><a href="#">404 Not Found</a></span>
            </div>
            <div class="blog-item" data-aos="fade-up">
                <div class="cart-img">
                    <img src="assets/images/homepage-one/empty-cart.webp" alt="">
                </div>
                <div class="cart-content">
                    <p class="content-title">Empty! You don’t Cart any Products </p>
                    <a href="/product-sidebar" class="shop-btn">Back to Shop</a>
                </div>
            </div>
        </div>
    </section>
    <!--------------- cart-section-end---------------->
@endsection
