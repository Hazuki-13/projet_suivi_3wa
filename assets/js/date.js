

// let firstDay = new Date();
// let lastDay = new Date();

// let check_in = firstDay.getDate(document.querySelector('.check-in').addEventListener('change'));
// let check_out = lastDay.getDate(document.querySelector('.check-out').addEventListener('change'));
let check_in = document.querySelector('.check-in');
let check_out = document.querySelector('.check-out');
check_in.addEventListener('change', countDays);
check_out.addEventListener('change', countDays);
function countDays() {
    if(check_in.value != "" && check_out.value !="" ) {
        console.log(check_in.value);
        console.log(check_out.value);

        let date1 = new Date(check_in);
        let date2 = new Date(check_out);
        let resultTime = date2.getTime() - date1.getTime();
        
        console.log(resultTime);
    }
}

/*
*** let date1 = new Date(check_in);
*** let date2 = new Date(check_out);

*** var date1 = new Date("01/01/2020");
*** var date2 = new Date("07/04/2020");
*** var Diff_temps = date2.getTime() - date1.getTime(); 
*** var Diff_jours = Diff_temps / (1000 * 3600 * 24);
*** alert("Le nombre de jours entre les deux dates est de " + Math.round(Diff_jours) + " jours");
*/


// check_in.addEventListener('change', this.value, true);
// check_out.addEventListener('change', this.value, true);

// let days = lastDay -= firstDay;
// let days = check_out -= check_in;

// // function days() {
    
//     document.querySelector('.check-in').addEventListener('change', function() {
//         let firstInput = this.value;
//         let check_in = new Date(firstInput);
//         // console.log(firstInput);
//         console.log(check_in);
//     })
//     document.querySelector('.check-out').addEventListener('change', function() {
//         let secondInput = this.value;
//         let check_out = new Date(secondInput);
//         console.log(check_out);
//         // console.log(secondInput);
//     })
// // }
    
// // console.log(check_out -= check_in);
// // console.log(check_out);
// console.log(firstInput);
// console.log(secondInput);
// console.log(days);
