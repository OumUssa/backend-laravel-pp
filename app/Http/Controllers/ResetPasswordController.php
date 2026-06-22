<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // We return true anyway for security, so attackers can't guess emails
            return response()->json(['result' => true, 'message' => 'If this email exists, a reset link has been sent.']);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => Carbon::now()]
        );

        // Try to send email. If it fails, we catch it so it doesn't crash the API
        try {
            // Provide a link back to the React app
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
            $resetLink = $frontendUrl . '/reset-password?token=' . $token . '&email=' . urlencode($request->email);

            Mail::raw("Hello {$user->name},\n\nYou requested a password reset. Click the link below to reset your password:\n\n{$resetLink}\n\nIf you did not request this, please ignore this email.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Reset Your Password');
            });

            return response()->json(['result' => true, 'message' => 'If this email exists, a reset link has been sent.']);
        } catch (\Exception $e) {
            return response()->json(['result' => false, 'message' => 'Failed to send email. Please check your SMTP settings in .env.'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6'
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return response()->json(['result' => false, 'message' => 'Invalid or expired token.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['result' => false, 'message' => 'User not found.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['result' => true, 'message' => 'Password reset successfully. You can now login.']);
    }
}
