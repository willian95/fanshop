<template>
  <div class="mt-150 container mb-2">
    <Loading :loading="loading" />

    <div class="row" v-if="error">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h3 class="text-center">Producto no disponible</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="row" v-else>
      <div class="col-md-4">
        <VueSlickCarousel :dots="true" v-if="images.length > 0">
          <img
            class="custom-carousel-img img-responsive"
            v-for="(image, index) in images"
            v-bind:key="index"
            :src="image"
            alt=""
          />
        </VueSlickCarousel>
      </div>
      <div class="col-md-4">
        <div class="content-decription">
          <h3>{{ title }}</h3>
          <p class="description-product" v-html="description"></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="content-decription-pago">
          <div class="precio-detail">
            <p class="medium-fs">
              Precio:
              <span
                >S.
                {{
                  ((price + price * earnPercentage) * dolarPrice).toFixed(2)
                }}</span
              >
            </p>
          </div>
          <div v-if="price > maxPriceWithoutTax" class="precio-detail">
            <p class="medium-fs">
              Impuesto: USD {{ Math.ceil(price * maxPriceTax) }}
            </p>
            <p class="small-fs">
              Toda comprar mayor a {{ maxPriceWithoutTax }} USD tendrá un
              impuesto del {{ maxPriceTax * 100 }}%
            </p>
          </div>

          <div v-if="hasWeight == false" class="precio-detail">
            <p class="medium-fs">Precio de envío con cobro a destino</p>
          </div>

          <div v-if="weight > 0 && weight <= 1" class="precio-detail">
            <p class="medium-fs">Costo de envío: S. {{ 15 * dolarPrice }}</p>
          </div>

          <div v-if="weight > 1" class="precio-detail">
            <p class="medium-fs">
              Costo de envío: S.
              {{ (weightPrice * dolarPrice).toFixed(2) }}
            </p>
          </div>

          <div class="precio-detail">
            <p class="large-fs">
              Total: S. {{ (total * this.dolarPrice).toFixed(2) }}
            </p>
          </div>

          <!--<p>Agreegar el producto al carrito para conocer los costos de envio</p>-->
          <span class="metodo-img">
            <strong>Compra con</strong>
            <img src="/img/Metodos-Pago.png" alt="" />
          </span>
          <div class="text-center mt-3" v-if="isAuthenticated">
            
            <div v-if="productType == 'REGULAR'">

              <button
                class="btn btn-custom"
                @click="storeCart()"
                v-if="availability == true"
              >
                <img class="icon_btn" src="/img/cart-add.svg" alt="" />
                Agregar al carrito
              </button>
              <span v-else>Producto no disponible</span>

            </div>
            <div v-if="productType != '' && productType != 'REGULAR'">

              <h5>Este producto de Walmart contiene variaciones y actualmente no está soportado por el sitio</h5>

            </div>

            <!--<a href="carrito.html" class="btn-custom">
                            <img class="icon_btn" src="/img/add-white.svg" alt="">
                            Comprar
                        </a>-->
          </div>
          <div class="text-center mt-3" v-else>
            <p class="text-center">
              Debes ingresar a tu cuenta para poder comprar
            </p>
            <NuxtLink :to="{ path: '/login' }" class="btn btn-info"
              >login</NuxtLink
            >
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h3>Características:</h3>
        <p v-for="(feature, index) in features" v-bind:key="index">
          {{ feature }}
        </p>

        <div class="row mt-4 mb-4 border-bottom pb-3">
          <div class="col-md-6">
            <h5 class="">Disponibilidad: {{ availability ? "disponible" : "no disponible" }}</h5>
          </div>
        </div>

        <!--<h4>Variaciones:</h4>

        <div class="row" v-if="visibleSwatches.length == 0">
          <div class="col-md-3 mb-2 mt-2" v-for="variant in variations.variantData" v-bind:key="variant.productId" >
            <div class="card" :class="variant.isAvailable == 'Y' ? 'cursor-pointer' : ''" @click="getVariationInfo(variant.productPageUrl.replace('/ip/', ''), variant.isAvailable)">
              <div class="card-body">
                
                  
                  <p>{{ variant.variantValues[0].name.replace("_", " ") }} : {{ variant.variantValues[0].displayName }}</p>
                  <img :src="variant.productImageUrl" class="w-100">
                  <p style="font-size: 10px" v-if="variant.isAvailable == 'N'">No disponible</p>

              </div>

            </div>

          </div>
          
        </div>-->

        <h4>Detalles del producto</h4>

        <table class="table">
          <thead>
            <tr>
              <th>Detalle</th>
              <th>Descripción</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(detail, index) in productDetails" v-bind:key="index">
              <td>
                {{ detail.name }}
              </td>
              <td>
                <p>{{ detail.value }}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <Recommendations
          :asin="id"
          :searchType="searchType"
          :fetch="setId"
          :productCategory="productCategory"
          v-if="productCategory != ''"
        />
      </div>
    </div>
  </div>
