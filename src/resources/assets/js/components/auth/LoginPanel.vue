<template>
    <div class="pmf-login-container">
        <div class="pmf-wrapper">
            <div class="pmf-login-center">
                <div class="pmf-login-box">
                    <h2>{{company}}</h2>
                    <h3>{{ $t('auth.please_login') }}</h3>
                    <pmf-alert
                            :loop-id="alertLoopId"
                            :visible.sync="alertVisible"
                            :title="alertTitle"
                            :type="alertType"
                            :description="alertDescription"
                            show-icon>
                    </pmf-alert>
                    <el-form ref="login_form"
                             :model="form"
                             :rules="validationRules"
                    >
                        <el-form-item prop="name">
                            <el-input v-model="form.name" :placeholder="$t('auth.login_name')" >
                                <template slot="prepend"><i class="fa fa-user"></i></template>
                            </el-input>
                        </el-form-item>
                        <el-form-item prop="password">
                            <el-input type="password" v-model="form.password" :placeholder="$t('auth.login_password')" @keyup.enter.native="doLogin" >
                                <template slot="prepend"><i class="fa fa-lock"></i></template>
                            </el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="doLogin">{{ $t('auth.login_btn') }}</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import AlertMixin from '../../mixins/AlertMixin';
    import BlockUIMixin from '../../mixins/BlockUIMixin';

    export default {

        name: 'LoginPanel',

        props: [ 'company' ],

        components: {},

        mixins: [AlertMixin, BlockUIMixin],

        methods: {
            doLogin() {
                this.$refs['login_form'].validate((valid) => {
                    if (valid) {

                        this.blockUI();

                        let request = axios.post('/login', this.form);
                        let scope = this;

                        request.then((res) => {
                            this.handleSuccessLogin(res);
                        });

                        request.catch((err) => {
                            this.handleErrorLogin(err.response);
                        });

                    } else {
                        return false;
                    }
                });
            }, //do login

            handleErrorLogin(res) {
                let data = res.data;

                if(data.errors){
                    let messages = data.errors;

                    //currently use email as login
                    if(messages.name){
                        this.showAlertError(this.$t('common.error'),messages.name[0]);
                    }
                    else {
                        this.showAlertError(this.$t('common.error'),messages.email[0]);
                    }
                }

                this.unblockUI();
            },

            handleSuccessLogin(res) {
                this.unblockUI();
                window.location = res.data.redirect;
            },

        },

        data() {
            return {
                form: {

                },

                validationRules: {
                    name: [
                        { required: true, message: this.$t('validation.required'), trigger: 'blur' },
                    ],

                    password: [
                        { required: true, message: this.$t('validation.required'), trigger: 'blur' },
                    ],
                }
            };
        }
    }
</script>
<style lang="scss" type="text/scss">

    .pmf-login-container {
        .pmf-wrapper {
            display: table;
            position: absolute;
            height: 100vh;
            width: 100%;

            > .pmf-login-center {
                display: table-cell;
                vertical-align: middle;

                > .pmf-login-box {
                    margin-left: auto;
                    margin-right: auto;
                    padding: 20px;

                    width: 300px; /*whatever width you want*/

                    h2 {
                        font-size: 24px;
                    }

                    h2,h3 {
                        text-align: center;
                    }

                    .el-alert {
                        margin-bottom: 20px;
                    }
                }
            }
        }
    }



</style>