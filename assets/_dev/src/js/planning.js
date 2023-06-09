export function getNumberOfRdvInDay() {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '?action=getNumberOfRdvInDay', true);
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

export function getEmpechements() {
    const URL = window.location.href;
    const urlParams = new URLSearchParams(URL);
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '?action=getEmpechements&intervenant=' + urlParams.get('intervenant'), true);
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
