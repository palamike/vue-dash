<template>
    <div class="pmf-sidebar" >
        <div class="pmf-sidebar-info">
            <div :class="{ 'pmf-sidebar-user': true, 'pmf-sidebar-user-collapsed':  isSidebarCollapsed}" >
                <div class="pmf-sidebar-user-icon">{{ getFirstCharAndCapitalize(getUserName()) }}</div>
                <div class="pmf-sidebar-user-info">
                    <a :href="getBaseUrl() + '/profile'" class="pmf-sidebar-user-name">{{ getUserName() }}</a>
                    <a :href="getBaseUrl() + '/profile'" class="pmf-sidebar-user-role">{{ getRoleName() }}</a>
                </div>
            </div>
        </div>
        <el-menu :default-active="getCurrentActiveMenu()" class="el-menu-vertical-demo" :collapse="isSidebarCollapsed">
            <template v-for="menu in menuItems" >
                <el-menu-item :index="menu.id" v-if="menu.link" @click="handleMenuSelect(menu.link)" v-show="hasPermission(menu.permissions)">
                    <i :class="iconClass(menu.icon)"></i>
                    <span slot="title" class="pmf-menu-item-text" >{{ $t('sidebar.' + menu.id) }}</span>
                </el-menu-item>
                <el-submenu :index="menu.id" v-else v-show="hasAnyPermissions(menu.permissions)">
                    <template slot="title">
                        <i :class="iconClass(menu.icon)"></i>
                        <span slot="title" class="pmf-menu-item-text" >{{ $t('sidebar.' + menu.id) }}</span>
                    </template>
                    <el-menu-item :index="item.id" v-for="item in menu.children" :key="item.id" @click="handleMenuSelect(item.link)" v-show="hasPermission(item.permissions)">
                        <i :class="iconClass(item.icon)"></i>
                        <span slot="title" class="pmf-menu-item-text" >{{ $t('sidebar.' + item.id) }}</span>
                    </el-menu-item>
                </el-submenu>
            </template>
        </el-menu>
    </div>
</template>
<script>
    import AuthMixin from '../../mixins/AuthMixin';
    import BlockUIMixin from '../../mixins/BlockUIMixin';
    import menuItems from '../../data/sidebar';

    export default {

        name: 'AppSidebar',

        props: [ 'isSidebarCollapsed' ],

        components: {},

        mixins: [AuthMixin, BlockUIMixin],

        methods: {
            iconClass(icon) {
                return 'fa fa-' + icon;
            },

            getFirstCharAndCapitalize(str) {
                return _.capitalize(str.substr(0,1));
            },

            handleMenuSelect(link) {
                this.blockUI();
                window.location = window.pmf.baseURL + link;
                console.log('currently you select', link);
            },

            getCurrentActiveMenu(){
                return window.pmfSelectedMenu;
            },

            getBaseUrl() {
                return window.pmf.baseURL;
            },
        },

        data() {
            return { menuItems: menuItems.data };
        }
    }
</script>
<style lang="scss" type="text/scss" >

    .pmf-sidebar {

        border-right: 1px solid lightgrey;

        > .el-menu {
            height: 100vh;
            border-right-width: 0;
        }
    }

    .pmf-menu-item-text {
        display: inline-block;
        white-space: normal;
        line-height: 18px;
    }

    .el-submenu__title {
        .pmf-menu-item-text {
            padding-right: 20px;
        }
    }

    .el-menu {
        .fa {
            font-size: 18px;
            padding: 0 5px;
        }

        .el-submenu__title {
            > .fa {
                margin-right: 5px;
            }
        }
    }

    .pmf-sidebar-user {
        display: grid;
        padding: 10px 15px;
        grid-template-columns: 50px auto;

        &.pmf-sidebar-user-collapsed {
            display: block;
            padding: 5px;

            .pmf-sidebar-user-info {
                display: none;
            }

            .pmf-sidebar-user-icon {
                text-align: center;
                padding: 12px 12px;
                font-size: 22px;
                font-weight: bold;
                color: white;
                border: 3px solid white;
                border-radius: 50%;
            }
        }

        .pmf-sidebar-user-icon {
            text-align: center;
            padding: 8px 16px;
            font-size: 24px;
            font-weight: bold;
            color: white;
            border: 3px solid white;
            border-radius: 50%;
        }

        .pmf-sidebar-user-info {
            padding: 8px 15px 0 15px;
        }

        .pmf-sidebar-user-name, .pmf-sidebar-user-role{
            text-decoration: none;
            color: #0d0d0d;
            display:block;
        }

        .pmf-sidebar-user-name{
            font-weight: bold;
            margin-bottom: 5px;
        }

        .pmf-sidebar-user-role {
            font-size: 14px;
        }

    }
</style>