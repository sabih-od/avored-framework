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

    public function index(Request $request, $type)
    {
        $q = $request->get('q');
        $is_query = in_array($q, ['deleted', 'ignored']);

        $models = ReportedCreateRequest::types();
        if (!array_key_exists($type, $models))
            return abort(404);
        $title = Str::ucfirst(Str::plural($type));

        if ($is_query) {
            if ($q == 'deleted') {
                $data = ($models[$type])::withTrashed()
                    ->whereNotNull('deleted_at')
                    ->whereHas('reported')
                    ->withCount('reported')
                    ->paginate();
            } elseif ($q == 'ignored') {
                $data = ($models[$type])::whereHas('reportedIgnored')->withCount(['reportedIgnored'])->paginate();
            }
        } else {
            $data = ($models[$type])::whereHas('reported')->withCount(['reported'])->paginate();
        }

        return view('avored::reported.index', compact('data', 'title', 'type', 'is_query', 'q'));
    }

    public function itemShow($type, $id)
    {
        $models = ReportedCreateRequest::types();
        if (!array_key_exists($type, $models))
            return abort(404);

        $item = ($models[$type])::find($id);
        if (is_null($item))
            return abort(404);

        $title = Str::ucfirst($type);
        $report_list = $item->reported()->with(['user'])->paginate();

        return view('avored::reported.show', compact('item', 'report_list', 'type', 'title'));
    }

    public function itemDestroy($type, $id)
    {
        $models = ReportedCreateRequest::types();
        if (!array_key_exists($type, $models))
            return abort(404);

        $item = ($models[$type])::find($id);
        if (is_null($item))
            return abort(404);

        $item->delete();

        return back();
    }

    /**
     * @param $reported
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Reported $reported)
    {
        $reported->delete();

        return back();
    }

    public function commentDestroy($post, $comment)
    {
        $item = $this->repository->find($post);
        if ($item)
            $item->comments()->where('id', $comment)->delete();

        return redirect(route('admin.post.show', $post));
    }


}
