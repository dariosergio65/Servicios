<?php

include("db.php");

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $query="SELECT * FROM tareas WHERE id = $id";
    $result=mysqli_query($conn,$query);
    //$registro = mysqli_num_rows($result);
    
    if ($result) {    
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $description = $row['description'];
    }

    if (isset($_POST['update'])) {
        $id=$_GET['id'];
        $title=$_POST['title'];
        $description=$_POST['description'];

        $query="UPDATE tareas SET title = '$title', description = '$description' WHERE id = $id";
        $result=mysqli_query($conn,$query);

        if(!$result) {
            die("Algo fallo y no se pudo modificar el registro.");
        }

        $_SESSION['message'] = "Registro actualizado con exito";
        $_SESSION['message_type'] = "success";
        header("location: index.php");
    }

}

?>

<?php include ("includes/header.php") ?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">
                <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="title" value="<?php echo $title; ?>" class="form-control" 
                        placeholder="Actualiza el titulo">
                    </div>
                    <div class="form-group">
                        <textarea name="description" rows="2" class="form-control" placeholder=
                        "Update Description"> <?php echo $description; ?>
                        </textarea>
                    </div>
                        <button class="btn btn-success" name="update">
                            UPDATE
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include ("includes/footer.php") ?>