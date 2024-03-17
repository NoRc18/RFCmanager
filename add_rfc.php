<?php
$id = $_GET['id'];
include_once 'header.php';
include_once 'db.php';
$user_id = $_SESSION['id'];

?>

    <form action="insert_rfc.php" method="post" >
        <h1 class="h3 mb-3 fw-normal">Dodaj RFC</h1>

        <div class="form-floating">
            <input type="text" name="short_description" required="required" class="form-control" id="floatingInput" placeholder="Naslov RFCja" />
            <label for="floatingInput">Vnesi naslov RFC-ja</label><br/>
        </div>
        <div class="form-floating">
            <select name="application_id" required="required" id="floatingSelect" class="form-select">
                <?php
                $query = "SELECT * FROM applications";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                while($row = $stmt->fetch()) {
                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
                ?>
            </select><br />
            <label for="floatingSelect">Izberi program</label>
        </div>
        <div class="form-floating">
            <select name="contractor_id" required="required" id="floatingSelect" class="form-select">
                <?php
                $query = "SELECT * FROM contractor";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                while($row = $stmt->fetch()) {
                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
                ?>
            </select><br />
            <label for="floatingSelect">Izberi izvajalca</label>
        </div>
        <div class="form-floating">
            <textarea name="long_description" class="form-control" placeholder="Opis" id="floatingTextarea"></textarea>
            <label for="floatingTextarea">Vnesi opis</label><br />
        </div>
        <div class="form-floating">
            <input type="date" id="floatingInput4" class="form-control" name="date_end" placeholder="Predlagana časovnica" required="required" /><br />
            <label for="floatingInput4">Predlagana časovnica</label>
        </div>
        <div class="form-floating">
            <input type="text" name="priority" required="required" class="form-control" id="floatingInput" placeholder="Prioriteta" />
            <label for="floatingInput">Prioriteta IT</label><br/>
        </div>
        <div class="form-floating">
            <input type="text" name="reasons" required="required" class="form-control" id="floatingInput" placeholder="Vzroki za rfc" />
            <label for="floatingInput">Vzroki za rfc</label><br/>
        </div>
        <div class="form-floating">
            <input type="text" name="risks" required="required" class="form-control" id="floatingInput" placeholder="Riziki" />
            <label for="floatingInput">Riziki nedodelave</label><br/>
        </div>
        <div class="form-floating">
            <input type="text" name="status" required="required" class="form-control" id="floatingInput" placeholder="Status" />
            <label for="floatingInput">Status</label><br/>
        </div> <hr />
        <button class="btn btn-primary w-100 py-2" type="submit">Shrani</button>
</form>
    <a href ="index.php">Prekliči</a>
<?php
include_once 'footer.php';

