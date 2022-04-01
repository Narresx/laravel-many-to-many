@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Inserisci il titolo"
                value="{{ old('title', $post->title) }}">
        </div>
        <div class="form-group">
            <label for="content">Contenuto</label>
            <textarea class="form-control" id="content" name="content" rows="12" placeholder="Inserisci qui il contenuto">
                {{ old('content', $post->content) }}
            </textarea>
        </div>
        <div class="form-group">
            <label for="image">Immagine</label>
            <input type="file" class="form-control-file" id="image" name="image" placeholder="Inserisci qui l'immagine"
                value="{{ old('image', $post->image) }}">
        </div>
        <div class="form-group">
            <label for="category">Categoria</label>
            <select type="text" class="form-control" id="category" name="category_id">
                <option value="">Nessuna categoria</option>
                @foreach ($categories as $category)
                    <option @if (old('category_id', $post->category_id) == $category->id) selected @endif value="{{ $category->id }}">
                        {{ $category->label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 d-flex">
            @foreach ($tags as $tag)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="{{ $tag->id }}" value="{{ $tag->id }}"
                        name="tags[]" @if (in_array($tag->id, old('tags', $posts_tags_id ?? []))) checked @endif>
                    <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->label }}</label>
                </div>
            @endforeach
        </div>
        <button type=" submit" class="btn btn-success">Conferma modifiche</button>
    </form>
@endsection
