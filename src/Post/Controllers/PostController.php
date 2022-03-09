<?php

namespace AvoRed\Framework\Post\Controllers;

use AvoRed\Framework\Database\Contracts\PostModelInterface;
use AvoRed\Framework\Database\Repository\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * @var PostModelInterface|PostRepository
     */
    protected $repository;

    /**
     *
     * @param PostModelInterface $repository
     */
    public function __construct(PostModelInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = $this->repository->list();
        return view('avored::post.index')->with('posts', $posts);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $item = $this->repository->find($id);
        return view('avored::post.show')->with('post', $item);
    }

    /**
     * @param $post
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($post)
    {
        $item = $this->repository->find($post);

        if ($item)
            $item->delete();

        return redirect(route('admin.post.index'));
    }

    public function commentDestroy($post, $comment)
    {
        $item = $this->repository->find($post);
        if ($item)
            $item->comments()->where('id', $comment)->delete();

        return redirect(route('admin.post.show', $post));
    }


}