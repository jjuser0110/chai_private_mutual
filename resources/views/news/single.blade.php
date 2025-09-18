@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('news') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">News</div>
</div>

<div id="page-content">
    <div id="single-news">
        <img src="{{ env('BACKEND_URL') }}/storage/{{ $news->last_file->file_path ?? '' }}" class="news-image"/>
        <div class="news-info">
            <h2>{{ $news->title ?? 'This is the title' }}</h2>
            <p>{{ isset($news->article_date) ? explode(' ', $news->article_date)[0] : '-' }}</p>  
            <div class="more-ifno">{!! nl2br(e($news->description ?? '')) !!}</div>
        </div>
    </div>
</div>
@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');
@endsection
