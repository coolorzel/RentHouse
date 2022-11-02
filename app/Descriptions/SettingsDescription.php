<?php

namespace App\Descriptions;

class SettingsDescription {

    public static $DESCRIPTION = [
        'default' =>
            [
                [
                    'title_settings' => 'Basic role & permissions',
                    'description_settings' => 'Update basic roles & permissions for users.',
                    'name_settings' => 'basic_role_permission',
                    'placeholder' => '',
                    'type' => 'checkbox',
                    'input_tag' => 'input',
                    'response' => '',
                    'checked' => 'checked',
                ],
            ],
        'additional' => [
            0 =>
                [
                    'name' => 'Page Settings',
                    'description' => 'Test desc',
                    'action' => 'settings',
                    [
                        'title_settings' => 'Page title',
                        'description_settings' => 'Enter the title of the page, the name that will be displayed in all adapted places.',
                        'name_settings' => 'page_name',
                        'placeholder' => 'Rent House',
                        'type' => 'text',
                        'input_tag' => 'input',
                        'response' => '',
                        'checked' => '',
                    ],
                    [
                        'title_settings' => 'Page description',
                        'description_settings' => 'Enter a description of the page that will be displayed in the designated places.',
                        'name_settings' => 'page_description',
                        'placeholder' => 'This is my site description',
                        'type' => 'text',
                        'input_tag' => 'input',
                        'response' => '',
                        'checked' => '',
                    ],
                    [
                        'title_settings' => 'Default language',
                        'description_settings' => 'Select the default language of the site that each visitor will have set, if not downloaded from the web browser settings.',
                        'name_settings' => 'page_default_language',
                        'placeholder' => '',
                        'type' => 'select',
                        'input_tag' => 'select',
                        'response' =>
                            [
                                'en' => 'English',
                                'pl' => 'Polish',
                                'ua' => 'Ukraine',
                            ],
                        'checked' => '',
                    ],
                    [
                        'title_settings' => 'Site available',
                        'description_settings' => 'Enabled or disabled page for users. When disabled, we provide a message to visitors to the site.
                Access only for administrators and moderators of the site, via the address .../acp/login',
                        'name_settings' => 'page_available',
                        'placeholder' => '',
                        'type' => 'checkbox',
                        'input_tag' => 'input',
                        'response' => '',
                        'checked' => 'checked',
                    ],
                ],
            1 =>
                [
                    'name' => 'User Settings',
                    'description' => 'Set all user-related parameters. Registration, login etc ...',
                    'action' => 'settings',
                    [
                        'title_settings' => 'Register new user',
                        'description_settings' => 'Enable or disable registration for new users. Checked means enabled.',
                        'name_settings' => 'user_register_available',
                        'placeholder' => '',
                        'type' => 'checkbox',
                        'input_tag' => 'input',
                        'response' => '',
                        'checked' => 'checked',
                    ],
                    [
                        'title_settings' => 'Login new user',
                        'description_settings' => 'Enable or disable login for normal users. Checked means enabled.',
                        'name_settings' => 'user_login_available',
                        'placeholder' => '',
                        'type' => 'checkbox',
                        'input_tag' => 'input',
                        'response' => '',
                        'checked' => 'checked',
                    ],
                    [
                        'title_settings' => 'Verify email address',
                        'description_settings' => 'Enable or disable verify email address for users. Checked means enabled.',
                        'name_settings' => 'user_email_verify',
                        'placeholder' => '',
                        'type' => 'checkbox',
                        'input_tag' => 'input',
                        'response' => '',
                        'checked' => 'checked',
                    ],
                ],
            2 =>
                [
                    'name' => 'Contact Settings',
                    'description' => 'Here you can set the basic information of the page from the contact tab.',
                    'action' => 'settings',
                    [
                        'title_settings' => 'Email',
                        'description_settings' => 'Enter the email address of the service office.',
                        'name_settings' => 'contact_email',
                        'placeholder' => 'bok@domain.com',
                        'type' => 'email',
                        'input_tag' => 'input',
                        'response' => '',
                    ],
                    [
                        'title_settings' => 'Phone number',
                        'description_settings' => 'Contact phone number for the service office.',
                        'name_settings' => 'contact_phone_number',
                        'placeholder' => '654-849-456',
                        'type' => 'tel',
                        'input_tag' => 'input',
                        'response' => '',
                    ],
                    [
                        'title_settings' => 'Start of work',
                        'description_settings' => 'Select the start time of the company.',
                        'name_settings' => 'contact_start_work',
                        'placeholder' => '08:00',
                        'type' => 'time',
                        'input_tag' => 'input',
                        'response' => '',
                        'value' => '07:00',
                    ],
                    [
                        'title_settings' => 'End of work',
                        'description_settings' => 'Select the end time of the company.',
                        'name_settings' => 'contact_end_work',
                        'placeholder' => '08:00',
                        'type' => 'time',
                        'input_tag' => 'input',
                        'response' => '',
                        'value' => '15:00',
                    ],
                ],
            3 =>
                [
                    'name' => 'Register Super Admin',
                    'description' => 'Test desc3',
                    'action' => 'user',
                    [
                        'title_settings' => 'Name',
                        'description_settings' => 'Enter the name of the main site administrator.',
                        'name_settings' => 'user_name',
                        'placeholder' => 'Name',
                        'type' => 'text',
                        'input_tag' => 'input',
                        'response' => '',
                    ],
                    [
                        'title_settings' => 'Last name',
                        'description_settings' => 'Enter the last name of the main site administrator.',
                        'name_settings' => 'user_lastname',
                        'placeholder' => 'Last name',
                        'type' => 'text',
                        'input_tag' => 'input',
                        'response' => '',
                    ],
                    [
                        'title_settings' => 'Email',
                        'description_settings' => 'Enter the email of the main site administrator.',
                        'name_settings' => 'user_email',
                        'placeholder' => 'admin@domain.com',
                        'type' => 'email',
                        'input_tag' => 'input',
                        'response' => '',
                    ],
                    [
                        'title_settings' => 'Password',
                        'description_settings' => 'Enter the password of the main site administrator.',
                        'name_settings' => 'user_password',
                        'placeholder' => 'Password',
                        'type' => 'password',
                        'input_tag' => 'input',
                        'response' => '',
                    ],
                ],
        ],
    ];

