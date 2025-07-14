<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: ../loginh.php");
    exit;
}

include('../config/connectDB.php');

if ($_SERVER['REQUEST_METHOD']) {
    if (empty($_POST['value']) && empty($_POST['cvalue'])) {
        echo '';
    } else {
        $flag = 0;
        $val = htmlspecialchars($_POST['value']);
        $cval = htmlspecialchars($_POST['cvalue']);
        $len = strlen($val);



        $stmt = $conn->prepare('SELECT * FROM employee_details');
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $flag = 0;
                foreach ($row as $key => $value) {
                    if (!empty($cval)) {
                        if ($cval == $key) {

                            if (stristr($value, $val)) {
                                $flag = 1;
                                break;
                            }
                        }


                    } else {
                        if (stristr($value, $val)) {
                            $flag = 1;
                            break;

                        }
                    }
                }
                if ($flag == 1) {
                    echo "
                         <div class='col-1'>{$row['id']}</div>
                         <div class='col-1'>{$row['emp_id']}</div>
                         <div class='col-5'>{$row['name_of_detail']}</div>
                         <div class='col-5'>{$row['value_of_detail']}</div>";
                }


            }
        } else {
            echo "";
        }
    }


}

