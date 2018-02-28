/**
 *
 * This function truncate date time string in to date only
 *
 * @param date_time_string
 */
export default function (date_time_string) {

    if( _.isString(date_time_string) ) {
        if(date_time_string) {
            return date_time_string.substr(0,10);
        }
        else {
            return '';
        }
    }
    else if( _.isDate(date_time_string) ) {

        return moment(date_time_string).format('YYYY-MM-DD');

    }
    else {
        return '';
    }

}