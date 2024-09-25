<?php

namespace App\Http\Controllers;
use App\Jobs\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Validator;



class Passwordcontroller extends Controller
{

    public function forgotPassword(Request $request)
{
    // Validate email input
    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
    ]);

    // Generate a 6-digit OTP
    $otp = random_int(100000, 999999);

    // Store or update the OTP with expiration
    Otp::updateOrCreate(
        ['email' => $request->email],
        [
            'otp' => $otp,
            'expires_at' => now()->addMinutes(15),
        ]
    );

    // Dispatch job to send OTP email
    SendOtpMail::dispatch($request->email, $otp);

    // Return success response
    return response()->json([
        'status' => true,
        'message' => __('OTP sent successfully. Please check your email.'),
    ], 200);
}




public function otpVerification(Request $request)
{
    // Validate OTP format
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    // Retrieve the OTP record and associated user in one query
    $otpRecord = Otp::where('otp', $request->otp)->with('user')->first();

    // Check if OTP and user exist
    if (!$otpRecord || !$otpRecord->user) {
        return response()->json([
            'status' => false,
            'message' => $otpRecord ? 'User not found' : 'OTP is incorrect or expired',
        ], $otpRecord ? 404 : 400);
    }

    // Delete the OTP record
    $otpRecord->delete();

    // Return a success response
    return response()->json([
        'status' => true,
        'message' => 'OTP verified successfully.',
        'email' => $otpRecord->user->email,
    ]);
}

public function resetPasswordWithOtp(Request $request)
{
    // Ensure email exists in the database
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
        ], 404);
    }
    // Update the user's password
    
    $user->update(['password' => Hash::make($request->password)]);

    // Delete the OTP record for the email
    Otp::where('email', $request->email)->delete();

    return response()->json([
        'status' => true,
        'message' => 'Password reset successfully.',
    ], 200);
}


}