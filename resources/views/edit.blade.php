@extends('master.layout');

@section('style')
@endsection

@section('title')
Modifier {{$post->title}}
@endsection

@section('content')
<div class="row ">
    <div class="col-md-8 mx-auto">
        <!-- Message d'erreur pour l'envoi de formulaire avec type d'erreur -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h3>Modifier {{$post->title}}</h3>
                </div>
                <div class="card-body">
                     
                    <form action="{{route('post.update',$post->slug)}}" method="post" enctype="multipart/form-data">
                        <!-- Ajout de CSRF token pour connexion sécurisée -->
                        @csrf
                        <!-- Pour annoncer qu'on utilise la méthode put -->
                        @method('PUT')
                        <!-- Ajout du champ value posttitlebody par rapport au create -->
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Titre</label>
                            <input type="text" class="form-control" name="title" placeholder="Insérer votre texte" value="{{ $post->title }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"></label>
                            <input type="file" class="form-control" name="image" >
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <input type="text" class="form-control" name="body" rows="8" placeholder="Description " value="{{ $post->body }}"></input>
                        </div>
                        <button type="submit"  class="btn btn-primary" >Valider</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection 