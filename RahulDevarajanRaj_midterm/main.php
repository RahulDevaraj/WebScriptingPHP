<?php
//Rahul Devarajan Raj (300342528)
$function_str = "";
$function_name = "calc_values";
$first_operation = ["++", "--"];
$first_operation_chooser = rand(0, 1);
$second_operation_chooser = rand(0, 3);
$third_operation_chooser = rand(0, 3);
$second_operation = ["+=", "-=", "*=", "/="];
$const_new_line = "<br/>";
$const_whitespace = "&nbsp;&nbsp;&nbsp;&nbsp;";

$to_eval_str = $first_operation[$first_operation_chooser];
$to_eval_array = [];


$params = array();
for ($i = 0; $i < rand(1, 3); $i++) {
    $params[] = chr(97 + $i);
}

$function_str .= "function $function_name(" . implode(', ', $params) . ") {\n{$const_new_line}";
if (count($params) == 1) {
    $function_str .= "{$const_whitespace}$params[0]" . $first_operation[$first_operation_chooser] . ";\n{$const_new_line}";
    $function_str .= "{$const_whitespace}return $params[0];\n{$const_new_line}}\n{$const_new_line}";
} else if (count($params) == 2) {
    $function_str .= "{$const_whitespace}$params[0]" . $first_operation[$first_operation_chooser] . ";\n{$const_new_line}";
    $function_str .= "{$const_whitespace}$params[1]" . $second_operation[$second_operation_chooser] . $params[0] . ";\n{$const_new_line}";
    $function_str .= "{$const_whitespace}return $params[1];\n{$const_new_line}}\n{$const_new_line}";
    $to_eval_array[] = $second_operation[$second_operation_chooser];
} else if (count($params) == 3) {
    $function_str .= "{$const_whitespace}$params[0]" . $first_operation[$first_operation_chooser] . ";\n{$const_new_line}";
    $function_str .= "{$const_whitespace}$params[1]" . $second_operation[$second_operation_chooser] . $params[0] . ";\n{$const_new_line}";
    $function_str .= "{$const_whitespace}$params[2]" . $second_operation[$third_operation_chooser] . $params[1] . ";\n{$const_new_line}";
    $function_str .= "{$const_whitespace}return $params[2];\n{$const_new_line}}\n{$const_new_line}";
    $to_eval_array[] = $second_operation[$second_operation_chooser];
    $to_eval_array[] = $second_operation[$third_operation_chooser];
}

//function calling
$params_for_calling = [];
for ($i = 0; $i < count($params); $i++) {
    $params_for_calling[] = rand(0, 10);
}

$function_str .= "{$const_new_line}y = $function_name(" . implode(', ', $params_for_calling) . ");\n{$const_new_line}";
$function_str .= "{$const_new_line}After executing this piece of code, the value of y would be: " . evaluate_function($params_for_calling, $to_eval_str, $to_eval_array) . "\n";

print $function_str;


function evaluate_function($params_for_calling, $to_eval_str, $to_eval_array)
{
    $result = $params_for_calling[0];
    // if ($to_eval_str == "++") {
    //     $result++;
    // } else {
    //     $result--;
    // }
    if (count($params_for_calling) == 1) {
        $result = evaluate_exp($result, 0, $to_eval_str);
    } else
    if (count($params_for_calling) == 2) {
        $result = evaluate_exp($result, 0, $to_eval_str);
        $result = evaluate_exp($params_for_calling[1], $result, $to_eval_array[0]);
    } else
    if (count($params_for_calling) == 3) {
        $result = evaluate_exp($result, 0, $to_eval_str);
        $result = evaluate_exp($params_for_calling[1], $result, $to_eval_array[0]);
        $result = evaluate_exp($params_for_calling[2], $result, $to_eval_array[1]);
    }



    return round($result, 2);
}

function evaluate_exp($a, $b, $operator)
{
    switch ($operator) {
        case "+=":
            return $a + $b;
        case "-=":
            return $a - $b;
        case "*=":
            return $a * $b;
        case "/=":
            return $a / $b;
        case "++":
            return $a + 1;
        case "--":
            return $a - 1;
    }
}
