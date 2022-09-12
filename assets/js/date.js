


let check_in = document.querySelector('.check-in');
let check_out = document.querySelector('.check-out');

function countDays() {
    if(check_in.value != "" && check_out.value !="" ) {
        // console.log(check_in.value);
        // console.log(check_out.value);

        let date1 = new Date(check_in.value);
        let date2 = new Date(check_out.value);
        date1 = Date.parse(date1);
        date2 = Date.parse(date2);
        // console.log(date1);
        // console.log(date2);

        let resultTime = date2 - date1;
        resultTime = (date2 - date1) / 86400000;

        document.querySelector('.days').innerHTML = `
        <span> x ${resultTime} </span>
        `
        console.log(resultTime);
        console.log(typeof(resultTime));
    }
        
}
    check_in.addEventListener('change', countDays);
    check_out.addEventListener('change', countDays);


    










    
    
    // const 
    /*
    *** let date1 = new Date(check_in);
    *** let date2 = new Date(check_out);
    
    *** var date1 = new Date("01/01/2020");
    *** var date2 = new Date("07/04/2020");
    *** var Diff_temps = date2.getTime() - date1.getTime(); 
    *** var Diff_jours = Diff_temps / (1000 * 3600 * 24);
    *** alert("Le nombre de jours entre les deux dates est de " + Math.round(Diff_jours) + " jours");
    */