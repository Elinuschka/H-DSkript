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

//dauer des waschgangs
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

            if(time>=gesamtdauer){
                var button = document.getElementById("absenden");
                button.click();
                //stopTimer();

            }


            if (srest - 1 < 0) { //Umsetzung Minuten Restzeit zu Sekunden, nachdem der timer
                srest = 59;
                mrest--;
            } else {
                srest--;
            }
            //Erstellung des TimerObjekts (Restzeit)
            resttimer.innerHTML = "Restzeit: " + ((mrest >= 10) ? mrest : "0" + mrest) + ":" + ((srest >= 10) ? srest : "0" + srest);

            if (s + 1 >= 60) {
                s = 0;
                m++;
            } else {
                s++;
            }
            //Erstellung des TimerObjekts (vergangene Zeit)
            timer.innerHTML = "Zeit: " + ((m >= 10) ? m : "0" + m) + ":" + ((s >= 10) ? s : "0" + s);
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