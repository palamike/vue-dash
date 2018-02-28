<template>
  <transition name="el-alert-fade">
    <div
      class="el-alert"
      :class="[typeClass, center ? 'is-center' : '']"
      v-show="visible"
      role="alert"
    >
      <i class="el-alert__icon" :class="[ iconClass, isBigIcon ]" v-if="showIcon"></i>
      <div class="el-alert__content">
        <span class="el-alert__title" :class="[ isBoldTitle ]" v-if="title">{{ title }}</span>
        <slot>
          <p class="el-alert__description" v-if="description" v-html="description" ></p>
        </slot>
        <i class="el-alert__closebtn" :class="{ 'is-customed': closeText !== '', 'el-icon-close': closeText === '' }" v-show="closable" @click="close()">{{closeText}}</i>
      </div>
    </div>
  </transition>
</template>

<script type="text/babel">
  const TYPE_CLASSES_MAP = {
    'success': 'el-icon-success',
    'warning': 'el-icon-warning',
    'error': 'el-icon-error'
  };
  export default {
    name: 'PmfAlert',

    props: {
      title: {
        type: String,
        default: '',
        required: true
      },

      description: {
        type: String,
        default: ''
      },

      type: {
        type: String,
        default: 'info'
      },

      closable: {
        type: Boolean,
        default: true
      },

      visible: {
          type: Boolean,
          default: true
      },

      autoClose: {
          type: Boolean,
          default: true
      },

      autoCloseDelay: {
          type: Number,
          default: 20000,
      },

      loopId: {
          type: String,
          default: ''
      },

      closeText: {
        type: String,
        default: ''
      },

      showIcon: Boolean,
      center: Boolean
    },

    data() {
      return {

      };
    },

    methods: {
      close() {
        this.$emit('close');
        this.$emit('update:visible', false);
      },

      doAutoClose() {
          if (this.autoClose && this.visible){

              let loopId = this.loopId;
              let that = this;

              setTimeout(function(){
                  if (loopId === that.loopId){
                      that.close();
                  }
              }, this.autoCloseDelay);
          }
      }
    },

    computed: {
      typeClass() {
        return `el-alert--${ this.type }`;
      },

      iconClass() {
        return TYPE_CLASSES_MAP[this.type] || 'el-icon-info';
      },

      isBigIcon() {
        return this.description || this.$slots.default ? 'is-big' : '';
      },

      isBoldTitle() {
        return this.description || this.$slots.default ? 'is-bold' : '';
      }
    },

    mounted(){
        this.doAutoClose();
    },

    updated(){
        this.doAutoClose();
    }
  };
</script>
