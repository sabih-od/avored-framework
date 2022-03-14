<?php

namespace AvoRed\Framework\GroupChat\Controllers;

use App\Models\GroupChat;
use AvoRed\Framework\Database\Contracts\ChannelModelInterface;
use AvoRed\Framework\Database\Contracts\GroupChatModelInterface;
use AvoRed\Framework\Database\Repository\GroupChatRepository;
use AvoRed\Framework\GroupChat\Requests\GroupCreateRequest;
use AvoRed\Framework\GroupChat\Requests\GroupUpdateRequest;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GroupChatController extends Controller
{
    /**
     * @var GroupChatModelInterface|GroupChatRepository
     */
    protected $repository;

    protected $channel;

    /**
     *
     * @param GroupChatRepository $repository
     */
    public function __construct(GroupChatModelInterface $repository, ChannelModelInterface $channel)
    {
        $this->repository = $repository;
        $this->channel = $channel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $list = $this->repository->list();
        return view('avored::group_chat.index')->with('list', $list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('avored::group_chat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupCreateRequest $request
     * @return Response
     */
    public function store(GroupCreateRequest $request)
    {
        $channel = $this->channel->create([
            'participants' => json_encode([]),
            'chat_type' => 'group'
        ]);

        $request['channel_id'] = $channel->id;

        $group = $this->repository->create($request->only(['title', 'channel_id']));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $group->addMediaFromRequest('image')->toMediaCollection('group_chat_upload');
        }

        return redirect(route('admin.group-chat.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GroupChat $groupChat
     * @return Response
     */
    public function edit(GroupChat $groupChat)
    {
        return view('avored::group_chat.edit')->with('group', $groupChat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupUpdateRequest $request
     * @param GroupChat $group
     * @return Response
     */
    public function update(GroupUpdateRequest $request, GroupChat $group_chat)
    {
        $group_chat->update($request->only(['title']));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $group_chat->clearMediaCollection('group_chat_upload');
            $group_chat->addMediaFromRequest('image')->toMediaCollection('group_chat_upload');
        }

        return redirect(route('admin.group-chat.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param GroupChat $groupChat
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupChat $groupChat)
    {
        $groupChat->channel()->delete();
        $groupChat->clearMediaCollection('group_chat_upload');
        $groupChat->delete();
        return redirect(route('admin.group-chat.index'));
    }
}