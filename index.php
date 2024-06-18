<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

echo 'Задание 1. Разбиение и объединение ФИО';
echo '<br/>';
echo '<br/>';

function getFullNameFromParts ($surename, $name, $patronomyc) {
    return $surename . ' ' . $name . ' ' . $patronomyc;
};

echo getFullNameFromParts ('Иванов', 'Иван', 'Иванович');

echo '<br/>';
echo '<br/>';

function getPartsFromFullname ($array) {
    $arrayForCombination = [
        'surename',
        'name',
        'patronomyc'
    ];
    foreach ($array as $person) {
        $breakName = (explode(' ', $person['fullname']));
        $newArray = array_combine($arrayForCombination, $breakName);
        unset($person);
        echo "<pre>";
        print_r($newArray);
        echo "</pre>";
        }
    };

getPartsFromFullname($example_persons_array);

echo '<br/>';
echo 'Задание 2. Сокращение ФИО';
echo '<br/>';
echo '<br/>';

function getShortName ($array) {
    foreach ($array as $person) {
    $breakName = (explode(' ', $person['fullname']));
    unset($person);
    $onlyName = $breakName[1];
    $onlySurename = mb_substr($breakName[0], 0, 1);
    $namePlusShortSurename = $onlyName . ' ' . $onlySurename . '.';

    echo $namePlusShortSurename;
    echo ', ';
    }
};

getShortName ($example_persons_array);

echo '<br/>';
echo '<br/>';
echo '<br/>';
echo 'Задание 3. Функция определения пола по ФИО';
echo '<br/>';
echo '<br/>';

function getGenderFromName ($array) {
    foreach ($array as $person) {
        $breakName = (explode(' ', $person['fullname']));
      
        $femPatrEnd = mb_substr($breakName[2], -3);
        $bothNameEnd = mb_substr($breakName[1], -1);
        $femSurEnd = mb_substr($breakName[0], -2);
        $manPatrEnd = mb_substr($breakName[2], -2);
        $manSurEnd = mb_substr($breakName[0], -1);

        $initialGenderValue = 0;

        if($femPatrEnd === 'вна') {
            $initialGenderValue -= 1;
        };
        if($femSurEnd === 'ва') {
            $initialGenderValue -= 1;
        };
        if($manPatrEnd === 'ич') {
            $initialGenderValue += 1;
        };
        if($manSurEnd === 'в') {
            $initialGenderValue += 1;
        };

        if($bothNameEnd === 'а') {
            $initialGenderValue -= 1;
        } elseif ($bothNameEnd === 'н'){
            $initialGenderValue += 1;
        } elseif ($bothNameEnd === 'й'){
            $initialGenderValue += 1;
        };

        if($initialGenderValue > 0){
            echo 'Пол мужской';
            echo '<br/>';
        } elseif($initialGenderValue < 0){
            echo 'Пол женский';
            echo '<br/>';
        } else {
            echo 'Пол неопределён';
            echo '<br/>';
        }
    }
};
    
getGenderFromName ($example_persons_array);

echo '<br/>';
echo '<br/>';
echo 'Задание 4. Определение возрастно-полового состава';
echo '<br/>';

function getGenderDescription ($array) {
    foreach ($array as $person) {
        $breakName = explode(' ', $person['fullname']);
        
        $femPatrEnd = mb_substr($breakName[2], -3);
        $bothNameEnd = mb_substr($breakName[1], -1);
        $femSurEnd = mb_substr($breakName[0], -2);
        $manPatrEnd = mb_substr($breakName[2], -2);
        $manSurEnd = mb_substr($breakName[0], -1);

        $initialGenderValue = 0;

        if($femPatrEnd === 'вна') {
            $initialGenderValue -= 1;
        };
        if($femSurEnd === 'ва') {
            $initialGenderValue -= 1;
        };
        if($manPatrEnd === 'ич') {
            $initialGenderValue += 1;
        };
        if($manSurEnd === 'в') {
            $initialGenderValue += 1;
        };

        if($bothNameEnd === 'а') {
            $initialGenderValue -= 1;
        } elseif ($bothNameEnd === 'н'){
            $initialGenderValue += 1;
        } elseif ($bothNameEnd === 'й'){
            $initialGenderValue += 1;
        };

        if($initialGenderValue > 0){
            $resultG = 'Мужской пол';
        } elseif($initialGenderValue < 0){
            $resultG = 'Женский пол';
        } else {
            $resultG = 'Неопределённый пол';
        }

        $arrayForGen[] = $resultG;
    }

    $arrayForGenLength = count($arrayForGen);

    $manGenArr = array_filter($arrayForGen, fn($a) => $a == 'Мужской пол');
    $femGenArr = array_filter($arrayForGen, fn($b) => $b == 'Женский пол');
    $undefGenArr = array_filter($arrayForGen, fn($c) => $c == 'Неопределённый пол');

    $manGenArrLength = count($manGenArr);
    $femGenArrLength = count($femGenArr);
    $undefGenArrLength = count($undefGenArr);

    echo '<br/>';
    echo 'Гендерный состав аудитории:';
    echo '<br/>';
    echo '--------------------------------------';
    echo '<br/>';
    echo 'Мужчины -' . ' ' . round($manGenArrLength / $arrayForGenLength * 100, 1) . '%';
    echo '<br/>';
    echo '<br/>';
    echo 'Женщины -' . ' ' . round($femGenArrLength / $arrayForGenLength * 100, 1) . '%';
    echo '<br/>';
    echo '<br/>';
    echo 'Не удалось определить -' . ' ' . round($undefGenArrLength / $arrayForGenLength * 100, 1) . '%';
};

