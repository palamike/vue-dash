<template>
    <div class="pmf-module-header">
        <h1><a href="#" @click="$emit('home')">{{pageTitle}}</a></h1>
        <el-button v-show="showButton" @click="$emit('click')" type="default" size="small"><i class="fa fa-plus"></i> {{$t('common.new')}}</el-button>
    </div>
</template>
<script>
    export default {

        name: 'ModuleHeader',

        props: {

            pageTitle: {
              type: String,
              required: true
            },

            showButton: {
                type: Boolean,
                default: false
            }
        },

        components: {},

        mixins: [],

        methods: {},

        data() {
            return {};
        }
    }
</script>
<style lang="scss" type="text/scss" >
    .pmf-module-header {
        padding: 30px 15px;
        border-bottom: 1px solid lightgrey;

        > h1 {
            margin: 0;
            display: inline-block;
            margin-right: 15px;
        }
    }
</style>