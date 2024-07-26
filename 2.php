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
    
?>