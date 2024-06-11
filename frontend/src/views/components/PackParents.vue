<template>
    <div class="card pb-8">
      <div class="container mt-5">
        <div class="row">
          <div class="card-header pb-3 px-3">
            <h2 class="mb-2 text-center">Choisir un pack</h2>
          </div>
        </div>
        <div class="row justify-content-center mt-4">
          <div class="col-lg-6 mb-4 d-flex">
            <div class="card pack-card flex-fill">
              <div class="card-body">
                <h4 class="card-title pack-title">PACK ATELIERS</h4>
                <p class="pack-description">
                  Apprenez les bases de la programmation et développez des compétences en codage à travers des projets passionnants.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4 d-flex">
            <div class="card pack-card flex-fill">
              <div class="card-body">
                <h4 class="card-title pack-title">PACK NOMBRES D'ENFANTS</h4>
                <p class="pack-description">
                  Explorez le monde fascinant de l'intelligence artificielle et apprenez à développer des applications intelligentes.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  .container {
    max-width: 1000px;
    margin: auto;
  }
  
  .card-header h2 {
    font-family: 'Georgia', 'Times New Roman', Times, serif;
    color: orange;
  }
  
  .pack-title {
    font-family: 'Georgia', 'Times New Roman', Times, serif;
    color: #000080;
  }
  
  .pack-description {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 16px;
    color: #333;
  }
  
  .pack-card {
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  
  .pack-card:hover {
    transform: translateY(-5px);
  }
  
  .card-body {
    padding: 20px;
    flex-grow: 1;
  }
  
  .d-flex {
    display: flex;
  }
  
  .flex-fill {
    flex: 1;
  }
  </style>
  