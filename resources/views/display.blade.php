<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Display Dashboard | ELING KOTA SEMARANG</title>
  <link href="{{asset('assets/css/bootstrap.css')}} " rel="stylesheet" type="text/css">
  <style>
  .carousel-inner.vertical {
    height: 100%; /*Note: set specific height here if not, there will be some issues with IE browser*/
  }
  .carousel-inner.vertical > .item {
    -webkit-transition: .6s ease-in-out top;
    -o-transition: .6s ease-in-out top;
    transition: .6s ease-in-out top;
  }

  @media all and (transform-3d),
  (-webkit-transform-3d) {
    .carousel-inner.vertical > .item {
      -webkit-transition: -webkit-transform .6s ease-in-out;
      -o-transition: -o-transform .6s ease-in-out;
      transition: transform .6s ease-in-out;
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      -webkit-perspective: 1000;
      perspective: 1000;
    }
    .carousel-inner.vertical > .item.next,
    .carousel-inner.vertical > .item.active.right {
      -webkit-transform: translate3d(0, 10%, 0);
      transform: translate3d(0, 12.5%, 0);
      top: 0;
    }
    .carousel-inner.vertical > .item.prev,
    .carousel-inner.vertical > .item.active.left {
      -webkit-transform: translate3d(0, -10%, 0);
      transform: translate3d(0, -12.5%, 0);
      top: 0;
    }
    .carousel-inner.vertical > .item.next.left,
    .carousel-inner.vertical > .item.prev.right,
    .carousel-inner.vertical > .item.active {
      -webkit-transform: translate3d(0, 0, 0);
      transform: translate3d(0, 0, 0);
      top: 0;
    }
  }

  .carousel-inner.vertical > .active {
    top: 0;
  }
  .carousel-inner.vertical > .next,
  .carousel-inner.vertical > .prev {
    top: 0;
    height: 100%;
    width: auto;
  }
  .carousel-inner.vertical > .next {
    left: 0;
    top: 12.5%
    right:0;
  }
  .carousel-inner.vertical > .prev {
    left: 0;
    top: -12.5%
    right:0;
  }
  .carousel-inner.vertical > .next.left,
  .carousel-inner.vertical > .prev.right {
    top: 0;
  }
  .carousel-inner.vertical > .active.left {
    left: 0;
    top: -12.5%
    right:0;
  }
  .carousel-inner.vertical > .active.right {
    left: 0;
    top:12.5%
    right:0;
  }

  #carousel-pager .carousel-control.left {
      bottom: initial;
      width: 100%;
  }
  #carousel-pager .carousel-control.right {
      top: initial;
      width: 100%;
  }
  .list-produk{
    padding: 20px 20px;
    background: rgba(255, 255, 255, 0.8);
    width:100%;
    margin-top:10px;
    min-height:100px
  }
  .label{
    font-size:12px;
    border-radius: 0px
  }
  .crossfade > figure {
	  animation: imageAnimation 30s linear infinite 0s;
	  backface-visibility: hidden;
	  background-size: cover;
	  background-position: center center;
	  color: transparent;
	  height: 100%;
	  left: 0px;
	  opacity: 0;
	  position: absolute;
	  top: 0px;
	  width: 100%;
	  z-index: 0;
		margin: 0px
	}
	.crossfade > figure:nth-child(1) {
		background-image: url("{{ asset('assets/images/slide1.jpg') }}");
	}

	.crossfade > figure:nth-child(2) {
	  animation-delay: 6s;
	  background-image: url("{{ asset('assets/images/slide2.jpg') }}");
	}

	.crossfade > figure:nth-child(3) {
	  animation-delay: 12s;
	  background-image: url("{{ asset('assets/images/slide1.jpg') }}");
	}

	.crossfade > figure:nth-child(4) {
	  animation-delay: 18s;
	 background-image: url("{{ asset('assets/images/slide2.jpg') }}");
	}

	.crossfade > figure:nth-child(5) {
	  animation-delay: 24s;
	  background-image: url("{{ asset('assets/images/slide1.jpg') }}");
	}
	#overlay {
	  position: fixed;
	  display: none;
	  width: 100%;
	  height: 100%;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: rgba(20, 20, 20, 0.5);
	  z-index: 2;
	  cursor: pointer;
	}
	@keyframes
		imageAnimation {  0% {
		 animation-timing-function: ease-in;
		 opacity: 0;
		}
		 8% {
		 animation-timing-function: ease-out;
		 opacity: 1;
		}
		 17% {
		 opacity: 1
		}
		 25% {
		 opacity: 0
		}
		 100% {
		 opacity: 0
		}
	}
  </style>
</head>
<body style="background:url('{{asset('assets/images/slide2.jpg')}}') no-repeat;background-size:cover;background-position:top center">
  {{-- <div class="crossfade">
		<figure></figure>
		<figure></figure>
		<figure></figure>
		<figure></figure>
		<figure></figure>
	 </div> --}}
  <div style="padding-left:30px;padding-right:30px;position:relative">
    <img src="{{asset('assets/images/logo_display.png')}}" style="height:100px;margin-top:20px">
    {{-- <div style="padding: 10px 20px;background:#d04e00;color:#fff;font-size:17px;width:100%;margin-bottom:10px">
      <div class="row">
        <div class="col-md-8">NOMOR / PRODUK HUKUM</div>
        <div class="col-md-4">SATUAN KERJA</div>
      </div>
    </div> --}}
    <div id="carousel-pager" class="carousel slide " data-ride="carousel" data-interval="3000">
      <div class="carousel-inner vertical">
        @foreach ($data as $key => $value)
          <div class="@if($key==0) active @endif item">
            <div class="list-produk">
              <div class="row">
                <div class="col-md-8">
                  <div style="color:#d04e00">188.45/198/HK/416-012/2019</div>
                  <div style="font-weight:500">{{$value->judul}}</div>
                </div>
                <div class="col-md-4">
                  <div style="font-weight:500;margin-bottom:5px">{{$value->satker}}</div>
                  <span class="label" style="background:{{$value->label}}">{{$value->status_produk}}</label>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      {{-- <a class="left carousel-control" href="#carousel-pager" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-pager" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a> --}}
    </div>
  </div>
  <script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery.min.js')}} "></script>
  <script type="text/javascript" src="{{asset('assets/js/core/libraries/bootstrap.min.js')}} "></script>
  <script>
  $('.carousel .vertical .item').each(function(){
    var next = $(this).next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    for (var i=1;i<7;i++) {
      next=next.next();
      if (!next.length) {
      	next = $(this).siblings(':first');
    	}
      next.children(':first-child').clone().appendTo($(this));
    }
  });
  </script>
</body>
</html>
