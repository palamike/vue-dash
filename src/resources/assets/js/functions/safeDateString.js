export default function (input, format = 'YYYY-MM-DD HH:mm:ss') {

    if( _.isString(input) ){
        return input;
    }
    else if( _.isDate(input) ) {
        return moment(input).format(format);
    }
    else {
        return '';
    }

}
