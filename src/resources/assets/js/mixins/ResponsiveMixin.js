export default {
    methods: {

        isMobile() {
            return window.pmf.isMobile;
        },

        responsive(desktop, mobile) {
            if(this.isMobile()){
                return mobile;
            }
            else{
                return desktop;
            }
        }

    }
}