<template>
    <div :class="containerClass">
        <h3 class="pmf-section-title">{{ title }}<span class="pmf-section-error" v-show="hasError" >{{ error }}</span><span class="pmf-section-button" ><el-button v-show="useNewButton" @click="$emit('new')" type="default" size="small"><i class="fa fa-plus"></i> {{$t('common.new')}}</el-button></span></h3>
    </div>
</template>
<script>
    export default {

        name: 'FormSection',

        props: {
            title: {
                type: String,
                required: true
            },

            error: {
                type: String,
                default: ''
            },

            useNewButton: {
                type: Boolean,
                default: false
            }
        },

        components: {},

        mixins: [],

        methods: {},

        data() {
            return {};
        },

        computed: {
            hasError() {
                return this.error ? true : false;
            },

            containerClass() {
                return 'pmf-form-section' + (this.hasError ? ' pmf-has-error' : '');
            }
        }
    }
</script>
<style lang="scss" type="text/scss">

    .pmf-section-title {
        margin: 0 0 15px 0;
        padding: 15px 0 10px 0;
        border-bottom: 1px solid lightgrey;
    }

    .pmf-has-error {
        .pmf-section-title {
            color: OrangeRed;
        }
    }

    .pmf-section-button {
        float: right;
        display: inline-block;
        position: relative;
        top: -5px;
    }

    .pmf-section-error {
        display: inline-block;
        padding-left: 15px;
        color: OrangeRed;
        font-size: 14px;
    }
</style>