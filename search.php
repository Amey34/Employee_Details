<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include('connectDB.php');

if ($_SERVER['REQUEST_METHOD']) {
    if (empty($_POST['value']) && empty($_POST['cvalue'])) {
        echo '';
    } else {
        $flag = 0;
        $val = htmlspecialchars($_POST['value']);
        $cval = htmlspecialchars($_POST['cvalue']);
        $len = strlen($val);
        $sort = "";
        if (!empty($_POST['sort'])) {
            $sort = htmlspecialchars($_POST['sort']);
        } else {
            $sort = "id";
        }


        $stmt = $conn->prepare("SELECT * FROM employee_personal_details ORDER BY $sort");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $flag = 0;
                foreach ($row as $key => $value) {
                    if (!empty($cval)) {
                        if ($cval == $key) {
                            if ($key === "gender") {
                                if (($value[0] == 'f' && $val[0] == 'm') || ($value[0] == 'm' && $val[0] == 'f')) {
                                    break;
                                } else {
                                    $flag = 1;
                                    break;
                                }
                            } else {
                                if (stristr($value, $val)) {
                                    $flag = 1;
                                    break;
                                }
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
                         <div class='col-2'>{$row['name']}</div>
                         <div class='col-2'>{$row['email']}</div>
                         <div class='col-1'>{$row['mobile_no']}</div>
                         <div class='col-1'>{$row['dob']}</div>
                         <div class='col-1'>{$row['gender']}</div>
                         <div class='col-3'>{$row['address']}</div>
                         <div class='col-1'>{$row['created_at']}</div>";
                }


            }
        } else {
            echo "";
        }
    }


}

