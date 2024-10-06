<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GitPushHandleController extends Controller
{


    public function __invoke(Request $request): JsonResponse
    {
        $output = shell_exec('git reset --hard HEAD && git pull origin master');

        Log::info("git pull completed", $request->all());
        return response()->json([
            'message' => 'Git pull executed',
            'output' => $output,
        ]);
    }

}
