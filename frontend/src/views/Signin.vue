<script setup>
import { onBeforeUnmount, onBeforeMount } from "vue";
import { useStore } from "vuex";
import Navbar from "@/examples/PageLayout/Navbar.vue"; 
import AppFooter from "@/examples/PageLayout/Footer.vue";
import ArgonInput from "@/components/ArgonInput.vue";
import ArgonSwitch from "@/components/ArgonSwitch.vue";
//import ArgonButton from "@/components/ArgonButton.vue";
const body = document.getElementsByTagName("body")[0];

const store = useStore();
onBeforeMount(() => {
  store.state.hideConfigButton = true;
  store.state.showNavbar = false;
  store.state.showSidenav = false;
  store.state.showFooter = false;
  body.classList.remove("bg-gray-100");
});
onBeforeUnmount(() => {
  store.state.hideConfigButton = false;
  store.state.showNavbar = true;
  store.state.showSidenav = true;
  store.state.showFooter = true;
  body.classList.add("bg-gray-100");
});
</script>
<template>
  <div class="container top-0 position-sticky z-index-sticky">
    <div class="row">
      <div class="col-12">
        <navbar isBlur="blur  border-radius-lg my-3 py-2 start-0 end-0 mx-4 shadow" v-bind:darkMode="true" isBtn="bg-gradient-success"/>
      </div> 
    </div>
  </div>
  <main class="mt-0 main-content">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0">
              <div class="card card-plain">
                <div class="pb-0 card-header text-start">
                  <h2 class="font-weight-bolder" style="text-align: center ">Connexion</h2>
                  <p class="mb-0">Veuillez entrer votre email et mot de passe pour se connecter</p>
                </div>
                <div class="card-body">
                  <form role="form">
                    <div class="mb-3">
                      <argon-input id="email" type="email" placeholder="Email" name="email" size="lg"/>
                    </div>
                    <div class="mb-3" >
                      <argon-input id="password" type="password" placeholder="Mot de passe" name="password" size="lg" />
                    </div>
                    <router-link to="/Forget" class="forget-pass">Mot de passe oublié</router-link> 
                    <argon-switch id="rememberMe" name="remember-me">Remember me</argon-switch>

                    <div class="text-center">
                      <router-link to="/dashboard-admin">
                      <button class="text-white font-weight-bolder" style="
                          background-color: #000080;
                          color: #fff;
                          border: none;
                          border-radius: 5px;
                          margin-top:5%;
                          padding: 8px;
                      " >Se connecter</button>
                      </router-link>
                    </div>
                  </form>
                </div>
                <div class="px-1 pt-0 text-center card-footer px-lg-2">
                  <p class="mx-auto mb-4 text-sm">
                    Vous n'avez pas un compte?
                    <router-link to="/signup" style="color:dark">S'inscrire</router-link>
                    
                  </p>
                </div>
              </div>
            </div>
            <div
              class="top-0 my-auto text-center col-6 d-lg-flex d-none h-100 pe-0 position-absolute end-0 justify-content-center flex-column"
       
                style="
                  background-image: url(https://pairroxz.com/blog/wp-content/uploads/2023/06/What-is-edtech-games-1-1536x681.png);
                  background-size: border-box;
                  background-position: center;
                "
              >
               <!-- <span class="mask bg-gradient-success opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">
                  "The Next Generation Era"
                </h4>
                <p class="text-white position-relative">
                  The Evolution of Innovation: Shaping Tomorrow's World
                </p>-->
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <app-footer/>
</template>
<style scoped>
.forget-pass{
  display: block;
    text-align: right;
    margin-top: -4%; /* Adjust margin-top */
    text-decoration: none;
}
.mb-0{
  margin-top:15%;
}
</style>

