import Chart from 'chart.js/auto';

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

const arrayCharts = Array.from(document.querySelectorAll('canvas.chartjs'));

if (arrayCharts.length > 0) {


    const TitleMapping = {
        'NbRdvByDay': 'Nombre de rendez-vous par jour',
        'NbRdvBySpecialite': 'Nombre de rendez-vous par spécialité',
        'NbRdvByTrancheHorraire': 'Nombre de rendez-vous par tranche horaire',
        'TauxSatisfaction': 'Taux de satisfaction',
        'TauxStatusRdv': 'Taux de rendez-vous par statut en %',
        'nbCommentaireByRdvEffectue': 'Nombre de commentaire par rendez-vous effectué',
    }

// Générez un jeu d'essai pour les données
    const data = getData();
    Promise.all([data]).then((values) => {
// Obtenez la référence de l'élément canvas

// Créez une instance de graphique pour chaque élément canvas
        arrayCharts.map((chart, index) => {
            const ctx = chart.getContext('2d');
            const title = TitleMapping[Object.keys(values[0])[index]];

            return new Chart(ctx, {
                type: ["NbRdvBySpecialite", "TauxStatusRdv"].includes(Object.keys(values[0])[index]) ? 'doughnut' : 'bar',
                data: {
                    labels: Object.keys(values[0][Object.keys(values[0])[index]]),
                    datasets: [{
                        label: "",
                        data: ["NbRdvBySpecialite", "TauxStatusRdv"].includes(Object.keys(values[0])[index]) ? Object.values(values[0][Object.keys(values[0])[index]]) : values[0][Object.keys(values[0])[index]]
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: title
                        },
                        legend: {
                            position: 'right',
                            align: 'center',
                            labels: {
                                boxWidth: 30, // adjust the width of the legend item boxes
                            },
                        }
                    }
                }
            });
        });
    });
}
