<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

  header('Access-Control-Allow-Methods: POST, OPTIONS');
  header('Content-type: application/json');

  $data = file_get_contents('php://input');

  if (!$data) {
    header('HTTP/1.1 400 No correct data');
    echo json_encode(['msg' => 'Отсутсвуют даннные']);
    die();
  }

  $data = json_decode($data, true);

//  var_dump($data);
function valid_data($value) {
  $value = stripslashes($value);
  $value = strip_tags($value);
  $value = htmlspecialchars($value);
  $value = trim($value);

  return $value;
}

  $startDate = valid_data($data['startDate']);
  $sum = valid_data($data['sum']);
  $percent = valid_data($data['percent']);
  $sumAdd = valid_data($data['sumAdd']);
  $term = valid_data($data['term']);

  $pattern_number = '/^\d{1,}$/';
  $pattern_date = '/^(0[1-9]|[12][0-9]|3[01])[\.](0[1-9]|1[012])[\.](19|20)\d\d$/';

  $error = [];
  $check = false;

  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Валидация на срок вклада в месяцах $term
    if(!preg_match($pattern_number, $term)) {
      $error['term'] = '<small class="error">Только число</small><br>';
      $check = true;
    }
    if(!filter_var($term, FILTER_VALIDATE_INT)) {
      $error['term'] = '<small class="error">Только целое число</small>';
      $check = true;
    }
    if($term > 60 && $term < 0 && empty($term)) {
      $error['term'] = '<small class="error">Срок вклада от 1 до 60 месяцев</small>';
      $check = true;
    }

    // Валидация суммы вклада $sum
    if(!preg_match($pattern_number, $sum)) {
      $error['sum'] = '<small class="error">Только число</small>';
      $check = true;
    }

    if(!filter_var($sum, FILTER_VALIDATE_INT)) {
      $error['sum'] = '<small class="error">Только целое число</small>';
      $check = true;
    }

    if($sum > 3000000 && $sum < 1000 && empty($sum)) {
      $error['sum'] = '<small class="error">Сумма вклада - число от 1000 до 3000000</small>';
      $check = true;
    }

    // Валидация процентной ставки, % годовых
    if(!preg_match($pattern_number, $percent)) {
      $error['percent'] = '<small class="error">Только число</small>';
      $check = true;
    }
    if(!filter_var($percent, FILTER_VALIDATE_INT)) {
      $error['percent'] = '<small class="error">Только целое число</small>';
      $check = true;
    }
    if($percent > 10 && $percent < 3 && empty($percent)) {
      $error['percent'] = '<small class="error">Процентная ставка, % от 3 до 10</small>';
      $check = true;
    }

    // Валидация суммы ежемесячного пополнения вклада $sumAdd
    if(!preg_match($pattern_number, $sumAdd)) {
      $error['sumAdd'] = '<small class="error">Только число</small>';
      $check = true;
    }
    if(!filter_var($sumAdd, FILTER_VALIDATE_INT)) {
      $error['sumAdd'] = '<small class="error">Только целое число</small>';
      $check = true;
    }
    if($sumAdd > 3000000 && $sumAdd < 0) {
      $error['sumAdd'] = '<small class="error">Сумма пополнения вклада - число от 0 до 3000000</small>';
      $check = true;
    }
    if($sumAdd == empty($sumAdd)) {
      $sumAdd = 0;
    }

    // Валидация даты открытия вклада $startDate
    if(!preg_match($pattern_date, $startDate)) {
      $error['startDate'] = '<small class="error">Дата в формате "04.09.2021"</small>';
      $check = true;
    }
    if(empty($startDate)) {
      $error['startDate'] = '<small class="error">Введите дату открытия вклада</small>';
      $check = true;
    }
  };
  if ($check === false) {
    echo json_encode(array('err' => $error, 'result'=>false));
    exit();
  }

    // Расчет депозита
    $startDate = new DateTime($data["startDate"]);
    $startDateDay = $startDate->format('j');
    $startDateMounth = $startDate->format('n');
    $startDateYear = $startDate->format('Y');

    $number = cal_days_in_month(CAL_GREGORIAN, $startDateMounth, $startDateYear);
    $firstMounth = $number - $startDateDay;
    $lastMounth = $startDateDay;
    $daysY = $startDateYear % 4 == 0 ? 366 : 365;

    settype($term, 'int');
    settype($percent, 'int');
    settype($sumAdd, 'int');

    $counter = 0;
    $sumB = $sum;
    $firstMounth = $number - $startDateDay;
    $lustMounth = $startDateDay;

    // echo $firstMounth. '-Количество дней в первом месяце firstMounth' . "\n";
    // echo $lustMounth. '-Количество дней в последнем месяце lustMounth' . "\n";


    function getAnswer($startDateMounth, $startDateYear, $term, $startDateDay, $counter, $percent, $daysY, $sumAdd, $lustMounth, $sumB) {
      $number = cal_days_in_month(CAL_GREGORIAN, $startDateMounth, $startDateYear);

      $sumN = $sumB + (($sumB + $sumAdd)*$number*($percent / $daysY))/100;
      $sumB = $sumN;

      $counter++;
      if($counter > $term) {
        $sumN = round($sumN, 2);
        echo json_encode(array('sum' => $sumN, 'result'=>true));
        return;
      };
      if($counter == 0) {
        $number == $firstMounth;
      };
      if($counter == $term) {
        $number == $lustMounth;
      };
      $startDateMounth++;
      if($startDateMounth > 12) {
        $startDateMounth = 1;
        $startDateYear++;
      };
      // echo $number. '- number' ."\n";
      // echo $startDateMounth. '-С какого месяца начиается вклад startDateMounth' ."\n";
      // echo $startDateYear. '-С какого года начинается влад startDateYear' ."\n";
      // echo $counter. '-Счетчик counter' . "\n";
      // echo $sumB. '-Сумма вклада на конец месяца sumB' . "\n";

    getAnswer($startDateMounth, $startDateYear, $term, $startDateDay, $counter, $percent, $daysY, $sumAdd, $lustMounth, $sumB);
      // echo $sumN. '-ответ' . "\n";
    }

    getAnswer($startDateMounth, $startDateYear, $term, $startDateDay, $counter, $percent, $daysY, $sumAdd, $lustMounth, $sumB);




?>
