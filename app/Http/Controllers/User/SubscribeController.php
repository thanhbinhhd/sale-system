<?php

namespace App\Http\Controllers\User;

use App\Repositories\SubscribeRepository;
use App\Http\Requests\CreateSubscribeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{
    protected $subscribe;


    public function __construct(SubscribeRepository $subscribe) {
        $this->subscribe = $subscribe;

    }

    /**
     * @param CreateSubscribeRequest $request
     */
    public function subscribe(CreateSubscribeRequest $request){
        $this->subscribe->store($request->all());
    }

}
