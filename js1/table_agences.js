let table_obj=[];
let ajouter=document.querySelector('.ajouter');
let form=document.getElementById("formulaireLocation")
console.log(form)
ajouter.addEventListener('click',function(){
    if (form.style.display === "none") {
    form.style.display = "block";
  } else {
    form.style.display = "none";
  }
})