import Chart from 'chart.js/auto';
import {getRelativePosition} from 'chart.js/helpers';

function getData() {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '?action=chartsAjax');
        xhr.onload = () => {
            if (xhr.status !== 200) {
                console.error(xhr);
                reject(xhr);
            } else {
                resolve(JSON.parse(xhr.responseText));
            }
        };
        xhr.onerror = () => reject(xhr);
        xhr.send();
    });
}


const TitleMapping = {
    'NbRdvByDay': 'Nombre de rendez-vous par jour',
    'NbRdvBySpecialite': 'Nombre de rendez-vous par spécialité',
    'NbRdvByTrancheHorraire': 'Nombre de rendez-vous par tranche horaire',
    'TauxSatisfaction': 'Taux de satisfaction',
    'TauxStatusRdv': 'Taux de rendez-vous par statut',
    'nbCommentaireByRdvEffectue': 'Nombre de commentaire par rendez-vous effectué',
}

// Générez un jeu d'essai pour les données
const data = getData();
Promise.all([data]).then((values) => {
// Obtenez la référence de l'élément canvas
    const arrayCharts = Array.from(document.querySelectorAll('canvas.chartjs'));

    console.log(values[0]);

// Créez une instance de graphique pour chaque élément canvas
    arrayCharts.map((chart, index) => {

        console.log("KEYSSS",["NbRdvBySpecialite","TauxStatusRdv"].includes(Object.keys(values[0])[index]) ? Object.keys(values[0][Object.keys(values[0])[index]]) : "",)

        const ctx = chart.getContext('2d');
        const title = TitleMapping[Object.keys(values[0])[index]];

        return new Chart(ctx, {
            type: ["NbRdvBySpecialite","TauxStatusRdv"].includes(Object.keys(values[0])[index]) ? 'doughnut' : 'bar',
            data: {
                labels: Object.keys(values[0][Object.keys(values[0])[index]]),
                datasets: [{
                    label: "",
                    data: ["NbRdvBySpecialite","TauxStatusRdv"].includes(Object.keys(values[0])[index]) ? Object.values(values[0][Object.keys(values[0])[index]]) : values[0][Object.keys(values[0])[index]]
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: title
                    }
                }
            }
        });
    });

});
