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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <section class="container d-flex flex-column  align-items-center mb-4">
        <h1>CFC 3</h1>
        <h2 id="infoScreen">Choose your cat</h2>
    </section>
    <div class="container d-flex flex-column  align-items-center">
        <div id="clock" class="clock display-4"></div>
        <div id="message" class="message"></div>
    </div>
    <div class="row">
        <div id="firstSide" class="container d-flex flex-column  align-items-center side first-side col-5">
            <div class="row d-flex justify-content-end">
                <div class="col-auto">
                    <ul class="cat-info list-group">
                        <li class="list-group-item name">Cat Name</li>
                        <li class="list-group-item age">Cat age</li>
                        <li class="list-group-item skills">Cat Info</li>
                        <li class="list-group-item record">Wins: <span class="wins"></span> Loss: <span class="loss"></span></li>
                    </ul>
                </div>
                <div class="col-auto featured-cat-fighter">
                    <img id="leftFighterImg" class="featured-cat-fighter-image img-rounded" src="https://via.placeholder.com/300" alt="Featured cat fighter">
                </div>
                <div class="col-auto w-100" style="margin-top: 24px">
                    <div class="row fighter-list">

                        <!-- pomocu sljedeceg php koda se spajamo na bazu i dohvacamo sve borce i potom ih prikazujemo
                            ovo se ponavlja za desnu stranu -->
                        <?php 
                            require "./controller/DbHandler.php";

                            use Db\DbHandler;

                            $db = new DbHandler();
                            $result = $db->select("SELECT * FROM fighters");
                        ?>
                        
                        <?php if($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <div class="col-md-4 mb-1">
                                    <div class="fighter-box"
                                    id="id-<?=$row["id"];?>"
                                    data-info = '{
                                        "id": "<?=$row["id"];?>",
                                        "name": "<?=$row["name"];?>" ,
                                        "age" : <?=$row["age"];?>,
                                        "catInfo": "<?=$row["info"];?>",
                                        "record" : {
                                            "wins":  <?=$row["wins"];?>,
                                            "loss": <?=$row["loss"];?>
                                        }
                                    }'>
                                    <img src="<?=$row["path"];?>" alt="Figter Box <?=$row["id"];?>" width="150" height="150">
                                    <form id="editFighter" name="editFighter" action="./editFighter.php" method="GET" enctype="multipart/form-data">
                                        <!-- Ovaj input se koristi samo za predaju id-a php skripti, preko GET metode, koja onda prepoznaje o kojem borcu se radi -->
                                        <input type="hidden" name="id" value="<?=$row["id"];?>"/>
                                        <input type="submit" id="editFighter" value="Edit" class="btn btn-light">
                                    </form>
                                </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 d-flex flex-column align-items-center">
            <p class="display-4">VS</p>
            <button id="generateFight" class="btn btn-primary mb-4 btn-lg">Fight</button>
            <button id="randomFight" class="btn btn-secondary">Select Random fighters</button>
        </div>
        <div id="secondSide" class="container d-flex flex-column align-items-center side second-side col-5">
            <div class="row">
                <div class="col-auto featured-cat-fighter">
                    <img id="rightFighterImg" class="featured-cat-fighter-image img-rounded" src="https://via.placeholder.com/300" alt="Featured cat fighter">
                </div>
                <div class="col-auto">
                    <ul class="cat-info list-group">
                        <li class="list-group-item name">Cat Name</li>
                        <li class="list-group-item age">Cat age</li>
                        <li class="list-group-item skills">Cat Info</li>
                        <li class="list-group-item record">Wins: <span class="wins"></span> Loss: <span class="loss"></span></li>
                    </ul>
                </div>
                <div class="col-auto w-100" style="margin-top: 24px">
                    <div class="row fighter-list">
                        <?php
                            $result = $db->select("SELECT * FROM fighters");
                        ?>
                        
                        <?php if($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <div class="col-md-4 mb-1">
                                    <div class="fighter-box"
                                    id="id-<?=$row["id"];?>"
                                    data-info = '{
                                        "id": "<?=$row["id"];?>",
                                        "name": "<?=$row["name"];?>" ,
                                        "age" : <?=$row["age"];?>,
                                        "catInfo": "<?=$row["info"];?>",
                                        "record" : {
                                            "wins":  <?=$row["wins"];?>,
                                            "loss": <?=$row["loss"];?>
                                        }
                                    }'>
                                    <img src="<?=$row["path"];?>" alt="Figter Box <?=$row["id"];?>" width="150" height="150">
                                    <form id="editFighter" name="editFighter" action="./editFighter.php" method="GET" enctype="multipart/form-data">
                                        <!-- Ovaj input se koristi samo za predaju id-a php skripti, preko GET metode, koja onda prepoznaje o kojem borcu se radi -->
                                        <input type="hidden" name="id" value="<?=$row["id"];?>"/>
                                        <input type="submit" id="editFighter" value="Edit" class="btn btn-light">
                                    </form>
                                </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="container d-flex flex-column  align-items-center mb-4">
        <a href="addFighter.html" class="btn btn-primary" id="newFighter">Dodaj novog borca</a>
    </section>
    <!-- skripta koja daje broj boraca u bazi podataka -->
    <script type="text/javascript">
        var fighterCount = <?php echo json_encode($result->num_rows); ?>;
    </script>
    <script src="./src/app.js"></script>
</body>
</html>