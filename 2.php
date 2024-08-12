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
        print "<br>";
    }

    // print "<br> After sort by 'c'<br>";
    // mySortForKey($testMySortForKey, 'c');
    /*
    if (file_exists('testData.xml')) {
        $xml = simplexml_load_file('testData.xml');
    
        print_r($xml);
    } else {
        exit('Не удалось открыть файл test.xml.');
    }
    print "<br><br>";
    foreach($xml as $product){
        print "<br><br>";
        //print_r($product);
        //print "<br>";
        //print_r($product->attributes());
        //print "<br>";
        echo "Код ".$product->attributes()["Код"]."<br>";
        echo "Название ".$product->attributes()["Название"]."<br>";
        //print_r($product->{'Цена'});
        print "<br>";
        foreach($product->{'Цена'} as $price){
            echo "Цена тип = ".$price->attributes()['Тип']." : ".$price."<br>";
        }
        //print_r($product->{'Свойства'});
        print "<br>";
        foreach($product->{'Свойства'}[0] as $propKey => $propValue){
            //print_r($propValue);
            //print "<br>";
            echo "Свойство ".$propKey." = ".$propValue." ".$propValue->attributes()."<br>";
        }
        
    }*/
    // $productCode = $product->attributes()["Код"];
    // $productName = $product->attributes()["Название"];
    // $query = <<<SQL
    //             INSERT INTO `test_samson`.`a_product`
    //             (`code`,`name`)
    //             VALUES
    //             ($productCode, '$productName');
    //         SQL;

    // echo "<br><br>". $query;
    // print "<br><br>";
    // print_r($xml->{'Товар'}->{'Цена'}[0]->attributes());
    // print_r($xml->{'Товар'}->{'Цена'}[1]->attributes());

    // try{    
    //     $pdo = new PDO("mysql:host=localhost;dbname=test_samson","root", "masterkey");
    // } catch(PDOException $e){
    //     echo "Невозмодно установить соединение с базой данныйх!";
    // }


    // // $query = "SELECT VERSION() as version";
    // $ansuer = $pdo->query("SELECT * FROM test_samson.a_product;");
    // while($elem = $ansuer->fetch()){
    //     print "<br>";
    //     print_r($elem);
    //     print "<br>";
    // }
    // echo "<br> version = ". print_r($ansuer) . "<br>" ;

    // Реализовать функцию importXml($filename). $filename – путь к xml файлу (структура
    // файла приведена ниже). Результат ее выполнения: прочитать файл $filename и
    // импортировать его в созданную БД.
    function importXML($filename)
    {
        // разбираем XML
        if (file_exists($filename)) {
            $xml = simplexml_load_file($filename);  
            //print_r($xml);
        } else {
            throw new Exception("Файл  не найден  '$filename'!");
        }

        // соединяеся с базой данных
        try{    
            $pdo = new PDO("mysql:host=localhost;dbname=test_samson","root", "masterkey");
        } catch(PDOException $e){
            echo "Невозмодно установить соединение с базой данныйх!";
        }
        // перебираем все товары
        foreach($xml as $product){
            // втавляем товар и получаем его id
            $productCode = $product->attributes()["Код"];
            $productName = $product->attributes()["Название"];
            $query = <<<SQL
                INSERT INTO `test_samson`.`a_product`
                (`code`,`name`)
                VALUES
                ($productCode, '$productName');
            SQL;
            $pdo->query($query);
            $newProductId = $pdo->lastInsertId();
            print "<br>";
            print_r($newProductId);
            print "<br>";
            // обрабатываем свойства товара
            $propertyes = $product->{'Свойства'}[0];
            print_r($product->{'Свойства'}[0]);
            $propertyes->rewind();
            do{
                //print_r($propValue);
                //print "<br>";
                //echo "Свойство ".$propKey." = ".$propValue." ".$propValue->attributes()."<br>";

                $propertyName = $propertyes->key();
                $proprtyValue = $propertyes->current()." ".$propertyes->current()->attributes(); // через пробел добавляем единицы измерения

                $query = <<<SQL
                    INSERT INTO `test_samson`.`a_property`
                    (`product_id`, `property_value`, `name`)
                    VALUES
                    (
                        $newProductId,
                        '$proprtyValue',
                        '$propertyName'
                    );
                SQL;
                echo $query;
                $propertyes->next();
                $pdo->query($query);
            } while($propertyes->valid());

        }

    }
    importXML("testData.xml");
    


    

?>