getGenderDescription ($example_persons_array);

echo '<br/>';
echo '<br/>';
echo '<br/>';
echo 'Задание 5. Идеальный подбор пары';
echo '<br/>';

function getPerfectPartner ($surename, $name, $patronomyc, $array) {

    //Обрабатываем ФИО, введенные в аргументы (не из массива):
    //приводим к регистру, сокращаем, вычисляем пол.

    $inputName = $surename . ' ' . $name . ' ' . $patronomyc;
    $inputNameConvCase = mb_convert_case($inputName, MB_CASE_TITLE_SIMPLE);
    $explodeName = explode(' ', $inputNameConvCase);
    $shortInputName = $explodeName[1] . ' ' . mb_substr($explodeName[0], 0, 1) . '.';

    $femPatrEnd = mb_substr($explodeName[2], -3);
    $bothNameEnd = mb_substr($explodeName[1], -1);
    $femSurEnd = mb_substr($explodeName[0], -2);
    $manPatrEnd = mb_substr($explodeName[2], -2);
    $manSurEnd = mb_substr($explodeName[0], -1);

    $initGenVal = 0;

    if($femPatrEnd === 'вна') {
        $initGenVal -= 1;
    };
    if($femSurEnd === 'ва') {
        $initGenVal -= 1;
    };
    if($manPatrEnd === 'ич') {
        $initGenVal += 1;
    };
    if($manSurEnd === 'в') {
        $initGenVal += 1;
    };

    if($bothNameEnd === 'а') {
        $initGenVal -= 1;
    } elseif ($bothNameEnd === 'н'){
        $initGenVal += 1;
    } elseif ($bothNameEnd === 'й'){
        $initGenVal += 1;
    };

    if($initGenVal > 0){
        $genderForInputName = 'Мужской пол';
    } elseif($initGenVal < 0){
        $genderForInputName = 'Женский пол';
    } else {
        $genderForInputName = 'Неопределённый пол';
    };

    //Обрабатываем ФИО из массива:
    //приводим к регистру, сокращаем, вычисляем пол.

    $inputArrLeng = count($array);
    $nameFromArr = explode(' ', $array[rand(0, $inputArrLeng - 1)]['fullname']);
    $shortArrName = $nameFromArr[1] . ' ' . mb_substr($nameFromArr[0], 0, 1) . '.';

    $femPatrEndArr = mb_substr($nameFromArr[2], -3);
    $bothNameEndArr = mb_substr($nameFromArr[1], -1);
    $femSurEndArr = mb_substr($nameFromArr[0], -2);
    $manPatrEndArr = mb_substr($nameFromArr[2], -2);
    $manSurEndArr = mb_substr($nameFromArr[0], -1);

    $initGenValArr = 0;

    if($femPatrEndArr === 'вна') {
        $initGenValArr -= 1;
    };
    if($femSurEndArr === 'ва') {
        $initGenValArr -= 1;
    };
    if($manPatrEndArr === 'ич') {
        $initGenValArr += 1;
    };
    if($manSurEndArr === 'в') {
        $initGenValArr += 1;
    };

    if($bothNameEndArr === 'а') {
        $initGenValArr -= 1;
    } elseif ($bothNameEndArr === 'н'){
        $initGenValArr += 1;
    } elseif ($bothNameEndArr === 'й'){
        $initGenValArr += 1;
    };

    if($initGenValArr > 0){
        $genderForArrayName = 'Мужской пол';
    } elseif($initGenValArr < 0){
        $genderForArrayName = 'Женский пол';
    } else {
        $genderForArrayName = 'Неопределённый пол';
    };

    if ($genderForInputName === $genderForArrayName) {
        echo '<br/>';
        echo 'Не получилось определить пару.';
        echo '<br/>';
        echo 'Перезагрузите страницу.';
        echo '<br/>';
    } 
    elseif ($genderForInputName === 'Неопределённый пол' || $genderForArrayName === 'Неопределённый пол') {
        echo '<br/>';
        echo 'Не получилось определить пару.';
        echo '<br/>';
        echo 'Перезагрузите страницу.';
        echo '<br/>';
    }
    else {
    echo '<br/>';
    echo $shortArrName . ' ' . ' + ' . $shortInputName . ' ' . ' = ';
    echo '<br/>';
    echo "\u{2661}" . ' ' . 'Идеально на' . ' ' . rand(50, 100) . '%' . ' ' .  "\u{2661}";
    echo '<br/>';
    }

}

getPerfectPartner ('Ангелинова', 'Ангелина', 'Жоровна', $example_persons_array);
