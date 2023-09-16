<?php

namespace App\Http\Controllers;

use App\Services\GoogleService;

class GoogleController extends Controller
{
    public function __construct(private GoogleService $googleService)
    {
    }

    public function redirectToGoogle()
    {
        return $this->googleService->redirectToGoogle();
    }

    public function handleGoogleCallback()
    {
        return $this->googleService->handleGoogleCallback();
    }
}
