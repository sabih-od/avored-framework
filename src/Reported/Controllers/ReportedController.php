<?php

namespace AvoRed\Framework\Reported\Controllers;

use App\Models\Reported;
use AvoRed\Framework\Database\Contracts\PostModelInterface;
use AvoRed\Framework\Database\Repository\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class ReportedController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reported = Reported::query()->orderByDesc('created_at')->paginate(10);
        return view('avored::reported.index', compact('reported'));
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
     * @param $reported
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Reported $reported)
    {
        $reported->delete();

        return redirect(route('admin.reported.index'));
    }

    public function commentDestroy($post, $comment)
    {
        $item = $this->repository->find($post);
        if ($item)
            $item->comments()->where('id', $comment)->delete();

        return redirect(route('admin.post.show', $post));
    }


}
