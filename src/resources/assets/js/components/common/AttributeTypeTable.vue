<template>
    <div class="pmf-attribute-type-table">
        <form-section :title="$t('fields.' + prop)" :error="getValidationError(prop)" :useNewButton="true && !readonly" @new="handleNewRow"></form-section>
        <el-form v-if="!readonly">
            <el-table
                    :ref="refElement"
                    :data="items"
                    :border="true"
                    :stripe="true"
                    :empty-text="$t('common.no_records_found')"
                    class="pmf-attribute-type-table-object" >
                <el-table-column
                        :label="$t('fields.attribute_code')"
                        property="code"
                ><template slot-scope="scope">
                    <el-form-item :error="getValidationErrorArray(prop, 'code', scope.$index)" >
                        <el-input v-model="scope.row.code" @change="handleCellChange" ></el-input>
                    </el-form-item>
                </template>
                </el-table-column>
                <el-table-column
                        :label="$t('fields.attribute_label')"
                        property="label"
                ><template slot-scope="scope">
                    <el-form-item :error="getValidationErrorArray(prop, 'label', scope.$index)" >
                        <el-input v-model="scope.row.label" @change="handleCellChange" ></el-input>
                    </el-form-item>
                </template>
                </el-table-column>
                <el-table-column
                        :label="$t('fields.attribute_unit')"
                        property="unit"
                ><template slot-scope="scope">
                    <el-form-item :error="getValidationErrorArray(prop, 'unit', scope.$index)" >
                        <el-input v-model="scope.row.unit" @change="handleCellChange" ></el-input>
                    </el-form-item>
                </template>
                </el-table-column>
                <el-table-column
                        width="50" >
                    <template slot-scope="scope">
                        <div class="pmf-table-operations">
                            <a class="pmf-delete-icon" href="#" @click.prevent="handleRowDelete(scope.$index)">
                                <i class="fa fa-times-circle"></i>
                            </a>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </el-form>
        <el-table v-else
                :data="items"
                :border="true"
                :stripe="true"
                :empty-text="$t('common.no_records_found')"
                class="pmf-attribute-type-table-object" >
            <el-table-column
                    :label="$t('fields.attribute_code')"
                    property="code"
            ></el-table-column>
            <el-table-column
                    :label="$t('fields.attribute_label')"
                    property="label"
            ></el-table-column>
            <el-table-column
                    :label="$t('fields.attribute_unit')"
                    property="unit"
            ></el-table-column>
        </el-table>
    </div>
</template>
<script>

    import ValidationMixin from '../../mixins/ValidationMixin';

    export default {

        name: 'AttributeTypeTable',

        props: {

            items: {
                type: Array,
                default() {
                    return [];
                }
            },

            readonly: {
                type: Boolean,
                default: false
            },

            //property name
            prop: {
                type: String,
                required: true
            },

            refElement: {
                type: String,
                default: 'pmfAttributeType'
            },

            validationErrors: {
                type: Object,
                default() {
                    return {};
                }
            },
        },

        components: {},

        mixins: [ ValidationMixin ],

        methods: {
            handleRowDelete(index) {
                this.tableItems = this.items;
                this.tableItems.splice(index, 1);
                this.$emit('update:items',this.tableItems);
            },

            handleCellChange() {
                this.tableItems = this.items;
                this.$emit('update:items',this.tableItems);
            },

            handleNewRow() {
                this.tableItems = this.items;
                this.tableItems.push( {} );
                this.$emit('update:items',this.tableItems);
            }
        },

        data() {
            return {
                tableItems: []
            };
        },
    }
</script>
<style lang="scss" type="text/scss">
    .pmf-attribute-type-table-object {
        margin-top: 15px;
        margin-bottom: 20px;

        .el-form-item {
            margin-bottom: 0;
        }

        .pmf-table-operations {
            text-align: center;
            font-size: 22px;
            a.pmf-delete-icon {
                color: OrangeRed;
            }
        }

        .el-form-item__error {
            position: static;
        }
    }
</style>