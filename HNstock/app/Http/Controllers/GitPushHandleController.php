<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GitPushHandleController extends Controller
{


    public function __invoke(): JsonResponse
    {
        $output = shell_exec('git reset --hard HEAD && git pull origin master');

        Log::info("git pull completed");
        return response()->json([
            'message' => 'Git pull executed',
            'output' => $output,
        ]);
    }

}
