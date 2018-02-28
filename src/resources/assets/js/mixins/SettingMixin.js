export default {
    methods: {
        getSetting(key) {
            return window.pmf.settings[key];
        }
    }
}