var npds = [380, 390, 450],
    npds2 = [345.8, 354.9, 409.5],
    npds3 = [881.6, 896.8],
    zzzs = [361, 362.5],

    pensijuKaupimas = [0, 0.01, 0.02],
    gpm = 0.15,
    mma = 400,
    y = 0,
    darbingumas = 1,
    atlyginimoTipas = 1,
    pritaikytasNPD = 0;

var z = 0, npd = npds[0], npd2 = npds2[0], npd3 = npds3[0], zzz = zzzs[0], pk = pensijuKaupimas[0], sodrosGrindys;



addEventListener("keydown", function(event) {
    if (event.keyCode == 13) {
    z = Math.abs(Number(document.getElementsByTagName('input')[0].value));
    sodrosGrindys = document.getElementsByTagName('select')[2].value;
    darbingumas = document.getElementsByTagName('select')[1].value;
    atlyginimoTipas = document.getElementsByTagName('select')[3].value;
    norimasPapildomasKaupimas = document.getElementsByTagName('select')[0].value;
    if (darbingumas == 1) {
        npd = npds[0];
        npd2 =npds2[0];
        npd3 =npds3[0];
    } else if (darbingumas == 2) {
        npd = npds[1];
        npd2 = npds2[1];
        npd3 = npds3[1];
        zzz = zzzs[1];
    } else {
        npd = npds[2];
        npd2 = npds2[2];
        npd3 = npds2[2];
    }
    if (norimasPapildomasKaupimas == 1) {
        pk = pensijuKaupimas[0];
    } else if (norimasPapildomasKaupimas == 2) {
        pk = pensijuKaupimas[1];
    } else {
        pk = pensijuKaupimas[2];
    }
//z turi buti gaunamas atlyginimas ant popieriaus
    if (atlyginimoTipas == 1) {
        document.getElementsByTagName('span')[6].innerHTML= z;
        c = antPop(z);
    } else {
        c = z;

        document.getElementsByTagName('span')[5].innerHTML= z;
        iRankas(c);
    }

} //pirmo ifo pabaiga
return npd, npd2, npd3, zzz, pk, sodrosGrindys;
}); //listener pabaiga


function taikytinasNPD(c) {
    var bb = npd - 0.5*(c - mma);
    document.getElementsByTagName('span')[0].innerHTML= bb;
    return bb;

}




function iRankas(x) {
    var pritaikytasNPD = 0, mokamasGPM = 0, darbdavioSodrosImokos;
    document.getElementsByTagName('span')[5].innerHTML= x;
    if (npd == npds[2]) {
        if (x <= npd) {
            pritaikytasNPD = x;
            document.getElementsByTagName('span')[0].innerHTML= x;
        } else if (x > npd) {
            pritaikytasNPD = npd;
            document.getElementsByTagName('span')[0].innerHTML= npd;
        }
    } else if (x <= npd) {
        document.getElementsByTagName('span')[0].innerHTML= x;
        pritaikytasNPD = x;
    } else if (x > npd && x <= mma) {
        document.getElementsByTagName('span')[0].innerHTML= npd;
        pritaikytasNPD = npd;
    } else if (x > npd && x < ((npd + 0.5*mma)*2)) {

        pritaikytasNPD = taikytinasNPD(x);

    } else if (x > ((npd + 0.5*mma)*2)) {

        document.getElementsByTagName('span')[0].innerHTML= 0;
        pritaikytasNPD = 0;

    }
        if (x > npd) {
            mokamasGPM = (Math.round(100*gpm*(x - pritaikytasNPD)))/100;
        }

        if (sodrosGrindys == 1) {
            if (x < mma) {
                darbdavioSodrosImokos = mma * 0.3118;
            } else {
                darbdavioSodrosImokos = x * 0.3118;
            }
        } else {
            darbdavioSodrosImokos = x * 0.3118;
        }

        var y = (Math.round((x - mokamasGPM - 0.09*x - pk*x)*100))/100;
        var proc6 = Math.round(100*x*0.06)/100;
        var proc3 = Math.round(100*x*0.03)/100;
        var pensijosKaupimui = x * pk;
        var darboVietosKaina = x + darbdavioSodrosImokos;
        document.getElementsByTagName('span')[1].innerHTML= mokamasGPM;
        document.getElementsByTagName('span')[2].innerHTML= proc6;
        document.getElementsByTagName('span')[3].innerHTML= proc3;
        document.getElementsByTagName('span')[4].innerHTML= pensijosKaupimui;
        document.getElementsByTagName('span')[6].innerHTML= y;
        document.getElementsByTagName('span')[7].innerHTML= darbdavioSodrosImokos;
        document.getElementsByTagName('span')[8].innerHTML= darboVietosKaina;

}

function antPop(x) {
    var pritaikytasNPD = 0, mokamasGPM = 0, y = 0;
    if (npd == npds[2]) {
        if (x <= npd) {
            y = Math.round(x *100/ (1 - 0.03 - 0.06 - pk))/100;
            iRankas(y);

        } else if (x > npd) {
            y = (x-0.15*npd)/(1 - gpm - 0.03 - 0.06 - pk);

            iRankas(y);
        }
    } else if (x <= npd2) {
        y = Math.round(x *100/ (1 - 0.03 - 0.06 - pk))/100;
        iRankas(y);

    } else if (x > npd2 && x <= zzz) {
        y = (x - gpm*npd)/(1 - gpm - 0.03 - 0.06 - pk);
        iRankas(y);
    } else if (x > npd2 && x < npd3) {

        y = (x - gpm*npd - 0.075*mma)/(0.775 - 0.06 - 0.03 - pk);
        iRankas(y);

    } else if (x > npd3) {
            y = x/(0.85 - 0.03 - 0.06 - pk);
            iRankas(y);


    } //if-end

}
