export default {

    methods: {

        /**
         * @param search string search string
         * @param singular string object singular name
         * @param plural string object plural name
         */
        remoteOptionSearch(search, singular, plural){

            if(!(search && search.length > 1)) {
                return;
            }

            let searchProperty = singular + 'Search';

            this.$set(this.loading, searchProperty, true);
            let request = axios.post(this.endpoints[singular + 'Search'], { search: search } );

            request.then((res) => {
                this.$set(this.formOptions, plural, res.data.objects);
                this.$set(this.loading, searchProperty, false);
            });

            request.catch((err) => {
                this.handleFormOptionErrorGet(err);
                this.$set(this.loading, searchProperty, false);
            });

        },
    }

}