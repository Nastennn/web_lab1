<!DOCTYPE html>
<html lang="ru">
<?php
if (session_id() === "") {
    session_start();
}
?>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Style.css">
    <title>index</title>
</head>
<body>
<?php

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

$start = microtime(true);
date_default_timezone_set("UTC");
$time = time() + 3 * 3600;
echo date("H:i:s", $time);

$xValid = false;
$yValid = false;
$rValid = false;

switch ($_SERVER['REQUEST_METHOD']) {
    case'GET':
        $the_request = &$_GET;
        echo "Данные должны быть введены через форму.";
        break;
    case 'POST':
        $the_request = &$_POST;

        if (empty($_POST['x']) && empty($_POST['y']) && empty($_POST['r'])) {
            break;
        }

        if (strcmp($_POST['x'], "no") === 0) {
            echo "<p>Выберите координату X.</p>";
        } else if (is_numeric($_POST['x'])) {
            $X = (float)$_POST['x'];
            $xValid = true;
        }

        if ($_POST['y'] === "") {
            echo "<p>Выберите координату Y.</p>";
        } else if (is_numeric(str_replace(",", ".", $_POST['y'])) && !is_null(str_replace(",", ".", $_POST['y']))) {
            $Y = (float)str_replace(",", ".", $_POST['y']);
            $yValid = true;
        } else {
            echo "<p>В поле ввода координаты Y допустимы только цифры, знак минуса/плюса и точка/запятая.</p>";
        }
        if (empty($_POST["r1"]) && empty($_POST["r15"]) && empty($_POST["r2"]) && empty($_POST["r25"]) && empty($_POST["r3"])) {
            echo "<p>Радиус не выбран.</p>";
        } else $rValid = true;

        if (!($rValid && $xValid && $yValid)) {
            exit();
        }
        if ($Y < -3 || $Y > 5) {
            echo "<p>Координата Y не входит в диапазон (-3;5)</p>";
            $yValid = false;
        }
        if ($Y === -0) {
            $Y = 0;
        }


        if (!isset($_SESSION['points'])) {
            $_SESSION['points'] = array();

        }

        if ($yValid && !empty($_POST['r1'])) {
            $point = new Point($X, $Y, $_POST['r1'], $time);
            array_push($_SESSION['points'], $point);
        }
        if ($yValid && !empty($_POST['r15'])) {
            $point = new Point($X, $Y, $_POST['r15'], $time);
            array_push($_SESSION['points'], $point);
        }
        if ($yValid && !empty($_POST['r2'])) {
            $point = new Point($X, $Y, $_POST['r2'], $time);
            array_push($_SESSION['points'], $point);
        }
        if ($yValid && !empty($_POST['r25'])) {
            $point = new Point($X, $Y, $_POST['r25'], $time);
            array_push($_SESSION['points'], $point);
        }
        if ($yValid && !empty($_POST['r3'])) {
            $point = new Point($X, $Y, $_POST['r3'], $time);
            array_push($_SESSION['points'], $point);
        }
        break;
}

echo <<<TAG
<table align="center"><thead><tr>
    <th> <h5>Х</h5></th>
    <th> <h5>Y</h5></th>
    <th> <h5>R</h5></th>
    <th> <h5>Результат</h5></th>
    <th> <h5>Время</h5></th>
    </tr></thead>
TAG;
foreach (array_reverse($_SESSION['points']) as $point) {
    echo "<tr><td>$point->X</td><td>$point->Y</td><td>$point->R</td>";
    echo $point->check() ? "<td>Попала</td>" : "<td>Не попала</td>";
    echo "<td>" . date("H:i:s", $point->Time) . "</td></tr>";
}

for ($i = 1; $i <= 10 - count($_SESSION['points']); $i++) {
    echo "<tr><td><br></td><td><br></td><td><br></td><td><br></td><td><br></td></tr>";
}

if (count($_SESSION['points']) >= 10) {
    array_shift($_SESSION['points']);
}
echo "</table>";
echo "<p>Время обработки:" . round(microtime(true) - $start, 5) . "</p>";

class Point
{
    public $X;
    public $Y;
    public $R;
    public $Time;

    public function __construct($x, $y, $r, $time)
    {
        $this->X = $x;
        $this->Y = $y;
        $this->R = $r;
        $this->Time = $time;
    }

    public function check()
    {
        if ((($this->X >= -$this->R / 2) && ($this->X <= 0) && ($this->Y >= ($this->X * (-2) - $this->R / 2) && ($this->Y <= 0))
            || (($this->X >= 0) && ($this->X <= $this->R / 2) && ($this->Y <= 0) && ($this->Y >= $this->R)) ||
            (($this->X >= 0) && ($this->X <= $this->R / 2) && ($this->Y <= sqrt(pow($this->R / 2, 2) - pow($this->X, 2)))))) {
            return true;
        } else {
            return false;
        }
    }
}

?>
</body>
</html>