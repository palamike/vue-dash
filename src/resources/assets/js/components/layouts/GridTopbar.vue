<template>
    <div class="pmf-grid-topbar">
        <div class="pmf-grid-actions" >
            <el-button type="danger" v-show="hasDeletePermission" :disabled="! hasSelected" @click="onDeleteSelectedClick"><i class="fa fa-trash"></i> {{ $t('common.delete_selected') }}</el-button>
        </div>
        <div class="pmf-grid-filters" >
            <el-form :inline="true" :model="form">
                <el-form-item v-show="useDateRange" >
                    {{dateRangeLabel}}
                    <el-date-picker

                        v-model="form.dateRange"
                        type="daterange"
                        align="center"
                        unlink-panels
                        :range-separator="$t('common.to')"
                        :start-placeholder="$t('fields.start_dt')"
                        :end-placeholder="$t('fields.end_dt')"
                        :picker-options="pickerOptions"
                        @change="onDateRangeChanged"
                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item >
                    <el-select v-model="form.field" :placeholder="$t('common.please_select')">
                        <el-option
                                v-for="item in searchFields"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-input v-model="form.value" :placeholder="$t('common.search_now')" @keyup.enter.native="onSearchClick" ></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearchClick"><i class="fa fa-search"></i> {{ $t('common.search') }}</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="default" @click="onResetClick"><i class="fa fa-refresh"></i> {{ $t('common.reset') }}</el-button>
                </el-form-item>
                <el-form-item v-show="useSwitch">
                    <el-button type="default" @click="onSwitch"><i class="fa fa-exchange"></i></el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>
<script>

    import SettingMixin from '../../mixins/SettingMixin';

    export default {

        name: 'GridTopbar',

        props: {

            dateRangeLabel: {
                type: String,
                default: ''
            },

            useDateRange: {
                type: Boolean,
                default: false
            },

            hasSelected: {
                type: Boolean,
                default: false
            },

            searchFields: {
                type: Array,
                required: true
            },

            hasDeletePermission: {
                type: Boolean,
                default: false
            },

            /**
             * this option will show the switch button and emit switch event out of the component
             */
            useSwitch: {
                type: Boolean,
                default: false
            }
        },

        components: {},

        mixins: [ SettingMixin ],

        methods: {
            onDeleteSelectedClick() {
                this.$emit('delete-selected');
            },

            onDateRangeChanged(){

                if (this.form.dateRange) {
                    this.form.startDate = moment(this.form.dateRange[0]).format('YYYY-MM-DD');
                    this.form.endDate = moment(this.form.dateRange[1]).format('YYYY-MM-DD');
                }

            },

            onSearchClick() {
                if(this.useDateRange){
                    this.$emit('search', this.form);
                }
                else {
                    if(this.form.field && this.form.value) {
                        this.$emit('search', this.form);
                    }
                }

            },

            onResetClick() {
                this.$emit('reset');
            },

            onSwitch() {
                this.$emit('switch');
            },

            getStartDate() {

                let general_query_date_range = this.getSetting('general_query_date_range');

                if(! general_query_date_range){
                    general_query_date_range = '7';
                }

                return moment().subtract( parseInt(general_query_date_range) - 1);
            },

            getEndDate() {
                return moment();
            }
        },

        data() {

            let startDate = this.getStartDate();
            let endDate = this.getEndDate();

            return {
                form: { field: null, value: null, startDate: startDate.format('YYYY-MM-DD') , endDate: endDate.format('YYYY-MM-DD') , dateRange: [startDate.toDate(), endDate.toDate() ] },

                pickerOptions: {
                    shortcuts: [
                        {
                            text: this.$t('date_picker.today'),
                            onClick(picker) {
                                const end = moment();
                                const start = moment();
                                picker.$emit('pick', [start, end]);
                            }
                        },
                        {
                            text: this.$t('date_picker.this_week'),
                            onClick(picker) {
                                const end = moment();
                                const start = moment();
                                start.subtract(6, 'days');
                                picker.$emit('pick', [start, end]);
                            }
                        },
                        {
                            text: this.$t('date_picker.this_month'),
                            onClick(picker) {
                                const start = moment().startOf('month');
                                const end = moment().endOf('month');
                                picker.$emit('pick', [start, end]);
                            }
                        },
                        {
                            text: this.$t('date_picker.last_month'),
                            onClick(picker) {
                                const start = moment().subtract(1,'months').startOf('month');
                                const end = moment().subtract(1,'months').endOf('month');
                                picker.$emit('pick', [start, end]);
                            }
                        },
                        {
                            text: this.$t('date_picker.last_30days'),
                            onClick(picker) {
                                const end = moment();
                                const start = moment();
                                start.subtract(29, 'days');
                                picker.$emit('pick', [start, end]);
                            }
                        },
                        {
                            text: this.$t('date_picker.last_90days'),
                            onClick(picker) {
                                const end = moment();
                                const start = moment();
                                start.subtract(89, 'days');
                                picker.$emit('pick', [start, end]);
                            }
                        },
                    ]
                },
            };
        },

        computed: {

        }
    }
</script>
<style lang="scss" type="text/scss">

    .pmf-grid-topbar {

        @media only screen and (max-width: 768px ) {
            .pmf-grid-actions {
                margin-bottom: 15px;
            }
        }

    }

    @media only screen and (min-width: 769px) {
        .pmf-grid-topbar {
            display: flex;
            justify-content: space-between;
        }
    }

</style>