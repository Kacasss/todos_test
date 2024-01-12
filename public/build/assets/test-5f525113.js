const n=document.getElementsByClassName("tr");let r=Array.from(n);r.forEach(function(t){t.addEventListener("click",e=>{e.preventDefault(),window.location=t.dataset.href})});
