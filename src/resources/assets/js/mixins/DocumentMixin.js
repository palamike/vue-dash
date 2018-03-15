export default {
    methods: {

        handleApproveActionForm() {

            this.handleSaveActionForm();
        },

        handleApproveActionForm() {

            this.blockUI();

            //clear form error data
            this.initializeFormErrorData();

            this.formData._command = 'submit';

            let endpoint = this.endpoints.update;

            let request = axios.post(endpoint, this.transformGridBeforeSaveData());

            request.then((res) => {
                this.handleGridSuccessApprove(res);
            });

            request.catch((err) => {
                this.handleGridErrorSave(err);
            });

        },

        handleGridSuccessApprove(res) {
            this.formData = this.transformGridViewData(res);
            this.isFormEdit = false;
            this.unblockUI();
            this.showView();
            this.showAlertSuccess(this.$t('common.success'), this.$t('success.save', { id: this.formData.id } ));
            window.scrollTo(0, 0);
        },

        handleCancelActionForm() {

            this.blockUI();

            //clear form error data
            this.initializeFormErrorData();

            let endpoint = this.endpoints.cancel;

            let request = axios.post(endpoint, { id: this.formData.id } );

            request.then((res) => {
                this.handleGridSuccessCancel(res);
            });

            request.catch((err) => {
                this.handleGridErrorCancel(err);
            });

        },

        handleGridSuccessCancel(res) {
            this.formData = this.transformGridViewData(res);
            this.unblockUI();
            this.showAlertSuccess(this.$t('common.success'), this.$t('success.cancel', { id: this.formData.id } ));
            window.scrollTo(0, 0);
        },

        handleGridErrorCancel(err) {
            this.unblockUI();

            //normal error message
            this.showAlertError(this.$t('common.error'), err.response.data.message );
        }

    }
}