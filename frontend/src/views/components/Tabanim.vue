<template>
    <div>
        <div>
            <h4 class="mb-2 text-center">Les activités disponibles</h4>
        </div>
        <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th class="text-primary opacity-7">
                            <h6>id</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Titre</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Description</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Type d'activité</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Domaine d'activité</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Age max</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Age min</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Nombres de séances par semaine</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Effectif maximale</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Effectif minimale</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Effectif actuel</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Tarif</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Date début d'étudiant</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Date fin d'étudiant</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Statuts</h6>
                        </th>
                        <th class="text-primary opacity-7">
                            <h6>Animateur</h6>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(activity, index) in affectes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
                        <td>
                            <h6 class="text-center">{{ activity.id }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.titre }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.description }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.typeactivite }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.domaineactivite }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.agemax }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.agemin }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.nbrseances }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.effectifmax }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.effectifmin }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.effectifactuel }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.tarif }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.datedebutetud }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.datefinetud }}</h6>
                        </td>
                        <td>
                            <h6 class="mb-2 text-center">{{ activity.statuts }}</h6>
                        </td>
                        <td class="text-center">
                            <select v-model="activity.animateur" class="form-control" >
                                <option value="Option 1">Ayoub</option>
                                <option value="Option 2">Taha</option>
                                <option value="Option 3">Anas</option>
                                <option value="Option 3">Sakhri</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            affectes: [
                {
                    id: "5",
                    titre: "Atelier",
                    description: "sdzkhasiojaoijs",
                    typeactivite: "atelier",
                    domaineactivite: "informatique",
                    agemax: "17",
                    agemin: "6",
                    nbrseances: "2",
                    effectifmax: "12",
                    effectifmin: "6",
                    effectifactuel: "10",
                    tarif: "400dh",
                    datedebutetud: "10/9/2025",
                    datefinetud: "17/9/2025",
                    statuts: "presentiel",
                    animateur:"AYOUB",
                    
                },
                {
                    id: "5",
                    titre: "Atelier",
                    description: "sdzkhasiojaoijs",
                    typeactivite: "atelier",
                    domaineactivite: "informatique",
                    agemax: "17",
                    agemin: "6",
                    nbrseances: "2",
                    effectifmax: "12",
                    effectifmin: "6",
                    effectifactuel: "10",
                    tarif: "400dh",
                    datedebutetud: "10/9/2025",
                    datefinetud: "17/9/2025",
                    statuts: "presentiel",
                    nom:"AYOUB",
                },
                {
                    id: "5",
                    titre: "Atelier",
                    description: "sdzkhasiojaoijs",
                    typeactivite: "atelier",
                    domaineactivite: "informatique",
                    agemax: "17",
                    agemin: "6",
                    nbrseances: "2",
                    effectifmax: "12",
                    effectifmin: "6",
                    effectifactuel: "10",
                    tarif: "400dh",
                    datedebutetud: "10/9/2025",
                    datefinetud: "17/9/2025",
                    statuts: "presentiel",
                    nom:"AYOUB",
                },
                {
                    id: "5",
                    titre: "Atelier",
                    description: "sdzkhasiojaoijs",
                    typeactivite: "atelier",
                    domaineactivite: "informatique",
                    agemax: "17",
                    agemin: "6",
                    nbrseances: "2",
                    effectifmax: "12",
                    effectifmin: "6",
                    effectifactuel: "10",
                    tarif: "400dh",
                    datedebutetud: "10/9/2025",
                    datefinetud: "17/9/2025",
                    statuts: "presentiel",
                    
                },
            ],
        };
    },
    
    
};
</script>

<style scoped>
h4 {
    font-family: Georgia, 'Times New Roman', Times, serif;
    color: orange;
}

h6 {
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    color: #000080;
}

th {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    color: #000080;
}

span {
    font-family: Georgia, 'Times New Roman', Times, serif;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    display: none;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-menu li {
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    cursor: pointer;
}

.dropdown-menu li:hover {
    background-color: #ddd;
}

.show-dropdown {
    display: block;
}
</style>
