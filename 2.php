<?php
    // convertString($a, $b) Результат ее выполнение: если в строке $a содержится 2 и более подстроки $b, то во втором месте заменить подстроку $b на инвертированную подстроку.
    function convertString(string $forSearch, string $forReplace) : string 
    {
        $repLenght = strlen($forReplace);       // чтобы два раза не считать длину
        return ($currentPos = strpos($forSearch, $forReplace)) === false ? $forSearch :         // если нет вхождений возвращаем исходную строку
               (($currentPos = strpos($forSearch, $forReplace, $currentPos + $repLenght)) === false ? $forSearch :  // если есть одно вхождение, то ищем второе на остатке строки
                substr_replace($forSearch, strrev($forReplace), $currentPos, $repLenght));  // меняем второе вхождение на инвертированную подстроку и возвращаем результат
        
    }
    // тестирование
    // нет вхождений
    print "<br>Coll convertString(affffa, ab)<br>";
    print_r( convertString("affffa", "ab"));
    // одно вхождение
    print "<br>Coll convertString(afabfffa, ab)<br>";
    print_r( convertString("afabfffa", "ab"));
    // три вхождения, заменяем только второе
    print "<br>Coll convertString(abfabfffab, ab)<br>";
    print_r( convertString("abfabfffab", "ab"));

    // функцию mySortForKey($a, $b). $a – двумерный массив вида [['a'=>2,'b'=>1],['a'=>1,'b'=>
    // 3]], $b – ключ вложенного массива. Результат ее выполнения: двумерном массива $a
    // отсортированный по возрастанию значений для ключа $b. В случае отсутствия ключа $b в
    // одном из вложенных массивов, выбросить ошибку класса Exception с индексом
    // неправильного массива.
    function mySortForKey(array &$inpArr, string $sortKey) : array
    {
        $sortKeyArr = [];
        foreach($inpArr as $arrInd => $arrVal){
            if(isset($arrVal[$sortKey]))
                array_push($sortKeyArr, $arrVal[$sortKey]);
            else {
                throw new Exception("Key '$sortKey' does not exist on array index '$arrInd' !");
            }
        }
        array_multisort($sortKeyArr, $inpArr);

        return $inpArr;
    }
    
    //тестирование
    $testMySortForKey = [['a'=> 2, 'b' => 45, 'c' => 10],['a'=> 10, 'b' => 1],['a'=> 7, 'b' => 25, 'c' => 10],['a'=> 5, 'b' => 50, 'c' => 10]];
    print "<br> Test array mySortForKey() ";
    foreach($testMySortForKey as $testVal){
        print "<br>";
        print_r($testVal);
    }
    print "<br> After sort by 'b'<br>";
    mySortForKey($testMySortForKey, 'b');
    foreach($testMySortForKey as $testVal){
        print "<br>";
        print_r($testVal);
    }
    print "<br> After sort by 'a'<br>";
    mySortForKey($testMySortForKey, 'a');
    foreach($testMySortForKey as $testVal){
        print "<br>";
        print_r($testVal);
    }

    // print "<br> After sort by 'c'<br>";
    // mySortForKey($testMySortForKey, 'c');

    

?>