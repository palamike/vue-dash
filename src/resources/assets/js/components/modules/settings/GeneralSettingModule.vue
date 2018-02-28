<template>
    <div class="pmf-module-container">
        <module-header :page-title="$t('modules.general_setting')" :show-button="false" ></module-header>

        <!-- Start Alert -->
        <div class="pmf-module-alert" v-show="alertVisible">
            <pmf-alert
                    :loop-id="alertLoopId"
                    :visible.sync="alertVisible"
                    :title="alertTitle"
                    :type="alertType"
                    :description="alertDescription"
                    show-icon>
            </pmf-alert>
        </div>
        <!-- End Alert -->

        <!-- Start Form -->
        <!-- Notes: You can choose to use pmf-compact-form or pmf-full-form class for the width of the form -->
        <div class="pmf-action-form pmf-compact-form" >
            <h2 class="pmf-form-title" >{{ $t('common.edit_object', { name: $t('modules.general_setting') }) }}</h2>
            <el-form label-position="right" label-width="100px" >
                <el-form-item :label="$t('settings.general_list_pagination')" :error="getValidationError('general_list_pagination')">
                    <el-select v-model="formData.general_list_pagination" :placeholder="$t('common.please_select')">
                        <el-option
                                v-for="item in [25, 50, 100, 150, 200]"
                                :key="item"
                                :label="item"
                                :value="item">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleSaveActionForm">{{ $t('common.save') }}</el-button>
                </el-form-item>
            </el-form>
        </div>
        <!-- End Form -->

    </div>
</template>
<script>

    import ModuleHeader from '../../layouts/ModuleHeader.vue';
    import BlockUIMixin from '../../../mixins/BlockUIMixin';
    import AlertMixin from '../../../mixins/AlertMixin';
    import ResponsiveMixin from '../../../mixins/ResponsiveMixin';
    import SettingFormMixin from '../../../mixins/SettingFormMixin';

    export default {

        name: 'GeneralSettingModule',

        components: { ModuleHeader },

        mixins: [BlockUIMixin, AlertMixin, ResponsiveMixin, SettingFormMixin ],

        methods: {

        },

        data() {
            return {

                permissionPrefix: 'general_setting',
                permissions: ['add', 'edit', 'delete', 'view'],

                endpoints: {
                    view: '/settings/general-settings/view',
                    save: '/settings/general-settings/save'
                }

            };
        },

        computed: {  },
    }
</script>
<style lang="scss" type="text/scss">
</style>