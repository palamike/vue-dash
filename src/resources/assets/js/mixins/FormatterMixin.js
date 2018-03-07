

export default {

    methods: {
        formatDate(dt, format){

            if(!format){
                format = this.getDefaultDateFormat();
            }

            return moment(dt).format(format);
        },

        getDefaultDateFormat(){
            return 'YYYY-MM-DD';
        }
    }

}