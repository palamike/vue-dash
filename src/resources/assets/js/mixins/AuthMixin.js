export default {
    methods: {

        /**
         *
         * get fully qualify permission name
         *
         * @param perm string should be action name such as add, edit, delete, view
         * @returns {string}
         */
        getPermissionName(perm){
            return this.permissionPrefix + '_' + perm;
        },

        /**
         *
         * check if current user has any permissions
         *
         * @param permissions array
         * @returns {boolean}
         */
        hasAnyPermissions(permissions){
            if(_.isArray(permissions) && (permissions.length > 0)){
                let intersection = _.intersection(permissions, this.authInfo.permissions);

                if(intersection.length > 0){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return true;
            }
        },

        hasPermission(permission) {

            if(Array.isArray(permission)) {

                //if has permissions input we need to check
                let result = true;

                permission.forEach( (perm) => {
                    result = result && this.authInfo.permissions.includes(perm);
                } );

                return result;
            }
            else {

                return this.authInfo.permissions.includes(permission);

            }


        },

        hasActionPermission(action) {
            return this.authPermissions[action];
        },

        prepareGridPermissions() {
            let perms = this.permissions;
            perms.forEach((action) => {
                let fullPermissionName = this.getPermissionName(action);
                this.authPermissions[action] = this.hasPermission(fullPermissionName);
            });
        },

        getUserName() {
            return this.authInfo.user_name;
        },

        getRoleName() {
            return this.authInfo.role_name;
        },

    },

    data() {
        return {
            authPermissions: {},
            authInfo: window.pmf.authInfo
        };
    },
}