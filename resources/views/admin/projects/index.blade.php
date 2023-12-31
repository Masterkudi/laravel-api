@extends('layouts.app')

@section('content')
    <div class="container">

        <h3 class="m-3">Lista dei miei Progetti</h3>

        {{--
            @if (Auth::user()->role->name === 'admin')
            <div class="bg-light my-2">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-link">Nuovo Progetto></a>
            </div>
            @endif
        --}}

        <div class="projectsGallery">
            <div class="row g-4 justify-content-center flex-wrap-wrap">
                @foreach ($projects as $project)
                    <div class="col-2">
                        <div class="card p-1">
                            <div>
                                <img src={{ asset('/storage/' . $project->image) }} class="img-thumbnail" style="width: 100%">
                            </div>
                            <div class="card-body bg-white text-center">
                                <div>{{ $project->title }}</div>
                                <span class="badge m-2"
                                    style="background-color: rgb({{ $project->type->color }})">{{ $project->type->name }}</span>
                                <div>{{ $project->published_at?->format('d/m/Y H:i') }}</div>
                                <div><a href="{{ $project->repository }}">
                                        <i class="fa-brands fa-github fa-2xl" style="padding: 2rem"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center w-100">
                                <div class="m-1">
                                    <a href="{{ route('admin.projects.show', $project->slug) }}" class="btn btn-success">
                                        <i class="fa-solid fa-circle-info"></i></a>
                                </div>
                                <div class="m-1">
                                    <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <div class="m-1">
                                    <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST">
                                        @csrf()
                                        @method('DELETE')
                                        <a class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <a
            v-for="pageLink in pagination.links"
            class="btn btn-link"
            @click="fetchData(pageLink.url)"
            v-html="pageLink.label"
            ></a>
        </div>
    </div>
@endsection
