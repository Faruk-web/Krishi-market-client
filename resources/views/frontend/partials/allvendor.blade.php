@extends('frontend.layouts.app')

@section('content')

<style>



 .recipe-card {
	 background: #fff;
	 margin: 4em auto;
	 width: 90%;
	 max-width: 496px;
}
 .recipe-card aside {
	 position: relative;
}
 .recipe-card aside .button {

	 display: inline-block;
	 position: absolute;
	 top: 80%;
	 right: 3%;
	 width: em(65);
	 height: em(65);
	 border-radius: em(65);
	 line-height: em(65);
	 text-align: center;
}
 .recipe-card aside .button .icon {
	 vertical-align: middle;
}
 .recipe-card article {
	 padding: 1.25em 1.5em;
}
 .recipe-card article ul {
	 list-style: none;
	 margin: 0.5em 0 0;
	 padding: 0;
}
 .recipe-card article ul li {
	 display: inline-block;
	 margin-left: 1em;
	 line-height: 1em;
}
 .recipe-card article ul li:first-child {
	 margin-left: 0;
}
 .recipe-card article ul li .icon {
	 vertical-align: bottom;
}
 .recipe-card article ul li span:nth-of-type(2) {
	 margin-left: 0.5em;
	 font-size: 0.8em;
	 font-weight: 300;
	 vertical-align: middle;
	 color: #838689;
}
 .recipe-card article h2, .recipe-card article h3 {
	 margin: 0;
	 font-weight: 300;
}
 .recipe-card article h2 {
	 font-size: em(28);
	 color: #222;
}
 .recipe-card article h3 {
	 font-size: em(15);
	 color: #838689;
}
 .recipe-card article p {
	 margin: 1.25em 0;
	 font-size: em(13);
	 font-weight: 400;
	 color: #222;
}
 .recipe-card article p span {
	 font-weight: 700;
	 color: #000;
}
 .recipe-card article .ingredients {
	 margin: 2em 0 0.5em;
}
 .recipe-card .icon {
	 display: inline;
	 display: inline-block;
	 background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/203277/recipe-card-icons.svg);
	 background-repeat: no-repeat;
}
 .recipe-card .icon-calories, .recipe-card .icon-calories\:regular {
	 background-position: 0 0;
	 width: 16px;
	 height: 19px;
}
 .recipe-card .icon-clock, .recipe-card .icon-clock\:regular {
	 background-position: 0 -19px;
	 width: 20px;
	 height: 20px;
}
 .recipe-card .icon-level, .recipe-card .icon-level\:regular {
	 background-position: 0 -39px;
	 width: 16px;
	 height: 19px;
}
 .recipe-card .icon-play, .recipe-card .icon-play\:regular {
	 background-position: 0 -58px;
	 width: 21px;
	 height: 26px;
}
 .recipe-card .icon-users, .recipe-card .icon-users\:regular {
	 background-position: 0 -84px;
	 width: 18px;
	 height: 18px;
}
 
</style>
<div class="container">
    <div class="row">
    @foreach($sellers as $seller)
    <div class="col-md-4">
<div class="recipe-card">

	<aside>

		  <img
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="@if ($seller->user->shop->logo !== null) {{ uploaded_asset($seller->user->shop->sliders) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                                                alt="{{ $seller->user->shop->name }}"
                                                class="img-fluid lazyload"
                                            >

			<a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="button rounded-pill btn btn-success"><span class="">Visit Store</span></a>

	</aside>

	<article>

		<h2 style="font-weight: bold;">{{ $seller->user->shop->name }}</h2>
	
	
	

	

	</article>
</div>
</div>
    @endforeach
</div>
</div>
@endsection
