//variablen für timer der bei 00:00 startet
var time = 0;
var m = 0;
var s = 0;

//variablen für timer der bei gesamtdauer startet und runterzählt
var resttime = 0;
var mrest = 0;
var srest = 0;

// bei 0 timer nicht starten, bei -1 startet der timer
var myInterval = 0;

var gesamtdauer;

//gesamtdauer setzen
function setGesamtdauer(wert) {
    gesamtdauer = wert;
}

//durchlaufen des timers
function runTimer() {
    var timer = document.getElementById("timer");
    var resttimer = document.getElementById("resttimer");
    if (myInterval === -1) {
        myInterval = setInterval(function () {
            time++;
            resttime--;

            if (gesamtdauer - 60 <= time) { //bestimmen wann der resttimer eingeblendet wird
                resttimer.style.display = 'block';
            }

            if (time >= gesamtdauer) {//nach ablauf der zeit den absende button automatisch drücken
                var button = document.getElementById("absenden");
                button.click();

            }

            if (srest - 1 < 0) { //resttimer in minuten und sekunden umrechnen
                srest = 59;
                mrest--;
            } else {
                srest--;
            }
            //Restzeit in htmlelement mit der id "resttimer" schreiben
            resttimer.innerHTML = "Restzeit: " + ((mrest >= 10) ? mrest : "0" + mrest) + ":" + ((srest >= 10) ? srest : "0" + srest);

            if (s + 1 >= 60) {
                s = 0;
                m++;
            } else {
                s++;
            }
            //vergangene zeit in das htmlelement "timer" schreiben
            timer.innerHTML = "Zeit: " + ((m >= 10) ? m : "0" + m) + ":" + ((s >= 10) ? s : "0" + s) + " von 15:00 min";
        }, 1000);
    } else {
        clearInterval(myInterval);
        myInterval = -1;
    }
}


//startet zeit
function startTimer() {
    myInterval = -1;
    resttime = gesamtdauer;
    mrest = Math.round(gesamtdauer / 60);
    srest = Math.round(gesamtdauer % 60);
}

//wird verwendet um bei closeTimer aufgerufen um die Zeit zu stoppen
function stopTimer() {
    s--;
    clearInterval(myInterval);
    myInterval = 0;
}

//Ausblenden des Timers und gibt Zeit zurück
function closeTimer() {
    var timer = document.getElementById("timer");
    timer.style.display = 'none';
    stopTimer();
    return m * 60 + s;
}

//Zeit in Sekunden zurueck geben
function gettime() {
    return m * 60 + s;
}