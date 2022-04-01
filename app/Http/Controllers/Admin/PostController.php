<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PubliscedPostMail;




class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */                         
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $post = new Post();
        $categories = Category::all();
        $tags = Tag::all();
        $posts_tags_id = $post->tags->pluck('id')->toArray();
        return view('admin.posts.create', compact('post','categories','tags','posts_tags_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
        'title' =>'required|string|min:2|max:75',
        'content' =>'string',
        'image' =>'nullable|image',
        'category_id'=>'nullable|exists:categories,id'
        ]);

        $data = $request->all();
        $post = new Post();
        $user = Auth::user();
        if(array_key_exists('image', $data)){
            $img_url = Storage::put('post_images',$data['image']);
            $data['image'] = $img_url;
        }
        $post->fill($data);
        $post->slug= Str::slug($post->title, '-');
        $post->save();
       
        if (array_key_exists('tags', $data)) $post->tags()->attach($data['tags']);

        $mail = new PubliscedPostMail();
        
        Mail::to($user->email)->send($mail);

        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        $categories = Category::all();
        $tags = Tag::all();
        $posts_tags_id = $post->tags->pluck('id')->toArray();
        return view('admin.posts.edit', compact('post', 'categories','tags','posts_tags_id'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' =>['required','string',Rule::unique('posts')->ignore($post->id),'min:2','max:75'],
            'content' =>'string',
            'image' =>'url',
            'category_id'=>'nullable|exists:categories,id'
        ]);
            
            $data = $request->all();
            $data['slug'] = Str::slug($request->title,'-');
            $post->update($data);
            if(array_key_exists('image', $data)){
                if($post->image){
                    Storage::delete($post->image);
                } 
                $img_url = Storage::put('post_images',$data['image']);

                $data['image'] = $img_url;
            }
            if (array_key_exists('tags', $data)) $post->tags()->sync($data['tags']);
            return redirect()->route('admin.posts.show', $post);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if($post->image) Storage::delete($post->image);

        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
