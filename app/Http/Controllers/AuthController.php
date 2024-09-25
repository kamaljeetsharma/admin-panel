<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Otp;
use App\Http\Controllers\Controller;
use App\Jobs\SendPasswordMail;
use App\Jobs\SendOtpMail;
use App\Mail\OtpMail;
use App\Mail\passmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    
public function index()
{
    $loggedInUserId = Auth::id(); // Get the ID of the currently logged-in user
    $users = User::where('id', '!=', $loggedInUserId)->get();
    return view('admin.delete', compact('users'));
}

    //Handle user signup.
     public function signup(Request $request)
{
    // Generate a random password
    $randomPassword = Str::random(8);

    // Validate input
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number',
    ]);

    // Hash the password and merge it with the validated data
    $data['password'] = Hash::make($randomPassword);

    // Create the user with the complete data
    $user = User::create($data);

    // Dispatch email sending
    SendPasswordMail::dispatch($user->email, $user->name, $randomPassword);

    return response()->json([
        'status' => true,
        'message' => 'User created successfully',
        'user' => $user,
    ], 201);
}
    // Send email with password.
      
     public function sendEmail($toEmail, $name, $password)
     {
         try {
             Mail::to($toEmail)->send(new Passmail($name, $password));
             Log::info('Email sent to: ' . $toEmail);
         } catch (\Exception $e) {
             Log::error('Error sending email: ' . $e->getMessage());
         }
     }
     
    /**
     * Handle user login.
     */
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
      'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Login successful!',
            'user' => Auth::user()
        ], 200);
    }
    return response()->json(['message' => 'Invalid email or password.'], 401);
}

    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['message' => 'Logout successful!']);
}

    public function dashboard(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user(); // Get the currently authenticated user
            $userDetails = [
                'name' => $user->name,
                'email' => $user->email,
            ];

            return response()->json([
                'status' => true,
                'message' => 'User is authenticated.',
                'userDetails' => $userDetails
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User is not authenticated.'
            ], 401); // 401 Unauthorized
        }
    }
    
public function edit($id)
{
    return view('admin.edit', ['user' => User::findOrFail($id)]);
}

public function showProfile($id)
{
  return view('admin.index', ['user' => User::findOrFail($id)]);
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    if ($user) {
        $this->validateProfile($request);
        $this->updateUserData($request, $user);

        return response()->json(['status' => true, 'message' => 'Profile updated successfully.']);
    }

    return response()->json(['status' => false, 'message' => 'User is not authenticated.'], 401);
}

public function updateUser(Request $request, $id)
{
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        $userToUpdate = User::findOrFail($id);
        $this->validateProfile($request);
        $this->updateUserData($request, $userToUpdate);

        return response()->json(['status' => true, 'message' => 'User updated successfully.']);
    }

    return response()->json(['status' => false, 'message' => 'Access denied or user not found.'], 403);
}

// Validation method to reuse in both profile and user updates
protected function validateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'mobile_number' => 'required|digits_between:10,15',
        'gender' => 'required|in:male,female,others',
        'address' => 'required|string|max:255',
        'password' => 'sometimes|nullable|string|min:8|confirmed',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
}

// Update user data method
protected function updateUserData(Request $request, User $user)
{
    $user->fill($request->only(['name', 'mobile_number', 'gender', 'address']));

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($user->image) {
            Storage::delete($user->image);
        }
        $user->image = $request->file('image')->store('images', 'public');
    }

    // Update password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();
}

public function showProfileForm()
{
    if (Auth::check()) {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'name' => $user->name,
            'email' => $user->email,
            'mobile_number' => $user->mobile_number,
            'gender' => $user->gender,
            'address' => $user->address,
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'User is not authenticated.',
    ], 401); // 401 Unauthorized
}

public function updatePassword(Request $request)
{
    $user = Auth::user();

    if (!Hash::check($request->old_password, $user->password)) {
        return response()->json(['status' => false, 'message' => 'Old password does not match.'], 400);
    }

    // Update the password directly
    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['status' => true, 'message' => 'Password updated successfully.']);
}

public function destroy($id)
{
    User::destroy($id); // Directly delete the user by ID

    return back()->with('success', 'User deleted successfully!');
}

 public function addUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number',
        'gender' => 'required|in:male,female,other',
        'address' => 'required|string|max:255',
    ]);

    // Create the user with a random hashed password and dispatch email
    $randomPassword = Str::random(8);
    $user = User::create(array_merge($request->only(['name', 'email', 'mobile_number', 'gender', 'address']), [
        'password' => Hash::make($randomPassword),
    ]));

    Log::info(__('user_created', ['email' => $user->email, 'mobile_number' => $user->mobile_number]));
    SendPasswordMail::dispatch($user->email, $user->name, $randomPassword);

    return response()->json([
        'status' => true,
        'message' => __('user_created_successfully'),
        'user' => $user,
    ], 201);
}

    public function Email($toEmail, $name, $password)
{
    Mail::to($toEmail)->send(new Passmail($name, $password));
    Log::info("Email sent to: $toEmail");
}

}