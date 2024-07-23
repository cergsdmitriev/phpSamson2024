<?php

    // Реализовать функцию findSimple ($a, $b). $a и $b – целые положительные числа. Результат ее выполнения: массив простых чисел от $a до $b

    function findSimple(int $a, int $b) :array
    {
        // входные аргументы должны быть типа инт, больше нуля, $a должно быть меньше $b
        if(!filter_var($a, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]))
            throw new InvalidArgumentException("findSimple function only accepts integers and above zero. Input \$a was: ".$a);
        if(!filter_var($b, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]))
            throw new InvalidArgumentException("findSimple function only accepts integers and above zero. Input \$b was: ".$b);
        if($a >= $b)
            throw new InvalidArgumentException("findSimple function argument \$b must be more then \$a. Arguments: \$a  = ".$a." \$b = ".$b);

        $simple_arr = [];

        function isSimple(int $n) :bool
        {
            if($n == 1)
                return false;
            
            for($i = 2; $i < $n; $i++){
                if($n % $i ==0)
                    return false;
            }
            return true;
        } 

        for($i = $a; $i <= $b; $i++) {
            if(isSimple($i)) {
                $simple_arr[] = $i;         // добавляем элемент с максимальным индексом + 1
            }
        }

        return $simple_arr;
    }

    // тестирование
    print "findSimple(1,50) <br>";
    print_r(findSimple(1,50));
    print "<br>";

    // Реализовать функцию createTrapeze($a). $a – массив положительных чисел, количество элементов кратно 3. 
    // Результат ее выполнения: двумерный массив (массив состоящий из ассоциативных массивов с ключами a, b, c). 
    // Пример для входных массива [1, 2, 3, 4, 5, 6] результат [[‘a’=>1,’b’=>2,’с’=>3],[‘a’=>4,’b’=>5 ,’c’=>6]].

    function createTrapeze(array $a) :array
    {
        // длинна массива должна быть кратна 3, каждый элемент это положительное число( вещественное)
        if(count($a) % 3 != 0)
            throw new InvalidArgumentException("createTrapeze function only accepts array multiple 3. Input array count was: ".count($a));
        foreach($a as $elem)
            if(($elem <= 0) || filter_var($elem, FILTER_VALIDATE_FLOAT) === false)
                throw new InvalidArgumentException("createTrapeze function only accepts array of float and above zero values. Input array elemt was: ".$elem);  

        $twoDim_arr = [];
         
        for($i = 0, $count = count($a); $i < $count; $i = $i + 3) {
            $twoDim_arr[] = [
                "a" => $a[$i],
                "b" => $a[$i+1],
                "c" => $a[$i+2]
            ];
        }

        return $twoDim_arr;
    }

    function createTrapeze2(array $a) :array
    {
        if(!is_array($a))
            throw new InvalidArgumentException("createTrapeze function only accepts array. Input was: ".print_r($a)); 
        if(count($a) % 3 != 0)
            throw new InvalidArgumentException("createTrapeze function only accepts array multiple 3. Input array count was: ".count($a));
        foreach($a as $elem)
            if(($elem <= 0) || filter_var($elem, FILTER_VALIDATE_FLOAT) === false)
                throw new InvalidArgumentException("createTrapeze function only accepts array of float and above zero values. Input array elemt was: ".$elem); 

        return array_map(fn($value) :array => array_combine(["a", "b", "c"], $value), array_chunk($a, 3));

    }
    // тестирование
    print "createTrapeze([1,2,3,4,5,6]) <br>";
    print_r(createTrapeze([1,2,3,4,5,6]));
    print "<br>";
    // тестирование2
    print "createTrapeze2([1,2,3,4,5,6]) <br>";
    print_r(createTrapeze2([1,2,3,4,5,6]));
    print "<br>";



    // Реализовать функцию squareTrapeze($a). $a – массив результата выполнения функции createTrapeze(). 
    // Результат ее выполнения: в исходный массив для каждой тройки чисел добавляется дополнительный ключ s, 
    // содержащий результат расчета площади трапеции со сторонами a и b, и высотой c.
    function squareTrapeze(array &$a) :void 
    {
        // так как входной аргумент это результат выполнения другой функции, в которой уже проведена проверка данных
        // то проверка данных будет избыточной. Попытаемся перехватить непредвиденные исключения.
        // !! При попытку обратиться к несуществующему элементу исключение не вызывается(вызывается Warning) и не обрабатывается !!
        try {
            foreach($a as &$trapeze) {
                $trapeze["s"] = ($trapeze["a"] + $trapeze["b"]) * $trapeze["c"] / 2;
            }
        } catch (Exception $exp) {
            throw new InvalidArgumentException("squareTrapeze function get wrong argument ".print_r($a). " \n Exception ".$exp->getMessage());
        }
    }

    //тестирование
    print "squareTrapeze(createTrapeze([1,2,3,4,5,6]) <br>";
    $trapezes = createTrapeze([1,2,3,4,5,6,7,8,9]);
    squareTrapeze($trapezes); // ничего не возвращаем, модифицируем исходный массив
    print_r($trapezes);
    print "<br>";

    // Реализовать функцию getSizeForLimit($a, $b). $a – массив результата выполнения функции squareTrapeze(), $b – максимальная площадь.
    // Результат ее выполнения: массив размеров трапеции с максимальной площадью, но меньше или равной $b.
    function getSizeForLimit(array $a, float $b) :array
    {
        $maxTrapeze = ["s" => 0];
        // так как входной аргумент это результат выполнения другой функции, в которой уже проведена проверка данных
        // то проверка данных будет избыточной. Попытаемся перехватить непредвиденные исключения.
        // !! При попытку обратиться к несуществующему элементу исключение не вызывается(вызывается Warning) и не обрабатывается !!
        try {
            foreach($a as $trapeze){
                if(($trapeze["s"] <= $b) && ($trapeze["s"] > $maxTrapeze["s"] )){
                    $maxTrapeze = $trapeze;
                }
            }
        } catch (Exception $exp) {
            throw new InvalidArgumentException("getSizeForLimit function get wrong argument ".print_r($a). " \n Exception ".$exp->getMessage());
        }
        if($maxTrapeze["s"] == 0) { // если нет подходящей трапеции, то возвращаеь пустой массив
            $maxTrapeze = [];
        }

        return $maxTrapeze;
    }

    //тестирование
    print "getSizeForLimit(trapezes, 10) <br>";
    print_r(getSizeForLimit($trapezes, 10));
    print "<br>";

    // Реализовать функцию getMin($a). $a – массив чисел. 
    // Результат ее выполнения: минимальное число в массиве (не используя функцию min, ключи массива могут быть ассоциативными).
    function getMin(array $a) :int
    {
        $minElem = null;
        foreach($a as $elem) {
            // проверка элемента. Должен быть int 
            if(filter_var($elem, FILTER_VALIDATE_INT) === false)
                throw new InvalidArgumentException("findSimple function only accepts array of integers. Array element value was: ".$elem);

            if($elem < $minElem || $minElem === null){
                $minElem = $elem;
            }
        }
        return $minElem;
    }

    // тестирование
    print "getMin([12,2,-56,84,5, \"d\" => 0]) <br>";
    print_r(getMin([12,2,-56,84,"5", "d" => 0]));
    print "<br>";

    // Реализовать функцию printTrapeze($a). $a – массив результата выполнения функции squareTrapeze(). 
    // Результат ее выполнения: вывод таблицы с размерами трапеций, строки с нечетной площадью трапеции отметить любым способом.
    function printTrapeze(array $a) :void
    {
        print "<Table>";
        foreach($a as $elem){
            // нечетными могут быть только целые числа
            if(is_int($elem["s"]) && $elem["s"] % 2 != 0){
                $notEvenColor = "bgColor = #FAEBD7";
            } else {
                $notEvenColor = "";
            }
            
            print "<tr $notEvenColor >";
            echo "<td>", $elem["a"], "</td><td>", $elem["b"], "</td><td>", $elem["c"], "</td><td>", $elem["s"], "</td>";
            print "</tr>";
        }
        print "</Table>";
    }

    //тестирование
    print "printTrapeze(trapezes) <br>";
    printTrapeze($trapezes);
    print "<br>";

    // Реализовать абстрактный класс BaseMath содержащий 3 метода: exp1($a, $b, $c) и exp2($a, $b, $c),getValue().
    //  Метод exp1 реализует расчет по формуле a*(b^c). Метод exp2 реализует расчет по формуле (a/b)^c. Метод getValue() возвращает результат расчета класса наследника.
    abstract class BaseMath {

        public function exp1(float $a, float $b, float $c) :float 
        {
            return $a * ($b**$c);
        }

        public function exp2(float $a, float $b, float $c) :float
        {
            return ($a / $b)**$c;
        }

        public abstract function getValue() :float;
    }

    // Реализовать класс F1 наследующий методы BaseMath, содержащий конструктор с параметрами ($a, $b, $c) и метод getValue().
    // Класс реализует расчет по формуле f=(a*(b^c)+(((a/c)^b)%3)^min(a,b,c)).

    class F1 extends BaseMath {

        public float $a;
        public float $b;
        public float $c;

        public function __construct(float $a, float $b, float $c) {
            $this -> a = $a;
            $this -> b = $b;
            $this -> c = $c;
        }

        public function getValue() :float
        {
            $a = $this -> a;
            $b = $this -> b;
            $c = $this -> c;
            // использовать методы exp1 и exp2 не желательно.  При изменении абстрактного класса поменяется и вычисления класса наследника. Это не очивидное поведение.
            // this -> exp1($a, $b, $c) + (this -> exp2($a, $c, $b) % 3)**min($a, $b, $c)
            //  (($a / $c)**$b) % 3  - результат деления может быть дробным числом. Не корректно получать остаток от деления на 3 от дробного числа.
            
            return $a * ($b**$c) + (intval(($a / $c)**$b) % 3)**min($a, $b, $c);
        }


    }

    // тестирование
    $f1 = new F1(1,2,3);
    print "F1 object <br>";
    print_r($f1);
    print "<br>";
    echo $f1->exp1(1,2,3), " " , $f1->exp2(1,2,3), " ", $f1->getValue();
    print "<br>";

?>