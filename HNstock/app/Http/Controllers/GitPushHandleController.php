<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GitPushHandleController extends Controller
{

    protected const REF = "refs/heads/master";

    public function __invoke(Request $request): JsonResponse
    {
        if ($request->get('ref') !== self::REF) {
            return response()->json([], Response::HTTP_BAD_REQUEST);
        }

        $output = shell_exec('git config --global --add safe.directory /var/www/app && cd /var/www/app && git reset --hard HEAD && git pull origin master 2>&1');

        Log::info("git pull completed", [$output]);
        return response()->json([
            'message' => 'Git pull executed',
            'output' => $output,
        ]);
    }

}
