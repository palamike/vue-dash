export default {

    methods: {

        showAlertSuccess(title, description) {
            this.alertType = 'success';
            this.alertTitle = title;
            this.alertDescription = description;
            this.showAlert();
        },

        showAlertError(title, description) {
            this.alertType = 'error';
            this.alertTitle = title;
            this.alertDescription = description;
            this.showAlert();
        },

        showAlertInfo(title, description) {
            this.alertType = 'info';
            this.alertTitle = title;
            this.alertDescription = description;
            this.showAlert();
        },

        showAlertWarning(title, description) {
            this.alertType = 'warning';
            this.alertTitle = title;
            this.alertDescription = description;
            this.showAlert();
        },

        showAlert() {
            this.generateAlertLoopId();
            this.alertVisible = true;
        },

        hideAlert() {
            this.alertVisible = false;
        },

        generateAlertLoopId() {
            this.alertLoopId = btoa('alert-loop-id-' + (new Date()).getTime());
        }

    },

    data() {
        return {
            //alertType can be success/error/warning/info
            alertTitle: 'alert title',
            alertDescription: 'alert description',
            alertType: 'error',
            alertVisible: false,
            alertLoopId: '',
        };
    },

    mounted() {
        this.generateAlertLoopId();
    }

}