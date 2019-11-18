document.addEventListener("DOMContentLoaded",() => {
    let button=document.getElementsByClassName("search");
    let btn=Array.from(button);
    var xhr;
    btn.forEach(addEvent);
    function addEvent(btn){
    btn.addEventListener("click",function(element){
    
        
         element.preventDefault();
          
         xhr=new XMLHttpRequest();

        var input=document.getElementById('country').value;
        if (btn.innerHTML==="Lookup Cities"){
            var search="cities";
        }
        xhr.onreadystatechange=fetchData;
        xhr.open('GET','world.php?country='+input+'&context='+search);
        xhr.send();
    }); 
    }

    function fetchData(){
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                var result=document.querySelector('#result');
                result.innerHTML=xhr.responseText;
            }else{
                alert("There was a problem with the request");
            }
        }
    }
    
    
});