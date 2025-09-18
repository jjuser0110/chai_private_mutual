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
        <div class="news-image-wrapper"
            style="background-image: {{ optional($n->last_file)->file_path ? 'url("' . env('BACKEND_URL') . '/storage/' . optional($n->last_file)->file_path . '")' : 'black' }};">
        </div>
        <div class="news-info">
            <h4>{{ $n->title ?? 'The title is here' }}</h4>
            <p>{{ isset($n->article_date) ? explode(' ', $n->article_date)[0] : '-' }}</p>
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
