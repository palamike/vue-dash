<template>
    <div class="pmf-module-container">
        <module-header page-title="Dashboard" :show-button="false"></module-header>
        <div class="pmf-dashboard">
            <div v-for="parent in sidebars">
                <div class="pmf-dashboard-module" v-if="(parent.id !== 'dashboard') && (hasAnyPermissions(parent.permissions))" :style="styleBorderColor(parent.color)" >
                    <div class="pmf-dashboard-module-title" :style="styleBackgroundColor(parent.color)">
                        {{ $t('sidebar.' + parent.id) }}
                    </div>
                    <div class="pmf-dashboard-module-body">
                        <div class="pmf-dashboard-item" v-for="item in parent.children" v-show="hasPermission(item.permissions)">
                            <a href="#" class="pmf-dashboard-icon-button"  @click="handleIconSelect(item.link)" :style="styleColor(parent.color)">
                                <i :class="iconClass(item.icon)"></i><span class="pmf-dashboard-icon-text">{{ $t('sidebar.' + item.id) }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import ModuleHeader from '../layouts/ModuleHeader.vue';
    import SidebarData from '../data/sidebar';
    import BlockUIMixin from '../../mixins/BlockUIMixin';
    import AuthMixin from '../../mixins/AuthMixin';

    export default {

        name: 'Dashboard',

        props: {
            showButton: {
                type: Boolean,
                default: true
            }
        },

        components: { ModuleHeader },

        mixins: [BlockUIMixin, AuthMixin],

        methods: {
            iconClass(icon) {
                return 'fa fa-' + icon + ' pmf-dashboard-icon';
            },

            styleBackgroundColor(color){
                if(!color){
                    return '';
                }

                return 'background-color: ' + color;
            },

            styleBorderColor(color){

                if(!color){
                    return '';
                }

                return 'border-color: ' + color;
            },

            styleColor(color){

                if(!color){
                    return '';
                }

                return 'color: ' + color;
            },

            handleIconSelect(link) {
                this.blockUI();
                window.location = window.pmf.baseURL + link;
                console.log('currently you select', link);
            },
        },

        data() {
            return {
                sidebars: SidebarData.data
            };
        }
    }
</script>
<style lang="scss" type="text/scss" >
    .pmf-dashboard {
        padding: 15px;
    }

    .pmf-dashboard-module {
        border-width: 1px;
        border-style: solid;
        margin-bottom: 30px;
        border-radius: 5px;
    }

    .pmf-dashboard-module-title {
        padding: 10px 15px;
        color: white;
    }

    .pmf-dashboard-module-body {
        display: flex;
        flex-flow: row wrap;
        padding: 15px;
        justify-content: flex-start;
    }

    .pmf-dashboard-item {
        max-width: 180px;
        min-width: 130px;
        margin-right: 15px;
    }

    .pmf-dashboard-icon {
        padding: 15px;
        font-size: 32px;
        display: block;
        text-align: center;
    }

    .pmf-dashboard-icon-text {
        padding: 5px 5px;
        display: block;
        text-align: center;
    }


</style>