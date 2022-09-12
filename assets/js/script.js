

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
        <span> x ${resultTime} day(s) </span>
        `
        console.log(resultTime);
        console.log(typeof(resultTime));
        return resultTime;
    }
        
}
    check_in.addEventListener('change', countDays);
    check_out.addEventListener('change', countDays);
    
    // const str = 'Mozilla';

    // console.log(str.substring(1, 3));
    // expected output: "oz"

    // console.log(str.substring(2));

if(document.querySelector('.selectCategory') !== null){

    let categoryList = document.querySelector('.selectCategory');
    categoryList.addEventListener('change', () => {
        let cat = categoryList.value;
        // console.log(cat)
        if(cat!="") {

            let myRequest = new Request('/projet_suivi_3wa/index.php/booking/ajax', {
                method:'POST',
                body: JSON.stringify({id: cat})
            })
            
            fetch(myRequest)
            .then(res=>res.text())
            .then(res=>{
                document.querySelector('.priceDisplay').innerHTML= "Room's price per day : " + res + "€" ;
                if(check_in.value != "" && check_out.value !="" ) {
            
                    let date1 = new Date(check_in.value);
                    let date2 = new Date(check_out.value);
                    date1 = Date.parse(date1);
                    date2 = Date.parse(date2);
            
                    let resultTime = date2 - date1;
                    resultTime = (date2 - date1) / 86400000;
            
                    document.querySelector('.days').innerHTML = `
                    <span> x ${resultTime} </span>
                    `
                    let total = resultTime * res;
                    console.log(resultTime);
                    console.log(typeof(resultTime));
                    console.log(total);
                    document.querySelector('.priceTimesDays').innerHTML= " = " + total ;
                }

            })
        }else {
            document.querySelector('.priceDisplay').innerHTML= "";
        }
    });
}



// if(document.querySelector('.selectCategory') !== null){

//     let categoryList = document.querySelector('.selectCategory');
//     categoryList.addEventListener('change', () => {
//         let cat = categoryList.value;
//         // console.log(cat)
//         if(cat!="") {

//             let myRequest = new Request('/projet_suivi_3wa/index.php/booking/ajax', {
//                 method:'POST',
//                 body: JSON.stringify({id: cat})
//             })
            
//             fetch(myRequest)
//             .then(res=>res.text())
//             .then(res=>{
//                 document.querySelector('.price').innerHTML= "Room's price per day : " + res;
//             })
            
//         }else {
//             document.querySelector('.price').innerHTML= "";
//         }
//     });
// }
