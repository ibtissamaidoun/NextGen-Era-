<template>
  <div class="access-denied">
    <h1 class="title">Accès Refusé</h1>
    <p class="message">Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
  </div>
</template>
<script>
export default {
  name: 'AccessDenied'
}
</script>
<style scoped>
.access-denied {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background-color: #f8f9fa;
  color: #333;
  font-family: 'Arial', sans-serif;
}
.title {
  font-size: 24px;
  color: #dc3545;
}
.message {
  font-size: 16px;
  color: #6c757d;
}
</style>
