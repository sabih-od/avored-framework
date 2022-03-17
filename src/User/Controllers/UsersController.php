<?php

namespace AvoRed\Framework\User\Controllers;

use App\Models\User;
use AvoRed\Framework\Database\Contracts\UserModelInterface;
use AvoRed\Framework\Database\Repository\UserRepository;
use AvoRed\Framework\User\Requests\AdminUserRequest;
use AvoRed\Framework\Database\Contracts\AdminUserModelInterface;
use AvoRed\Framework\Database\Contracts\RoleModelInterface;
use AvoRed\Framework\Database\Models\AdminUser;
use AvoRed\Framework\Document\Document;
use AvoRed\Framework\Tab\Tab;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    /**
     * @var UserRepository $repository
     */
    protected $repository;

    /**
     * @param UserModelInterface $repository
     */
    public function __construct(
        UserModelInterface $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $users = $this->repository->list();

        return view('avored::user.users.index')
            ->with('users', $users);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        if (!is_null($user->profile_image))
            Storage::delete('public/uploads/' . $user->profile_image);

        $user->delete();

        return redirect(route('admin.users.index'));
    }
}
