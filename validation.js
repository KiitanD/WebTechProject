const pwd = document.querySelector('input[type="password"]');

pwd.addEventListener('blur', (e) => {
            Validate(e)})

function Validate(e) {
    var isValid = e.getAttribute(value).test(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/);
    if (isValid) { alert('true'); break;}
    alert('false')
}