export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'fanshop',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    '@/assets/css/animate.css',
    '@/assets/css/bootstrap.min.css',
    /*'@/assets/css/flag-icon.min.css',*/
    '@/assets/css/icofont.css',
    '@/assets/css/main.css',
    /*'@/assets/css/slick-theme.css',*/
    '@/assets/css/slick.css'

  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    '@nuxtjs/auth-next',
    'vue-sweetalert2/nuxt',
  ],

  auth: {
    strategies:{
      "local":{
        token: {
          property: 'access_token',
        },
        endpoints:{
          login:{url: '/login', method:"post"},
          logout:{url: '/logout', method:"post"},
          user:{url: '/user', method:"get"},
        },

      },
    },
      watchLoggedIn: true,
      redirect: {
        logout: '/',
        callback: '/login',
        home: '/'
      },
    },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL: 'http://localhost:8000/api',
  },

  // PWA module configuration: https://go.nuxtjs.dev/pwa
  pwa: {
    manifest: {
      lang: 'en'
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
