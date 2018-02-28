

export default {
    data: [
        { id: 'dashboard', icon: 'tachometer', link: '/home', permissions: [] },
        {
            id: 'material_mgmt', color: 'IndianRed', icon: 'cubes', permissions: ['material_type_view','materiale_view'],
            children: [
                { id: 'material_types', icon: 'archive', link: '/materials/material-types', permissions: ['material_type_view'] },
                { id: 'materials', icon: 'cube', link: '/materials/materials', permissions: ['material_view'] },
            ],
        },
        {
            id: 'billet_mgmt', color: 'Indigo' , icon: 'bars', permissions: ['billet_type_view','billet_view'],
            children: [
                { id: 'billet_types', icon: 'server', link: '/billets/billet-types', permissions: ['billet_type_view'] },
                { id: 'billets', icon: 'minus', link: '/billets/billets', permissions: ['billet_view'] },
            ],
        },
        {
            id: 'die_mgmt', color: 'Coral' , icon: 'th', permissions: ['die_type_view','die_object_view','sub_die_view'],
            children: [
                { id: 'die_types', icon: 'th-large', link: '/dies/die-types', permissions: ['die_type_view'] },
                { id: 'die_objects', icon: 'square', link: '/dies/die-objects', permissions: ['die_object_view'] },
                { id: 'sub_dies', icon: 'anchor', link: '/dies/sub-dies', permissions: ['sub_die_view'] },
            ],
        },
        {
            id: 'supplier_mgmt', color: 'DarkSeaGreen' , icon: 'truck', permissions: ['billet_supplier_view','material_supplier_view','die_supplier_view'],
            children: [
                { id: 'billet_suppliers', icon: 'bars', link: '/suppliers/billet-suppliers', permissions: ['billet_supplier_view'] },
                { id: 'material_suppliers', icon: 'cubes', link: '/suppliers/material-suppliers', permissions: ['material_supplier_view'] },
                { id: 'die_suppliers', icon: 'th', link: '/suppliers/die-suppliers', permissions: ['die_supplier_view'] },
            ],
        },
        {
            id: 'scrap_mgmt', color: 'Chocolate' , icon: 'clone', permissions: ['scrap_type_view','scrap_view'],
            children: [
                { id: 'scrap_types', icon: 'object-group', link: '/scraps/scrap-types', permissions: ['scrap_type_view'] },
                { id: 'scraps', icon: 'file-o', link: '/scraps/scraps', permissions: ['scrap_view'] },
            ],
        },
        {
            id: 'department_mgmt', color: 'SteelBlue' , icon: 'university', permissions: ['department_type_view','department_view'],
            children: [
                { id: 'department_types', icon: 'industry', link: '/departments/department-types', permissions: ['department_type_view'] },
                { id: 'departments', icon: 'building-o', link: '/departments/departments', permissions: ['department_view'] },
            ],
        },
        {
            id: 'product_mgmt', color: 'SeaGreen' , icon: 'shopping-cart', permissions: ['product_type_view','product_view'],
            children: [
                { id: 'product_types', icon: 'suitcase', link: '/products/product-types', permissions: ['product_type_view'] },
                { id: 'products', icon: 'shopping-basket', link: '/products/products', permissions: ['product_view'] },
            ],
        },
        {
            id: 'inner_product_mgmt', color: 'Goldenrod' , icon: 'sign-in', permissions: ['inner_product_type_view','inner_product_view'],
            children: [
                { id: 'inner_product_types', icon: 'th-large', link: '/inner-products/inner-product-types', permissions: ['inner_product_type_view'] },
                { id: 'inner_products', icon: 'th', link: '/inner-products/inner-products', permissions: ['inner_product_view'] },
            ],
        },
        {
            id: 'customer_mgmt', color: 'Goldenrod' , icon: 'fa fa-user-circle-o', permissions: ['customer_type_view','customer_view'],
            children: [
                { id: 'customer_types', icon: 'users', link: '/customers/customer-types', permissions: ['customer_type_view'] },
                { id: 'customers', icon: 'user-circle', link: '/customers/customers', permissions: ['customer_view'] },
            ],
        },
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