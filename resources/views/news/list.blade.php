@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('index') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">News</div>
</div>

<div id="page-content">
    @if(!isset($news))
    <div class="no-data">
        <div class="icon">
            <img src="{{ asset('img/no-data.png') }}" alt="No Data">
        </div>
        <div class="label">No Data</div>
    </div>
    @else
    <div id="news">  
    @foreach($news as $n)
    <div class="news" onclick="loadPage('{{ route('single_news', ['id'=>$n->id]) }}')">
        <div class="news-image-wrapper" style="{{ $n->image_path ? 'background-image:url('.$n->image_path.')' : 'background:black' }}"></div>
        <div class="news-info">
            <h4>{{ $n->title ?? 'The title is here' }}</h4>
            <p>{{ isset($n->created_at) ? explode(' ', $n->created_at)[0] : '-' }}</p>
        </div>
    </div>
    @endforeach
    </div>
    @endif
</div>
@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');
</script>
@endsection
