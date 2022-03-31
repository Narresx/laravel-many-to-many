@extends('layouts.app')
@section('content')
    <div class="container w-50">
        <div class="card">
            <img class="card-img-top" src="{{ $post->image }}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->content }}</p>
                <p class="card-text">{{ $post->created_at }}</p>
                <p class="badge badge-pill badge-{{ $post->category->color }}">
                    @if ($post->category)
                        {{ $post->category->label }}
                    @else
                        -
                    @endif
                </p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.posts.index', $post->id) }}" class="btn btn-primary">Indietro</a>
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">Modifica</a>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post" id="delete_form">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
