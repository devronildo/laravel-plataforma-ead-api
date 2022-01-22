<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\StoreReplySupport;
use App\Http\Resources\ReplySupportResource;
use Illuminate\Http\Request;

class ReplySupportController extends Controller
{
    protected $repository;

    public function __construct(ReplySupportRepository $replySupportRepository){
        $this->repository = $replySupportRepository;
    }


    public function createReply(StoreReplySupport $request){
        $reply = $this->repository->createReplyToSupport($request->validated());

        return new ReplySupportResource($reply);

      }
}
