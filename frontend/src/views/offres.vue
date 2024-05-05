<script setup>
//import MasterCard from "@/examples/Cards/MasterCard.vue";
//import DefaultInfoCard from "@/examples/Cards/DefaultInfoCard.vue";
import PaymentCard from "./components/PaymentCard.vue";
//import InvoiceCard from "./components/InvoiceCard.vue";
import BillingCard from "./components/BillingCard.vue";
//import TransactionCard from "./components/TransactionCard.vue";
</script>

<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <payment-card />
      </div>
    </div>
    <div class="mt-4 row">
      <div class="col-12">
        <billing-card />
      </div>
    </div>
    
    
    
  </div>
</template>

