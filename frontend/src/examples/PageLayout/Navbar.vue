<script setup>
defineProps({
  btnBackground: {
    type: String,
    default: "",
  },
  isBlur: {
    type: String,
    default: "",
  },
  darkMode: {
    type: Boolean,
    default: false,
  },
  isBtn: { type: String, default: "bg-gradient-light" },
});
</script>
<template>
  <!-- Navbar -->
  <nav 
    class="navbar navbar-expand-lg top-0 z-index-3 position-absolute mt-4 bg-transparent border-0"
    :class="isBlur ? isBlur : 'shadow-none my-2 navbar-transparent w-100'"
  >
    <div class="container ps-2 pe-0">
      <router-link
        class="navbar-brand font-weight-bolder ms-lg-0 ms-3"
        :class="darkMode ? 'text-black' : 'text-white'"
        to="/"
        >
        <img src="@/assets/img/logos/nextgenerabar.png" alt="logo" class="navbar-logo "  />
        </router-link>
      <button
        class="shadow-none navbar-toggler ms-2"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navigation"
        aria-controls="navigation"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="mt-2 navbar-toggler-icon">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav ms-auto">
        <!--  <li class="nav-item">
            <router-link
              class="nav-link me-2"
              aria-current="page"
              to="/dashboard-default"
            >
              <i
                class="fa fa-chart-pie opacity-6 me-1"
                aria-hidden="true"
                :class="isBlur ? 'text-dark' : 'text-white'"
              ></i>
              Dashboard
            </router-link>
          </li>-->
          <li class="nav-item">
            <router-link
              class="nav-link d-flex align-items-center me-2 active"
              aria-current="page"
              to="/register"
            >
              <i
                class="fas fa-user-circle opacity-6 me-1"
                aria-hidden="true"
                :class="isBlur ? 'text-dark' : 'text-white'"
              ></i>
              Inscription
            </router-link>
         </li>
         <li class="nav-item">
            <router-link class="nav-link me-2" to="/login">
              <i
                class="fas fa-key opacity-6 me-1"
                aria-hidden="true"
                :class="isBlur ? 'text-dark' : 'text-white'"
              ></i>
              Connexion
            </router-link>
          </li>
          
        </ul>
      <ul class="navbar-nav d-lg-block d-none">
          <!-- <li class="nav-item">
            <a
              href="https://www.creative-tim.com/product/vue-argon-dashboard"
              class="btn btn-sm mb-0 me-1"
              :class="isBtn"
              >Free download</a
            >
          </li> -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
</template>
<!--<style scoped>
.navbar-logo{
  margin-top:10px;
}
</style>-->
