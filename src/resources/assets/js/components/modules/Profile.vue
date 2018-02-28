<template>
    <div class="pmf-module-container">
        <module-header :page-title="$t('modules.profile')" :show-button="false" ></module-header>

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
            <h2 class="pmf-form-title" >{{ $t('common.edit_object', { name: $t('modules.profile') }) }}</h2>
            <el-form label-position="right" label-width="100px" >

                <el-form-item :label="$t('fields.name')" :error="getValidationError('name')">
                    <el-input v-model="formData.name" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.email')" :error="getValidationError('email')">
                    <el-input type="email" v-model="formData.email" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.password')" :error="getValidationError('password')">
                    <el-input type="password" v-model="formData.password" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.password_confirmation')" :error="getValidationError('password_confirmation')">
                    <el-input type="password" v-model="formData.password_confirmation" ></el-input>
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

    import ModuleHeader from '../layouts/ModuleHeader.vue';
    import BlockUIMixin from '../../mixins/BlockUIMixin';
    import AlertMixin from '../../mixins/AlertMixin';
    import ResponsiveMixin from '../../mixins/ResponsiveMixin';
    import SimpleFormMixin from '../../mixins/SimpleFormMixin';

    export default {

        name: 'Profile',

        components: { ModuleHeader },

        mixins: [BlockUIMixin, AlertMixin, ResponsiveMixin, SimpleFormMixin ],

        methods: {

        },

        data() {
            return {

                permissionPrefix: 'profile',
                permissions: ['update'],

                endpoints: {
                    view: '/profile/view',
                    save: '/profile/update'
                }

            };
        },

        computed: {  },

        mounted() {
            this.prepareFormData();
        }
    }
</script>
<style lang="scss" type="text/scss">
</style>