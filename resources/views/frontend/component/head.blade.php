<base href="{{ config('app.url') }}">
<meta charset="utf-8">
<title>{{$titleClient ?? 'PHGMNHD NEWS'}}</title>

<!-- mobile responsive meta -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="This is meta description">
<meta name="author" content="Themefisher">
<meta name="generator" content="Hugo 0.74.3" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- plugins -->

<link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugins/themify-icons/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick.css') }}">

<!-- Main Stylesheet -->
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" media="screen">

<!--Favicon-->
<link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">

<meta property="og:title" content="Reader | Hugo Personal Blog Template" />
<meta property="og:description" content="This is meta description" />
<meta property="og:type" content="website" />
<meta property="og:url" content="" />
<meta property="og:updated_time" content="2020-03-15T15:40:24+06:00" />
