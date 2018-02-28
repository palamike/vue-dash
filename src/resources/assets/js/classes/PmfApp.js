import Vue from 'vue';
import VueI18n from 'vue-i18n';
import ElementUI from 'element-ui';
import PmfAlert from '../components/common/PmfAlert';
import FormSection from '../components/common/FormSection';
import lang from '../lang/th';
import AppPanel from '../components/layouts/AppPanel.vue';

/**
 * Palamike Framework App
 */
class PmfApp {

    /**
     *
     * @param component the vue component
     */
    constructor(component) {

        Vue.use(VueI18n);

        // Create VueI18n instance with options
        const i18n = new VueI18n({
            locale: 'th', // set locale
            messages: { th: lang }, // set locale messages
        });

        Vue.use(ElementUI,{
            i18n: (key, value) => i18n.t(key, value)
        });

        Vue.component(FormSection.name, FormSection);
        Vue.component(PmfAlert.name, PmfAlert);
        Vue.component(AppPanel.name, AppPanel);

        Vue.component(component.name, component);


        // Create a Vue instance with `i18n` option
        this.instance = new Vue({

            el: '#app',
            i18n: i18n

        });
    }
}

export default PmfApp;