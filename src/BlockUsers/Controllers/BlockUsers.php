<?php

namespace AvoRed\Framework\BlockUsers\Controllers;

use App\Http\Requests\ReportedCreateRequest;
use App\Models\EmailSubscription;
use App\Models\Reported;
use App\Models\User;
use App\Models\BlockUser;
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

class BlockUsers extends Controller
{

    public function index(Request $request)
    {
        $data = BlockUser::query()->with(['blockedUserDetail', 'blockedByUserDetail'])->paginate();

        return view('avored::block_users.index', compact('data'));
    }

    /**
     * @param $reported
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(EmailSubscription $email_sub)
    {
        $email_sub->delete();

        return back();
    }

}
