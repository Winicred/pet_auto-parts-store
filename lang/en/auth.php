<?php

return [
  'welcome' => 'Добро пожаловать, <b>:name</b>!',

  "failed" => "Invalid login or password.",
  "password" => "Invalid password.",
  "throttle" =>
    "Too many login attempts. Please try again in :seconds seconds.",

  "labels" => [
    'name' => 'Username',
    'email' => 'Email',
    'password' => 'Password',
    'confirm_password' => 'Confirm password',
    'remember' => 'Remember me',
    'forgot' => 'Forgot password?',
    'already_registered' => 'Already registered?',
    'logout' => 'Logout',
  ],
  "login" => [
    "title" => "Login",
  ],
  "register" => [
    "title" => "Register",
  ],
  "forgot_password" => [
    "description" => "Forgot your password? No problem. Just tell us your email address and we'll send you a password reset link that will allow you to choose a new one.",
    "submit" => "Send password reset link",
  ],
  "reset_password" => [
    "submit" => "Reset password",
  ],
  "confirm_password" => [
    "description" => "This is a secure area. Please confirm your password to continue.",
    "submit" => "Confirm password",
  ],
  "verify_email" => [
    "description" => "Thank you for registering! Before continuing, please check your email for a confirmation link.",
    "new_link" => "We have sent you a new confirmation link.",
    "resend" => "If you did not receive the email",
  ]
];
