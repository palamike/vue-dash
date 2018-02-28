import Vue from 'vue';
import VueI18n from 'vue-i18n';
import ElementUI from 'element-ui';
import PmfAlert from '../../components/common/PmfAlert';
import LoginPanel from '../../components/auth/LoginPanel.vue';
import lang from '../../lang/th';


Vue.use(VueI18n);
Vue.use(ElementUI);

Vue.component(PmfAlert.name, PmfAlert);
Vue.component(LoginPanel.name, LoginPanel);

// Create VueI18n instance with options
const i18n = new VueI18n({
    locale: 'th', // set locale
    messages: { th: lang }, // set locale messages
});


// Create a Vue instance with `i18n` option
new Vue({

    el: '#app',
    i18n: i18n

});