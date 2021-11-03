<?php
require_once("../classes/general_handler.php");
$gh = new GeneralHandler();
require_once("../classes/admin_handler.php");
$admin = new AdminHandler();

if (isset($_REQUEST["term"])) {
    // Prepare a select statement
    $sql = "SELECT s.`index`, s.`fullname`, p.`program`, c.permit, f.bal 
        FROM students AS s, program AS p, secret_codes AS c, finance AS f, settings AS t 
        WHERE s.id = f.sid AND s.id = c.sid AND t.id = c.set 
        AND s.pid = p.id AND c.qr_code = :q";
    $param = array(':q' => $_REQUEST["term"]);

    $result = $gh->getData($sql, $param);

    if (!empty($result)) {
        $eligibility = $admin->getFinanceStatus($result[0]["bal"]);
        echo "<div><h2>QR Scan results</h2>";
        echo "<table>";
        echo "<tr><td style='text-align: center; background-color: #eee;' colspan='2'>Student Details</td></tr>";
        echo "<tr><td>Name:</td><td>" . $result[0]["fullname"] . "</td></tr>";
        echo "<tr><td>Index No.:</td>
                    <td style='text-transform: uppercase;'>" . $result[0]["index"] . "</td>
                </tr>";
        echo "<tr><td>Program</td>
                    <td style='text-transform: uppercase;'>" . $result[0]["program"] . "</td>
                </tr>";
        echo "<tr><td>Permit No.:</td><td>" . $result[0]["permit"] . "</td></tr>";
        echo "<tr>
                    <td colspan='2'><h2 id='eligible-status'>'" . $eligibility . "'</h2></td>
                </tr>";
        echo "</table>";
        echo "<div id='back-btn-container'>
                <button id='back-btn' onclick='closResults()'>Back</button>
            </div></div>";
    } else {
        echo "<div><h2>QR Scan results</h2>";
        echo "<table>";
        echo "<tr><td style='text-align: center; background-color: red; color: #fff' colspan='2'>No matches found</td></tr>";
        echo "</table>";
        echo "<div id='back-btn-container'>
                <button id='back-btn' onclick='closResults()'>Back</button>
            </div></div>";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
