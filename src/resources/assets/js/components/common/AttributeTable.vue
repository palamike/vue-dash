<template>
    <div class="pmf-attribute-table">
        <form-section :title="$t('fields.' + prop)" :error="getValidationError(prop)" ></form-section>
        <el-form v-if="!readonly">
            <el-table
                    :ref="refElement"
                    :data="attributes"
                    :border="true"
                    :stripe="true"
                    :empty-text="$t('common.no_records_found')"
                    class="pmf-attribute-table-object" >
                <el-table-column
                        :label="$t('fields.attribute_label')"
                        property="label"
                ></el-table-column>
                <el-table-column
                        :label="$t('fields.attribute_value')"
                        property="value"
                ><template slot-scope="scope">
                    <el-form-item :error="getValidationErrorObject(prop, scope.row.code, scope.row.label )" >
                        <el-input v-model="items[scope.row.code]" @change="handleCellChange" ></el-input>
                    </el-form-item>
                </template>
                </el-table-column>
                <el-table-column
                        :label="$t('fields.attribute_unit')"
                        property="unit"
                ></el-table-column>
            </el-table>
        </el-form>
        <el-table
                v-else
                :data="attributes"
                :border="true"
                :stripe="true"
                :empty-text="$t('common.no_records_found')"
                class="pmf-attribute-table-object" >
            <el-table-column
                    :label="$t('fields.attribute_label')"
                    property="label"
            ></el-table-column>
            <el-table-column
                    :label="$t('fields.attribute_value')"
                    property="value"
            ><template slot-scope="scope">
                {{ items[scope.row.code] }}
            </template>
            </el-table-column>
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

        name: 'AttributeTable',

        props: {

            attributes: {
                type: Array,
                default() {
                    return [];
                }
            },

            items: {
                type: Object,
                default() {
                    return { };
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

        mixins: [ValidationMixin],

        methods: {
            handleCellChange() {
                this.values = this.items;
                this.$emit('update:items',this.values);
            },
        },

        data() {
            return {
                tableItems: [],
                values: {}
            };
        }
    }
</script>
<style lang="scss" type="text/scss">
    .pmf-attribute-table-object {
        margin-top: 15px;
        margin-bottom: 20px;

        .el-form-item {
            margin-bottom: 0;
        }

        .el-form-item__error {
            position: static;
        }
    }
</style>