<template>
  <div class="relative">
    <button class="items-center px-3 py-2 border rounded md:hidden text-blue-lighter border-blue-light hover:text-white hover:border-white" @click="toggleMenu">
      <svg class="w-3 h-3 text-blue-400 fill-current hover:text-white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
    </button>
    <div class="absolute py-1 mt-6 text-right bg-gray-400 shadow md:block md:static pin-r md:pin-none md:mt-0 md:shadow-none" :class="{'hidden' : !visible}">
      <a v-for="item in items" class="block py-2 pl-8 pr-3 text-sm font-semibold text-gray-900 no-underline md:inline hover:text-gray-600" :key="item.url" :href="item.url">{{ item.label }}</a>
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
          visible: false,
        };
      },

      methods: {
        toggleMenu: function() {
          this.visible = !this.visible;
        }
      }
    }
</script>