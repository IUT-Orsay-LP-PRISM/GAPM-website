const btn_RDVS = document.querySelectorAll('.js-btn-RDV');

if (btn_RDVS) {
    btn_RDVS.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const idDemandeur = btn.getAttribute('data-id');
            const isLogged = document.body.getAttribute('data-log');
            if (isLogged != 1) {
                const currentUrl = window.location.href;
                const currentQueryString = window.location.search;
                const newUrl = currentQueryString + '&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion';
                window.location.href = newUrl;
            } else {
                window.location.href = '/?action=prendre-rdv&demandeur=' + idDemandeur;
            }
        });
    });
}


const calendar = document.querySelector('.js-calendar');
if (calendar) {
    StartCalendar();
}

function estBissextile(annee) {
    return (annee % 400 == 0) || ((annee % 4 == 0) && (annee % 100 != 0));
}

function nbJours(annee, mois) {
    let n = 31;
    if ((mois == 4) || (mois == 6) || (mois == 9) || (mois == 11)) {
        n = 30;
    } else if (mois == 2) {
        if (estBissextile(annee)) {
            n = 29;
        } else {
            n = 28;
        }
    }
    return n;
}

function getMonthName(monthNumber) {
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    const date = new Date();
    date.setMonth(monthNumber - 1);
    return capitalize(date.toLocaleString('fr-fr', {month: 'long'}));
}

function creerCalendrier(annee, mois) {
    let nbJoursMois = nbJours(annee, mois);
    let date = new Date(annee, mois - 1, 1);
    let jourSemaine = date.getDay();
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth() + 1;
    const currentDay = now.getDate();
    const days = calendar.querySelector('.days');
    days.innerHTML = '';

    let day = 1 - jourSemaine;
    while (day <= nbJoursMois) {
        const row = document.createElement('div');
        row.classList.add('row');
        for (let dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day');
            const dayNumber = document.createElement('div');
            dayNumber.classList.add('day-number');

            if (day + dayOfWeek < 1 || day + dayOfWeek > nbJoursMois) {
                const previousMonthYear = mois === 1 ? annee - 1 : annee;
                const previousMonthMonth = mois === 1 ? 12 : mois - 1;
                const previousMonthDays = nbJours(previousMonthYear, previousMonthMonth);
                const previousMonthDay = day + dayOfWeek < 1 ? previousMonthDays + day + dayOfWeek : day + dayOfWeek - nbJoursMois;
                dayDiv.classList.add('--disabled');
                dayNumber.innerHTML = previousMonthDay;
            } else {
                dayNumber.innerHTML = day + dayOfWeek;
                const dateObj = new Date(annee, mois - 1, dayNumber.innerHTML);
                const datasetDate = `${dateObj.getFullYear()}-${dateObj.getMonth() + 1}-${dateObj.getDate()}`;
                dayDiv.dataset.date = datasetDate;
            }

            if (annee === currentYear && mois === currentMonth && day + dayOfWeek === currentDay) {
                dayDiv.classList.add('--today');
            }

            dayDiv.appendChild(dayNumber);
            row.appendChild(dayDiv);
        }
        days.appendChild(row);
        day += 7;
    }

    placeEventListenerInDays();
}



function StartCalendar() {
    const now = new Date();
    let currentYear = now.getFullYear();
    let currentMonth = now.getMonth() + 1;
    creerCalendrier(currentYear, currentMonth);

    const textMonth = calendar.querySelector(".current-month");
    textMonth.innerText = `${getMonthName(currentMonth)} ${currentYear}`;
    const btnNextMonth = calendar.querySelector('.buttons .next');
    const btnPreviousMonth = calendar.querySelector('.buttons .prev');
    const btnNow = calendar.querySelector('.buttons .now');

    btnNextMonth.addEventListener('click', () => {
        if (currentMonth == 12) {
            currentMonth = 1;
            currentYear++;
            creerCalendrier(currentYear, currentMonth);
            textMonth.innerText = `${getMonthName(currentMonth)} ${currentYear}`;
        } else {
            currentMonth++;
            creerCalendrier(currentYear, currentMonth);
            textMonth.innerText = `${getMonthName(currentMonth)} ${currentYear}`;
        }
    });

    btnPreviousMonth.addEventListener('click', () => {
        if (currentMonth == 1) {
            currentMonth = 12;
            currentYear--;
            creerCalendrier(currentYear, currentMonth);
            textMonth.innerText = `${getMonthName(currentMonth)} ${currentYear}`;
        } else {
            currentMonth--;
            creerCalendrier(currentYear, currentMonth);
            textMonth.innerText = `${getMonthName(currentMonth)} ${currentYear}`;
        }
    });

    btnNow.addEventListener('click', () => {
        currentYear = now.getFullYear();
        currentMonth = now.getMonth() + 1;
        creerCalendrier(currentYear, currentMonth);
        textMonth.innerText = `${getMonthName(currentMonth)} ${currentYear}`;
    });
}


function placeEventListenerInDays() {
    const popUp_prendreRDV = document.querySelector('#popUp-prendre-RDV');
    document.querySelectorAll('.day:not(.--disabled)').forEach(divDay => {
        divDay.addEventListener('click', () => {
            popUp_prendreRDV.classList.toggle('visible');

            const [year, month, day] = divDay.dataset.date.split('-');
            const options = {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'};
            const fullDate = new Date(year, month - 1, day).toLocaleDateString('fr-FR', options)
                .replace(/^\w|\s\w/g, (c) => c.toUpperCase());

            popUp_prendreRDV.querySelector('.popup-container-col__date').innerText = fullDate;
        });
    });
}

