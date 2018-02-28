

export default {
    data: [
        { id: 'dashboard', icon: 'tachometer', link: '/home', permissions: [] },
        {
            id: 'user_mgmt', color: 'Teal', icon: 'users', permissions: ['user_view', 'role_view'],
            children: [
                { id: 'users', icon: 'users', link: '/users/users', permissions: ['user_view'] },
                { id: 'roles', icon: 'graduation-cap', link: '/users/roles', permissions: ['role_view'] },
            ],
        },
        {
            id: 'setting_mgmt', color: 'DarkSlateGray' , icon: 'cogs', permissions: ['general_setting_update'],
            children: [
                { id: 'general_settings', icon: 'cog', link: '/settings/general-settings', permissions: ['general_setting_update'] },
            ],
        },

    ]
}