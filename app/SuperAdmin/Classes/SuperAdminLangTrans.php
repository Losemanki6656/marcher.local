<?php

namespace App\SuperAdmin\Classes;

class SuperAdminLangTrans
{
    public static $mainTranslations = [
        'menu' => [
            'superadmins' => 'Super Admin',
            'subscription' => 'Subscription',
            'subscriptions' => 'Subscriptions',
            'subscription_plans' => 'Subscription Plans',
            'payment_settings' => 'Payment Settings',
            'paypal' => 'Paypal',
            'stripe' => 'Stripe',
            'razorpay' => 'Razorpay',
            'paystack' => 'Paystack',
            'mollie' => 'Mollie',
            'authorize' => 'Authorize',
            'website_settings' => 'Website Settings',
            'website_clients_settings' => 'Clients Settings',
            'website_testimonials_settings' => 'Testimonials Settings',
            'website_features_settings' => 'Features Settings',
            'website_contact_settings' => 'Contact Settings',
            'website_price_settings' => 'Price Settings',
            'website_faq_settings' => 'FAQ Settings',
            'website_footer_settings' => 'Footer Settings',
            'website_seo_settings' => 'SEO Settings',
            'website_header_settings' => 'Header Settings',
            'website_register_settings' => 'Register Settings',
            'website_call_to_action_settings' => 'Call To Action Settings',
            'payment_transactions' => 'Transcations',
            'current_plan' => 'Current Plan',
            'transcations' => 'Transcations',
            'change_plan' => 'Change Plan',
            'offline_payment_modes' => 'Offline Payment Modes',
            'offline_requests' => 'Offline Requests',
            'paymo' => 'Paymo',
            'paymo_requests' => 'Paymo Requests',
            'white_label' => 'White Label Settings',
        ],
        'subscription_plans' => [
            'subscription_plan' => 'Subscription Plan',
            'add' => 'Add New Subscription Plan',
            'edit' => 'Edit Subscription Plan',
            'created' => 'Subscription Plan Created Successfully',
            'updated' => 'Subscription Plan Updated Successfully',
            'deleted' => 'Subscription Plan Deleted Successfully',
            'super_admin_details' => 'Subscription Plan Details',
            'delete_message' => 'Are you sure you want to delete this subscription plan?',
            'name' => 'Name',
            'description' => 'Description',
            'annual_price' => 'Annual Price',
            'monthly_price' => 'Monthly Price',
            'max_products' => 'Max Products',
            'pricing_details' => 'Pricing Details',
            'payment_gateway_details' => 'Payment Gateway',
            'stripe_monthly_plan_id' => 'Stripe Monthly Plan ID',
            'razorpay_monthly_plan_id' => 'Razorpay Monthly Plan ID',
            'paystack_monthly_plan_id' => 'Paystack Monthly Plan ID',
            'stripe_annual_plan_id' => 'Stripe Annual Plan ID',
            'razorpay_annual_plan_id' => 'Razorpay Annual Plan ID',
            'paystack_annual_plan_id' => 'Paystack Annual Plan ID',
            'enabled_modules' => 'Enabled Modules',
            'free_trail_settings' => 'Free Trail Settings',
            'pos' => 'POS',
            'stock_transfer' => 'Stock Transfer',
            'stock_adjustment' => 'Stock Adjustment',
            'online_store' => 'Online Store',
            'expense' => 'Expense',
            'quotation' => 'Quotation/Estimate',
            'purchase_return' => 'Purchase Return',
            'sales_return' => 'Sales Return',
            'features' => 'Features',
            'add_feature' => 'Add Feature',
            'is_popular_plan' => 'Is Popular',
            'limit_exceed' => 'Limit Exceed',
            'upgrade_your_plan' => 'Please Upgrade Your Subscription Plan To Perform Action',
            'change_plan' => 'Change Plan',
            'upgrade_plan' => 'Upgrade Plan',
            'unlimited' => 'Unlimited',
            'out_of' => 'out of',
            'per_month' => 'per month',
            'per_year' => 'per year',
            'plan_type' => 'Plan Type',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'annual' => 'Annual',
            'trial_duration' => 'Trial Duration',
            'notify_before' => 'Notify Before Days',
            'days' => 'Day(s)',
            'redirecting_please_wait' => 'Redirecting Please Wait...',
            'change' => 'Change',
            'change_subscription_plan' => 'Change Subscription Plan',
            'plan_changed_successfully' => 'Subscription Plan Changed Successfully',
            'plan_expired' => 'Plan Expired',
            'plan_expired_message' => 'Your subscription plan has expired on {0}. To keep using your applications without interruption, please renew your plan...',
            'trial_plan' => 'Trial Plan',
            'trial_plan_message' => 'You are on trial version! Your trial ends on {0}',
        ],
        'superadmin_dashboard' => [
            'dashboard' => 'Dashboard',
            'total_companies' => 'Total Companies',
            'active_companies' => 'Active Companies',
            'license_expired' => 'License Expired',
            'inactive_companies' => 'Inactive Companies',
            'recently_registered_companies' => 'Recently Registered Companies',
        ],
        'superadmin' => [
            'add' => 'Add New Super Admin',
            'edit' => 'Edit Super Admin',
            'created' => 'Super Admin Created Successfully',
            'updated' => 'Super Admin Updated Successfully',
            'deleted' => 'Super Admin Deleted Successfully',
            'super_admin_details' => 'Super Admin Details',
            'delete_message' => 'Are you sure you want to delete this super admin?',
        ],
        'payment_settings' => [
            'environment' => 'Environment',
            'webhook_url' => 'Webhook Url',
            'callback_url' => 'Callback Url',
            'paypal_settings' => 'Paypal Settings',
            'paypal_client_id' => 'Paypal Client Id',
            'paypal_secret' => 'Paypal Secret',
            'paypal_status' => 'Paypal Status',
            'paypal_mode' => 'Paypal Mode',
            'stripe_settings' => 'Stripe Settings',
            'paymo_settings' => 'Paymo Settings',
            'stripe_api_key' => 'Publishable Key',
            'stripe_api_secret' => 'Stripe Secret',
            'stripe_webhook_key' => 'Stripe Webhook Secret',
            'stripe_status' => 'Stripe Status',
            'paymo_api_key' => 'Paymo Api Key',
            'paymo_api_secret' => 'Paymo Api Secret',
            'paymo_store_id' => 'Paymo StoreID',
            'paymo_terminal_id' => 'Paymo TerminalID',
            // 'stripe_webhook_key' => 'Stripe Webhook Secret',
            'paymo_status' => 'Paymo Status',
            'razorpay_settings' => 'Razorpay Settings',
            'razorpay_key' => 'Razorpay Key',
            'razorpay_secret' => 'Razorpay Secret Key',
            'razorpay_webhook_secret' => 'Razorpay Webhook Secret Key',
            'razorpay_status' => 'Razorpay Status',
            'paystack_settings' => 'Paystack Settings',
            'paystack_client_id' => 'Paystack Key',
            'paystack_secret' => 'Paystack Secret Key',
            'paystack_merchant_email' => 'Paystack merchant email',
            'paystack_status' => 'Paystack Status',
            'mollie_settings' => 'Paystack Settings',
            'mollie_api_key' => 'Mollie Api Key',
            'mollie_status' => 'Mollie Status',
            'authorize_settings' => 'Authorize Settings',
            'authorize_api_login_id' => 'Authorize Api Login Id',
            'authorize_transaction_key' => 'Authorize Transaction Key',
            'authorize_signature_key' => 'Authorize Signature Key',
            'authorize_environment' => 'Select environment',
            'authorize_status' => 'Authorize Status',
            'sandbox' => 'Sandbox',
            'live' => 'Live',
            'credential_saved' => 'Credentials saved successfully',
            'stripe_webhook_message' => 'Add this webhook url on your stripe app settings',
            'stripe_customer_name' => 'Name',
            'paymo_customer_card' => 'Card Number',
            'paymo_customer_card_expires' => 'Expiration Date',
            'paymo_otp_code' => 'Code OTP',
            'verification_code_bind_card' => 'Verification Code',
            'confirm_bind_card' => 'Confirm',
            'bind_card_text' => 'Please go to confirmation to register your card!',
            'bind_confirm_button' => 'Confirmation',
            'stripe_customer_line1' => 'Line 1',
            'stripe_customer_city' => 'City',
            'stripe_customer_state' => 'State',
            'stripe_customer_country' => 'Country',
            'stripe_card_details' => 'Card Details',
            'paymo_card_details' => 'Card Details',
            'complete_transcation' => 'Complete Transcation',
            'finish_transcation' => 'Finish Transcation',
            'required_message' => '{0} is required',
            'payment_success_give_some_time' => 'Payment Successful... Please Give Us Some Time To Update...',
        ],
        'payment_transaction' => [
            'last_paid_on' => 'Last Paid On',
            'paid_on' => 'Date',
            'company' => 'Company',
            'transcation_id' => 'Transcation ID',
            'amount' => 'Amount',
            'card_num' => 'Card Number',
            'next_payment_date' => 'Next Payment Date',
            'payment_method' => 'Payment Method',
            'license_expires_on' => 'License Will Expires On',
            'plan' => 'Plan',
            'subscribe' => 'Subscribe',
            'paid_by' => 'Paid By',
            'subscription_plan' => 'Subscription Plan',
            'plan_type' => 'Plan Type',
            'total' => 'Total',
            'status' => 'Status',
            'no_date_selected' => 'No Date Selected',
        ],
        'website_settings' => [
            'website' => 'Website',
            'app_name' => 'App Name',
            'basic_text' => 'Basic Text',
            'basic_settings' => 'Basic Settings',
            'header' => 'Header',
            'clients' => 'Clients',
            'testimonials' => 'Testimonials',
            'features' => 'Features',
            'home_page_feature_widget' => 'Home Page Feature Widget',
            'features_home_page' => 'Home Page Features',
            'features_page' => 'Features Page',
            'faq' => 'FAQ',
            'footer' => 'Footer',
            'seo' => 'SEO',
            'language' => 'Language',
            'features_lists' => 'Features',
            'pricing_cards' => 'Pricing Cards',

            'text_settings' => 'Text Settings',
            'header_settings' => 'Header Settings',
            'header_client' => 'Header Client',
            'header_features' => 'Header Features',
            'header_logo' => 'Header Logo',
            'header_sidebar_logo' => 'Header Sidebar Logo',
            'home_text' => 'Home Text',
            'features_text' => 'Features Text',
            'pricing_text' => 'Pricing Text',
            'register_text' => 'Register Text',
            'contact_text' => 'Contact Text',
            'login_button_show' => 'Show Login Button',
            'login_button_text' => 'Login Text',
            'register_button_show' => 'Show Register Button',
            'register_button_text' => 'Register Text',

            'header_title' => 'Header Title',
            'header_sub_title' => 'Header Sub Title',
            'header_description' => 'Header Description',
            'header_button1_show' => 'Show Header Button 1',
            'header_button1_text' => 'Header Button 1 Text',
            'header_button1_url' => 'Header Button 1 Url',
            'header_button2_show' => 'Show Header Button 2',
            'header_button2_text' => 'Header Button 2 Text',
            'header_button2_url' => 'Header Button 2 Url',
            'header_features' => 'Header Features',
            'header_background_image' => 'Header Background Image',
            'header_client_show' => 'Show Header Client',
            'header_client_image' => 'Header Client Image',
            'header_client_name' => 'Header Client Name',
            'header_client_text' => 'Header Client Text',

            'contact_title' => 'Contact Title',
            'contact_description' => 'Contact Description',
            'contact_email_text' => 'Email Text',
            'contact_phone_text' => 'Phone Text',
            'contact_address_text' => 'Address Text',
            'contact_details' => 'Contact Details',
            'contact_form' => 'Contact Form',
            'contact_form_settings' => 'Contact Form Settings',
            'contact_form_title' => 'Contact Form Title',
            'contact_form_description' => 'Contact Form Description',
            'contact_form_background_image' => 'Contact Form Background Image',
            'contact_form_heading' => 'Contact Form Heading',
            'contact_form_heading' => 'Contact Form Heading',
            'contact_form_name_text' => 'Name Text',
            'contact_form_email_text' => 'Email Text',
            'contact_form_message_text' => 'Message Text',
            'contact_form_send_message_text' => 'Send Button Text',
            'contact_us_submit_message_text' => 'Contact Success Message',

            'footer_title' => 'Footer Title',
            'footer_description' => 'Footer Description',
            'footer_logo' => 'Footer Logo',
            'footer_copyright_text' => 'Footer Copyright',
            'footer_links_text' => 'Links Text',
            'footer_pages_text' => 'Pages',
            'footer_contact_us_text' => 'Contact Us',
            'footer_pages' => 'Pages',
            'social_links' => 'Social Links',
            'facebook_url' => 'Facebook Url',
            'twitter_url' => 'Twitter Url',
            'linkedin_url' => 'LinkedIn Url',
            'instagram_url' => 'Instagram Url',
            'youtube_url' => 'Youtube Url',

            'register_title' => 'Register Title',
            'register_description' => 'Register Description',
            'register_background' => 'Background Image',
            'register_company_name_text' => 'Company Name Text',
            'register_email_text' => 'Email Text',
            'register_password_text' => 'Password Text',
            'register_confirm_password_text' => 'Confirm Passwrod Text',
            'register_submit_button_text' => 'Submit Button Text',
            'register_agree_text' => 'Terms & Condition Text',
            'register_agree_url' => 'Terms & Condition Url',
            'error_contact_support' => 'Error Contact Support Message',
            'register_success_text' => 'Register Success Text',

            'call_to_action_title' => 'Call To Action Title',
            'call_to_action_description' => 'Call To Action Description',
            'call_to_action_widgets' => 'Widgets',
            'call_to_action_add_widget' => 'Add Widget',
            'call_to_action_submit_button_text' => 'Submit Button Text',
            'call_to_action_email_text' => 'Email Text',
            'call_to_action_no_email_sell_text' => 'No Email Sell Text',

            'setting_saved' => 'Setting Saved Successfully',

            'client_title' => 'Client Title',
            'client_description' => 'Client Description',
            'testimonial_title' => 'Testimonial Title',
            'testimonial_description' => 'Testimonial Description',
            'feature_title' => 'Feature Title',
            'feature_description' => 'Feature Description',

            'price_title' => 'Price Title',
            'price_description' => 'Price Description',
            'price_card_title' => 'Price Card Title',
            'price_card_title' => 'Price Card Title',
            'pricing_month_text' => 'Pricing Month Text',
            'pricing_year_text' => 'Pricing Year Text',
            'pricing_monthly_text' => 'Pricing Monthly Text',
            'pricing_yearly_text' => 'Pricing Yearly Text',
            'pricing_billed_monthly_text' => 'Billed Monthly Text',
            'pricing_billed_yearly_text' => 'Billed Yearly Text',
            'most_popular_image' => 'Most Popular Image',
            'faq_title' => 'FAQ Title',
            'faq_sub_title' => 'FAQ Sub Title',
            'faq_still_have_question_text' => 'Still Have Questions Text',
            'faq_contact_us_text' => 'Contact Us Text',
            'faq_background_image' => 'FAQ Background',
            'pricing_get_started_button_text' => 'Get Started ButtonText',
            'pricing_no_card_text' => 'No Credit Card Required Text',

            'edit_seo' => 'Edit SEO',
            'seo_updated' => 'SEO Details Updated Successfully',
            'page_key' => 'Page',
            'seo_title' => 'SEO Title',
            'seo_description' => 'SEO Description',
            'seo_keywords' => 'SEO Keywords',
            'seo_author' => 'SEO Author',
            'seo_image' => 'SEO Image',

            'add_pricing_card' => 'Add Pricing Card',
            'edit_pricing_card' => 'Edit Pricing Card',
            'pricing_card_created' => 'Pricing Card Created Successfully',
            'pricing_card_updated' => 'Pricing Card Updated Successfully',
            'pricing_card_delete_message' => 'Are you sure you want to delete this Pricing Card?',
            'pricing_card_deleted' => 'Pricing Card Deleted Successfully',

            'add_client' => 'Add Client',
            'edit_client' => 'Edit Client',
            'client_created' => 'Client Created Successfully',
            'client_updated' => 'Client Updated Successfully',
            'client_delete_message' => 'Are you sure you want to delete this client?',
            'client_deleted' => 'Client Deleted Successfully',
            'add_testimonial' => 'Add Testimonial',
            'edit_testimonial' => 'Edit Testimonial',
            'testimonial_created' => 'Testimonial Created Successfully',
            'testimonial_updated' => 'Testimonial Updated Successfully',
            'testimonial_delete_message' => 'Are you sure you want to delete this testimonial?',
            'testimonial_deleted' => 'Testimonial Deleted Successfully',
            'add_feature' => 'Add Feature',
            'edit_feature' => 'Edit Feature',
            'feature_created' => 'Feature Created Successfully',
            'feature_updated' => 'Feature Updated Successfully',
            'feature_delete_message' => 'Are you sure you want to delete this feature?',
            'feature_deleted' => 'Feature Deleted Successfully',
            'add_faq' => 'Add Faq',
            'edit_faq' => 'Edit Faq',
            'faq_created' => 'Faq Created Successfully',
            'faq_updated' => 'Faq Updated Successfully',
            'faq_delete_message' => 'Are you sure you want to delete this faq?',
            'faq_deleted' => 'Faq Deleted Successfully',
            'add_footer_page' => 'Add Footer Page',
            'edit_footer_page' => 'Edit Footer page',
            'footer_page_created' => 'Footer Page Created Successfully',
            'footer_page_updated' => 'Footer Page Updated Successfully',
            'footer_page_delete_message' => 'Are you sure you want to delete this footer page?',
            'footer_page_deleted' => 'Footer Page Deleted Successfully',
            'rating_between_text' => 'Rating must be between 1 - 5',
        ],
        'offline_payment_mode' => [
            'add' => 'Add New Offline Payment Mode',
            'edit' => 'Edit Offline Payment Mode',
            'created' => 'Offline Payment Mode Created Successfully',
            'updated' => 'Offline Payment Mode Updated Successfully',
            'deleted' => 'Offline Payment Mode Deleted Successfully',
            'delete_message' => 'Are you sure you want to delete this Offline Payment Mode?',
            'details' => 'Offline Payment Mode Details',
            'name' => 'Name',
            'description' => 'Description',
        ],
        'offline_request' => [
            'company' => 'Company',
            'created' => 'Offline Request Created',
            'created_message' => 'Offline request submitted... Please wait for some time to get approved the request...',
            'offline' => 'Offline',
            'offline_account_details' => 'Offline Account Details',
            'subscription_plan' => 'Subscription Plan',
            'plan_type' => 'Plan Type',
            'payment_mode' => 'Payment Mode',
            'payment_date' => 'Payment Date',
            'status' => 'Status',
            'proof_document' => 'Proof Document',
            'submit_description' => 'Submit Description',
            'request_submited_successfully' => 'Request Submited Successfully',
            'submitted_on' => 'Submitted On',
            'submitted_by' => 'Submitted By',
            'payment_method' => 'Payment Method',
            'status' => 'Status',
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'approve' => 'Approve',
            'rejecte' => 'Rejecte',
            'approve_request' => 'Approve Request',
            'reject_request' => 'Reject Request',
            'view_proof_document' => 'View Proof Document',
            'request_approved_successfully' => 'Request Approved Successfully',
            'are_you_sure_reject_request' => 'Are you sure you want to reject this request',
            'request_rejected_successfully' => 'Request Rejected Successflly',
            'yes_rejected' => 'Yes Reject',
        ],
        'setup_superadmin_company' => [
            'setup_not_completed' => 'Setup Not Completed',
            'setup_not_completed_description' => 'Your company default settings not completed. Follow below setups to complete your company basic settings...',
            'currency' => 'Currency',
            'add_first_currency' => 'Add First Currency',
            'white_label_settings' => 'White Label Settings',
            'white_label_descrtipion' => 'Default Logo Settings',
            'white_label_update_details' => 'Change all default logo which will be displayed when a new user register a new company. Click on below image to change it...',
            'white_label_settings_completed' => 'Are you sure you uploaded all logo',
            'yes_uploaded' => 'Yes Uploaded',
            'default_company_logo' => 'Default Company Logo',
            'company_settings' => 'Company Settings',
            'set_company_basic_settings' => 'Setup Company Basic Settings',
            'previous_step' => 'Previous Step',
            'next_step' => 'Next Step',
            'basic_settings' => 'Basic Settings',
            'theme_settings' => 'Theme Settings',
            'logo_settings' => 'Logo Settings',
            'save_finish_setup' => 'Save & Finish Setup',
            'go_to_dashboard' => 'Go To Dashboard',
            'setup_running_message' => 'Please wait... we are setting up inital company settings.',
            'setup_complete_message' => 'Setup completed... Click on below link to view your app...',
            'hard_reload_message' => 'If logo not changed after upload.. Please hard reload your browser or clear your browser cache.',
        ]
    ];
}