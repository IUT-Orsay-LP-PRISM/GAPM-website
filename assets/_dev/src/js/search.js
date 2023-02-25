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
                window.location.href = '/?action=prendre-rdv&intervenant=' + idDemandeur;
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
    for (day; day <= nbJoursMois; day += 7) {
        const row = document.createElement('div');
        row.classList.add('row');

        if (day + 7 > nbJoursMois) {
            const nbDaysLeft = nbJoursMois - day;
            for (let dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('day');
                const dayNumber = document.createElement('div');
                dayNumber.classList.add('day-number');
                if (dayOfWeek <= nbDaysLeft) {
                    dayNumber.innerHTML = day + dayOfWeek;
                } else {
                    dayDiv.classList.add('--disabled');
                    const nextMonthDay = dayOfWeek - nbDaysLeft;
                    dayNumber.innerHTML = nextMonthDay;
                }
                if (annee == currentYear && mois == currentMonth && day + dayOfWeek == currentDay) {
                    dayDiv.classList.add('--today');
                }
                dayDiv.appendChild(dayNumber);
                row.appendChild(dayDiv);
            }
            days.appendChild(row);
            break;
        } else {
            for (let dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('day');
                const dayNumber = document.createElement('div');
                dayNumber.classList.add('day-number');
                if (day + dayOfWeek <= 0) {
                    let previousMonth = mois - 1;
                    let previousMonthYear = annee;
                    if (previousMonth == 0) {
                        previousMonth = 12;
                        previousMonthYear = annee - 1;
                    }
                    const previousMonthDays = nbJours(previousMonthYear, previousMonth);
                    const previousMonthDay = previousMonthDays + day + dayOfWeek;
                    dayNumber.innerHTML = previousMonthDay;
                    dayDiv.classList.add('--disabled');
                } else {
                    dayNumber.innerHTML = day + dayOfWeek;
                }
                if (annee == currentYear && mois == currentMonth && day + dayOfWeek == currentDay) {
                    dayDiv.classList.add('--today');
                }
                dayDiv.appendChild(dayNumber);
                row.appendChild(dayDiv);
            }
            days.appendChild(row);
        }


    }
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
            creerCalendrier(currentYear + 1, 1);
            textMonth.innerText = `${getMonthName(1)} ${currentYear + 1}`;
            currentYear++;
        } else {
            creerCalendrier(currentYear, currentMonth + 1);
            textMonth.innerText = `${getMonthName(currentMonth + 1)} ${currentYear}`;
        }
        currentMonth++;
    });

    btnPreviousMonth.addEventListener('click', () => {
        if (currentMonth == 1) {
            creerCalendrier(currentYear - 1, 12);
            textMonth.innerText = `${getMonthName(12)} ${currentYear - 1}`;
            currentYear--;
        } else {
            creerCalendrier(currentYear, currentMonth - 1);
            textMonth.innerText = `${getMonthName(currentMonth - 1)} ${currentYear}`;
        }
        currentMonth--;
    });

    btnNow.addEventListener('click', () => {
        currentYear = now.getFullYear();
        currentMonth = now.getMonth() + 1;
        creerCalendrier(currentYear, currentMonth);
        textMonth.innerText = `${getMonthName(currentMonth)} ${currentYear}`;
    });
}

