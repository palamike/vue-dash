import GridTopbar from '../components/layouts/GridTopbar.vue';
import BlockUIMixin from './BlockUIMixin';
import SettingMixin from './SettingMixin';
import AuthMixin from './AuthMixin';
import ValidationMixin from './ValidationMixin';
import Promise from 'bluebird';
import truncateDate from '../functions/truncateDate';
import safeDateString from '../functions/safeDateString';

export default {

    components: { GridTopbar },

    mixins: [ BlockUIMixin, SettingMixin, AuthMixin, ValidationMixin ],

    methods: {

        truncateDate(date_time_str) {
            return truncateDate(date_time_str);
        },

        safeDateString(input) {
            return safeDateString(input);
        },

        showGrid() {
            this.isGridVisible = true;
            this.isViewVisible = false;
            this.isFormVisible = false;
            this.gridQuery();
        },

        showForm() {
            this.isGridVisible = false;
            this.isViewVisible = false;
            this.isFormVisible = true;
        },

        showView() {
            this.isGridVisible = false;
            this.isViewVisible = true;
            this.isFormVisible = false;
        },

        gridQuery(){

            this.blockUI();

            let request = axios.post(this.endpoints.grid, this.gridQueryObject);

            request.then((res) => {
                this.handleGridSuccessQuery(res);
            });

            request.catch((err) => {
                this.handleGridErrorQuery(err);
            });

            return request;
        },

        gridSearch(form) {
            this.gridQueryObject.search = form;
            this.gridQuery();
        },

        gridReset() {
            this.gridQueryObject.sort = {};
            this.gridQueryObject.search = { field: null, value: null };
            this.gridQueryObject.pagination = 25;
            this.gridQueryObject.page = 1;
            this.gridQuery();
        },

        transformGridData(res) {
            return res.data.grid;
        },

        handleGridSuccessQuery(res) {
            this.grid = this.transformGridData(res);
            this.unblockUI();
            window.scrollTo(0, 0);
        },

        handleGridErrorQuery(err) {
            console.log('handleGridErrorQuery',err.response);
            this.unblockUI();
            this.showAlertError(this.$t('common.error'), err.response.data.message );
        },

        handleGridSelectionChange(val) {
            this.gridSelection = val;
        },

        handleGridSortChange(sort) {
            //clear sort first
            this.gridQueryObject.sort = {};
            this.gridQueryObject.sort[sort.prop] = sort.order === 'ascending' ? 'asc' : 'desc';
            this.gridQuery();
        },

        handleGridDelete(id) {
            console.log('id', id);
            this.selectedGridRowId = id;
            this.isGridDeleteDialogVisible = true;
        },

        handleGridDeleteRemote() {

            let id = this.selectedGridRowId;

            this.blockUI();

            let request = axios.post(this.endpoints.delete, {id: id});

            request.then((res) => {
                this.handleGridSuccessDelete(res);
            });

            request.catch((err) => {
                this.handleGridErrorDelete(err);
            });

        },

        handleGridSuccessDelete(res){
            this.isGridDeleteDialogVisible = false;
            this.showAlertSuccess(this.$t('common.success'), this.$t('success.deleted_object', { id: res.data.id }));
            this.gridQuery();
        },

        handleGridErrorDelete(err){
            console.log('handleGridErrorDelete',err.response);
            this.unblockUI();
            this.isGridDeleteDialogVisible = false;
            this.showAlertError(this.$t('common.error'), err.response.data.message );
        },

        handleGridDeleteSelected() {

            this.isGridDeleteSelectedDialogVisible = true;

        },

        handleGridDeleteSelectedRemote() {

            let ids = _.map(this.gridSelection, 'id');

            this.blockUI();

            let request = axios.post(this.endpoints.deleteSelected, {ids: ids});

            request.then((res) => {
                this.handleGridSuccessDeleteSelected(res);
            });

            request.catch((err) => {
                this.handleGridErrorDeleteSelected(err);
            });

        },

        handleGridSuccessDeleteSelected(res) {
            this.isGridDeleteSelectedDialogVisible = false;
            this.showAlertSuccess(this.$t('common.success'), this.$t('success.deleted_selected_object'));
            this.gridQuery();
        },

        handleGridErrorDeleteSelected(err) {

            console.log('handleGridErrorDeleteSelected',err.response);
            this.unblockUI();
            this.isGridDeleteSelectedDialogVisible = false;
            this.showAlertError(this.$t('common.error'), err.response.data.message );

        },

        handleGridPageSizeChange(val) {
            this.gridQueryObject.pagination = val;
            this.gridQuery();
        },

        handleGridPageCurrentChange(val) {
            this.gridQueryObject.page = val;
            this.gridQuery();
        },

        handleCloseViewForm() {
            this.showGrid();
        },

        handleGridView(id) {

            this.blockUI();

            let request = axios.post(this.endpoints.view, {id: id});

            request.then((res) => {
                this.handleGridSuccessView(res);
            });

            request.catch((err) => {
                this.handleGridErrorView(err);
            });

        },

        handleGridSuccessView(res){

            /** Deprecated (use viewData Instead) **/
            this.formData = this.transformGridViewData(res);

            this.viewData = this.transformGridViewData(res);
            this.unblockUI();
            this.showView();

        },

        transformGridViewData(res) {
            return res.data.object;
        },

        handleGridErrorView(err){
            console.log('handleGridErrorView',err.response);
            this.unblockUI();
            this.showAlertError(this.$t('common.error'), err.response.data.message );
        },

        handleGridEdit(id) {

            this.hideAlert();
            this.initializeFormErrorData();

            this.blockUI();

            let request = axios.post(this.endpoints.view, {id: id});

            request.then((res) => {
                this.handleGridSuccessEdit(res);
            });

            request.catch((err) => {
                this.handleGridErrorEdit(err);
            });

        },

        handleGridSuccessEdit(res){
            this.isFormEdit = true;
            this.formData = this.transformGridEditData(res);
            this.unblockUI();
            this.showForm();
        },

        transformGridEditData(res) {
            return res.data.object;
        },

        handleGridErrorEdit(err){
            console.log('handleGridErrorEdit',err.response);
            this.unblockUI();
            this.showAlertError(this.$t('common.error'), err.response.data.message );
        },

        handleCloseActionForm() {
            this.showGrid();
        },

        transformGridBeforeSaveData() {
            return this.formData;
        },

        handleSaveActionForm() {

            this.blockUI();

            //clear form error data
            this.initializeFormErrorData();

            let endpoint = this.endpoints.create;

            if(this.isFormEdit){
                endpoint = this.endpoints.update;
            }

            let request = axios.post(endpoint, this.transformGridBeforeSaveData());

            request.then((res) => {
                this.handleGridSuccessSave(res);
            });

            request.catch((err) => {
                this.handleGridErrorSave(err);
            });

        },

        transformGridSuccessSaveData(res) {
            return res.data.object;
        },

        transformGridErrorData(res) {
            return res.data.errors;
        },

        handleGridSuccessSave(res) {
            this.formData = this.transformGridSuccessSaveData(res);
            this.isFormEdit = true;
            this.unblockUI();
            this.showAlertSuccess(this.$t('common.success'), this.$t('success.save', { id: this.formData.id } ));
            window.scrollTo(0, 0);
        },

        handleGridErrorSave(err) {
            console.log('handleGridErrorEdit',err.response);
            this.unblockUI();

            let response = err.response;

            // handle validation error.
            if( response.status === 422 ){
                this.showAlertError(this.$t('common.error'), this.$t('error.validation') );
                this.formErrorData = this.transformGridErrorData(response);
            }
            else{
                //normal error message
                this.showAlertError(this.$t('common.error'), err.response.data.message );
            }

        },

        getValidationError(field) {
            if(this.formErrorData[field]){
                return this.formErrorData[field][0];
            }
        },

        initializeFormErrorData() {
            this.formErrorData = {};
        },

        initializeFormData() {
            this.formData = this.initializeFormDataValue();
        },

        initializeFormDataValue() {
            return {};
        },

        /**
         *
         * This will use for retrieve options with ajax and then initialize the form data
         *
         */
        initializeForm() {
            return new Promise((resolve, reject) => {
                try {
                    this.initializeFormData();
                    return resolve(this.formData);
                }
                catch (e) {
                    console.log(e);
                    return reject(e);
                }
            });

        },

        handleGridCreate() {
            this.isFormEdit = false;
            this.initializeFormErrorData();
            this.hideAlert();
            this.blockUI();
            this.initializeForm().then(() => {
                this.showForm();
            }).finally(() => {
                setTimeout(() => { this.unblockUI(); }, 500);
            });
        },

        handleFormOptionErrorGet(err) {
            console.log('handleFormOptionErrorGet',err.response);
            this.unblockUI();
            this.showAlertError(this.$t('common.option_error'), err.response.data.message );
        },

        handleFormRelateValueErrorGet(err) {
            console.log('handleFormRelateValueErrorGet',err.response);
            this.unblockUI();
            this.showAlertError(this.$t('common.value_error'), err.response.data.message );
        },

        getGridStartDate() {
            return moment().subtract( parseInt(this.getSetting('general_query_date_range')) - 1, 'days').format('YYYY-MM-DD');
        },

        getGridEndDate() {
            return moment().format('YYYY-MM-DD');
        }
    },

    data() {
        return {
            grid: {
                data: [],
                total: 0
            },

            gridQueryObject: {
                sort: { },
                search: {
                    field: null,
                    value: null,
                    startDate: this.getGridStartDate(),
                    endDate: this.getGridEndDate()
                },
                page: 1,
                pagination: parseInt(this.getSetting('general_list_pagination')),
            },

            selectedGridRowId: 0,

            isGridDeleteDialogVisible: false,
            isGridDeleteSelectedDialogVisible: false,

            gridPageSizes: [25, 50, 100, 150, 200],

            gridSelection: [],

            isGridVisible: true,
            isViewVisible: false,
            isFormVisible: false,

            isFormEdit: false,

            formData: this.initializeFormDataValue(),
            viewData: {},

            formErrorData: {

            }

        };
    },

    computed: {
        hasSelectedGridRow() {
            return this.gridSelection.length > 0 ? true: false;
        }
    },

    created() {
        //prepareGridPermission
        this.prepareGridPermissions();
    },

    mounted() {
        this.gridQuery();
    },
}