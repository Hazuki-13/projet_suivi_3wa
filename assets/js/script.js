

let check_in = document.querySelector('.check-in');
let check_out = document.querySelector('.check-out');
let resultTime;
let day;

function countDays() {
    if(check_in.value != "" && check_out.value !="" ) {

        let date1 = new Date(check_in.value);
        let date2 = new Date(check_out.value);
        date1 = Date.parse(date1);
        date2 = Date.parse(date2);

        resultTime = (date2 - date1) / 86400000;

        document.querySelector('.days').innerHTML = 
        `<span> Day(s) x ${resultTime} </span>`
        total();
    }
        
}


function total() {

    if(check_in.value != "" && check_out.value !="" && selectCategory !== null) {
        let total = resultTime * day;      
        document.querySelector('.priceTimesDays').innerHTML= " Total = " + total + "€" ;
    }
}
    check_in.addEventListener('change', countDays);
    check_out.addEventListener('change', countDays);

let selectCategory = document.querySelector('.selectCategory')
if(selectCategory !== null){

    let categoryList = document.querySelector('.selectCategory');
    categoryList.addEventListener('change', () => {
        let cat = categoryList.value;
        if(cat!="") {

            let myRequest = new Request('/projet_suivi_3wa/index.php/booking/ajax', {
                method:'POST',
                body: JSON.stringify({id: cat})
            })
            
            fetch(myRequest)
            .then(res=>res.text())
            .then(res=>{
                document.querySelector('.priceDisplay').innerHTML= "Room : " + res + "€" ;
                day = res;
                total();

            })
        }else {
            document.querySelector('.priceDisplay').innerHTML= "";
        }
    });
}