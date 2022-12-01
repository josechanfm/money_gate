export default [
    {
        key: 'order',
        icon: 'BarsOutlined',
        title: 'Order',
        children: [
            {
                icon: 'rightOutlined',
                key: 'order.order',
                route: 'order.order.index',
                title: 'List',
                permission: 'order.view',
            },
        ]
    },
    {
        key: 'payment',
        icon: 'DollarOutlined',
        title: 'Payment',
        children: [
            {
                icon: 'rightOutlined',
                key: 'payment.payment',
                route: 'payment.payment.index',
                title: 'Payment',
                permission: 'payment.view',
            },
            {
                icon: 'rightOutlined',
                key: 'payment.payments',
                route: 'payment.payments.index',
                title: 'Payments',
                permission: 'payments.view',
            },
            // {
            //     icon: 'ApartmentOutlined',
            //     key: 'admin.system.roles',
            //     route: 'admin.system.roles.index',
            //     title: 'layout.menu.roles',
            //     permission: 'admin.system.roles.view',
            // },
            // {
            //     icon: 'DatabaseOutlined',
            //     key: 'admin.system.logs',
            //     route: 'admin.system.logs.index',
            //     title: 'layout.menu.logs',
            //     permission: 'admin.system.logs',
            // }
        ]
    },
    // {
    //     key: 'admin.admin',
    //     icon: 'BuildOutlined',
    //     title: 'layout.menu.admin',
    //     children: [
    //         {
    //             icon: 'UserOutlined',
    //             route: 'admin.admin.bulletins.index',
    //             key: 'admin.admin.bulletins',
    //             title: 'layout.menu.bulletins',
    //             permission: 'admin.system.users.view',
    //         }
    //     ]
    // },
    // {
    //     key: 'admin.developer',
    //     icon: 'CodeOutlined',
    //     title: 'layout.menu.developer',
    //     children: [
    //         {
    //             icon: 'NodeIndexOutlined',
    //             key: 'admin.developer.routes',
    //             route: 'admin.developer.routes',
    //             title: 'layout.menu.route',
    //             permission: 'admin.developer.route',
    //         },
    //         {
    //             icon: 'ThunderboltOutlined',
    //             key: 'admin.developer.misc',
    //             route: 'admin.developer.misc',
    //             title: 'layout.menu.misc',
    //             permission: 'admin.developer.misc',
    //         }
    //     ]
    // }
]
