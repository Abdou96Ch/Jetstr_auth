<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
      /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }


        /**
         * Fonction index
         *
         * @return \Illuminate\Http\Response
         */
    public function index($usr = null)
    {
        //
        $posts = Post::latest()->paginate(6);
        return view('home')->with([
            'posts'=> $posts,
        ]);
    }

    /**
     * Fonction pour créer un post
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return view('create');   
    }
    

    /**
     * Fonction pour enregistrer les données
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //
    public function store(PostRequest $request)
    {
        
    // diedamp function pour stocker dans al base de données et afficher le token csrf
    // dd($request->all());

    // 1ère méthode pour enregistrer le formulaire dans la base de donées
        // $_post = new Post();
        // $post->title = $request->title;
        // $post->slug = Str::slug($request->title);
        // $post->body = $request->body;
        // $post->image = "https://via.placeholder.com/640x480.png/0055cc?text=minus";
        // $post->save();

                // Tester si le formulaire a une image et l'envoyer au fichier publicupload
                if($request->has('image')){
                    $file = $request->image;
                    $image_name = time().'_'.$file->getClientOriginalName();
                    $file->move(public_path('uploads'),$image_name);
                }   

        // 2ème méthode pour enregistrer le formulaire dans la base de donées
        Post::create([
        'title' => $request->title,
        'slug' => Str::slug($request->title),
        'body' => $request->body,
        'image' => $image_name,
        'user_id' => auth()->user()->id
    ]);
    echo("Post ajouté");
    return redirect('/')->with(['success'=>'Le post est ajouté avec succès']);}
    

    /**
     * Fonction pour afficher les posts
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function show(Post $post)
    {
        //
        return view('show')->with([
            'post'=>$post
        ]);
    }

    /**
     * Fonction pour modifier les posts
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('edit')->with(['post' => $post]);
    }

    /**
     * Fonction pour enregistrer les modifications des posts
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        if($request->has('image')){

            $file = $request->image;
            $image_name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'),$image_name);
           
            // Vérifier si le post à une image afin de la remplacer et détruire l'ancienne sinon la creer en upload
            if(file_exists(public_path('uploads/') . $post->image)){
                unlink(public_path('uploads/') . $post->image);
               }
            $post->image = $image_name;
        } 
        
        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'image' => $post->image 
        ]);
        echo("Post modifié");
        return redirect('/')->with(['success'=>'Le post est modifié avec succès']);
    }

    /**
     * Fonction pour supprimer les posts
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //Chercher d'abord si l'image existe dans le dossier uploads pour la supprimer
        if(file_exists(public_path( ' ./ uploads/') . $post->image)) {
             unlink(public_path( ' uploads ') . '/' . $post->image);
        }
        $post->delete();
        return redirect('/')->with(['success'=>'Le post est supprimé avec succès']);    
    }

     /**
     * Fonction pour supprimer les posts d'une manière définitive
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($slug)
    {
        $post = Post::withTrashed()->where('slug',$slug)->first();

        //Chercher d'abord si l'image existe dans le dossier uploads pour la supprimer
        if(file_exists(public_path( ' ./ uploads/') . $post->image)) {
             unlink(public_path( ' uploads ') . '/' . $post->image);
        }
        $post->forceDelete();
        return redirect('/')->with(['success'=>'Le post est supprimé définitivement avec succès']);    
    }

     /**
     * Fonction pour restaurer les posts supprimés
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function restore($slug)
    { 
        $post = Post::withTrashed()->where('slug',$slug)->first();
        $post->restore();
        return redirect('/')->with(['success'=>'Le post est récupéré avec succès']);    
    }
}
