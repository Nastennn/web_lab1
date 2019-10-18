function check() {
    var valid = true;
    document.getElementById("message").value = "";
    var dataFromURL = getUrlVars();
    if (dataFromURL > 0) {
        document.getElementById("request").value += "Данные должны быть введены через форму.";
        valid = false;
    } else {
        var x = document.getElementById('x').value;
        console.log(x);
        var y = document.getElementById('y').value;
        console.log(y);

        if (x === 'no') {
            document.getElementById("message").value += "Не выбрана координата X.\n";
            valid = false;
        }
        if (y === '') {
            document.getElementById("message").value += "Не введена координата Y.\n";
            valid = false;
        } else if (/[^0-9,.+-]/.test(y)) {
            document.getElementById("message").value += "В поле ввода координаты Y допустимы только цифры, знак минуса/плюса и точка/запятая.\n";
            valid = false;
        } else if (!/^(\+?(([0-4]([.,]\d+)?)|5([.,]0+)?))$|(-(([0-2]([.,]\d+)?)|(3([,.]0+)?)))$/.test(y)) {
            document.getElementById("message").value += "В поле ввода координаты Y должно находиться число из диапазона [-3; 5].";
            valid = false;
        }
        if (!rSelected()) {
            document.getElementById("message").value += "Радиус не выбран.";
            valid = false;
        }
    }
    return valid;

}

function getUrlVars() {
    var vars = {};
    window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars.length;
}

function rSelected() {
    var first = document.getElementById("r1");
    var second = document.getElementById("r1.5");
    var third = document.getElementById("r2");
    var forth = document.getElementById("r2.5");
    var fifth = document.getElementById("r3");
    return first.checked || second.checked || third.checked || forth.checked || fifth.checked;
}