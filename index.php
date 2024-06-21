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

function getFullNameFromParts ($surename, $name, $patronomyc) {
    return $surename . ' ' . $name . ' ' . $patronomyc;
};
echo getFullNameFromParts ('Иванов', 'Иван', 'Иванович');

function getPartsFromFullname ($string) {
    $arrayForCombination = [
        'surename',
        'name',
        'patronomyc'
    ];
        $breakName = (explode(' ', $string));
        $newArray = array_combine($arrayForCombination, $breakName);
        return $newArray;
    };
print_r(getPartsFromFullname('Степанова Наталья Степановна'));

function getShortName ($string) {
    $breakName = getPartsFromFullname($string);
    $shortName = $breakName['name'] . ' ' . mb_substr($breakName['surename'], 0, 1) . '.';
    return $shortName;
};
echo getShortName ('Пащенко Владимир Александрович');

function getGenderFromName ($string) {
    $breakName = getPartsFromFullname($string);
    
    $femPatrEnd = mb_substr($breakName['patronomyc'], -3);
    $bothNameEnd = mb_substr($breakName['name'], -1);
    $femSurEnd = mb_substr($breakName['surename'], -2);
    $manPatrEnd = mb_substr($breakName['patronomyc'], -2);
    $manSurEnd = mb_substr($breakName['surename'], -1);

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
        return $resultG;
    } elseif($initialGenderValue < 0){
        $resultG = 'Женский пол';
        return $resultG;
    } else {
        $resultG = 'Неопределённый пол';
        return $resultG;
    }
};
echo getGenderFromName ('Громов Александр Иванович');

function getGenderDescription ($array) {
    foreach ($array as $person) {
        $breakName = getGenderFromName($person['fullname']);
        $arrayForGen[] = $breakName;
    };

    $arrayForGenLength = count($arrayForGen);

    $manGenArr = array_filter($arrayForGen, fn($a) => $a == 'Мужской пол');
    $femGenArr = array_filter($arrayForGen, fn($b) => $b == 'Женский пол');
    $undefGenArr = array_filter($arrayForGen, fn($c) => $c == 'Неопределённый пол');

    $manGenArrLength = count($manGenArr);
    $femGenArrLength = count($femGenArr);
    $undefGenArrLength = count($undefGenArr);

    $roundMen = round($manGenArrLength / $arrayForGenLength * 100, 1);
    $roundWomen = round($undefGenArrLength / $arrayForGenLength * 100, 1);
    $roundUndef = round($undefGenArrLength / $arrayForGenLength * 100, 1);

    $answer = <<<HEREDOC
    Гендерный состав аудитории:
    --------------------------------------
    Мужчины - $roundMen %
    Женщины - $roundWomen %
    Не удалось определить - $roundUndef %
    HEREDOC;
    return nl2br($answer);
};
echo getGenderDescription ($example_persons_array);

function getPerfectPartner ($surename, $name, $patronomyc, $array) {
    //Обрабатываем ФИО, введенные в аргументы (не из массива):
    $inputName = getFullNameFromParts ($surename, $name, $patronomyc);
    $inputNameConvCase = mb_convert_case($inputName, MB_CASE_TITLE_SIMPLE);
    $inputNameGender = getGenderFromName ($inputNameConvCase);
    $shortInputName = getShortName ($inputNameConvCase);

    //Обрабатываем ФИО из массива:
    $inputArrLeng = count($array);
    $nameFromArray = $array[rand(0, $inputArrLeng - 1)]['fullname'];

    $arrayNameGender = getGenderFromName ($nameFromArray);
    $shortArrName = getShortName ($nameFromArray);

    while($inputNameGender === $arrayNameGender){
        $inputArrLeng = count($array);
        $nameFromArray = $array[rand(0, $inputArrLeng - 1)]['fullname'];

        $arrayNameGender = getGenderFromName ($nameFromArray);
        $shortArrName = getShortName ($nameFromArray);
    } 
    if ($inputNameGender === 'Неопределённый пол' || $arrayNameGender === 'Неопределённый пол') {
        $answer = "\u{2639} Извините, программа дала сбой, попробуйте заново \u{2639}";
        return $answer;
    }
    else {  
        $randNum = number_format((float)(rand(5000, 10000)/100), 2, '.', '');
        $answer = <<<HEREDOC
        $shortArrName + $shortInputName = 
        \u{2661} Идеально на $randNum % \u{2661}
        HEREDOC;
        return nl2br($answer);
    }
};
echo getPerfectPartner ('Антонова', 'Анна', 'Антоновна', $example_persons_array);
