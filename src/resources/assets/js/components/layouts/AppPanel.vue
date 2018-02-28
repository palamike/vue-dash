<template>
    <div id="pmf-app-container" class="pmf-app-container" >
        <div :class="{ 'pmf-wrapper': true, 'pmf-sidebar-collapsed': sidebarCollapsedStyle } " :style="{ width: mainApplicationWidth }">
            <app-sidebar :is-sidebar-collapsed="isSidebarCollapsed"></app-sidebar>
            <div :style="{ width: mainPanelWidth }">
                <div class="pmf-topbar">
                    <div class="pmf-topbar-left">
                        <a @click.prevent="doCollapse" href="#" class="pmf-nav-icon"><i class="fa fa-bars"></i></a>
                        <div class="pmf-company-logo">
                            <span v-html="getCompanyName()"></span>
                        </div>
                    </div>
                    <div class="pmf-topbar-right">
                        <a @click.prevent="doLogout" href="#" class="pmf-logout-link"><i class="fa fa-sign-out pmt-logout-icon"></i> <span class="pmt-logout-text">Logout</span></a>
                    </div>
                </div>
                <div class="pmf-main-panel">
                    <slot></slot>
                </div>
            </div>
        </div>
        <div class="pmf-footer">&copy; {{ year }} {{ companyName }}</div>
    </div>
</template>
<script>

    import BlockUIMixin from '../../mixins/BlockUIMixin';
    import AppSidebar from '../../components/layouts/AppSidebar.vue';

    export default {

        name: 'AppPanel',

        components: { AppSidebar },

        mixins: [BlockUIMixin],

        methods: {
            doLogout() {
                this.blockUI();

                let request = axios.post('/logout', { });

                request.then((res) => {
                    this.unblockUI();
                    window.location = res.data.redirect;
                });

                request.catch((err) => {
                    this.unblockUI();
                    console.log(err.response);
                });
            },

            doCollapse() {
                if( ! this.isMobile ){
                    this.isSidebarCollapsed = !this.isSidebarCollapsed;

                    if(this.isSidebarCollapsed){
                        this.mainPanelWidth = (this.scrollWidth - 64) + 'px';
                    }
                    else{
                        this.mainPanelWidth = (this.scrollWidth - 220) + 'px';
                    }
                }

                this.sidebarCollapsedStyle = ! this.sidebarCollapsedStyle;

            },

            getCompanyName() {

                let company = window.pmfAppName;
                let part1 = company.substr(0,3);
                let part2 = company.substr(3);

                return `<strong>${part1}</strong>${part2}`;
            },
        },

        data() {
            return {
                sidebarCollapsedStyle: false, //must have style because of mobile support
                isSidebarCollapsed: false,
                isMobile: false,
                viewportWidth: 1280,
                scrollWidth: 1280,
                mainPanelWidth: '100%',
                mainApplicationWidth: '100%',
                mainApplicationHeight: '100vh',
                scrollControl: null,
                year: 2018,
                companyName: window.pmfAppName
            };
        },

        mounted() {
            this.viewportWidth = document.documentElement.clientWidth;
            this.scrollWidth = document.body.scrollWidth; //width without scrollbar
            this.mainApplicationHeight = document.body.scrollHeight + 'px'; //width without scrollbar
            window.pmf.isMobile = false;

            if(this.viewportWidth <= 768){
                this.isMobile = true;
                window.pmf.isMobile = true;
                this.mainPanelWidth = this.scrollWidth + 'px';
                this.mainApplicationWidth = (this.viewportWidth + 220) + 'px';
            }
            else {
                this.mainPanelWidth = (this.scrollWidth - 220) + 'px';
            }

            this.year = (new Date()).getFullYear();
        }
    }
</script>
<style lang="scss" type="text/scss">

    .pmf-app-container > .pmf-wrapper {
        display: grid;
        grid-template-columns: 220px auto;

        &.pmf-sidebar-collapsed {
            grid-template-columns: 64px auto;

            .el-menu--collapse {
                max-width: 63px;
            }
        }
    }

    @media only screen and (max-width: 768px) {

        .pmf-app-container {
            overflow-x: hidden;
        }

        .pmf-app-container > .pmf-wrapper {
            position: relative;
            left: -220px;

            &.pmf-sidebar-collapsed {
                left: 0;
                grid-template-columns: 220px auto;
            }
        }
    }

    .pmf-topbar {
        display: grid;
        grid-template-columns: auto 90px;
    }

    .pmf-topbar {
        height: 30px;
        padding: 10px 10px;
    }

    .pmf-topbar-right {
        text-align: right;
    }

    .pmf-nav-icon, .pmf-company-logo, .pmf-logout-link {
        display: inline-block;
    }

    .pmf-nav-icon {
        padding: 5px 8px;
        border: 1px solid whitesmoke;
        border-radius: 3px;
        color: white;

        &:hover {
            color: white;
            background-color: rgba(255,255,255,0.2);
            cursor: pointer;
        }

        &:visited, &:active {
            color: white;
        }
    }

    .pmf-logout-link {
        padding-top: 5px;
        color: white;

        &:hover {
            color: #EEE9A0;
        }
        
        @media only screen and (max-width: 768px) {
            .pmt-logout-text {
                display: none;
            }
        }
    }

    .pmf-company-logo {
        padding: 0 15px;
    }

    .pmf-footer {
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 300;
        color: white;
        background-color: #414343;
    }
</style>