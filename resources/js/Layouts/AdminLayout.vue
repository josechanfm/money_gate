<template>
    <a-layout style="min-height: 100vh">
        <a-layout-sider 
            v-model:collapsed="collapsed" 
            collapsible
        >
            <side-menu></side-menu>
        </a-layout-sider>
            
        <a-layout>
            <!-- header -->
            <a-layout-header style="background: #fff; padding: 0;box-shadow:3px 3px 3px rgb(0,0,0,0.1);" />

            <!-- content -->
            <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '280px' }">
                <main>
                    <slot />
                </main>
            </a-layout-content>

            <!-- footer -->
            <a-layout-footer style="text-align: center">
                Hubis
            </a-layout-footer>
        </a-layout>
    </a-layout>
</template>

<script lang="ts">
import {
  PieChartOutlined,
  DesktopOutlined,
  UserOutlined,
  TeamOutlined,
  FileOutlined,
} from '@ant-design/icons-vue';

import { defineComponent, ref } from 'vue';
import SideMenu from './Menu/Menu.vue'

export default defineComponent({
    components: {
        PieChartOutlined,
        DesktopOutlined,
        UserOutlined,
        TeamOutlined,
        FileOutlined,
        SideMenu,
    },
    data() {
        return {
            collapsed: ref<boolean>(false),
            // selectedKeys: [
                //route().current().split('.').slice(0, 3).join('.')
            // ]
        };
    },
});
</script>

<style>
.logo {
  height: 32px;
  margin: 16px;
  color:#fff
  /* background: rgba(255, 255, 255, 0.3); */
}

.site-layout .site-layout-background {
  background: #fff;
}
[data-theme='dark'] .site-layout .site-layout-background {
  background: #141414;
}
</style>
  