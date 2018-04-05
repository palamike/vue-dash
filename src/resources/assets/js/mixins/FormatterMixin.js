

export default {

    methods: {
        formatDate(dt, format){

            if(!format){
                format = this.getDefaultDateFormat();
            }

            let date = moment(dt);

            if(date.isValid()) {
                return date.format(format);
            }

            return 'N/A';
        },

        getDefaultDateFormat(){
            return 'YYYY-MM-DD';
        }
    }

}