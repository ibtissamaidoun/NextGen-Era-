<template>
    <section class="h-100 h-custom" >
    <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
        <div class="card border-0">
            <div class="card-body p-4">
    
            <div class="row">
                <div class="col-lg-7">
                <h5 class="mb-3"><router-link :to="{name:'ActivitesParents'}" class="text-body"><i
                        class="fas fa-long-arrow-alt-left me-2"></i>Continue l'achat</router-link></h5>
                <hr>
    
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-align-center">
                    <h5 class="mb-0 " style="color:orange;">Tu as {{ $store.state.cart.length }} activités dans votre panier</h5>
                    </div>
                </div>
    
                <div v-for="item in $store.state.cart" class="card mb-3 shadow-sm border-0" :key="item.id">
                    <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div>
                                <img
                                :src="item.image"
                                class="img-fluid rounded-3" alt="Shopping item" style="width: 90px;">
                            </div>
                            <div class="ms-3">
                                <h5 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;color:#000080">{{ item.name }}</h5>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <!-- <div >
                                <CartAddRemove :product="item"/>
                            </div> -->
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div >
                                <h5 class="mb-0"><i class="bi bi-currency-dollar"></i>{{ item.price*item.qty }} DH</h5>
                                <small v-if="item.hasDiscount" class="text-muted text-decoration-line-through"><i class="bi bi-currency-dollar"></i>{{ item.price}}</small>
                            </div>
                            <a role="button" @click="removeItem(item)" class="ms-4" style="color: #cecece;"><i class="bi bi-trash3 h4"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
    
                </div>
                <div class="col-lg-5">
    
                <div class="card bg-primary text-white rounded-0 border-0">
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Détails de la carte</h5>
                        <i class="bi bi-cart3 h1"></i>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between mb-4">
                        <p class="mb-2">Total</p>
                        <p class="mb-2"><i class="bi bi-currency-dollar"></i>{{ $store.state.cartTotal }}</p>
                    </div>
                    <div>
                    <router-link to="/dashboard-parents/Demandes/Pack" type="button" class="btn btn-info btn-block btn-lg">
                        Continue
                    </router-link>
                    <router-link to="/dashboard-parents/Activites" type="button" class="btn btn-warning btn-block btn-lg">
                        Refuser
                    </router-link>
                </div>
    
                    </div>
                </div>
    
                </div>
    
            </div>
    
            </div>
        </div>
        </div>
    </div>
    </div>
    </section>
    </template>
    <!-- <script>
    import CartAddRemove from './components/CartAddRemove.vue';
    export default{
    components :{CartAddRemove},
    methods:{
        removeItem(item){
            this.$store.commit('addRemoveCart',{product:item,toAdd:false}) //mutation addremove
        },
    },
    mounted(){
    
    }
    
    }
    </script> -->