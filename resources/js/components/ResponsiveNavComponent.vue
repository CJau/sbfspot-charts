<template>
  <div class="relative">
    <button class="md:hidden items-center px-3 py-2 border rounded text-blue-lighter border-blue-light hover:text-white hover:border-white" @click="toggleMenu">
      <svg class="fill-current text-blue-light hover:text-white h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
    </button>
    <div class="block bg-grey-light absolute md:static text-right pin-r md:pin-none mt-6 md:mt-0 py-1 shadow md:shadow-none" :class="{'hidden' : !visible}">
      <a v-for="item in items" class="block md:inline no-underline text-grey-darkest text-sm font-semibold hover:text-grey-dark py-2 pl-8 pr-3" :key="item.url" :href="item.url">{{ item.label }}</a>
    </div>
  </div>
</template>

<script>
  export default {
      props: [
        'items',
      ],

      data: function() {
        return {
          visible: true,
        };
      },

      methods: {
        toggleMenu: function() {
          this.visible = !this.visible;
        }
      }
    }
</script>