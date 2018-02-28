export default {

    methods: {
        getValidationError(field) {

            let errors = this.getValidationDataObject();

            if(errors[field]){
                return errors[field][0];
            }
            else{
                return '';
            }

        },

        getValidationErrorArray(prop, field, index) {

            let errors = this.getValidationDataObject();
            let rowFieldName = `${prop}.${index}.${field}`;

            if(errors[rowFieldName]){

                let msg = errors[rowFieldName][0];

                msg = msg.replace(rowFieldName, this.$t('fields.' + field));

                return msg;
            }
            else{
                return '';
            }
        },

        getValidationErrorObject(prop, field, label){

            let errors = this.getValidationDataObject();
            let rowFieldName = `${prop}.${field}`;

            if(errors[rowFieldName]){

                let msg = errors[rowFieldName][0];

                msg = msg.replace(rowFieldName, label );

                return msg;
            }
            else{
                return '';
            }
        },

        getValidationDataObject() {
            return this.validationErrors;
        }
    },

}