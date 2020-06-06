<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 1</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
</head>
<body>
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <div class="row">
        <div class="col-sm-10 p-3">
            <h2>CFC 3 - ADD NEW FIGHTER</h2><br>
            <p>Slika borca će se promijeniti samo ako se doda nova, u suprotnom ostaje stara slika.</p>
        </div>
        <div class="col-sm-2 text-right">
            <a href="index.php" class="btn btn-link">Go Back</a>
        </div>
        <div class="d-flex flex-column  align-items-start side col p-4">
            <div class="row d-flex justify-content-start">
                <div class="col-auto">
                    <div>
                        <?php
                            error_reporting(0);
                            require "./controller/DbHandler.php";

                            use Db\DbHandler;
                            $id = $_GET['id'];

                            $db = new DbHandler();
                            $result = $db->select("SELECT * FROM fighters WHERE id = '{$id}'");
                        ?>
                        
                        <?php if($result->num_rows > 0):
                            $row = $result->fetch_assoc() ?>
                            <form id="fighterForm" name="fighterForm" action="./controller/db/Update.php" method="POST" enctype="multipart/form-data" target="_blank">
                            <!-- Ovaj input se koristi za predaju id-a php skripti, preko GET metode, koja onda prepoznaje o kojem borcu se radi -->
                            <input type="hidden" name="id" value="<?=$row["id"];?>"/>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" maxlength="64" required value="<?= $row["name"];?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="age" class="col-sm-2 col-form-label">Age</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="age" name="age" min="0" step="1" required value="<?= $row["age"];?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="info" class="col-sm-2 col-form-label">Cat info</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="info" name="info" maxlength="256" value="<?= $row["info"];?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="wins" class="col-md-4 col-sm-2 col-form-label">Wins</label>
                                            <div class="col-md-8 col-sm-10">
                                                <input type="number" class="form-control" id="wins" name="wins" required="" min="0" step="1" value="<?= $row["wins"];?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="loss" class="col-md-4 col-sm-2 col-form-label">Loss</label>
                                            <div class="col-md-8 col-sm-10">
                                                <input type="number" class="form-control" id="loss" name="loss" required="" min="0" step="1" value="<?= $row["loss"];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="image" class="col-sm-2 col-form-label">Cat image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control-file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif" onchange="loadFile(event)"><br>
                                        <img id="output" style="max-width: 60%;" src="./img/<?=basename($row["path"]);?>">
                                    </div>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-success" id="submitInput">
                            </form>
                            <br>
                            <form id="deleteFighter" name="deleteFighter" action="./controller/db/Delete.php" method="GET" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?=$row["id"];?>"/>
                                <input type="submit" value="Delete Fighter" class="btn btn-danger">
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>