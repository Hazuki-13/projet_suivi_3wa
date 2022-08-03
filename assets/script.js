if(document.querySelector('#selectCategory') !== null){

    let categoryList = document.querySelector('#selectCategory');
    categoryList.addEventListener('change', () => {
        let cat = categoryList.value;
        // console.log(cat)
    
        let myRequest = new Request('/projet_suivi_3wa/index.php/booking/ajax', {
            method:'POST',
            body: JSON.stringify({id: cat})
        })
            
        fetch(myRequest)
        .then(res=>res.text())
        .then(res=>{
            document.getElementById('price').innerHTML= 'Room\'s price per day : ' + res;
        })
    
    });
}