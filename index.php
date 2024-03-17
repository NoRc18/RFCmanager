<?php
include_once 'header.php';
include_once 'db.php';
$user_id = $_SESSION ['id'];
?>

    <div id="naslov">
    <h1 id="inventory">RFC seznam</h1>
    <?php echo '<a class="btn btn-primary" href="add_rfc.php?id='. $user_id .'" id="addRfc" role="button">Dodaj nov RFC</a><br /><hr />' ?>
    </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ime RFCja</th>
                <th scope="col">Lastnik</th>
                <th scope="col">Željeni datum realizacije</th>
                <th scope="col">Status</th>
                <th scope="col">Prioriteta</th>
                <th scope="col">Program</th>
                <th scope="col">Izvajalec</th>
                <th scope="col">Akcija</th>
            </tr>
            </thead>
            <tbody>
        <?php

        $query = "SELECT r.user_id , r.id , short_description, u.first_name AS uname, u.last_name AS lname, date_end, status, priority, a.name AS aname, c.name AS cname
        FROM rfc r INNER JOIN users u ON r.user_id = u.id INNER JOIN applications a ON r.application_id = a.id INNER JOIN contractor c ON r.contractor_id = c.id ORDER BY date_add DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $i=0;
        while ($result = $stmt->fetch()) {

            $i++;
            echo '<tr>';
            echo '<th scope="row">'.$i.'</th>';
            echo '<td>'.$result['short_description'].'</td>';
            echo '<td>'.$result['uname'].' '.$result['lname'].'</td>';
            echo '<td>'.date("d/m/y H:i",strtotime($result['date_end'])).'</td>';
            echo '<td>'.$result['status'].'</td>';
            echo '<td>'.$result['priority'].'</td>';
            echo '<td>'.$result['aname'].'</td>';
            echo '<td>'.$result['cname'].'</td>';
            echo '<td>';
            echo '<a href="view_rfc.php?id='.$result['id'].'" class="btn btn-sm btn-outline-secondary" > <i class="bi bi-binoculars"></i></a>';
            if (($_SESSION['id'] == $result['user_id']) || ($_SESSION['it'])) {
                echo '<a href="edit_rfc.php?id=' . $result['id'] . '" class="btn btn-sm btn-outline-secondary" > <i class="bi bi-pencil"></i></a>';
                echo '<a href="delete_rfc.php?id=' . $result['id'] . '" class="btn btn-sm btn-outline-secondary" onclick="return confirm(\'Prepričan?\');"><i class="bi bi-trash"></i></a>';
            }
            echo '</tr>';

        }
            echo '</td>';
        ?>
            </tbody>
        </table>
    </div>
<hr />
    <footer class="text-body-secondary py-5">
        <div class="container">
            <p class="float-end mb-1">
                <?php
                $query ="SELECT * FROM users WHERE id=$user_id";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result=$stmt->fetch();
                    echo 'Prijavljen kot:<br/>';
                    echo $result['first_name'];
                    echo ' ';
                    echo $result['last_name'];
                ?>
            </p>
        </div>
    </footer>
<?php
include_once 'footer.php';
?>
