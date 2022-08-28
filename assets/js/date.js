

let firstDay = new Date();
let lastDay = new Date();

// let check_in = firstDay.getDate(document.querySelector('.check-in').addEventListener('change'));
// let check_out = lastDay.getDate(document.querySelector('.check-out').addEventListener('change'));
let check_in = firstDay.getDate(document.querySelector('.check-in'));
let check_out = lastDay.getDate(document.querySelector('.check-out'));

check_in.addEventListener('change', this.value, true);
check_out.addEventListener('change', this.value, true);

let days = lastDay -= firstDay;

// function days() {
    
//     document.querySelector('.check-in').addEventListener('change', function() {
//         let firstInput = this.value;
//         let check_in = new Date(firstInput);
//         console.log(firstInput);
//     })
//     document.querySelector('.check-out').addEventListener('change', function() {
//         let secondInput = this.value;
//         let check_out = new Date(secondInput);
//         console.log(secondInput);
//     })
// }
    
console.log(check_in);
console.log(check_out);
console.log(days);
