<!-- =========================================================================================
  File Name: ECommerceItemDetail.vue
  Description: eCommerce Item Detail page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="item-detail-page">

    <vs-alert color="danger" title="Error Fetching Product Data" :active.sync="error_occured">
      <span>{{ error_msg }}. </span>
      <span>
        <span>Check </span><router-link :to="{name:'ecommerce-shop'}" class="text-inherit underline">All Items</router-link>
      </span>
    </vs-alert>

    <vx-card v-if="item_data" :key="item_data.objectID">


      <template slot="no-body">

        <div class="item-content">

          <!-- Item Main Info -->
          <div class="product-details p-6">
            <div class="vx-row mt-6">
              <div class="vx-col md:w-2/5 w-full flex items-center justify-center">
                <div class="product-img-container w-3/5 mx-auto mb-10 md:mb-0">
                  <img src="https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/01.png" :alt="item_data.name" class="responsive">

                  <!--
                    UnComment Below line for true flow
                    <img :src="item_data.image" :alt="item_data.name" class="responsive">

                    Remove above img tag which is for demo purpose in actual flow
                  -->
                </div>
              </div>

              <!-- Item Content -->
              <div class="vx-col md:w-3/5 w-full">

                <h3>{{ item_data.name }}</h3>

                <p class="my-2">
                  <span class="mr-2">by</span>
                  <span>{{ item_data.brand }}</span>
                </p>
                <p class="flex items-center flex-wrap">
                  <span class="text-2xl leading-none font-medium text-primary mr-4 mt-2">${{ item_data.price }}</span>
                  <span class="pl-4 mr-2 mt-2 border border-solid d-theme-border-grey-light border-t-0 border-b-0 border-r-0"><star-rating :show-rating="false" :rating="item_data.rating" :star-size="20" read-only /></span>
                  <span class="cursor-pointer leading-none mt-2">424 ratings</span>
                </p>

                <vs-divider />

                <p>{{ item_data.description }}</p>

                <vs-list class="product-sales-meta-list px-0 pt-4">
                  <vs-list-item
                    v-if="item_data.free_shipping"
                    class="p-0 border-none"
                    title="Free Sheeping"
                    icon-pack="feather"
                    icon="icon-truck" />
                  <vs-list-item class="p-0 border-none" title="EMI options available" icon-pack="feather" icon="icon-dollar-sign"></vs-list-item>
                </vs-list>

                <vs-divider />

                <!-- Color -->
                <div class="vx-row">
                  <div class="vx-col w-full">
                    <span class="text-xl font-medium">Color</span>
                    <div class="flex flex-wrap items-center mt-2">
                      <div
                        :class="{'border-transparent': opt_color != color}"
                        class="color-radio rounded-full mx-1 border-2 border-solid cursor-pointer relative"
                        :style="itemColor({color: color, style: ['borderColor']})"
                        v-for="color in available_item_colors"
                        :key="color"
                        @click="opt_color=color">
                          <div class="h-6 w-6 rounded-full absolute" :style="itemColor({color: color, style: ['backgroundColor']})"></div>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /Color -->

                <vs-divider />

                <!-- Quantity -->
                <div class="vx-row">

                  <div class="vx-col w-full">
                    <p class="my-2">
                      <span>Available</span>
                      <span class="mx-2">-</span>
                      <span class="text-success">In Stock</span>
                    </p>
                  </div>

                  <div class="vx-col w-full">
                    <div class="flex flex-wrap items-start mb-4">

                      <!-- Add To Cart Button -->
                      <vs-button
                        class="mr-4 mb-4"
                        icon-pack="feather"
                        icon="icon-shopping-cart"
                        v-if="!isInCart(item_data.objectID)"
                        @click="toggleItemInCart(item_data)">
                        ADD TO CART
                      </vs-button>

                      <vs-button
                        v-else
                        class="mr-4 mb-4"
                        icon-pack="feather"
                        icon="icon-shopping-cart"
                        @click="$router.push({name: 'ecommerce-checkout'}).catch(err => {})">
                        VIEW IN CART
                      </vs-button>
                      <!-- /Add To Cart Button -->

                      <!-- Wishlist Button -->
                      <vs-button
                        v-if="isInWishList(item_data.objectID)"
                        key="filled"
                        class="mb-4"
                        icon-pack="feather"
                        icon="icon-heart"
                        color="danger"
                        @click="toggleItemInWishList(item_data)">
                        WHISHLIST
                      </vs-button>

                      <vs-button
                        v-else
                        key="border"
                        class="mb-4"
                        type="border"
                        icon-pack="feather"
                        icon="icon-heart"
                        color="danger"
                        @click="toggleItemInWishList(item_data)">
                        WHISHLIST
                      </vs-button>
                      <!-- /Wishlist Button -->

                    </div>
                  </div>
                </div>
                <!-- /Quantity -->

                <div class="vx-row">
                  <div class="vx-col flex flex-wrap items-center">
                    <vs-button class="mr-4" type="border" icon-pack="feather" color="#1551b1" icon="icon-facebook" radius></vs-button>
                    <vs-button class="mr-4" type="border" icon-pack="feather" color="#00aaff" icon="icon-twitter" radius></vs-button>
                    <vs-button class="mr-4" type="border" icon-pack="feather" color="#c4302b" icon="icon-youtube" radius></vs-button>
                    <vs-button class="mr-4" type="border" icon-pack="feather" color="#405DE6" icon="icon-instagram" radius></vs-button>
                  </div>
                </div>

              </div>

            </div>
          </div>

          <!-- Product Feature/Meta Row -->
          <div class="py-24 mb-16 mt-10 text-center item-features">
            <div class="vx-row">
              <div class="vx-col md:w-1/3 w-full">
                <div class="w-64 mx-auto mb-16 md:mb-0">
                  <feather-icon icon="AwardIcon" svgClasses="h-12 w-12 text-primary stroke-current" class="block mb-4" />
                  <span class="font-semibold text-lg">100% Original</span>
                  <p class="mt-2">Chocolate bar candy canes ice cream toffee cookie halvah.</p>
                </div>
              </div>
              <div class="vx-col md:w-1/3 w-full">
                <div class="w-64 mx-auto mb-16 md:mb-0">
                  <feather-icon icon="ClockIcon" svgClasses="h-12 w-12 text-primary stroke-current" class="block mb-4" />
                  <span class="font-semibold text-lg">10 Day Replacement</span>
                  <p class="mt-2">Marshmallow biscuit donut dragée fruitcake wafer.</p>
                </div>
              </div>
              <div class="vx-col md:w-1/3 w-full">
                <div class="w-64 mx-auto">
                  <feather-icon icon="ShieldIcon" svgClasses="h-12 w-12 text-primary stroke-current" class="block mb-4" />
                  <span class="font-semibold text-lg">1 Year Warranty</span>
                  <p class="mt-2">Cotton candy gingerbread cake I love sugar sweet.</p>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Related Products -->
        <div class="related-products text-center px-6">

          <div class="related-headings mb-8 text-center">
            <h2 class="uppercase">Related Products</h2>
            <p>People also search for this items</p>
          </div>
          <swiper :options="swiperOption" :dir="$vs.rtl ? 'rtl' : 'ltr'" :key="$vs.rtl" class="related-product-swiper px-12 py-6">
            <swiper-slide v-for="item in related_items" :key="item.objectId" class="p-6 rounded cursor-pointer">

              <!-- Item Heading -->
              <div class="item-heading mb-4">
                <p class="text-lg font-semibold truncate">{{ item.name }}</p>
                <p class="text-sm">
                  <span class="mr-2">by</span>
                  <span>{{ item.brand }}</span>
                </p>
              </div>

              <!-- Item Image -->
              <div class="img-container w-32 mx-auto my-base">
                <img class="responsive" :src="item.image" :alt="item.name">
              </div>

              <!-- Item Meta -->
              <div class="item-meta">
                <star-rating :show-rating="false" :rating="item.rating" :star-size="14" class="justify-center" read-only />
                <p class="text-lg font-medium text-primary">${{ item.price }}</p>
              </div>
            </swiper-slide>
            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next" slot="button-next"></div>
          </swiper>
        </div>

      </template>
    </vx-card>
  </div>
