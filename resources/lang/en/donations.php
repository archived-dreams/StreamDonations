<?php
return [
    // Home
    'home' => [
        'title' => 'My Donations',
        'updated_at' => 'When',
        'name' => 'Donor',
        'amount' => 'Amount',
        'message' => 'Message',
        'status' => 'Status',
        'billing_system' => 'Payment Method',
        'statuses' => [
            'success' => 'Success',
            'refund' => 'Refunded',
            'user' => 'Custom'
        ],
        'create' => [
            'title' => 'Add a Donation',
            'cancel' => 'Cancel',
            'save' => 'Save donation',
            'name' => 'Donor Name',
            'message' => 'Donation Message',
            'amount' => 'Donation Amount',
            'updated_at' => 'Date'
            ]
        ],
    'remove' => [
        'error' => 'Message not found',
        'success' => 'Message successfully deleted'
        ],
    'create' => [
        'success' => 'Message successfully added',
        'error' => 'Error adding message'
        ],
    // Donate
    'donate' => [
        'title' => 'Donate',
        'emotion_error' => 'Message length is too long',
        'submit' => 'Donate',
        'terms' => 'By interacting on this page, you are agreeing to our <a href="#" data-toggle="modal" data-target="#:modal">Terms & Conditions</a>.',
        'conditions' => 'Terms & Conditions',
        'subtotal' => 'Subtotal',
        'back' => 'Back',
        'name' => [
            'title' => 'Your name'
            ],
        'amount' => [
            'title' => 'Tip Amount',
            'info' => 'Minimum amount: :amount_minimum'
            ],
        'message' => [
            'title' => 'Tip Message'
            ],
        'payment_description' => 'Donation for a streamer :name',
        'pay' => [
            'title' => 'Invoice #:invoice',
            'method' => 'Payment method',
            'button' => 'Pay',
            'amount' => 'Amount',
            'message' => 'Message',
            'streamer' => 'Streamer',
            'created_at' => 'Date'
            ]
        ]
    
];