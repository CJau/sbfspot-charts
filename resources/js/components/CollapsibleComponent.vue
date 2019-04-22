<template>
  <div>
    <div :class="buttonWrapperClass">
      <h3 class="inline-block align-middle">{{ title }}</h3>      
      <button class="btn-outline inline-block align-middle" type="button" @click.prevent="toggleCollapse">
        Show/Hide
      </button>
    </div>
    <div :class="[visible ? '' : 'hidden', collapsibleWrapperClass]">
      <slot></slot>
    </div>
  </div>
</template>

<script>
  export default {
      props: [
        'title',
        'buttonWrapperClass',
        'collapsibleWrapperClass'
      ],

      data: function() {
        return {
          visible: false,
        };
      },

      methods: {
        toggleCollapse: function() {
          this.visible = !this.visible;
        }
      }
    }
</script>