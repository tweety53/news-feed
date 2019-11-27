@extends('layouts.app')

@section('title', 'Список новостей')

@section('content')
    <h1><a style="text-decoration: none; margin-left: 15px;" href="{{ route('news.index') }}">Список новостей</a></h1>

    @if (count($news) > 0)
        @foreach ($news as $newsItem)
            @php
                $url = route('news.item.view', ['id' => $newsItem]);
            @endphp
            <div class="col-md-12">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0">
                            <a class="text-dark" href="{{ $url }}">{{ $newsItem->title }}</a>
                        </h3>
                        <div class="mb-1 text-muted">{{ $newsItem->created_at }}</div>
                        <p class="card-text mb-auto">{{ $newsItem->short_description }}</p>
                        <a class="btn btn-success" href="{{ $url }}">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        Новостей не найдено
    @endif
    {{ $news->links() }}
@endsection
