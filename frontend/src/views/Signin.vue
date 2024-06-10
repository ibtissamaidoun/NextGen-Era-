<script setup>
import { ref, onBeforeMount, onBeforeUnmount } from 'vue';
import { useStore } from 'vuex';
// Importing components
import Navbar from "@/examples/PageLayout/Navbar.vue"; 
import AppFooter from "@/examples/PageLayout/Footer.vue";
import ArgonInput from "@/components/ArgonInput.vue";
import ArgonSwitch from "@/components/ArgonSwitch.vue";
// import ArgonButton from "@/components/ArgonButton.vue"; // Commented out if not used

// Getting references to document body, router, and store
const body = document.getElementsByTagName("body")[0];
const store = useStore();
// Setting up state variables
const user = ref({
  email: '',
  mot_de_passe: '',
});
const error = ref('');
const loading = ref(false);

// Setup for mounting and unmounting the component
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

// Function to handle login submission
async function submitLogin() {
  loading.value = true;
  try {
    await store.dispatch('login', user.value);
    setTimeout(() => {
      const role = store.getters.userRole;
      console.log('User Role:', role); 
      switch (role) {
        case "admin":
          store.dispatch('navigateTo', {
            route: '/dashboard-admin',
            navbar: true,
            sidenav: true,
            footer: true,
            hideConfigButton: false
          });
          break;
        case "animateur":
          store.dispatch('navigateTo', {
            route: '/dashboard-animateurs',
            navbar: true,
            sidenav: true,
            footer: true,
            hideConfigButton: false
          });
          break;
        default:
          store.dispatch('navigateTo', {
            route: '/dashboard-parents',
            navbar: true,
            sidenav: true,
            footer: true,
            hideConfigButton: false
          });
          break;
        }
      }, 100);
    } catch (e) {
    error.value = e.message || 'An error occurred during login';
    console.error('Login failed:', e);
  } finally {
    loading.value = false;
  }
}
</script>


<!-- <script setup>
import { ref, onBeforeMount, onBeforeUnmount, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useStore, mapGetters, mapActions } from 'vuex';
import http from '@/services/http';

// Composants
import Navbar from "@/examples/PageLayout/Navbar.vue"; 
import AppFooter from "@/examples/PageLayout/Footer.vue";
import ArgonInput from "@/components/ArgonInput.vue";
import ArgonSwitch from "@/components/ArgonSwitch.vue";

const body = document.getElementsByTagName("body")[0];
const router = useRouter();
const store = useStore();

const user = ref({
  email: '',
  password: '',
});
const error = ref('');
const showPassword = ref(false);
const loading = ref(false);



const password = computed(() => {
  return showPassword.value ? 'text' : 'password';
});

// function togglePasswordVisibility() {
//   showPassword.value = !showPassword.value;
// }
      async function submitLogin() {
  try {
    const response = await submitLogin(user.value);
    if (response.isAuthenticated) {
      const userType = store.getters['auth/user'].type;
      switch (userType) {
        case 'parent':
          router.push('/dashboard-parents');
          break;
        case 'admin':
          router.push('/dashboard-admin');
          break;
        case 'animateur':
          router.push('/dashboard-animateurs');
          break;
        default:
          router.push('/');
      }
      // store.commit('auth/login', response.data.user);
      // router.push('/dashboard'); // Redirect to dashboard or another page
    } else {
      error.value = 'Invalid username or password'; // Set error message
    }
  } catch (e) {
    console.error('Login failed', e);
    error.value = 'error'; // Set error message if there was a problem with the request
  }
  loading.value = false;
}
</script> -->
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
                  <form role="form"  @submit.prevent="submitLogin" >
                    <div class="mb-3">
                      <argon-input v-model="user.email" :type="email" id="email"  placeholder="Email" name="email" size="lg"/>
                    </div>   
                    <div class="mb-3" >
                      <argon-input v-model="user.mot_de_passe" :type="password" id="password"  placeholder="Mot de passe" name="password" size="lg" />
                    <!-- <div class="absolute inset-y-0 right-0 pr-3 flex ">

                      <svg class="h-8 w-8 text-dark cursor-pointer" width="30" height="23" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" @click="togglePasswordVisibility">
                         <circle cx="12" cy="12" r="2" />
                         <path v-if="!showPassword" d="M3 12l2.5 2.5a6.5 6.5 0 0 0 10.95 -3.5a6.5 6.5 0 0 0 -10.95 -3.5l-2.5 2.5" />
                         <path v-if="showPassword" d="M2 12l4 4l6 -6" />
                      </svg> 

                    </div> -->
                    </div>
                    <router-link to="/forget" class="forget-pass">Mot de passe oublié</router-link> 
                    <argon-switch id="rememberMe" name="remember-me">Remember me</argon-switch>

                    <div class="text-center">
                       <!-- <router-link to="/">  -->
                      <button @click="submitLogin"  class="text-white font-weight-bolder" style="
                          background-color: #000080;
                          color: #fff;
                          border: none;
                          border-radius: 5px;
                          margin-top:5%;
                          padding: 8px;
                      " >Se connecter</button>
                     <!-- </router-link>  -->
                     <p v-if="error">{{ error }}</p>
                    </div>
                  </form>
                </div>
                <div class="px-1 pt-0 text-center card-footer px-lg-2">
                  <p class="mx-auto mb-4 text-sm">
                    Vous n'avez pas un compte?
                    <router-link to="/register" style="color:dark">S'inscrire</router-link>
                    
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