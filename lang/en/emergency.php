<?php

return [
    'title' => 'Emergency: Reset/Activate User',
    'user_type' => 'User Type',
    'search_label' => 'Email or NIC',
    'search_placeholder' => 'Enter email or NIC number',
    'search_btn' => 'Search',
    'searching_btn' => 'Searching',
    'reset_btn' => 'Reset Password & Activate',
    'user_info_title' => 'User Information',
    'confirm_msg' => 'Are you sure you want to reset the password and activate this user?',

    'types' => [
        'admin' => 'Admin User',
        'trainee' => 'Trainee User',
        'cgo' => 'CGO User',
        'recruiter' => 'Company Recruiter',
    ],

    'fields' => [
        'email' => 'Email Address',
        'nic' => 'NIC Number',
        'name' => 'Full Name',
        'status' => 'Account Status',
    ],

    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    'not_found' => 'User not found',
    'found_success' => 'User found',
    'found_msg' => 'Found user with email: :email',
    'reset_success_title' => 'Success',
    'reset_success_body' => 'Password reset and user activated. New password sent to email.',
    'email_failed' => 'Password reset but email failed to send.',
    'confirm_modal_heading' => 'Confirm Security Reset',
    'confirm_modal_desc' => 'To prevent accidental resets, please type "CONFIRM" below to proceed.',
    'confirm_input_label' => 'Type CONFIRM to authorize',
    'reset_complete' => 'Password Successfully Reset',
    'new_password_display' => 'The new password is',
    'password_warning' => 'Please copy this password now. It will disappear if you refresh or search again.',
];
