import lodash from 'lodash';
import axios from 'axios';
import moment from 'moment';
import decrypt from './functions/decrypt';

export default function() {

    window._ = lodash;

    window.moment = moment;

    /**
     * We'll load the axios HTTP library which allows us to easily issue requests
     * to our Laravel back-end. This library automatically handles sending the
     * CSRF token as a header based on the value of the "XSRF" token cookie.
     */

    window.axios = axios;

    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    window.axios.defaults.baseURL = document.head.querySelector('meta[name="base-url"]').content;

    window.pmf = { baseURL: window.axios.defaults.baseURL, authInfo: decrypt(window.pmfLicenseInfo) };
    window.pmf.settings = decrypt(window.pmfSettings);

    //console.log('window.pmf', window.pmf);

    /**
     * Next we will register the CSRF Token as a common header with Axios so that
     * all outgoing HTTP requests automatically have it attached. This is just
     * a simple convenience so we don't have to attach every token manually.
     */

    let token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

}//end export default