</template>

<script>
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
import "vue-slick-carousel/dist/vue-slick-carousel-theme.css";

import Loading from "../../components/Loading";
import Recommendations from "../../components/Recommendations";

import { mapGetters } from "vuex";

export default {
  name: "productDetail",
  components: { VueSlickCarousel, Loading, Recommendations },
  data() {
    return {
      ref:"",
      fullObject: "",
      loading: true,
      images: [],
      title: "",
      description: "",
      features: [],
      price: 0,
      availability: "",
      minimalQuantity: 1,
      productCategory: "",
      id: "",
      searchType: "",
      error: false,
      productDetails: [],
      weight: 0,
      maxPriceWithoutTax: 0,
      maxPriceTax: 0,
      dolarPrice: 0,
      earnPercentage: 0,
      pricePerPound: 0,
      total: 0,
      usItem:"",
      showAddToCartButton: false,
      hasWeight:false,
      weightPrice:0,
      overpriceTax:0,
      variations: [],
      visibleSwatches:[],
      productType:"",
    };
  },
  computed: {
    ...mapGetters(["isAuthenticated", "loggedInUser"])
  },
  methods: {
    async storeCart() {
      this.loading = true;

      var destinationPayment = 0;
      if (this.weight == 0) {
        destinationPayment = 1;
      }

      let res = await this.$axios.post("/cart/store", {
        productId: this.id,
        searchType: this.$route.query.searchType,
        image: this.images[0],
        price: this.total,
        object: JSON.stringify(this.fullObject),
        amount: this.minimalQuantity,
        destinationPayment: destinationPayment,
        walmartUsItem:this.usItem
      });
      if (res.data.success == true) {
        this.$swal({
          icon: "success",
          toast: true,
          position: "top-end",
          text: res.data.msg
        });
      } else {
        this.$swal({
          icon: "error",
          toast: true,
          position: "top-end",
          text: res.data.msg
        });
      }
      this.loading = false;
    },
    setId(id) {
      this.fetch(id, this.searchType);
    },
    async fetch(id, searchType, ref) {
      this.clear();
      this.loading = true;

      this.id = id;
      this.searchType = searchType;
      this.ref = ref
      
      let res = await this.$axios.post("/product", {
        id: this.id,
        searchType: this.searchType
      });

      if (res.data.product[0].productInfo.imageUrlList) {

        this.images = res.data.product[0].productInfo.imageUrlList;
        this.productDetails = res.data.product[0].productInfo.productDetails;
        this.title = res.data.product[0].productInfo.productTitle;
        this.price = res.data.product[0].productInfo.price;
        this.availability = res.data.product[0].searchInfo.productDetails[0].inventory.availableOnline;
        this.features = res.data.product[0].productInfo.productHighlights;
        this.description = res.data.product[0].searchInfo.productDetails[0].description;
        this.productType = res.data.product[0].searchInfo.productDetails[0].productType

        //this.variations = res.data.product[0].searchInfo.productDetails[0].variants
        //this.visibleSwatches = res.data.product[0].searchInfo.productDetails[0].visibleSwatches
    
        
        let weight = res.data.product[0].productInfo.productDetails.filter(data => { return data.name == "Assembled Product Weight"})
        if(weight.length > 0){
          let value = weight[0].value.replaceAll("lbs", "")
          this.weight = parseFloat(value)
        }else{
          this.weight = 0
        }
        

        this.calculateTaxes(res);

        this.fullObject = res.data.product[0];
        

      } else {
        this.error = true;
      }
      this.loading = false;
    },
    setUrlVariation(index){
      
      let ref = ""
      let id = ""
      let value = $("#"+index).val()
      if(value.indexOf("ref=") > -1){
        ref = value.substring(value.indexOf("ref="), value.length)
      }

      if(value.indexOf("/dp/") > -1){
        id = value.replaceAll("/dp/", "")
        id = id.substring(0, id.indexOf("/"))
      }else{
        id = value
      }
    
      this.$router.push({path: "/product/"+id, query:{searchType: this.searchType, ref: ref}})
    },
    calculateTaxes(res) {
      this.weight = 0;
      this.maxPriceWithoutTax = res.data.configuration.max_price_without_tax;
      this.maxPriceTax = res.data.configuration.price_tax_percent;
      this.dolarPrice = res.data.configuration.dolar_price;
      this.earnPercentage = res.data.configuration.earn_percentage;
      this.pricePerPound = res.data.configuration.price_per_pound;
      let weightTax = 0;
      let priceTax = 0;

      if (res.data.product[0].productInfo.productDetails != null) {
        
        let weight = res.data.product[0].productInfo.productDetails.filter(data => {
          if (data.name.toLowerCase() == "item weight" || data.name.toLowerCase() == "assembled product weight") return data.value;
        });
        this.weight = 0;
        
        if (weight.length > 0) {
          
          
          if (weight[0]["value"].toLowerCase().indexOf("lb") > -1) {
            
            weight = weight[0]["value"]
              .toLowerCase()
              .substring(0, weight[0]["value"].indexOf("lb"));
              
            this.weight = parseFloat(weight);

            this.hasWeight = true

            if (weight <= 2.20 && this.hasWeight == true) {
                    
              weightTax = 15;
              this.weightPrice = weightTax
           
            } else if (weight > 1) {
              weightTax = this.weight * (this.pricePerPound * this.dolarPrice);
              this.weightPrice = weightTax
             
            }

          } /*else if (weight[0]["value"].toLowerCase().indexOf("ounce") > -1) {
            
            weight = weight[0]["value"]
              .toLowerCase().replace("ounces", "ounce")
              .substring(0, weight[0]["value"].indexOf("ounce"));
            weight = parseFloat(weight);
            
            this.hasWeight = true
            if (weight <= 16) {
              this.weight = 1;
              weightTax = 15;
              this.weightPrice = weightTax
             
            } else {
              this.weight = weight / 16;
              weightTax = this.weight * (this.pricePerPound * this.dolarPrice);
              this.weightPrice = weightTax
              
            }
          }*/
        }

        /*if(this.weight == 0){
            
          let iterateWeight = false
          let weight = res.data.product.productDetails.filter(data => {
            if (data.name.toLowerCase().trim() == "package dimensions" || data.name.toLowerCase().trim() == "product dimensions") return data.value;
          });

          this.weight = 0;

          if(weight.length != 0){
            iterateWeight = true
          }

          if(iterateWeight == true)
          {
            if (weight[0]["name"].length > 0) {
            weight = weight[0].value
            
            if(weight.indexOf(";") > -1){
                
              let weightString = weight.substring(weight.indexOf(";") + 1, weight.length).toLowerCase()
              if(weightString.indexOf("pound") > -1){

                this.weight = parseFloat(weightString.replace("pounds", "").replace("pound", "").trim())
                
                this.hasWeight = true

                if (weight <= 1 && this.hasWeight == true) {
                  
                  weightTax = 15;
                  this.weightPrice = weightTax
                  
                  
                } else if (weight > 1) {
                  weightTax = this.weight * (this.pricePerPound * this.dolarPrice);
                  this.weightPrice = weightTax
                  
                }

              }else if(weightString.indexOf("ounce") > -1){
                
                weight = parseFloat(weightString.replace("ounces", "").replace("ounce", "").trim())
                this.hasWeight = true
                
                if (weight <= 16) {
                  this.weight = 1;
                  weightTax = 15;
                  this.weightPrice = weightTax
          
                } else {
         
                  this.weight = this.weight / 16;
                  weightTax = this.weight * (this.pricePerPound * this.dolarPrice);
                  this.weightPrice = weightTax
                  
                }

              }

            }
          }
          }

        }*/
        
      }

      if (this.price > this.maxPriceWithoutTax) {
        this.overpriceTax = this.price * this.maxPriceTax * this.dolarPrice;
      }

      this.total = this.price + (this.price * this.earnPercentage) + this.weightPrice + this.overpriceTax;
    },
    clear() {
      window.scrollTo(0, 0);
      this.images = [];
      this.title = "";
      this.description = "";
      this.features = [];
      this.price = 0;
      this.availability = "";
      this.minimalQuantity = 1;
      this.variations = [];
    },
    async getVariationInfo(link, available){

      if(available == "Y"){

        this.loading = true

        let res = await this.$axios.post("/product", {
          id: link,
          searchType: this.searchType
        });

        this.price = res.data.product[0].productInfo.price
        this.title = res.data.product[0].productInfo.productTitle
        this.images = res.data.product[0].productInfo.imageUrlList;

        this.loading = false

      }

    }
  },
  created: async function() {
    this.usItem = this.$route.query.usItemId
    this.fetch(this.$route.params.id, this.$route.query.searchType);

  }
};
</script>

<style>
.custom-carousel-img {
  max-height: 400px;
}

.cursor-pointer {
  cursor: pointer;
}

.small-fs {
  font-size: 10px;
  margin-top: -10px;
}

.medium-fs {
  font-size: 16px;
}

.large-fs {
  font-size: 20px;
}

.variation-select > option{
  color: #000;
}

.variation-select > option:disabled{
  color: #bdc3c7;
}

</style>
