<?php

include_once 'db.php';

$id = $_GET['id'];


$query = "SELECT r.*, u.first_name, u.last_name, a.name AS aname, c.name AS cname FROM rfc r INNER JOIN users u ON r.user_id=u.id INNER JOIN applications a ON r.application_id=a.id INNER JOIN contractor c ON r.contractor_id=c.id WHERE r.id=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$result = $stmt->fetch();
//ce rfc s to številko ne obstaja
if (!$result) {
    header("Location: index.php");
    die();
}
include_once 'header.php';
$user_id = $_SESSION['id'];
$it = $_SESSION['it'];
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">
            <h1 class="h3 mb-3 fw-normal">Pregled RFCja</h1>
        </th>
        <th>
<?php
$query = "SELECT * FROM rfc r INNER JOIN users u ON r.user_id = u.id ";
$stmt = $pdo->prepare($query);
$stmt->execute();
$res = $stmt->fetch();
//preverim ali je trenutno prijavljen user, lastnik rfcja ali informatik
if (($_SESSION['id'] == $result['id']) || ($_SESSION['it'])) {
    echo '<a href="edit_rfc.php?id=' . $result['id'] . '" class="btn btn-sm btn-outline-secondary" > <i class="bi bi-pencil"></i></a>';
    echo '<a href="delete_rfc.php?id=' . $result['id'] . '" class="btn btn-sm btn-outline-secondary" onclick="return confirm(\'Prepričan?\');"><i class="bi bi-trash"></i></a>';
}
    echo '<a href="index.php"  class="btn btn-sm btn-outline-secondary"><i class="bi bi-house"></i></a>';
?>

        </th>
    </tr>
    <tbody></tbody>
    </thead>
</table>
</br>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Naslov RFCja:</th>
            <th scope="col">
           <?php echo $result['short_description'];?>
            </th>
        </tr>
    </thead>
<tbody>
<tr>
    <td>
        Izbrani program:
    </td>
    <td>
        <?php echo $result['aname'];?>
    </td>
</tr>
<tr>
    <td>
        Izbran izvajalec:
    </td>
    <td>
        <?php echo $result['cname'];?>
    </td>
</tr>
<tr>
    <td>
        Opis RFCja:
    </td>
    <td>
        <?php echo $result['long_description'];?>
    </td>
</tr>
<tr>
    <td>
        Željena časovnica:
    </td>
    <td>
        <?php echo date("d/m/y H:i",strtotime($result['date_end']));?>
    </td>
</tr>
<tr>
    <td>
        Prioriteta:
    </td>
    <td>
        <?php echo $result['priority'];?>
    </td>
</tr>
<tr>
    <td>
        Vzroki za RFC:
    </td>
    <td>
        <?php echo $result['reasons'];?>
    </td>
</tr>
<tr>
    <td>
        Riziki neobdelave:
    </td>
    <td>
        <?php echo $result['risks'];?>
    </td>
</tr>
<tr>
    <td>
        Status:
    </td>
    <td>
        <?php echo $result['status'];?>
    </td>
</tr>
<tr>
    <td>
            <form action="screenshot_insert.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id;?>" />
                <label for="formFile" class="form-label">Naloži screenshot</label>
                <input class="form-control" type="file" id="formFile" name="fileToUpload" />
        </div>
        <div class="form-floating">
            <input type="text" name="description" class="form-control" id="floatingInput" placeholder="Status" />
            <label for="floatingInput">Opis screenshota</label><br/>
        </div>
        <button class="btn btn-primary w-20 py-1" type="submit">Shrani screenshot</button>
        </form>
    </td>
    <td>
        <?php
            $query = "SELECT * FROM screenshots  WHERE rfc_id=? ORDER BY id DESC";
            $stmt2 = $pdo->prepare($query);
            $stmt2->execute([$id]);

            while ($picture = $stmt2->fetch()) {
                if ($picture) {
                    echo '<img src="' . $picture['url'] . '" alt="' . $picture['description'] . '" width="600" height="400" class="img-thumbnail"/>';
                    echo $picture['description'];
                } else {
                    echo '<img src="https://placehold.co/600x400/EEE/31343C" alt="Manjkajoča slika"/>';
                }
                if ($user_id == $it) {
                    echo '<a href="screenshot_delete.php?id=' . $picture['id'] . '&'.$user_id.'" onclick="return confirm(\'Prepičan\');" ><i class="bi bi-x"></i></a>';
                }
            }
    ?>

    </td>
    </tr>
        </tbody>
    </table>
<br />
<?php if($user_id==$it){?>
<h2>Komentarji</h2><hr />
<form action="insert_comment.php" method="post" >
    <input type="hidden" name="id" value="<?php echo $id;?>" />
    <div class="form-floating">
        <textarea name="comment" class="form-control" placeholder="Komentar" id="floatingTextarea" rows="6" style="height:100%"></textarea>
        <label for="floatingTextarea">Vpiši komentar:</label>
    </div>
        <input type="submit" class="btn btn-primary w-100 py-2" value="Shrani" />
</form>
<div class="komentarji">
    <hr />
    <?php
    $query = "SELECT c.*, u.first_name, u.last_name 
FROM comments c INNER JOIN users u ON u.id=c.user_id 
WHERE c.rfc_id=? ORDER BY date_add DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    while ($row=$stmt->fetch()){
        echo '<div class="komentar card mb-3">';
        echo '<div class="card-header">';
        echo '<div class="badge badge-primary text-dark">'.$row['first_name'].' '.$row['last_name'].' @ '.date('j. n. Y H:i',strtotime($row['date_add'])).'</div>';
        echo '<a href="comment_delete.php?id='.$row['id'].'" onclick="return confirm(\'Prepičan\');" ><i class="bi bi-x"></i></a>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<div class="card-text">'.$row['description'].'</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
<?php } ?>
<?php
include_once 'footer.php';
?>
