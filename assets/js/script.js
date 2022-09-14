

let check_in = document.querySelector('.check-in');
let check_out = document.querySelector('.check-out');
let currentDate = new Date;
let checkinDate;
let checkoutDate;
let resultTime;
let date1;
let date2;
let day;
let limitBooking = 57600000;
function countDays() {
    let message = document.querySelector('.days');
    checkinDate = new Date(check_in.value);
    checkoutDate = new Date(check_out.value);
    date1 = Date.parse(checkinDate);
    date2 = Date.parse(checkoutDate);
    if(check_in.value != "" && check_out.value !="" && check_in.value < check_out.value && date1 + limitBooking >= currentDate) {
        
        resultTime = (date2 - date1) / 86400000;
        message.innerHTML = `<span> Day(s) x ${resultTime} </span>`;
    }
    else if(date1 + limitBooking < currentDate) {
        message.innerHTML = `<span style="color:red"> date of check-in is alredy expired </span>`;
    }
    else if(check_in.value != "" && check_out.value !="" && check_in.value >= check_out.value) {
        message.innerHTML = `<span style="color:red"> date of check-out is invalid </span>`;
    }
    else
    {
        message.innerHTML="";
    }
    total();
}
        
function total() {
    let message = document.querySelector('.priceTimesDays')
    if(check_in.value != "" && check_out.value !="" && selectCategory.value !== "" && check_in.value < check_out.value && date1 + limitBooking >= currentDate) {
        let total = resultTime * day;      
        message.innerHTML= " Total = " + total + "€" ;
    }
    else
    {
        message.innerHTML="";
    }
}
check_in.addEventListener('change', countDays);
check_out.addEventListener('change', countDays);

let selectCategory = document.querySelector('.selectCategory');
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
        }
        else
        {
            document.querySelector('.priceDisplay').innerHTML= "";
        }
    });
}