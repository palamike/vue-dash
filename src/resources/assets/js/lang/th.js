import thLocale from 'element-ui/lib/locale/lang/th'

export default {

    sidebar: {
        dashboard: 'หน้าควบคุม',
        user_mgmt: 'จัดการผู้ใช้งาน',
        users: 'ผู้ใช้งาน',
        roles: 'บทบาท',
        setting_mgmt: 'การตั้งค่า',
        general_settings: 'ตั้งค่าทั่วไป',
    },

    common: {
        loading: 'กำลังทำงาน',
        error: 'มีข้อผิดพลาด',
        value_error: 'มีข้อผิดพลาดจากค่าตัวเลือก',
        option_error: 'มีข้อผิดพลาดจากตัวเลือกฟอร์ม',
        success: 'สำเร็จ',
        new: 'เพิ่ม',
        no_records_found: 'ไม่พบข้อมูล',
        delete_selected: 'ลบที่เลือก',
        please_select: 'โปรดเลือก',
        search_now: 'ค้นหา...',
        delete_now: 'กำลังจะลบ...',
        delete_selected_now: 'กำลังจะลบที่เลือก...',
        delete_selected_object: 'ท่านต้องการจะลบข้อมูลที่เลือก ?',
        delete_object: 'ข้อมูลเลขที่ {id} กำลังจะถูกลบ',
        submit: 'ส่งข้อมูล',
        confirm: 'ยืนยัน',
        cancel: 'ยกเลิก',
        search: 'ค้นหา',
        reset: 'เริ่มใหม่',
        close: 'ปิด',
        back: 'กลับ',
        info: 'ข้อมูล',
        add_object: 'เพิ่ม{name}',
        edit_object: 'แก้ไข{name}',
        save: 'จัดเก็บ',
        operations: 'จัดการ',
        to: 'ถึง'
    },

    date_picker: {
        today: 'วันนี้',
        this_week: 'สัปดาห์นี้',
        this_month: 'เดือนนี้',
        last_month: 'เดือนที่แล้ว',
        last_30days: '30 วันที่แล้ว',
        last_90days: '90 วันที่แล้ว'
    },

    error: {
        validation: 'ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบข้อมูลที่ระบุ'
    },

    success: {
        save: 'ข้อมูลเลขที่ {id} จัดเก็บเรียบร้อยแล้ว',
        deleted_object: 'ข้อมูลเลขที่ {id} ถูกลบเรียบร้อยแล้ว',
        deleted_selected_object: 'ข้อมูลที่เลือก ถูกลบเรียบร้อยแล้ว',
    },

    permission_groups: {
        user: 'การจัดการผู้ใช้งาน',
        role: 'การจัดการบทบาท',
        profile: 'จัดการบัญชีของตัวเอง',
        general_setting: 'การจัดการบทบาท'
    },

    permissions: {
        user_view: 'ดู',
        user_add: 'เพิ่ม',
        user_edit: 'แก้ไข',
        user_delete: 'ลบ',
        role_view: 'ดู',
        role_add: 'เพิ่ม',
        role_edit: 'แก้ไข',
        role_delete: 'ลบ',
        profile_update: 'แก้ไข',
        general_setting_update: 'แก้ไข'
    },

    modules: {
        profile: 'บัญชีของฉัน',
        role: 'บทบาท',
        roles: 'บทบาท',
        user: 'ผู้ใช้',
        users: 'ผู้ใช้',
        general_setting: 'การตั้งค่าทั่วไป',
        /**LANG_REPLACER**/
    },

    fields: {
        id: 'เลขที่',
        name: 'ชื่อ',
        title: 'ชื่อ',
        code: 'รหัส',
        description: 'คำอธิบาย',
        email: 'อีเมลล์',
        role: 'บทบาท',
        status: 'สถานะ',
        password: 'รหัสผ่าน',
        password_confirmation: 'ยืนยันรหัสผ่าน',
        permissions: 'สิทธิ์การเข้าถึง'
    },

    settings: {
        general_list_pagination: 'รายการต่อหน้า'
    },

    status: {
        active: 'Active',
        inactive: 'Inactive',
    },

    auth: {
        please_login: 'กรุณาใส่ชื่อผู้ใช้ และ รหัสผ่าน',
        login_email: 'อีเมลล์ของคุณ',
        login_name: 'ชื่อผู้ใช้',
        login_password: 'รหัสผ่านของคุณ',
        login_btn: 'เข้าสู่ระบบ',
    },

    validation: {
        required: 'โปรดระบุข้อมูลนี้'
    },

    ...thLocale
}