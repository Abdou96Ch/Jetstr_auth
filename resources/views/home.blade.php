@extends('master.layout'); 
@section('title')
Acceuil
@endsection

@section('content')
<div class="row ">
    <div class="col-md-8">
        <!-- Message de succès d'ajout de post -->
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif
        <!-- Cards des posts sur la page htmlh home -->
        <div class="row">
        @foreach ($posts as $post)
            <div class="col md-3 mb-2 ">
                <div class="card h-100 " style="width: 18rem;">
                <img src="{{ asset('./uploads/'.$post->image) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title}}</h5>
                        <h5 class="card-title">{{ $post->user_id ? $post->user->name : null  }}</h5>
                        <p class="card-text">{{ Str::limit($post->body,50) }}</p>
                        <a href= " /post/{{$post->slug}}" class="btn btn-primary">voir</a>
                    </div>
                </div>
            </div>
        @endforeach
        </div>

        <!-- Code de pagination -->
            <div class="d-flex justify-content-center my-4">
                {{ $posts->links() }}
            </div>
    </div>
</div>
@endsection