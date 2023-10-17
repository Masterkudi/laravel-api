@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="title m-4">
            <h1>Nuovo Progetto</h1>
        </div>

        {{-- Variabile $errors che va a ciclare su ogni errore e poi li stampa --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf()

            <div class="mb-3">
                <label class="form-label">Titolo</label>
                <input type="text" class="form-control" name="title">
            </div>

            <div class="mb-3">
                <label class="form-label">Tipologia</label>
                <select class="form-select" name="type_id">
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tecnologie utilizzate</label>

                <div>
                    @foreach ($technologies as $technology)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="technologies[]"
                                id="{{ $technology->slug }}" value="{{ $technology->id }}">
                            <label class="form-check-label" for="{{ $technology->slug }}">{{ $technology->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Immagine</label>
                <input type="file" accept="image/*" class="form-control" name="image">
            </div>

            <div class="mb-3">
                <label class="form-label">Contenuto</label>
                <textarea class="form-control" name="body"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Repository</label>
                <input type="text" class="form-control" name="repository">
            </div>

            <div class="mb-3">
                <label class="form-label">Data Pubblicazione</label>
                <input type="date" class="form-control" name="published_at">
            </div>

            <button type="submit" class="btn btn-primary">Salva</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-danger">Annulla</a>
        </form>
    </div>

@endsection
