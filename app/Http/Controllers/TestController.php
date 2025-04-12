<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testCORS()
    {
        return response()->json([
            'message' => 'CORS works successfully!',
            'data' => [
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ]
        ]);
    }
}