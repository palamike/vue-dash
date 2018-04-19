export default {

    methods: {

        handleSaveActionForm() {

            this.blockUI();

            //clear form error data
            this.initializeFormErrorData();

            this.hideAlert();

            let endpoint = this.endpoints.save;

            let request = axios.post(endpoint, this.transformBeforeSaveData());

            request.then((res) => {
                this.handleSuccessSave(res);
            });

            request.catch((err) => {
                this.handleErrorSave(err);
            });

        },

        transformBeforeSaveData() {
            return this.formData;
        },

        transformErrorData(res) {
            return res.data.errors;
        },

        handleSuccessSave(res) {
            this.unblockUI();
            this.showAlertSuccess(this.$t('common.success'), this.$t('success.save', { id: this.formData.id } ));
            window.scrollTo(0, 0);
        },

        handleErrorSave(err) {
            console.log('handleErrorSave',err.response);
            this.unblockUI();

            let response = err.response;

            // handle validation error.
            if( response.status === 422 ){
                this.showAlertError(this.$t('common.error'), this.$t('error.validation') );
                this.formErrorData = this.transformErrorData(response);
            }
            else{
                //normal error message
                this.showAlertError(this.$t('common.error'), err.response.data.message );
            }

        },

        handleFormOptionErrorGet(err) {
            console.log('handleFormOptionErrorGet',err.response);
            this.unblockUI();
            this.showAlertError(this.$t('common.option_error'), err.response.data.message );
        },

        getValidationError(field) {
            if(this.formErrorData[field]){
                return this.formErrorData[field][0];
            }
        },

        initializeFormErrorData() {
            this.formErrorData = {};
        },

        initializeFormData() {
            this.formData = {};
        },

        handleFormSettingErrorGet(err) {
            console.log('handleFormSettingErrorGet',err.response);
            this.unblockUI();
            this.showAlertError(this.$t('common.setting_error'), err.response.data.message );
        },

        prepareFormSettingData(){

            this.blockUI();

            let endpoint = this.endpoints.view;
            let request = axios.post(endpoint, {} );

            request.then((res) => {
                this.unblockUI();
                this.formData = this.transformEditData(res);
            });

            request.catch((err) => {
                this.handleFormSettingErrorGet(err);
            });

        },

        transformEditData(res){
            return res.data.object;
        }
    },

    data() {
        return {
            formData: {

            },

            formErrorData: {

            }
        };
    },

    mounted() {
        this.prepareFormSettingData();
    },

    created() {
        this.initializeFormData();
    }
}