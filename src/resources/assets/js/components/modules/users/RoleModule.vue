<template>
    <div class="pmf-module-container">
        <module-header :page-title="$t('modules.roles')" :show-button="hasActionPermission('add')" @click="handleGridCreate"></module-header>

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

        <!-- Start Grid -->
        <div class="pmf-grid" v-show="isGridVisible">
            <div class="pmf-grid-wrapper">

                <grid-topbar
                    :has-selected="hasSelectedGridRow"
                    :search-fields="gridSearchFields"
                    :has-delete-permission="hasActionPermission('delete')"
                    @delete-selected="handleGridDeleteSelected"
                    @search="gridSearch"
                    @reset="gridReset"
                ></grid-topbar>

                <el-dialog
                        :title="$t('common.delete_now')"
                        :visible.sync="isGridDeleteDialogVisible"
                        :width="responsive('30%','80%')" >
                    <span>{{ $t('common.delete_object', { id: selectedGridRowId } ) }}</span>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="isGridDeleteDialogVisible = false">{{ $t('common.cancel') }}</el-button>
                        <el-button type="primary" @click="handleGridDeleteRemote">{{ $t('common.confirm') }}</el-button>
                    </span>
                </el-dialog>

                <el-dialog
                        :title="$t('common.delete_selected_now')"
                        :visible.sync="isGridDeleteSelectedDialogVisible"
                        :width="responsive('30%','80%')" >
                    <span>{{ $t('common.delete_selected_object') }}</span>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="isGridDeleteSelectedDialogVisible = false">{{ $t('common.cancel') }}</el-button>
                        <el-button type="primary" @click="handleGridDeleteSelectedRemote">{{ $t('common.confirm') }}</el-button>
                    </span>
                </el-dialog>


                <el-table
                        ref="pmfGrid"
                        :data="grid.data"
                        :border="true"
                        :stripe="true"
                        :empty-text="$t('common.no_records_found')"
                        style="min-width: 600px; width: 100%;"
                        @sort-change="handleGridSortChange"
                        @selection-change="handleGridSelectionChange">
                    <el-table-column
                            v-if="hasActionPermission('delete')"
                            type="selection"
                            width="40">
                    </el-table-column>
                    <el-table-column
                            :label="$t('fields.id')"
                            property="id"
                            sortable="custom"
                            width="100" >
                    </el-table-column>
                    <el-table-column
                            :label="$t('fields.name')"
                            property="name"
                            sortable="custom"
                            width="120" >
                    </el-table-column>
                    <el-table-column
                            :label="$t('fields.description')"
                            property="description"
                            sortable="custom" >
                    </el-table-column>
                    <el-table-column
                            id="operation"
                            :label="$t('common.operations')"
                            width="150" >
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                        v-show="hasActionPermission('view')"
                                        type="primary"
                                        size="mini"
                                        @click="handleGridView(scope.row.id)" ><i class="fa fa-search"></i></el-button>
                                <el-button
                                        v-show="hasActionPermission('edit')"
                                        type="primary"
                                        size="mini"
                                        @click="handleGridEdit(scope.row.id)" ><i class="fa fa-pencil"></i></el-button>
                                <el-button
                                        v-show="hasActionPermission('delete')"
                                        size="mini"
                                        type="primary"
                                        @click="handleGridDelete(scope.row.id)"><i class="fa fa-trash"></i></el-button>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="pmf-grid-pagination">
                    <el-pagination
                            @size-change="handleGridPageSizeChange"
                            @current-change="handleGridPageCurrentChange"
                            :background="true"
                            :current-page="gridQueryObject.page"
                            :page-sizes="gridPageSizes"
                            :page-size="gridQueryObject.pagination"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="grid.total">
                    </el-pagination>
                </div>
            </div>
        </div>
        <!-- End Grid -->
        <!-- Start Form -->
        <!-- Notes: You can choose to use pmf-compact-form or pmf-full-form class for the width of the form -->
        <div class="pmf-action-form pmf-compact-form" v-show="isFormVisible">
            <h2 class="pmf-form-title" v-if="isFormEdit === false">{{ $t('common.add_object', { name: $t('modules.role') }) }}</h2>
            <h2 class="pmf-form-title" v-else>{{ $t('common.edit_object', { name: $t('modules.role') }) }}</h2>
            <el-form label-position="right" label-width="100px" >
                <el-form-item :label="$t('fields.id')" v-show="isFormEdit">
                    <el-input v-model="formData.id" :disabled="true" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.name')" :error="getValidationError('name')">
                    <el-input v-model="formData.name" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.redirect')" :error="getValidationError('redirect')">
                    <el-input v-model="formData.redirect" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.description')" :error="getValidationError('description')" >
                    <el-input type="textarea" :rows="5" v-model="formData.description" ></el-input>
                </el-form-item>
                <form-section :title="$t('fields.permissions')" :error="getValidationError('permissions')" ></form-section>
                <div class="pmf-permission-group" v-for="(permissions, group) in formOptions.permissionGroups">
                    <h4 class="pmf-permission-group-title">{{ $t('permission_groups.' + group) }}</h4>
                    <el-checkbox v-for="perm in permissions" :key="perm.name"  v-model="formData.permissions[perm.name]">{{ $t('permissions.' + perm.name) }}</el-checkbox>
                </div>
                <el-form-item>
                    <el-button type="primary" @click="handleSaveActionForm">{{ $t('common.save') }}</el-button>
                    <el-button type="default" @click="handleCloseActionForm">{{ $t('common.back') }}</el-button>
                </el-form-item>
            </el-form>
        </div>
        <!-- End Form -->
        <!-- Start View -->
        <div class="pmf-data-view pmf-compact-form" v-show="isViewVisible">
            <h2 class="pmf-form-title">{{ $t('common.info') }}</h2>
            <el-form label-position="right" label-width="100px" >
                <el-form-item :label="$t('fields.id')">
                    <el-input :readonly="true" :value="formData.id" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.name')">
                    <el-input :readonly="true" :value="formData.name" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.redirect')">
                    <el-input :readonly="true" :value="formData.redirect" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.description')">
                    <el-input type="textarea" :rows="5" :readonly="true" :value="formData.description" ></el-input>
                </el-form-item>
                <form-section :title="$t('fields.permissions')" ></form-section>
                <div class="pmf-permission-group" v-for="(permissions, group) in formOptions.permissionGroups">
                    <h4 class="pmf-permission-group-title">{{ $t('permission_groups.' + group) }}</h4>
                    <el-checkbox :disabled="true" v-for="perm in permissions" :key="perm.name"  v-model="formData.permissions[perm.name]">{{ $t('permissions.' + perm.name) }}</el-checkbox>
                </div>
                <el-form-item>
                    <el-button type="default" @click="handleCloseViewForm">{{ $t('common.back') }}</el-button>
                </el-form-item>
            </el-form>
        </div>
        <!-- End View -->
    </div>
