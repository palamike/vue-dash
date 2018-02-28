<template>
    <div class="pmf-module-container">
        <module-header :page-title="$t('modules.users')" :show-button="hasActionPermission('add')" @click="handleGridCreate"></module-header>

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
                            :label="$t('fields.email')"
                            property="email"
                            sortable="custom" >
                    </el-table-column>
                    <el-table-column
                            :label="$t('fields.role')"
                            property="role"
                            sortable="custom" >
                    </el-table-column>
                    <el-table-column
                            :label="$t('fields.status')"
                            property="status"
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
            <h2 class="pmf-form-title" v-if="isFormEdit === false">{{ $t('common.add_object', { name: $t('modules.user') }) }}</h2>
            <h2 class="pmf-form-title" v-else>{{ $t('common.edit_object', { name: $t('modules.user') }) }}</h2>
            <el-form label-position="right" label-width="100px" >
                <el-form-item :label="$t('fields.id')" v-show="isFormEdit">
                    <el-input v-model="formData.id" :disabled="true" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.name')" :error="getValidationError('name')">
                    <el-input v-model="formData.name" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.email')" :error="getValidationError('email')">
                    <el-input type="email" v-model="formData.email" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.status')" :error="getValidationError('status')">
                    <el-select v-model="formData.status" :placeholder="$t('common.please_select')">
                        <el-option key="active" :label="$t('status.active')" value="active"></el-option>
                        <el-option key="inactive" :label="$t('status.inactive')" value="inactive"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('fields.password')" :error="getValidationError('password')">
                    <el-input type="password" v-model="formData.password" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.password_confirmation')" :error="getValidationError('password_confirmation')">
                    <el-input type="password" v-model="formData.password_confirmation" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.role')" :error="getValidationError('role_id')">
                    <el-select v-model="formData.role_id" :placeholder="$t('common.please_select')" filterable >
                        <el-option v-for="role in formOptions.roles" :key="role.id" :label="role.name" :value="role.id"></el-option>
                    </el-select>
                </el-form-item>
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
                <el-form-item :label="$t('fields.email')">
                    <el-input type="text" :readonly="true" :value="formData.email" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.status')">
                    <el-input type="text" :readonly="true" :value="formData.status" ></el-input>
                </el-form-item>
                <el-form-item :label="$t('fields.role')">
                    <el-input type="text" :readonly="true" :value="formData.role" ></el-input>
                </el-form-item>
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

        name: 'UserModule',

        components: { ModuleHeader },

        mixins: [BlockUIMixin, AlertMixin, GridMixin, ResponsiveMixin ],

        methods: {
            transformGridViewData(res) {
                let object = res.data.object;
                let roles = object.roles;
                object.role = roles[0] ? roles[0].name : '';
                return object;
            },

            transformGridEditData(res) {
                let object = res.data.object;
                let roles = object.roles;
                object.role_id = roles[0] ? roles[0].id: '';
                return object;
            },

            transformGridSuccessSaveData(res) {
                return this.transformGridEditData(res);
            },

            getFormOptionRoles() {
                let request = axios.post(this.endpoints.roles, { } );

                request.then((res) => {
                    this.formOptions.roles = res.data.objects;
                });

                request.catch((err) => {
                    this.handleFormOptionErrorGet(err);
                });
            }
        },

        data() {
            return {

                permissionPrefix: 'user',
                permissions: ['add', 'edit', 'delete', 'view'],

                endpoints: {
                    grid: '/users/users/grid',
                    view: '/users/users/view',
                    create: '/users/users/create',
                    update: '/users/users/update',
                    delete: '/users/users/delete',
                    deleteSelected: '/users/users/delete-selected',
                    roles: '/users/users/roles'
                },

                gridSearchFields: [
                    { value: 'id', label: this.$t('fields.id') },
                    { value: 'name', label: this.$t('fields.name') },
                    { value: 'description', label: this.$t('fields.description') },
                ],

                formOptions: {
                    roles: []
                }

            };
        },

        computed: {  },

        mounted() {
            this.getFormOptionRoles();
        }
    }
</script>
<style lang="scss" type="text/scss">
</style>