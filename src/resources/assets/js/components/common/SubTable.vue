<template>
    <div class="pmf-sub-table">
        <form-section :title="$t('fields.' + prop)" :error="getValidationError(prop)" :useNewButton="true && !readonly" @new="handleNewRow"></form-section>
        <el-form v-if="!readonly">
            <el-table
                    :ref="refElement"
                    :data="items"
                    :border="true"
                    :stripe="true"
                    :empty-text="$t('common.no_records_found')"
                    class="pmf-sub-table-object" >
                <el-table-column
                        v-for="column in columns"
                        :key="column.prop"
                        :label="column.label"
                        :property="column.prop"
                        :width="column.width"
                ><template slot-scope="scope">
                    <el-form-item :error="getValidationErrorArray(prop, column.prop, scope.$index)" >
                        <el-select
                                v-if="column.type === 'search'"
                                v-model="scope.row[column.prop]"
                                filterable
                                remote
                                :placeholder="$t('common.please_enter_keyword')"
                                :remote-method="getRemoteSearchMethod(scope.$index,column.prop, column.endpoint,column.format)"
                                :loading="getSearchLoading(scope.$index,column.prop)"
                                @change="handleCellChange" >
                            <el-option
                                    v-for="item in getSearchItemOptions(scope.$index,column.prop)"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                        <el-input v-else v-model="scope.row[column.prop]" @change="handleCellChange" ></el-input>
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
        <div v-else class="pmf-sub-table-view">
            <el-table
                    :ref="refElement"
                    :data="items"
                    :border="true"
                    :stripe="true"
                    :empty-text="$t('common.no_records_found')"
                    class="pmf-sub-table-object" >
                <el-table-column
                        v-for="column in columns"
                        :key="column.prop"
                        :label="column.label"
                        :property="column.prop"
                        :width="column.width"
                ><template slot-scope="scope" >
                    <span v-if="column.type === 'search'" >
                        {{ scope.row[column.prop + '_label'] }}
                    </span>
                    <span v-else>
                        {{ scope.row[column.prop] }}
                    </span>
                </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>
<script>

    import ValidationMixin from '../../mixins/ValidationMixin';

    export default {

        name: 'SubTable',

        props: {

            columns: {
                type: Array,
                required: true
            },

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
                default: 'pmfSubTable'
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

                this.removeSearchProps(index);

                this.$emit('update:items',this.tableItems);
            },

            handleCellChange() {

                let oldItems = this.tableItems;
                let updatedItems = this.items;

                if( updatedItems && ( updatedItems.length > 0 ) ) {
                    updatedItems.forEach( (updated, index) => {

                        this.columns.forEach((column) => {

                            let updatedStr = new String(updated[column.prop]);
                            let oldStr = new String(oldItems[index][column.prop]);

                            /**
                             *
                             * @event cell-update will attach the following value
                             *
                             * However when column provide onChange value as function this function will called when cell change.
                             *
                             * @var {{
                             *
                             *  prop: string,
                             *  index: number,
                             *  row: object,
                             *  oldValue: String,
                             *  newValue: String
                             *
                             *  }}
                             */
                            let result = { prop: column.prop, index: index, row: updated, oldValue: oldStr, newValue: updatedStr };

                            if(column.onChange && (updatedStr !== oldStr) ){
                                column.onChange(result);
                            }

                            if( updatedStr !== oldStr ) {
                                this.$emit('cell-update', result);
                            }

                        });

                    } );
                }//if

                this.tableItems = this.items;
                this.$emit('update:items',this.tableItems);
            },

            handleNewRow() {
                this.tableItems = this.items;
                this.tableItems.push( {} );
                let lastIndex = this.tableItems.length - 1;

                this.initializeSearchProps(lastIndex);

                this.$emit('update:items',this.tableItems);
            },

            initializeSearchProps(index) {
                this.$set(this.searchRemoteMethods, index, {});
                this.$set(this.searchItemOptions, index, {});
                this.$set(this.searchLoading, index, {});
            },

            removeSearchProps(index){
                this.searchRemoteMethods.splice(index, 1);
                this.searchItemOptions.splice(index, 1);
                this.searchLoading.splice(index, 1);
            },

            setSearchLoading(index , prop, value){
                if(this.searchLoading[index]) {
                    this.$set(this.searchLoading[index], prop , value);
                }
            },

            getSearchLoading(index , prop) {
                if(this.searchLoading[index]) {
                    return this.searchLoading[index][prop];
                }
                else{
                    this.$set(this.searchLoading, index, {});
                    return this.searchLoading[index][prop];
                }
            },

            getSearchItemOptions(index , prop) {
                if(this.searchItemOptions[index]) {
                    return this.searchItemOptions[index][prop];
                }
                else{
                    this.$set(this.searchItemOptions, index, {});
                    return this.searchItemOptions[index][prop];
                }
            },

            getRemoteSearchMethod(index ,prop, endpoint, formatMethod) {
                if(this.searchRemoteMethods[index] && (this.searchRemoteMethods[index][prop] && this.searchRemoteMethods[index].hasOwnProperty('prop'))){
                    return this.searchRemoteMethods[index][prop];
                }//if
                else{

                    if(! this.searchRemoteMethods[index]) {
                        this.$set(this.searchRemoteMethods, index, {});
                    }

                    this.searchRemoteMethods[index][prop] = (search) => {

                        if(!(search && search.length > 1)) {
                            return;
                        }

                        this.setSearchLoading(index ,prop, true);

                        let request = axios.post(endpoint, { search: search } );

                        request.then((res) => {
                            let objects = res.data.objects;

                            if(this.searchItemOptions[index]) {
                                this.$set(this.searchItemOptions[index], prop , [] );
                            }
                            else{
                                this.$set(this.searchItemOptions, index , {} );
                                this.$set(this.searchItemOptions[index], prop , [] );
                            }

                            if(objects && (objects.length > 0)) {
                                objects.forEach( (object) => {
                                    this.searchItemOptions[index][prop].push(formatMethod(object));
                                });
                            }//if

                            this.setSearchLoading(index ,prop, false);
                        });

                        request.catch((err) => {
                            this.$emit('error-search', err);
                            this.setSearchLoading(index ,prop, false);
                        });

                    };

                    return this.searchRemoteMethods[index][prop];
                }
            }

        },//method

        updated() {

            //initialize items
            this.tableItems = this.items;

            if(this.columns && (this.columns.length > 0) && this.items && (this.items.length > 0) ){
                this.items.forEach((item,index) => {

                    this.columns.forEach((column) => {

                        if(column.type === 'search' && item[column.prop]) {
                            let option = column.initial(item);

                            if(this.readonly) {
                                if(option !== null){
                                    this.$set(item,column.prop + '_label', option.label);
                                }
                            }
                            else {
                                if(option !== null){
                                    this.$set(this.searchItemOptions[index], column.prop , [ option ] );
                                }
                            }


                        }

                    });
                });
            }//if

        },

        data() {
            return {
                tableItems: [],
                
                searchItemOptions: [], //use for handle remote search
                searchLoading: [], //use for handle remote search
                searchRemoteMethods: [] //use for handle remote search
            };
        }
    }
</script>
<style lang="scss" type="text/scss">
    .pmf-sub-table {
        margin-top: 30px;

        .pmf-section-title {
            margin-bottom: 20px;
        }

        .el-table {
            margin-bottom: 20px;
        }

        .el-form-item__error {
            position: static;
        }
    }
</style>