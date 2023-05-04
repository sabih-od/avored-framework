<?php

namespace AvoRed\Framework\Reported\Controllers;

use App\Http\Requests\ReportedCreateRequest;
use App\Models\Reported;
use AvoRed\Framework\Database\Contracts\PostModelInterface;
use AvoRed\Framework\Database\Repository\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportedController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, $type)
    {
        $models = ReportedCreateRequest::types();
        if (!array_key_exists($type, $models))
            return abort(404);
        $title = Str::ucfirst(Str::plural($type));
        $data = ($models[$type])::whereHas('reported')->withCount(['reported'])->paginate();
//        dd($data);
//        $reported = Reported::query()->orderByDesc('created_at')->paginate(10);
        return view('avored::reported.index', compact('data', 'title', 'type'));
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
