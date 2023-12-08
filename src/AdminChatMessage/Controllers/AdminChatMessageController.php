<?php

namespace AvoRed\Framework\AdminChatMessage\Controllers;

use \Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminChatMessage;
use AvoRed\Framework\Database\Repository\AdminChatMessageRepository;
use AvoRed\Framework\AdminChatMessage\Requests\AdminChatMessageCreateRequest;
use AvoRed\Framework\AdminChatMessage\Requests\AdminChatMessageUpdateRequest;

class AdminChatMessageController extends Controller
{
    /**
     * @var AdminChatModelInterface|AdminChatMessageRepository
     */
    protected $repository;

    /**
     *
     * @param AdminChatMessageRepository $repository
     */
    public function __construct(AdminChatMessageRepository $repository)
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
        $list = $this->repository->list();
        return view('avored::admin_chat_message.index')->with('list', $list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('avored::admin_chat_message.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminChatMessageCreateRequest $request
     * @return Response
     */
    public function store(AdminChatMessageCreateRequest $request)
    {
        $adminChatMessage = $this->repository->create([
            'admin_user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return redirect(route('admin.admin-chat-message.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AdminChatMessage $adminChatMessage
     * @return Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminChatMessageUpdateRequest $request
     * @param AdminChatMessage $adminChatMessage
     * @return Response
     */
    public function update(AdminChatMessageUpdateRequest $request, AdminChatMessage $adminChatMessage)
    {

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param AdminChatMessage $adminChatMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminChatMessage $adminChatMessage)
    {
        
    }
}
