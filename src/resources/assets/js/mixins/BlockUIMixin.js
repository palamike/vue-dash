export default {
    methods: {
        blockUI() {
            if(!this.blockUIInstance){
                this.blockUIInstance = this.$loading({
                    target: '.pmf-app-container',
                    lock: true,
                    text: this.$t('common.loading'),
                    spinner: 'el-icon-loading',
                    background: 'rgba(255, 255, 255, 0.5)'
                });
            }
        },

        unblockUI() {
            if(this.blockUIInstance){
                this.blockUIInstance.close();
                this.blockUIInstance = null;
            }
        }
    },

    data() {
        return {
            blockUIInstance: null
        };
    }
}