</template>

<script>
import 'swiper/dist/css/swiper.min.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import algoliasearch from 'algoliasearch/lite'
import StarRating from 'vue-star-rating'

export default{
  components: {
    swiper,
    swiperSlide,
    StarRating
  },
  data() {
    return {
      algolia_index: algoliasearch(
        'latency',
        '6be0576ff61c053d5f9a3225e2a90f76'
      ).initIndex("instant_search"),
      item_data: null,
      error_occured: false,
      error_msg: "",

      // Related Products Swiper
      swiperOption: {
          slidesPerView: 5,
          spaceBetween: 55,
          breakpoints: {
              1600: {
                slidesPerView: 4,
                spaceBetween: 55,
              },
              1300: {
                slidesPerView: 3,
                spaceBetween: 55,
              },
              900: {
                  slidesPerView: 2,
                  spaceBetween: 55
              },
              640: {
                  slidesPerView: 1,
                  spaceBetween: 55
              }
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
          }
      },

      // Below is data which is common in any item
      // Algolia's dataSet don't provide this kind of data. So, here's dummy data for demo
      available_item_colors: ["#7367F0", "#28C76F", "#EA5455", "#FF9F43", "#1E1E1E"],
      opt_color: "#7367F0",
      is_hearted: false,

      related_items: [{
        "name"       : "Apple - Apple Watch Series 1 42mm Space Gray Aluminum Case Black Sport Band - Space Gray Aluminum",
        "brand"      : "Apple",
        "price"      : 229,
        "image"      : "https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/01.png",
        "rating"     : 4,
        "objectID"   : "5546604",
      },
      {
        "name"       : "Beats by Dr. Dre - Powerbeats2 Wireless Earbud Headphones - Black/Red",
        "brand"      : "Beats by Dr. Dre",
        "price"      : 199.99,
        "image"      : "https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/08.png",
        "rating"     : 4,
        "objectID"   : "5565002",
      },
      {
        "name"       : "Amazon - Fire TV Stick with Alexa Voice Remote - Black",
        "brand"      : "Amazon",
        "price"      : 39.99,
        "image"      : "https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/03.png",
        "rating"     : 4,
        "objectID"   : "5477500",
      },
      {
        "name"       : "Apple - Apple Watch Nike+ 42mm Silver Aluminum Case Silver/Volt Nike Sport Band - Silver Aluminum",
        "brand"      : "Apple",
        "price"      : 399,
        "image"      : "https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/07.png",
        "rating"     : 4,
        "objectID"   : "5547700",
      },
      {
        "name"       : "Google - Chromecast Ultra - Black",
        "brand"      : "Google",
        "price"      : 69.99,
        "image"      : "https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/05.png",
        "rating"     : 4,
        "objectID"   : "5578628",
      },
      {
        "name"       : "Beats by Dr. Dre - Beats EP Headphones - White",
        "brand"      : "Beats by Dr. Dre",
        "price"      : 129.99,
        "image"      : "https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/02.png",
        "rating"     : 4,
        "objectID"   : "5577781",
      },
      {
        "name"       : "LG - 40\" Class (39.5\" Diag.) - LED - 1080p - HDTV - Black",
        "brand"      : "LG",
        "price"      : 279.99,
        "image"      : "https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/products/09.png",
        "rating"     : 4,
        "objectID"   : "5613404",
      }]
    }
  },
  computed: {
    item_qty() {
      const item = this.$store.getters['eCommerce/getCartItem'](this.item_data.objectID)
      return Object.keys(item).length ? item.quantity : 1
    },
    itemColor() {
      return (obj) => {
        let style_obj = {}

        obj.style.forEach(p => { style_obj[p] = obj.color })

        return style_obj
      }
    },
    isInWishList() {
        return (itemId) => this.$store.getters['eCommerce/isInWishList'](itemId)
    },
    isInCart() {
      return (itemId) => this.$store.getters['eCommerce/isInCart'](itemId)
    },
  },
  methods: {
    toggleItemInWishList(item) {
      this.$store.dispatch('eCommerce/toggleItemInWishList', item)
    },
    toggleItemInCart(item) {
      this.$store.dispatch('eCommerce/toggleItemInCart', item)
    },
    fetch_item_details(id) {
      this.algolia_index.getObject(id, (err, content) => {
        if(err) {
          this.error_occured = true
          this.error_msg = err.message
          console.error(err);
        }else {
          this.item_data = content
        }
      })

    }
  },
  created() {
    this.fetch_item_details(this.$route.params.item_id)
  }
}
</script>

<style lang="scss">

@import "@/assets/scss/vuexy/_variables.scss";

#item-detail-page {
  .color-radio {
    height: 2.28rem;
    width: 2.28rem;

    > div {
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  }

  .item-features {
    background-color: #f7f7f7;

    .theme-dark & {
      background-color: $theme-dark-secondary-bg;
    }
  }

  .product-sales-meta-list {
    .vs-list--icon {
      padding-left: 0;
    }
  }

  .related-product-swiper {
      // padding-right: 2rem;
      // padding-left: 2rem;

    .swiper-wrapper {
      padding-bottom: 2rem;

      > .swiper-slide {
        background-color: #f7f7f7;
        box-shadow: 0 4px 18px 0 rgba(0,0,0,0.1), 0 5px 12px 0 rgba(0,0,0,0.08) !important;

        .theme-dark & {
          background-color: $theme-light-dark-bg;
        }
      }
    }

    .swiper-button-next,
    .swiper-button-prev {
      transform: scale(.5);
      filter: hue-rotate(40deg);
    }

    .swiper-button-next {
      right: 0
    }

    .swiper-button-prev {
      left: 0;
    }
  }
}
</style>
