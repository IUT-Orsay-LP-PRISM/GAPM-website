const btn_RDVS = document.querySelectorAll('.js-btn-RDV');
const popUp_prendreRDV = document.querySelector('#popUp-prendre-RDV');

if (btn_RDVS) {
    btn_RDVS.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const idIntervenant = btn.getAttribute('data-id');
            const isLogged = document.body.getAttribute('data-log');
            if (isLogged != 1) {
                const currentQueryString = window.location.search;
                const newUrl = currentQueryString + '&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion';
                window.location.href = newUrl;
            } else {
                window.location.href = '/?action=prendre-rdv&intervenant=' + idIntervenant;
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
    const btnPreviousMonth = calendar.querySelector('.buttons .prev');

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

            if (annee < currentYear || (annee === currentYear && mois < currentMonth) || (annee === currentYear && mois === currentMonth && day + dayOfWeek < currentDay)) {
                dayDiv.classList.add('--disabled');
            }

            if (annee === currentYear && mois === currentMonth) {
                btnPreviousMonth.classList.add('--disabled');
            } else {
                btnPreviousMonth.classList.remove('--disabled');
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
        if (!btnPreviousMonth.classList.contains('--disabled')) {
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
    document.querySelectorAll('.day:not(.--disabled)').forEach(divDay => {
        divDay.addEventListener('click', () => {
            popUp_prendreRDV.classList.toggle('visible');

            const [year, month, day] = divDay.dataset.date.split('-');
            const options = {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'};
            const fullDate = new Date(year, month - 1, day).toLocaleDateString('fr-FR', options)
                .replace(/^\w|\s\w/g, (c) => c.toUpperCase());

            popUp_prendreRDV.querySelector('.popup-container-col__date').innerText = fullDate;

            const newFullDate = `${year}-${month < 10 ? '0' + month : month}-${day < 10 ? '0' + day : day}`;
            editDateInPopUp(newFullDate);
            removeHeureNotAvailable(newFullDate);
        });
    });
}

function editDateInPopUp(fullDate) {
    const inputDate = document.querySelector('#inputDate');
    inputDate.value = fullDate;
}


function removeHeureNotAvailable(date) {
    // get id intervenant from url
    const URL = window.location.href;
    const urlParams = new URLSearchParams(URL);
    const idIntervenant = urlParams.get('intervenant');

    const xhr = new XMLHttpRequest();
    const url = "?action=getHoraireNotAvailable&date=" + date + "&idIntervenant=" + idIntervenant;
    xhr.open("GET", url, true);
    xhr.onload = () => callback(xhr);
    xhr.send();

    function callback(xhr) {
        if (xhr.status !== 200) return;
        const data = JSON.parse(xhr.responseText);
        const selectHoraire = document.querySelector('#selectHoraire');
        selectHoraire.innerHTML = '<option value="" selected hidden> </option>';
        const notAvailable = data.map(horaire => horaire.heureDebut);
        const heures = [];
        for (let h = 8; h < 20; h++) {
            for (let m = 0; m < 60; m += 30) {
                if (h === 19 && m === 30) continue;
                let heure = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
                if (!notAvailable.includes(heure)) {
                    selectHoraire.appendChild(new Option(heure.replace(':', 'h'), heure));
                }
            }
        }
    }
}