    public static $ROLES = ['Owner',
        'admin',
        'moderator',
        'landlord',
        'tenant',
        'user',
    ];

    public static $PERMISSIONS = [
        // PERMISSION FOR ROUTES //
        'ACP-system-control',
        'ACP-view',
        'ACP-user-list-view',
        'USER-my-profile-update',
        'USER-my-password-update',
        'USER-my-avatar-update',
        'USER-my-avatar-delete',
        'USER-my-link-edit',
        'USER-my-link-create',
        'USER-my-link-update',
        'ACP-update-user-profile',
        'ACP-update-user-avatar',
        'ACP-delete-user-avatar',
        'ACP-user-info-links',
        'ACP-user-create-link',
        'ACP-user-link-edit',
        'ACP-user-link-update',
        'ACP-user-link-delete',
        'ACP-change-available-site',
        'ACP-update-settings-site',
        'ACP-roles-view',
        'ACP-permissions-view',

        // PERMISSION FOR BLADE //
        'ACP-user-edit',
        'ACP-user-edit-name-lname',
        'ACP-user-edit-email',
        'ACP-user-edit-username',
        'ACP-user-edit-phone',
        'ACP-user-edit-address',
        'ACP-user-add-new-link',
        'USER-my-account',
        'ACP-role-create',
        'ACP-role-edit',
        'ACP-role-delete',
        'ACP-permission-create',
        'ACP-permission-edit',
        'ACP-permission-delete'

        ];
}
