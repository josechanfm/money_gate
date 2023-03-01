export default [
    {
        key: 'order',
        icon: 'BarsOutlined',
        title: 'Order',
        children: [
            {
                icon: 'rightOutlined',
                key: 'admin.order',
                route: 'admin.order.index',
                title: 'List',
                permission: 'admin.order.order',
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
                key: 'admin.payment.payment',
                route: 'admin.payment.payment.index',
                title: 'Payment',
                permission: 'admin.payment.payment',
            },
            {
                icon: 'rightOutlined',
                key: 'admin.payment.payments',
                route: 'admin.payment.payments.index',
                title: 'Payments',
                permission: 'admin.payment.payment',
            },
        ]
    },
    {
        key: 'user',
        icon: 'UserOutlined',
        title: 'User',
        children: [
            {
                icon: 'rightOutlined',
                key: 'admin.user',
                route: 'admin.user.index',
                title: 'List',
                permission: 'admin.user',
            },
            {
                icon: 'rightOutlined',
                key: 'admin.user.create',
                route: 'admin.user.create',
                title: 'Create',
                permission: 'admin.user',
            },
        ]
    },
]
