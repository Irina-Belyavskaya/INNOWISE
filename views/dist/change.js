(()=>{"use strict";class e{checkName(e){return 0!==e.length&&null!==e.match(/^([а-яА-яa-zA-z]+\s)+([а-яА-яa-zA-z])+$/gi)}checkEmail(e){return!(0===e.length||e.length<5)}checkStatus(e){return"status"!==e}checkGender(e){return"gender"!==e}}const t=document.querySelector(".form-change"),s=document.getElementById("name"),r=document.getElementById("email"),a=document.getElementById("gender"),n=document.getElementById("status");!function(t,s,r,a){const n=new e;t.addEventListener("input",(()=>{n.checkName(t.value)?t.classList.remove("error"):t.classList.add("error")})),s.addEventListener("input",(()=>{n.checkEmail(s.value)?s.classList.remove("error"):s.classList.add("error")})),r.addEventListener("click",(()=>{n.checkGender(r.value)?(r.classList.remove("btn-danger"),r.classList.add("btn-primary")):(r.classList.remove("btn-primary"),r.classList.add("btn-danger"))})),a.addEventListener("click",(()=>{n.checkStatus(a.value)?(a.classList.remove("btn-danger"),a.classList.add("btn-primary")):(a.classList.remove("btn-primary"),a.classList.add("btn-danger"))}))}(s,r,a,n),t.onsubmit=function(c){if(c.preventDefault(),!function(t,s,r,a){const n=new e;let c=!1;return n.checkName(t.value)?t.classList.remove("error"):(t.classList.add("error"),c=!0),n.checkEmail(s.value)?s.classList.remove("error"):(s.classList.add("error"),c=!0),n.checkGender(r.value)?(r.classList.remove("btn-danger"),r.classList.add("btn-primary")):(r.classList.remove("btn-primary"),r.classList.add("btn-danger"),c=!0),n.checkStatus(a.value)?(a.classList.remove("btn-danger"),a.classList.add("btn-primary")):(a.classList.remove("btn-primary"),a.classList.add("btn-danger"),c=!0),!c}(s,r,a,n))return;let i=new URLSearchParams(window.location.search).get("source");t.action=t.action+"?source="+i,HTMLFormElement.prototype.submit.call(t)}})();