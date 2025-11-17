<?php

namespace App\Services\V1\Auth;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Authentication Service
 * 
 * Handles user authentication operations including registration, login, and logout
 * using JWT tokens for API authentication.
 */
class AuthService
{
    /**
     * Register a new user and generate JWT token
     * 
     * @param array $data User registration data (name, email, password)
     * @return array Contains token and user object
    * @throws HttpException If token creation fails
     */
    public function register(array $data)
    {
        $user = User::create($data);

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            throw new HttpException(500, 'Could not create token');
        }

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    /**
     * Authenticate user and generate JWT token
     * 
     * @param array $credentials User credentials (email, password)
     * @return array Contains token and expiration time
    * @throws HttpException If credentials are invalid or token creation fails
     */
    public function login(array $credentials)
    {
        // basic guard for missing fields
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        if (!$email || !$password) {
            throw new HttpException(422, 'Email and password are required.');
        }

        $creds = [
            'email' => $email,
            'password' => $password,
        ];

        try {
            // attempt returns token on success, false on invalid credentials
            $token = JWTAuth::attempt($creds);
        } catch (JWTException $e) {
            // JWT library problem (signing, config, etc.)
            throw new HttpException(500, 'Could not create token');
        }

        if (!$token) {
            // invalid credentials — explicit and not swallowed by the catch
            throw new HttpException(401, 'Invalid credentials');
        }

        return [
            'token' => $token,
            'expires_in' => config('jwt.ttl') * 60,
        ];
    }

    /**
     * Logout user by invalidating JWT token
     * 
     * @return array Success message
    * @throws HttpException If token invalidation fails
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            throw new HttpException(500, 'Failed to logout, please try again');
        }

        return ['message' => 'Successfully logged out'];
    }
}