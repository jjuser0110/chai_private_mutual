@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('news') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">News</div>
</div>

<div id="page-content">
    <div id="single-news">
        <img src="{{ $news->image_path ?? '' }}" class="news-image"/>
        <div class="news-info">
            <p>{{ isset($news->created_at) ? explode(' ', $news->created_at)[0] : '-' }}</p>  
            <h2>{{ $news->title ?? 'This is the title' }}</h2>
            <div class="more-ifno">{{ $news->description ?? 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.' }}</div>
        </div>
    </div>
</div>
@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');
@endsection
