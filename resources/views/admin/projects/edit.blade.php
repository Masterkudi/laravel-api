@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="title m-4">
            <h1>Modifica il Progetto</h1>
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

        {{-- $project rappresenta i dati recuperarti con il controller --}}
        <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf()
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="title_input">Titolo</label>
                <input type="text" class="form-control" name="title" value="{{ $project->title }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Tipologia</label>
                <select class="form-select" name="type_id" value="{{ $project->type_id }}">
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ $project->type_id === $type->id ? 'selected' : '' }}>
                            {{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tecnologie utilizzate</label>

                <div>
                    @foreach ($technologies as $technology)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="technologies[]"
                                id="{{ $technology->slug }}" value="{{ $technology->id }}"
                                {{ $project->technologies->contains($technology) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $technology->slug }}">{{ $technology->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Immagine</label>
                @if ($project->image)
                    <img src="{{ asset('/storage/' . $project->image) }}" alt="" class="img-thumbnail"
                        style="width: 100px">
                @endif

                <div class="input-group">
                    <label class="btn btn-danger" type="button" id="inputGroupFileAddon04">
                        <input type="file" class="form-control d-none" name="image" accept="image/*">Scegli</label>
                    <input type="text" class="form-control" name="image_link">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="content_input">Contenuto</label>
                <textarea class="form-control" name="body" id="content_input">{{ $project->body }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Repository</label>
                <input type="text" class="form-control" name="repository" value="{{ $project->repository }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Data Pubblicazione</label>
                <input type="date" class="form-control" name="published_at"
                    value="{{ $project->published_at?->toDateString() }}">
            </div>

            <div class="mb-3">
                <div class="form-check">
                    {{-- type="hidden" fornisce un valore predefinito (in questo caso "0") per l'input "is_published" nel caso in cui la checkbox non sia selezionata. --}}
                    <input type="hidden" name="is_published" value="0">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published_input"
                        {{ $project->is_published ? 'checked' : '' }} value="1">
                    <label class="form-check-label" for="is_published_input">
                        Pubblicato
                    </label>
                </div>
            </div>



            <button class="btn btn-primary">Aggiorna</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-danger">Annulla</a>
        </form>
    </div>

@endsection
