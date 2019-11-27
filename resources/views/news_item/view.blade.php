@extends('layouts.app')

@section('title', $newsItem->title )

@section('content')
    <a href="{{ route('news.index') }}" role="button" aria-pressed="true">Назад к списку новостей</a>

    <div class="blog-post">
        <h2 class="blog-post-title">{{ $newsItem->title }}</h2>
        <p class="blog-post-meta">{{ $newsItem->created_at }}</p>
        @if (!empty($newsItem->image_url))
            <img width="500px" style="float: left; margin:0 15px 0 0;" src="{{ $newsItem->image_url }}"
                 alt="Изображение не найдено">
        @endif
        <p>{!! $newsItem->description !!}</p>
    </div>

@endsection
