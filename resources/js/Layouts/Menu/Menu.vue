<template>
    <div class="logo" > Hubis </div>
    <a-menu 
        v-model:selectedKeys="selectedKeys" 
        theme="dark" 
        mode="inline"
        :inline-collapsed="collapsed"
        :open-keys="openKeys"
    >
        <template v-for="item in list" :key="item.key">
            <template v-if="!item.children">
                <a-menu-item 
                    :key="item.key" 
                    v-if="item.permission ? hasPermission(item.permission): true"
                >
                    <template #icon v-if="item.icon">
                        <component :is="item.icon" />
                    </template>
                    <inertia-link :href="route(item.route)">
                        {{ $t(item.title) }}
                    </inertia-link>
                </a-menu-item>
            </template>
            <template v-else>
                <sub-menu :key="item.key" :menu-info="item" />
            </template>
        </template>
    </a-menu>
</template>

<script>
import * as AntdIcons from '@ant-design/icons-vue';
import menu from './menu.js';
import SubMenu from './SubMenu.vue';


export default {
    name: "Menu",
    props: {
        collapsed: {
            type: Boolean,
            required: false,
            default: false,
        },
    },
    components: {
        SubMenu,
        ...AntdIcons,
    },
    data () {
        return {
            openKeys: [route().current().split('.').slice(0, 1).join('.')],
            selectedKeys: [
                route().current().split('.').slice(0, 2).join('.')
            ]
        }
    },
    setup () {
        return { 
            list: menu
        }
    },
    computed: {
        hasPermission () {
            return (permission) => {
                const permissions = this.$page.props.currentUserPermissions
                return permissions.includes(permission)
            }
        },
    },
}
</script>