</template>
<script>

    import ModuleHeader from '../../layouts/ModuleHeader.vue';
    import BlockUIMixin from '../../../mixins/BlockUIMixin';
    import AlertMixin from '../../../mixins/AlertMixin';
    import GridMixin from '../../../mixins/GridMixin';
    import ResponsiveMixin from '../../../mixins/ResponsiveMixin';

    export default {

        name: 'RoleModule',

        components: { ModuleHeader },

        mixins: [BlockUIMixin, AlertMixin, GridMixin, ResponsiveMixin ],

        methods: {

            initializeFormData() {

                let permissions = {};
                this.formOptions.permissions.forEach( (perm) => {
                    permissions[perm.name] = false;
                });

                this.formData = { permissions: permissions, redirect: '/home' };

            },

            transformGridViewData(res) {
                let object = res.data.object;

                let permissions = object.permissions;

                if(Array.isArray(permissions)){
                    permissions = _.map(permissions,'name');
                }

                let formPermissions = {};

                this.formOptions.permissions.forEach( (perm) => {
                    if(permissions.includes(perm.name)){
                        formPermissions[perm.name] = true;
                    }
                    else {
                        formPermissions[perm.name] = false;
                    }
                });

                object.permissions = formPermissions;

                return object;
            },

            transformGridEditData(res) {
                return this.transformGridViewData(res);
            },

            transformGridBeforeSaveData() {

                let permissionList = [];

                for(let perm in this.formData.permissions){
                    if (this.formData.permissions.hasOwnProperty(perm)) {
                        if(this.formData.permissions[perm]) {
                            permissionList.push(perm);
                        }
                    }//if
                }//for

                this.formData.permissionList = permissionList;

                return this.formData;
            },

            transformGridSuccessSaveData(res) {
                return this.transformGridViewData(res);
            },

            getFormOptionPermissions() {
                let request = axios.post(this.endpoints.permissions, { } );

                request.then((res) => {
                    this.formOptions.permissions = res.data.objects;

                    this.formOptions.permissions.forEach( (perm) => {
                        if (! this.formOptions.permissionGroups[perm.group]){
                            this.formOptions.permissionGroups[perm.group] = [];
                        }

                        this.formOptions.permissionGroups[perm.group].push(perm);
                    });
                });

                request.catch((err) => {
                    this.handleFormOptionErrorGet(err);
                });
            }

        },

        data() {
            return {

                permissionPrefix: 'role',
                permissions: ['add', 'edit', 'delete', 'view'],

                endpoints: {
                    grid: '/users/roles/grid',
                    view: '/users/roles/view',
                    create: '/users/roles/create',
                    update: '/users/roles/update',
                    delete: '/users/roles/delete',
                    deleteSelected: '/users/roles/delete-selected',
                    permissions: '/users/roles/permissions'
                },

                gridSearchFields: [
                    { value: 'id', label: this.$t('fields.id') },
                    { value: 'name', label: this.$t('fields.name') },
                    { value: 'description', label: this.$t('fields.description') },
                ],

                formData: { permissions: {} },

                formOptions: {
                    permissions: [],
                    permissionGroups: {}
                }

            };
        },

        computed: {  },

        created() {
            this.getFormOptionPermissions();
        }
    }
</script>
<style lang="scss" type="text/scss">

    .pmf-permission-group {
        margin-bottom: 15px;
        border: 2px solid lighten(lightgrey,10);
        padding: 15px;
        border-radius: 4px;
    }

    .pmf-permission-group-title {
        margin-bottom: 10px;
    }
</style>